<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Keuzedeel;
use App\Models\Period;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of all enrollments with filters.
     */
    public function index(Request $request)
    {
        $query = Enrollment::with(['user', 'keuzedeel', 'period']);

        // Filter by keuzedeel
        if ($request->filled('keuzedeel_id')) {
            $query->where('keuzedeel_id', $request->keuzedeel_id);
        }

        // Filter by period
        if ($request->filled('period_id')) {
            $query->where('period_id', $request->period_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Order by most recent first
        $enrollments = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get stats
        $allEnrollments = Enrollment::with(['user', 'keuzedeel', 'period']);
        $totalEnrollments = $allEnrollments->count();
        $activeEnrollments = $allEnrollments->where('status', 'enrolled')->count();
        $cancelledEnrollments = $allEnrollments->where('status', 'cancelled')->count();

        // Get available keuzedelen and periods for filters
        $keuzedelen = Keuzedeel::orderBy('code')->get();
        $periods = Period::orderBy('start_date')->get();

        return view('admin.enrollments.index', [
            'enrollments' => $enrollments,
            'keuzedelen' => $keuzedelen,
            'periods' => $periods,
            'totalEnrollments' => $totalEnrollments,
            'activeEnrollments' => $activeEnrollments,
            'cancelledEnrollments' => $cancelledEnrollments,
        ]);
    }

    /**
     * Cancel an enrollment (admin action).
     */
    public function cancel($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        
        if ($enrollment->status === 'enrolled') {
            $enrollment->update(['status' => 'cancelled']);
            
            return back()->with('success', 'Inschrijving geannuleerd.');
        }

        return back()->with('error', 'Kan alleen actieve inschrijvingen annuleren.');
    }

    /**
     * Restore a cancelled enrollment (admin action).
     */
    public function restore($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        
        if ($enrollment->status === 'cancelled') {
            $enrollment->update(['status' => 'enrolled']);
            
            return back()->with('success', 'Inschrijving hersteld.');
        }

        return back()->with('error', 'Kan alleen geannuleerde inschrijvingen herstellen.');
    }
}
