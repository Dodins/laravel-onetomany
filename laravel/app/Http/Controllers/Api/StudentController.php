<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('subjects')->get();

        return response()->json($students);
    }

    public function store(Request $request)
    {
        $student = Student::create($request->all());

        $student->subjects()->createMany(
            $request->input('subjects', [])
        );

        return response('Created Successfully!');
    }

    public function show($id)
    {
        return Student::with('subjects')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        // Find the student by ID
        $student = Student::findOrFail($id);

        // Update the student's attributes based on the data provided in the request
        $student->update($request->all());

        // Update associated subjects if subjects data is provided in the request
        if ($request->has('subjects')) {
            $subjectsData = $request->input('subjects');

            foreach ($subjectsData as $subjectData) {
                if (isset($subjectData['id'])) {
                    // Find the subject by its ID
                    $subject = Subject::findOrFail($subjectData['id']);
                    // Update the subject attributes
                    $subject->update($subjectData);
                } else {
                    // If the subject doesn't have an 'id' field, it means it's a new subject
                    // Create the new subject
                    $student->subjects()->create($subjectData);
                }
            }
        }

        // Optionally, you may eager load the subjects relationship before returning the updated student
        $student->load('subjects');

        return $student;
    }

    public function destroy(Student $student)
    {

        $student->subjects()->delete();
        $student->delete();
        return response('Deleted Succesfully!');
    }
}
