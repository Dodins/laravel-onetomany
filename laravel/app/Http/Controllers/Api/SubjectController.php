<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        return Subject::all();
    }

    public function store(Request $request)
    {

        return Subject::create($request->all());
    }

    public function update(Request $request, Subject $id)
    {

        $id->update($request->all());
        return response($id);
    }
    public function destroy(Subject $id)
    {
        return $id->delete();
    }
}
