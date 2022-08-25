<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Spatie\Tags\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends Controller {
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
        $users = User::get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $roles = Role::where('name', '!=', 'Super-Admin')->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validatedData = $request->validate([
            // validate to see if roles are of the expected values
            'roles' => 'required',
            'roles.*' => Rule::in(['Editor', 'Verified User']),

            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        // create user with form data
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // delete all previous roles and set the selected roles
        $user->syncRoles($validatedData['roles']);
        $user->save();

        return redirect()->route('admin.users.index')->with('messages', ['User created.' => 'success']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        // Super Admins should not be editable
        if ($user->hasRole('Super-Admin')) return redirect('admin/users')
            ->with('messages', ['Cannot update superadmin user!' => 'Warning']);

        $roles = Role::where('name', '!=', 'Super-Admin')->get();

        return view('admin.users.create', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user) {
        // deny if trying to edit a super admin
        if ($user->hasRole('Super-Admin')) {
            return redirect()->route('admin.users.index')
                ->with('messages', ['Cannot update superadmin user!' => 'Warning']);
        }

        // validate to see if roles are of the expected values
        $validatedData = $request->validate([
            'roles' => 'required',
            'roles.*' => Rule::in(['Editor', 'Verified User']),
        ]);

        // delete all previous roles and set the selected roles
        $user->syncRoles($validatedData['roles']);
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('messages', ['Updated user roles successfully' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        //TODO: disable user
    }
}
