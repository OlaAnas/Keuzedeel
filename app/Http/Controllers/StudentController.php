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
        $query = Keuzedeel::where('active', true)
            ->with(['teacher', 'study']);

        // Filter by study if provided
        if ($request->has('study_id') && $request->study_id !== null) {
            $query->where('study_id', $request->study_id);
        }

        $keuzedelen = $query->get();
        $studies = Study::orderBy('name')->get();

        return view('student.keuzedelen', [
            'keuzedelen' => $keuzedelen,
            'studies' => $studies,
            'selectedStudy' => $request->study_id,
        ]);
    }

    /**
     * Show keuzedeel detail.
     */
    public function keuzedelenDetail($id)
    {
        $keuzedeel = Keuzedeel::findOrFail($id);

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
