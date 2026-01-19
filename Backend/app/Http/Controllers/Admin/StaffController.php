<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Admin::latest()->paginate(10);
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'username' => 'required|string|unique:admins',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,superadmin,staff',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'active',
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member added successfully.');
    }

    public function edit(Admin $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, Admin $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $staff->id,
            'role' => 'required|in:admin,superadmin,staff',
            'status' => 'required|in:active,inactive',
        ]);

        $staff->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        if ($request->password) {
            $staff->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Admin $staff)
    {
        if ($staff->id == auth()->guard('admin')->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff member removed.');
    }
}
