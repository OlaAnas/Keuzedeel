<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Study;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Show list of all students.
     */
    public function index(Request $request)
    {
        $students = User::where('role', 'student')
            ->with('study')
            ->orderBy('first_name')
            ->paginate(20);

        // If AJAX request, return only the table rows
        if ($request->ajax()) {
            return view('admin.students.partials.table-rows', [
                'students' => $students,
            ]);
        }

        return view('admin.students.index', [
            'students' => $students,
        ]);
    }

    /**
     * Show the bulk import form.
     */
    public function import()
    {
        $studies = Study::orderBy('name')->get();

        return view('admin.students.import', [
            'studies' => $studies,
        ]);
    }

    /**
     * Store bulk imported students.
     */
    public function storeImport(Request $request)
    {
        $validated = $request->validate([
            'student_data' => 'required|string',
            'study_id' => 'required|exists:studies,id',
        ]);

        $studyId = $validated['study_id'];
        $data = $validated['student_data'];

        // Parse the input data
        $lines = array_filter(array_map('trim', preg_split('/[\r\n]+/', $data)));
        
        $importedCount = 0;
        $errors = [];
        $createdStudents = [];

        foreach ($lines as $line) {
            // Extract student number from the line
            // Expected format: "1234567 Name Lastname" or just "1234567"
            $parts = preg_split('/\s+/', $line, 2);
            
            if (empty($parts[0]) || !is_numeric($parts[0])) {
                $errors[] = "Ongeldig formaat: '{$line}' - verwacht: 'nummer [naam]'";
                continue;
            }

            $studentNumber = trim($parts[0]);
            $name = isset($parts[1]) ? trim($parts[1]) : "Student {$studentNumber}";
            
            // Check if student number already exists
            if (User::where('student_number', $studentNumber)->exists()) {
                $errors[] = "Student {$studentNumber} bestaat al";
                continue;
            }

            // Generate email
            $email = "{$studentNumber}@student.tcr.nl";
            
            // Check if email already exists
            if (User::where('email', $email)->exists()) {
                $errors[] = "Email {$email} bestaat al";
                continue;
            }

            // Split name into first and last name
            $nameParts = explode(' ', $name, 2);
            $firstName = $nameParts[0] ?? "Student";
            $lastName = $nameParts[1] ?? $studentNumber;

            try {
                $student = User::create([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt($studentNumber), // Default password is student number
                    'role' => 'student',
                    'student_number' => $studentNumber,
                    'study_id' => $studyId,
                ]);

                $createdStudents[] = $student;
                $importedCount++;
            } catch (\Exception $e) {
                $errors[] = "Fout bij toevoegen {$studentNumber}: " . $e->getMessage();
            }
        }

        return redirect()->route('students.index')
            ->with([
                'success' => "{$importedCount} studenten succesvol geïmporteerd.",
                'errors' => $errors,
                'createdStudents' => $createdStudents,
            ]);
    }

    /**
     * Show the edit form.
     */
    public function edit($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        $studies = Study::orderBy('name')->get();

        return view('admin.students.edit', [
            'student' => $student,
            'studies' => $studies,
        ]);
    }

    /**
     * Update a student.
     */
    public function update(Request $request, $id)
    {
        $student = User::where('role', 'student')->findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id.'|max:255',
            'study_id' => 'required|exists:studies,id',
            'class_name' => 'nullable|string|max:255',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student succesvol bijgewerkt.');
    }

    /**
     * Delete a student.
     */
    public function destroy($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student succesvol verwijderd.');
    }
}
