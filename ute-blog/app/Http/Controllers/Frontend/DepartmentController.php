<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Post;

class DepartmentController extends Controller
{
    /**
     * Display listing of all departments
     */
    public function index()
    {
        $faculties = Department::where('type', Department::TYPE_FACULTY)
            ->orderBy('order', 'asc')
            ->get();

        $offices = Department::where('type', Department::TYPE_OFFICE)
            ->orderBy('order', 'asc')
            ->get();

        $centers = Department::where('type', Department::TYPE_CENTER)
            ->orderBy('order', 'asc')
            ->get();

        return view('frontend.departments.index', compact('faculties', 'offices', 'centers'));
    }

    /**
     * Display single department page with content
     */
    public function show(string $slug)
    {
        $department = Department::where('slug', $slug)->firstOrFail();

        // Department's posts/news
        $posts = Post::published()
            ->where('department_id', $department->_id)
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();

        // Child departments (if any)
        $subDepartments = Department::where('parent_id', $department->_id)
            ->orderBy('order', 'asc')
            ->get();

        return view('frontend.departments.show', compact('department', 'posts', 'subDepartments'));
    }
}
