<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('majors')->get();
        return view('departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:255|unique:departments'
        ]);

        Department::create($validated);
        return redirect()->route('departments.index')->with('success', 'Department created successfully');
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:255|unique:departments,department_name,' . $department->department_id . ',department_id'
        ]);

        $department->update($validated);
        return redirect()->route('departments.index')->with('success', 'Department updated successfully');
    }
}
