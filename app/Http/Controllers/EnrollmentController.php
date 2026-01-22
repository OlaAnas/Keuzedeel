<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Keuzedeel;
use App\Models\Period;
use App\Models\Waitlist;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Enroll student in a keuzedeel.
     */
    public function enroll(Request $request, $keuzedelId)
    {
        $user = auth()->user();
        $keuzedeel = Keuzedeel::findOrFail($keuzedelId);

        // 1. Check if keuzedeel is active
        if (! $keuzedeel->active) {
            return back()->with('error', 'Deze keuzedeel is niet actief.');
        }

        // 2. Check if there's an open enrollment period
        $openPeriod = Period::where('enrollment_open', true)->first();
        if (! $openPeriod) {
            return back()->with('error', 'Inschrijving is gesloten.');
        }

        // 3. Check if student already enrolled in this period
        $existingEnrollment = Enrollment::where('user_id', $user->id)
            ->where('period_id', $openPeriod->id)
            ->where('status', '!=', 'cancelled')
            ->with('keuzedeel')
            ->first();

        if ($existingEnrollment) {
            return back()->with('error', 'Je mag maar 1 keuzedeel per periode kiezen. Je bent al ingeschreven voor: '.$existingEnrollment->keuzedeel->name);
        }

        // 4. Check if keuzedeel is full (check against max_students)
        $enrolledCount = Enrollment::where('keuzedeel_id', $keuzedelId)
            ->where('period_id', $openPeriod->id)
            ->where('status', '!=', 'cancelled')
            ->count();

        if ($enrolledCount >= $keuzedeel->max_students) {
            // 5. Add to waitlist instead
            Waitlist::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'keuzedeel_id' => $keuzedelId,
                    'period_id' => $openPeriod->id,
                ],
                [
                    'preference_order' => 1,
                    'status' => 'waiting',
                ]
            );

            return back()->with('success', 'Keuzedeel is vol. Je bent op de wachtlijst geplaatst!');
        }

        // 6. Create enrollment (vol=vol fairness - timestamp order)
        Enrollment::create([
            'user_id' => $user->id,
            'keuzedeel_id' => $keuzedelId,
            'period_id' => $openPeriod->id,
            'status' => 'enrolled',
        ]);

        return back()->with('success', 'Je bent ingeschreven voor '.$keuzedeel->name);
    }

    /**
     * Remove student from a keuzedeel.
     */
    public function unenroll($enrollmentId)
    {
        $enrollment = Enrollment::findOrFail($enrollmentId);

        // Make sure it's the student's own enrollment
        if ($enrollment->user_id !== auth()->id()) {
            abort(403);
        }

        $enrollment->update(['status' => 'cancelled']);

        return back()->with('success', 'Je bent uitgeschreven.');
    }

    /**
     * Show student's enrollments for current period.
     */
    public function myEnrollments()
    {
        $user = auth()->user();
        $openPeriod = Period::where('enrollment_open', true)->first();

        if (! $openPeriod) {
            $enrollment = null;
        } else {
            $enrollment = Enrollment::where('user_id', $user->id)
                ->where('period_id', $openPeriod->id)
                ->with(['keuzedeel' => function ($query) {
                    $query->with('teacher');
                }])
                ->first();
        }

        return view('student.my-enrollments', [
            'enrollment' => $enrollment,
            'openPeriod' => $openPeriod,
        ]);
    }

    /**
     * Toggle period enrollment open/closed (admin only).
     */
    public function togglePeriod(Request $request, $periodId)
    {
        $period = Period::findOrFail($periodId);

        // If opening a period, close all others
        if (! $period->enrollment_open) {
            Period::where('id', '!=', $period->id)->update(['enrollment_open' => false]);
        }

        $period->update(['enrollment_open' => ! $period->enrollment_open]);

        // If closing, apply minimum 15 rule
        if ($period->enrollment_open === false) {
            $this->applyMinimum15Rule($period);
        }

        $action = $period->enrollment_open ? 'geopend' : 'gesloten';

        return back()->with('success', 'Inschrijving is '.$action.'.');
    }

    /**
     * Apply minimum 15 students rule to period.
     */
    private function applyMinimum15Rule($period)
    {
        // Find all keuzedelen with less than 15 enrolled students
        $lowEnrollment = Keuzedeel::where('active', true)
            ->whereHas('enrollments', function ($query) use ($period) {
                $query->where('period_id', $period->id)
                    ->where('status', '!=', 'cancelled')
                    ->havingRaw('COUNT(*) < 15');
            }, '>=', 0)
            ->get();

        foreach ($lowEnrollment as $keuzedeel) {
            $count = Enrollment::where('keuzedeel_id', $keuzedeel->id)
                ->where('period_id', $period->id)
                ->where('status', '!=', 'cancelled')
                ->count();

            if ($count < 15 && $count > 0) {
                // Cancel all enrollments for this keuzedeel
                Enrollment::where('keuzedeel_id', $keuzedeel->id)
                    ->where('period_id', $period->id)
                    ->where('status', '!=', 'cancelled')
                    ->update(['status' => 'cancelled']);
            }
        }
    }
}
