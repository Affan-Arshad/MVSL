<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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
            'roles.*' => [Rule::in(Role::pluck('name')->toArray()), 'not_in:Super-Admin'],

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

        flashMessage('User created', 'success');

        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        // Super Admins should not be editable
        if ($user->hasRole('Super-Admin')) {
            flashMessage('Cannot update superadmin user!', 'warning');
            return redirect('admin/users');
        }

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
            flashMessage('Cannot update superadmin user!', 'warning');
            return redirect()->route('admin.users.index');
        }

        // validate to see if roles are of the expected values
        $validatedData = $request->validate([
            'roles.*' => [Rule::in(Role::pluck('name')->toArray()), 'not_in:Super-Admin']
        ]);

        // delete all previous roles and set the selected roles
        if (!isset($validatedData['roles'])) $validatedData['roles'] = null;
        $user->syncRoles($validatedData['roles']);
        $user->save();

        flashMessage('Updated user roles successfully', 'success');

        return redirect()->route('admin.users.index');
    }

    public function toggleStatus(Request $request, $id) {
        // check if previous url parameter id and current id matches
        $previousId = $this->prev_segments(url()->previous())[2];
        if ($previousId != $id) {

            flashMessage('Could not complete action. There was an error!', 'danger');
            return redirect()->back();
        }

        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->save();

        if ($user->status) flashMessage('User activated', 'info');
        else flashMessage('User disabled', 'danger');

        return redirect()->back();
    }

    public function changePasswordForm() {
        return view('admin.users.changePassword');
    }

    public function changePassword(Request $request) {

        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth()->user()->getAuthPassword())) {
                    $fail('Incorrect Current Password');
                };
            }],
            'new_password' => 'required|confirmed'
        ]);

        $user = User::find(Auth()->user()->id);
        $user->password = Hash::make($request->new_password);
        $user->save();

        flashMessage('Password changed!', 'success');

        return redirect()->back();
    }

    /**
     * Get all of the segments for the previous uri.
     *
     * @return array
     */
    public function prev_segments($uri) {
        $segments = explode('/', str_replace('' . url('') . '', '', $uri));

        return array_values(array_filter($segments, function ($value) {
            return $value !== '';
        }));
    }
}
