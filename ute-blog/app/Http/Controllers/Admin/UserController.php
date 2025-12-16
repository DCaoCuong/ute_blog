<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by department
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Search by name, email, or user_code
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('user_code', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        $departments = \App\Models\Department::orderBy('name')->get();

        return view('admin.users.index', compact('users', 'departments'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $departments = \App\Models\Department::orderBy('name')->get();
        return view('admin.users.create', compact('departments'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_code' => 'required|string|unique:users,user_code',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,content_manager,member',
            'status' => 'required|in:active,inactive,pending',
            'department_id' => 'nullable|string',
        ]);

        User::create([
            'user_code' => strtoupper(trim($request->user_code)),
            'name' => $request->name,
            'email' => strtolower(trim($request->email)),
            'password' => $request->password,
            'role' => $request->role,
            'status' => $request->status,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Tạo người dùng thành công!');
    }

    /**
     * Show the form for editing a user
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $departments = \App\Models\Department::orderBy('name')->get();
        return view('admin.users.edit', compact('user', 'departments'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'user_code' => 'required|string|unique:users,user_code,' . $id . ',_id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',_id',
            'role' => 'required|in:admin,content_manager,member',
            'status' => 'required|in:active,inactive,pending',
            'department_id' => 'nullable|string',
        ]);

        $data = [
            'user_code' => strtoupper(trim($request->user_code)),
            'name' => $request->name,
            'email' => strtolower(trim($request->email)),
            'role' => $request->role,
            'status' => $request->status,
            'department_id' => $request->department_id,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $data['password'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Cập nhật người dùng thành công!');
    }

    /**
     * Remove the specified user
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself
        if ($user->_id === auth()->id()) {
            return back()->with('error', 'Bạn không thể xóa chính mình!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Xóa người dùng thành công!');
    }

    /**
     * Approve a pending user
     */
    public function approve(string $id)
    {
        $user = User::findOrFail($id);

        $user->update(['status' => User::STATUS_ACTIVE]);

        return back()->with('success', "Đã phê duyệt tài khoản của {$user->name}!");
    }

    /**
     * Reject/Deactivate a user
     */
    public function reject(string $id)
    {
        $user = User::findOrFail($id);

        $user->update(['status' => User::STATUS_INACTIVE]);

        return back()->with('success', "Đã từ chối/khóa tài khoản của {$user->name}!");
    }

    /**
     * Bulk approve pending users
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'string',
        ]);

        $count = User::whereIn('_id', $request->user_ids)
            ->update(['status' => User::STATUS_ACTIVE]);

        return redirect()->route('admin.users.index')
            ->with('success', "Đã phê duyệt {$count} tài khoản!");
    }
}
