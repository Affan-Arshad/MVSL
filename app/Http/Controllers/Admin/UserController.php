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
        if ($user->hasRole('Super-Admin')) {
            return redirect('admin/users')
                ->with('messages', ['Cannot update superadmin user!' => 'warning']);
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
            return redirect()->route('admin.users.index')
                ->with('messages', ['Cannot update superadmin user!' => 'warning']);
        }

        // validate to see if roles are of the expected values
        $validatedData = $request->validate([
            'roles.*' => [Rule::in(Role::pluck('name')->toArray()), 'not_in:Super-Admin']
        ]);

        // delete all previous roles and set the selected roles
        if (!isset($validatedData['roles'])) $validatedData['roles'] = null;
        $user->syncRoles($validatedData['roles']);
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('messages', ['Updated user roles successfully' => 'success']);
    }

    public function toggleStatus(Request $request, $id) {
        // check if previous url parameter id and current id matches
        $previousId = $this->prev_segments(url()->previous())[2];
        if ($previousId != $id) return redirect()->back()->with('messages', ["Could not complete action. There was an error!" => "danger"]);

        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->save();

        $messages = [];
        if ($user->status) $messages['User activated'] = 'info';
        else $messages['User disabled'] = 'danger';

        return redirect()->back()->with('messages', $messages);
    }

    public function changePasswordForm() {
        return view('admin.changePassword');
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

        return redirect()->back()->with('messages', ['Password changed (not really)' => 'success']);
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
