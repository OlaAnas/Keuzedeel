<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    /**
     * Show list of periods.
     */
    public function index()
    {
        $periods = Period::orderBy('start_date', 'desc')->paginate(10);

        return view('admin.periods.index', [
            'periods' => $periods,
        ]);
    }

    /**
     * Show edit form for period.
     */
    public function edit($id)
    {
        $period = Period::findOrFail($id);

        return view('admin.periods.edit', [
            'period' => $period,
        ]);
    }

    /**
     * Update period.
     */
    public function update(Request $request, $id)
    {
        $period = Period::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:periods,name,'.$id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $period->update($validated);

        return redirect()->route('periods.index')
            ->with('success', 'Periode bijgewerkt.');
    }

    /**
     * Toggle enrollment open/closed.
     */
    public function toggleEnrollment($id)
    {
        $period = Period::findOrFail($id);

        // If opening, close all others
        if (! $period->enrollment_open) {
            Period::where('id', '!=', $period->id)->update(['enrollment_open' => false]);
        }

        $period->update(['enrollment_open' => ! $period->enrollment_open]);

        // If closing, apply minimum 15 rule
        if (! $period->enrollment_open) {
            $this->applyMinimum15Rule($period);
        }

        $action = $period->enrollment_open ? 'geopend' : 'gesloten';

        return back()->with('success', 'Inschrijving is '.$action.'.');
    }

    /**
     * Apply minimum 15 students rule.
     */
    private function applyMinimum15Rule($period)
    {
        $keuzedelen = \App\Models\Keuzedeel::where('active', true)->get();

        foreach ($keuzedelen as $keuzedeel) {
            $count = \App\Models\Enrollment::where('keuzedeel_id', $keuzedeel->id)
                ->where('period_id', $period->id)
                ->where('status', '!=', 'cancelled')
                ->count();

            // If less than 15 students, cancel all enrollments
            if ($count > 0 && $count < 15) {
                \App\Models\Enrollment::where('keuzedeel_id', $keuzedeel->id)
                    ->where('period_id', $period->id)
                    ->where('status', '!=', 'cancelled')
                    ->update(['status' => 'cancelled']);
            }
        }
    }
}
