<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Traits\MyUuid;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    use MyUuid;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->can('view-users')) {
            return redirect()->route('dashboard')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        return view('users.index');
    }

    /**
     * Get users.
     *
     * @return Yajra\DataTables\DataTables
     */
    public function getUsers()
    {
        if (!Auth::user()->can('view-users')) {
            return redirect()->route('dashboard')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $users = User::orderBy('created_at', 'desc')->get();

        return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('verified', function ($users) {
                    if ($users->verified === 1) {
                        $verified = 'Verified';
                    } else {
                        $verified = 'Pending';
                    }

                    return $verified;
                })
                ->addColumn('active', function ($users) {
                    if ($users->active === 1) {
                        $active = 'Active';
                    } else {
                        $active = 'Disabled';
                    }

                    return $active;
                })
                ->addColumn('audit_log', function ($users) {
                    if ($users->created_at == $users->updated_at) {
                        $auditLog = 'Created on ' . date('jS F Y @ g:i a', strtotime($users->created_at));
                    } else {
                        $auditLog = 'Updated on ' . date('jS F Y @ g:i a', strtotime($users->updated_at));
                    }

                    return $auditLog;
                })
                ->addColumn('action', function ($user) {
                    $actions = '';

                    if (Auth::user()->can('edit-user')) {
                        $actions .= '<a href="' . route('users.edit', ['uuid' => $user->uuid]) . '" class="card-link">Edit</a>';
                    }

                    if (Auth::user()->can('view-user')) {
                        $actions .= '<a href="' . route('users.show', ['uuid' => $user->uuid]) . '" class="card-link">View</a>';
                    }

                    return $actions;
                })
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('create-user')) {
            return redirect()->route('users.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $roles = Role::orderBy('name', 'desc')->get();

        return view('users.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create-user')) {
            return redirect()->route('users.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $request->validate([
            'username' => 'required|unique:users,username|max:30',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email|max:255',
        ]);

        $user = new User;
        $user->uuid = $this->generateUuid();
        $user->username = $request->username;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt(str_random(15));
        $user->api_token = str_random(60);
        $user->verified = true;
        $user->active = true;
        $user->save();

        $roles = $request->roles;

        if (!is_null($roles)) {
            $newUser = User::find($user->id);

            foreach ($roles as $id) {
                $role = Role::find($id);
                $newUser->attachRole($role);
            }
        }

        return redirect()->route('users.index')->with('alert', $this->getAlert('RECORD_CREATED'));
    }

    /**
     * Display the specified resource.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        if (!Auth::user()->can('view-user')) {
            return redirect()->route('users.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $user = User::where('uuid', $uuid)->firstOrFail();

        return view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        if (!Auth::user()->can('edit-user')) {
            return redirect()->route('users.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $user = User::where('uuid', $uuid)->firstOrFail();

        $roles = Role::orderBy('name', 'asc')->get();

        $currentRoles = [];

        foreach ($user->roles as $role) {
            $currentRoles[] = $role->id;
        }

        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'currentRoles' => $currentRoles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        if (!Auth::user()->can('edit-user')) {
            return redirect()->route('users.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $user = User::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id . '|max:30',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id . '|max:255',
        ]);

        $user->username = $request->username;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->active = ($request->active === '2') ? 0 : 1;
        $user->save();

        $roles = $request->roles;

        RoleUser::where('user_id', $user->id)->delete();

        if (!is_null($roles)) {
            foreach ($roles as $id) {
                $role = Role::find($id);
                $user->attachRole($role);
            }
        }

        return redirect()->route('users.show', ['uuid' => $user->uuid])->with('alert', $this->getAlert('RECORD_UPDATED'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        //
    }
}
