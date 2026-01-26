<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Show list of all teachers.
     */
    public function index()
    {
        $teachers = User::where('role', 'teacher')
            ->orderBy('first_name')
            ->paginate(10);

        return view('admin.teachers.index', [
            'teachers' => $teachers,
        ]);
    }

    /**
     * Show the create form.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a new teacher.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'teacher',
        ]);

        return redirect()->route('teachers.index')
            ->with('success', 'Docent succesvol aangemaakt.');
    }

    /**
     * Show the edit form.
     */
    public function edit($id)
    {
        $teacher = User::where('role', 'teacher')->findOrFail($id);

        return view('admin.teachers.edit', [
            'teacher' => $teacher,
        ]);
    }

    /**
     * Update a teacher.
     */
    public function update(Request $request, $id)
    {
        $teacher = User::where('role', 'teacher')->findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id.'|max:255',
        ]);

        $teacher->update($validated);

        return redirect()->route('teachers.index')
            ->with('success', 'Docent succesvol bijgewerkt.');
    }

    /**
     * Delete a teacher.
     */
    public function destroy($id)
    {
        $teacher = User::where('role', 'teacher')->findOrFail($id);
        $teacher->delete();

        return redirect()->route('teachers.index')
            ->with('success', 'Docent succesvol verwijderd.');
    }
}
