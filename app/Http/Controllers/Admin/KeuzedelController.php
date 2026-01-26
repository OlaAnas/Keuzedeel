<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuzedeel;
use App\Models\Study;
use App\Models\User;
use Illuminate\Http\Request;

class KeuzedelController extends Controller
{
    /**
     * Show list of all keuzedelen.
     */
    public function index()
    {
        $keuzedelen = Keuzedeel::with(['teacher', 'study'])
            ->orderBy('code')
            ->paginate(10);

        return view('admin.keuzedelen.index', [
            'keuzedelen' => $keuzedelen,
        ]);
    }

    /**
     * Show the create form.
     */
    public function create()
    {
        $teachers = User::where('role', 'teacher')->orderBy('first_name')->get();
        $studies = Study::orderBy('name')->get();
        $periods = \App\Models\Period::orderBy('start_date')->get();

        return view('admin.keuzedelen.create', [
            'teachers' => $teachers,
            'studies' => $studies,
            'periods' => $periods,
        ]);
    }

    /**
     * Store a new keuzedeel.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:keuzedelen,code|max:50',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'min_students' => 'required|integer|min:1',
            'max_students' => 'required|integer|min:1',
            'teacher_id' => 'nullable|exists:users,id',
            'study_id' => 'nullable|exists:studies,id',
            'period_id' => 'nullable|exists:periods,id',
            'repeatable' => 'boolean',
        ], [
            'code.unique' => 'A keuzedeel with this code already exists.',
            'max_students.min' => 'Max students must be at least 1.',
            'min_students.min' => 'Min students must be at least 1.',
        ]);

        // Validate that max >= min
        if ($validated['max_students'] < $validated['min_students']) {
            return back()->withErrors([
                'max_students' => 'Maximum students cannot be less than minimum students.',
            ])->withInput();
        }

        $validated['active'] = true; // New keuzedelen are active by default
        $validated['repeatable'] = $request->boolean('repeatable');

        Keuzedeel::create($validated);

        return redirect()->route('keuzedelen.index')
            ->with('success', 'Keuzedeel created successfully.');
    }

    /**
     * Show the edit form.
     */
    public function edit($id)
    {
        $keuzedeel = Keuzedeel::findOrFail($id);
        $teachers = User::where('role', 'teacher')->orderBy('first_name')->get();
        $studies = Study::orderBy('name')->get();
        $periods = \App\Models\Period::orderBy('start_date')->get();

        return view('admin.keuzedelen.edit', [
            'keuzedeel' => $keuzedeel,
            'teachers' => $teachers,
            'studies' => $studies,
            'periods' => $periods,
        ]);
    }

    /**
     * Update a keuzedeel.
     */
    public function update(Request $request, $id)
    {
        $keuzedeel = Keuzedeel::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|unique:keuzedelen,code,'.$id.'|max:50',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'min_students' => 'required|integer|min:1',
            'max_students' => 'required|integer|min:1',
            'teacher_id' => 'nullable|exists:users,id',
            'study_id' => 'nullable|exists:studies,id',
            'period_id' => 'nullable|exists:periods,id',
            'repeatable' => 'boolean',
        ], [
            'code.unique' => 'A keuzedeel with this code already exists.',
            'max_students.min' => 'Max students must be at least 1.',
            'min_students.min' => 'Min students must be at least 1.',
        ]);

        // Validate that max >= min
        if ($validated['max_students'] < $validated['min_students']) {
            return back()->withErrors([
                'max_students' => 'Maximum students cannot be less than minimum students.',
            ])->withInput();
        }

        $validated['repeatable'] = $request->boolean('repeatable');

        $keuzedeel->update($validated);

        return redirect()->route('keuzedelen.index')
            ->with('success', 'Keuzedeel updated successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive($id)
    {
        $keuzedeel = Keuzedeel::findOrFail($id);
        $keuzedeel->update([
            'active' => ! $keuzedeel->active,
        ]);

        $status = $keuzedeel->active ? 'activated' : 'deactivated';

        return back()->with('success', "Keuzedeel {$status} successfully.");
    }

    /**
     * Delete a keuzedeel.
     */
    public function destroy($id)
    {
        $keuzedeel = Keuzedeel::findOrFail($id);
        $keuzedeel->delete();

        return redirect()->route('keuzedelen.index')
            ->with('success', 'Keuzedeel deleted successfully.');
    }
}
