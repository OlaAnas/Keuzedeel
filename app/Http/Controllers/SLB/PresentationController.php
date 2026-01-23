<?php

namespace App\Http\Controllers\SLB;

use App\Http\Controllers\Controller;
use App\Models\Keuzedeel;
use App\Models\Study;
use Illuminate\Http\Request;

class PresentationController extends Controller
{
    /**
     * Show dashboard to select study.
     */
    public function dashboard()
    {
        $studies = Study::with(['keuzedelen' => function ($query) {
            $query->where('active', true);
        }])->orderBy('name')->get();

        $totalKeuzedelen = Keuzedeel::where('active', true)->count();

        return view('slb.dashboard', [
            'studies' => $studies,
            'totalKeuzedelen' => $totalKeuzedelen,
        ]);
    }

    /**
     * Show presentation mode with keuzedelen slides.
     */
    public function index(Request $request)
    {
        // Get study ID from query parameter
        $studyId = $request->input('study_id');

        // Get active keuzedelen, optionally filtered by study
        $query = Keuzedeel::where('active', true)
            ->with(['teacher', 'study']);

        if ($studyId) {
            $query->where('study_id', $studyId);
        }

        $keuzedelen = $query->orderBy('created_at', 'asc')
            ->get();

        // Get current slide index from query parameter or session
        $slideIndex = $request->input('slide', session('presentation_slide', 0));
        session(['presentation_slide' => $slideIndex]);

        // Get study info if filtering by study
        $study = $studyId ? Study::findOrFail($studyId) : null;

        return view('slb.presentation', [
            'keuzedelen' => $keuzedelen,
            'slideIndex' => $slideIndex,
            'study' => $study,
            'studyId' => $studyId,
        ]);
    }

    /**
     * Move to next slide.
     */
    public function next(Request $request)
    {
        $slideIndex = $request->input('slide', 0) + 1;
        $studyId = $request->input('study_id');
        
        return redirect()->route('slb.presentation', [
            'slide' => $slideIndex,
            'study_id' => $studyId,
        ]);
    }

    /**
     * Move to previous slide.
     */
    public function previous(Request $request)
    {
        $slideIndex = max(0, $request->input('slide', 0) - 1);
        $studyId = $request->input('study_id');
        
        return redirect()->route('slb.presentation', [
            'slide' => $slideIndex,
            'study_id' => $studyId,
        ]);
    }

    /**
     * Reset presentation and return to dashboard.
     */
    public function reset()
    {
        session()->forget('presentation_slide');
        return redirect()->route('slb.dashboard');
    }
}

