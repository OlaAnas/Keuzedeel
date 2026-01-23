<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Period;
use App\Models\Waitlist;
use Illuminate\Http\Request;

class WaitlistController extends Controller
{
    /**
     * Show waitlist for current period.
     */
    public function index()
    {
        $openPeriod = Period::where('enrollment_open', true)->first();

        if (! $openPeriod) {
            $waitlistEntries = collect();
        } else {
            $waitlistEntries = Waitlist::where('period_id', $openPeriod->id)
                ->where('status', 'waiting')
                ->with(['user', 'keuzedeel'])
                ->orderBy('keuzedeel_id')
                ->orderBy('created_at')
                ->get();
        }

        return view('admin.waitlists.index', [
            'waitlistEntries' => $waitlistEntries,
            'openPeriod' => $openPeriod,
        ]);
    }

    /**
     * Approve a waitlist entry and enroll the student.
     */
    public function approve($waitlistId)
    {
        $waitlist = Waitlist::findOrFail($waitlistId);
        $keuzedeel = $waitlist->keuzedeel;

        // Check if there's still space in the keuzedeel
        $enrolledCount = Enrollment::where('keuzedeel_id', $waitlist->keuzedeel_id)
            ->where('period_id', $waitlist->period_id)
            ->where('status', '!=', 'cancelled')
            ->count();

        if ($enrolledCount >= $keuzedeel->max_students) {
            return back()->with('error', 'Keuzedeel is vol. Kan niet goedkeuren.');
        }

        // Check if student is already enrolled in another keuzedeel for this period
        $existingEnrollment = Enrollment::where('user_id', $waitlist->user_id)
            ->where('period_id', $waitlist->period_id)
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($existingEnrollment) {
            return back()->with('error', 'Student is al ingeschreven voor een ander keuzedeel in deze periode.');
        }

        // Create enrollment
        Enrollment::create([
            'user_id' => $waitlist->user_id,
            'keuzedeel_id' => $waitlist->keuzedeel_id,
            'period_id' => $waitlist->period_id,
            'status' => 'enrolled',
        ]);

        // Update waitlist status
        $waitlist->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Student is goedgekeurd en ingeschreven.');
    }

    /**
     * Reject a waitlist entry.
     */
    public function reject($waitlistId)
    {
        $waitlist = Waitlist::findOrFail($waitlistId);

        $waitlist->update(['status' => 'rejected']);

        return back()->with('success', 'Wachtlijst entry is afgewezen.');
    }
}
