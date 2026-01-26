<?php

namespace App\Http\Controllers;

use App\Models\Keuzedeel;
use App\Models\Study;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Show list of available keuzedelen.
     */
    public function keuzedelen(Request $request)
    {
        $user = auth()->user();
        $query = Keuzedeel::where('active', true)
            ->with(['teacher', 'study']);

        // Only show keuzedelen from the student's own study
        if ($user->study_id) {
            $query->where('study_id', $user->study_id);
        }

        $keuzedelen = $query->get();
        
        // Get the student's study for display
        $studentStudy = $user->study;

        return view('student.keuzedelen', [
            'keuzedelen' => $keuzedelen,
            'studentStudy' => $studentStudy,
        ]);
    }

    /**
     * Show keuzedeel detail.
     */
    public function keuzedelenDetail($id)
    {
        $user = auth()->user();
        $keuzedeel = Keuzedeel::findOrFail($id);

        // Ensure student can only view keuzedelen from their own study
        if ($keuzedeel->study_id !== $user->study_id) {
            abort(403, 'Je hebt geen toegang tot dit keuzedeel.');
        }

        return view('student.keuzedeel-detail', [
            'keuzedeel' => $keuzedeel,
        ]);
    }

    /**
     * Show user's enrollments.
     */
    public function enrollments()
    {
        $enrollments = auth()->user()
            ->enrollments()
            ->with(['keuzedeel', 'period'])
            ->get();

        return view('student.enrollments', [
            'enrollments' => $enrollments,
        ]);
    }
}
