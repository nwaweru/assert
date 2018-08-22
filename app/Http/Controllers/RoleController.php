<?php
namespace App\Http\Controllers;

use App\Models\Role;
use App\Traits\MyUuid;
use App\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{

    use MyUuid;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->can('view-roles')) {
            return redirect()->route('dashboard')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        return view('roles.index');
    }

    /**
     * Get roles.
     *
     * @return Yajra\DataTables\DataTables
     */
    public function getRoles()
    {
        if (!Auth::user()->can('view-roles')) {
            return redirect()->route('dashboard')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $roles = Role::orderBy('name', 'asc')->get();

        return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('audit_log', function ($roles) {
                    if ($roles->created_at == $roles->updated_at) {
                        $auditLog = 'Created on ' . date('jS F Y @ g:i a', strtotime($roles->created_at));
                    } else {
                        $auditLog = 'Updated on ' . date('jS F Y @ g:i a', strtotime($roles->updated_at));
                    }

                    return $auditLog;
                })
                ->addColumn('action', function ($role) {
                    $actions = '';

                    if (Auth::user()->can('edit-role')) {
                        $actions .= '<a href="' . route('roles.edit', ['uuid' => $role->uuid]) . '" class="card-link">Edit</a>';
                    }

                    if (Auth::user()->can('view-role')) {
                        $actions .= '<a href="' . route('roles.show', ['uuid' => $role->uuid]) . '" class="card-link">View</a>';
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
        $permissions = Permission::orderBy('name', 'asc')->get();

        return view('roles.create', [
            'permissions' => $permissions
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
        $request->validate([
            'name' => 'required|unique:roles,name|max:255',
            'display_name' => 'required|unique:roles,display_name|max:255',
            'description' => 'required|unique:roles,description|max:255',
        ]);

        $role = new Role;
        $role->uuid = $this->generateUuid();
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        $role->attachPermission($request->permissions);

        return redirect()->route('roles.index')->with('alert', $this->getAlert('RECORD_CREATED'));
    }

    /**
     * Display the specified resource.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        if (!Auth::user()->can('view-role')) {
            return redirect()->route('roles.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $role = Role::where('uuid', $uuid)->firstOrFail();

        return view('roles.show', ['role' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        if (!Auth::user()->can('edit-role')) {
            return redirect()->route('roles.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $role = Role::where('uuid', $uuid)->firstOrFail();

        $permissions = Permission::orderBy('name', 'asc')->get();

        $currentPermissions = [];

        foreach ($role->permissions as $permission) {
            $currentPermissions[] = $permission->id;
        }

        return view('roles.edit', ['role' => $role, 'permissions' => $permissions, 'currentPermissions' => $currentPermissions]);
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
        if (!Auth::user()->can('edit-role')) {
            return redirect()->route('roles.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $role = Role::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id . '|max:255',
            'display_name' => 'required|unique:roles,display_name,' . $role->id . '|max:255',
            'description' => 'required|unique:roles,description,' . $role->id . '|',
        ]);

        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        $role->perms()->sync($request->permissions);

        return redirect()->route('roles.show', ['uuid' => $role->uuid])->with('alert', $this->getAlert('RECORD_UPDATED'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $role = Role::where('uuid', $uuid)->firstOrFail();
        $role->delete();
    }
}
