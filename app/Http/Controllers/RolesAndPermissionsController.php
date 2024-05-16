<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RolesAndPermissionsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::where('name', '!=', 'Super Admin')->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', fn($row) => view('admin.roles-and-permissions.action', ['row' => $row]))
                ->rawColumns(['action'])
                ->make(true);
        }

        $permissionsCollection = Permission::get()->groupBy(function ($permission) {
            $nameParts = explode('.', $permission->name);
            return $nameParts[0] . ' ' . $nameParts[1]; // Kategori admin.user atau admin.post
            return $nameParts;
        });

        return view('admin.roles-and-permissions.index', ['permissionsCollection' => $permissionsCollection]);
    }

    public function show(Role $role, Request $request)
    {
        if ($request->ajax()) {
            $data = [
                'role' => $role,
                'permissions' => $role->permissions
            ];
            return response()->json($data);
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|exists:permissions,name',
        ]);



        $permissions = $validatedData['permissions'] ?? null;

        $role = Role::create($validatedData);

        // Memberikan permissions kepada role baru jika diatur
        if ($permissions !== null) {
            $role->givePermissionTo($permissions);
        }

        return response()->json(['success' => 'Roles created successfully!']);
    }

    public function update(Role $role, Request $request) {
        $rules = [
            'permissions' => 'nullable|exists:permissions,name'
        ];

        if ($request->name !== $role->name) {
            $rules['name'] = 'required|unique:roles,name';
        }

        $validatedData = $request->validate($rules);


        $permissions = $validatedData['permissions'] ?? null;

        $role->update($validatedData);

        $role->syncPermissions($permissions);

        return response()->json(['success' => 'Role updated successfully.']);
    }

    public function destroy(Role $role, Request $request) {
        $permissions = $role->permissions->pluck('id')->toArray();

        if ($role->name === 'Super Admin') {
            throw new \Exception("Cannot delete Super Admin.");
        }

        if (!empty($permissions)) {
            $role->revokePermissionTo($permissions);
        }

        $role->delete();

        return response()->json(['success' => 'Role deleted successfully.']);

    }
}
