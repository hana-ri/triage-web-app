<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query()->with('roles')->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('roles', fn(User $user) => $user->roles()->first()->name ?? 'Not set')
                ->addColumn('action', fn($row) => view('admin.user.action', ['row' => $row]))
                ->rawColumns(['action'])
                ->toJson(true);
        }

        return view('admin.user.index', [
            'roles' => Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create($validatedData);

        $user->assignRole($validatedData['role']);

        return response()->json(['success' => 'User created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Request $request)
    {
        if ($request->ajax()) {
            // dd($user->roles()->first()->name);
            // return $user;
            return response()->json([
                'role' => $user->roles()->first()->name ?? null,
                'user' => $user,
            ]);
        }
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [];

        if ($request->filled('name')) {
            $rules['name'] = 'required';
        }

        if ($request->filled('email') && $request->email !== $user->email) {
            $rules['email'] = 'required|email|unique:users';
        }

        if ($request->filled('password')) {
            $rules['password'] = 'required|min:6|confirmed';
        }

        if ($request->filled('role')) {
            $rules['role'] = 'required|exists:roles,name';
        }

        $validatedData = $request->validate($rules);

        $user->update($validatedData);
        if (!$request->filled('password')) {
            $user->syncRoles($validatedData['role']);
        }

        return response()->json(['success' => 'User updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['success' => 'User deleted successfully.']);
    }
}
