<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of departments
     */
    public function index(Request $request)
    {
        $query = Department::query();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $departments = $query->orderBy('order', 'asc')->paginate(20);

        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new department
     */
    public function create()
    {
        $parentDepartments = Department::orderBy('name', 'asc')->get();
        return view('admin.departments.create', compact('parentDepartments'));
    }

    /**
     * Store a newly created department
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:departments,slug',
            'type' => 'required|in:faculty,office,center',
            'order' => 'nullable|integer',
            'parent_id' => 'nullable|string',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        Department::create($request->all());

        return redirect()->route('admin.departments.index')
            ->with('success', 'Tạo đơn vị thành công!');
    }

    /**
     * Show the form for editing a department
     */
    public function edit(string $id)
    {
        $department = Department::findOrFail($id);
        $parentDepartments = Department::where('_id', '!=', $id)->orderBy('name', 'asc')->get();

        return view('admin.departments.edit', compact('department', 'parentDepartments'));
    }

    /**
     * Update the specified department
     */
    public function update(Request $request, string $id)
    {
        $department = Department::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:departments,slug,' . $id . ',_id',
            'type' => 'required|in:faculty,office,center',
            'order' => 'nullable|integer',
            'parent_id' => 'nullable|string',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $department->update($request->all());

        return redirect()->route('admin.departments.index')
            ->with('success', 'Cập nhật đơn vị thành công!');
    }

    /**
     * Remove the specified department
     */
    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);

        // Check if department has children
        $hasChildren = Department::where('parent_id', $id)->exists();
        if ($hasChildren) {
            return back()->with('error', 'Không thể xóa đơn vị có đơn vị con. Vui lòng xóa các đơn vị con trước.');
        }

        // Check if department has users
        $hasUsers = \App\Models\User::where('department_id', $id)->exists();
        if ($hasUsers) {
            return back()->with('error', 'Không thể xóa đơn vị có người dùng. Vui lòng chuyển người dùng sang đơn vị khác trước.');
        }

        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Xóa đơn vị thành công!');
    }
}
