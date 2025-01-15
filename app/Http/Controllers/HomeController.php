<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Department;
use App\Models\Project;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'projects' => Project::count(),
            'departments' => Department::count(),
            'students' => User::where('role', 'student')->count(),
            'lecturers' => User::where('role', 'lecturer')->count()
        ];

        $categories = Category::withCount('projects')->get();
        return view('home', compact('categories', 'stats'));
    }
}
