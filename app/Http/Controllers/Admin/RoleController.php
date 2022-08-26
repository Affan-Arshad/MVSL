<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['role:Editor|Super-Admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $roles = Role::get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $permissions = Permission::get()->groupBy('group');
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // Validate Request Data
        $validatedData = $request->validate([
            'name' => 'required',
            'permissions.*' => Rule::in(Permission::pluck('name')->toArray())
        ]);

        $role = Role::create(['name' => $validatedData['name']]);

        if (!isset($validatedData['permissions'])) $validatedData['permissions'] = null;
        $role->syncPermissions($validatedData['permissions']);
        $role->save();

        return redirect()->route('admin.roles.index')->with('messages', ['Role created.' => 'success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role) {
        // Super Admins should not be editable
        if ($role->name == 'Super-Admin') {
            return redirect()->route('admin.roles.index')
                ->with('messages', ['Cannot update superadmin role!' => 'warning']);
        }

        $permissions = Permission::get()->groupBy('group');
        return view('admin.roles.create', compact('permissions', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role) {
        // Super Admins should not be editable
        if ($role->name == 'Super-Admin') {
            return redirect()->route('admin.roles.index')
                ->with('messages', ['Cannot update superadmin role!' => 'warning']);
        }

        // Validate Request Data
        $validatedData = $request->validate([
            'name' => 'required',
            'permissions.*' => Rule::in(Permission::pluck('name')->toArray())
        ]);

        if (!isset($validatedData['permissions'])) $validatedData['permissions'] = null;
        $role->syncPermissions($validatedData['permissions']);
        $role->save();

        return redirect()->route('admin.roles.index')->with('messages', ['Role updated.' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role) {
        // Super Admins should not be editable
        if ($role->name == 'Super-Admin') {
            return redirect()->route('admin.roles.index')
                ->with('messages', ['Cannot delete superadmin role!' => 'warning']);
        }

        // Cannot delete role with users
        if ($role->users()->count()) {
            return redirect()->route('admin.roles.index')
                ->with('messages', ['Cannot delete role with users!' => 'warning']);
        }

        $role->delete();
        return redirect()->route('admin.roles.index')
            ->with('messages', [$role->name . ' Role deleted.' => 'success']);
    }
}
