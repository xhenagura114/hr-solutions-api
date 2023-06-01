<?php

namespace Modules\SystemSettingsModule\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class SystemRoleController extends SystemSettingsModuleController
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $roles = Role::all();//Get all roles
        $permissions = Permission::all();

        return view('systemsettingsmodule::access-rights.system-roles.index', ['roles' => $roles, 'permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('systemsettingsmodule::access-rights.system-roles.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        //Validate name and permissions field
        $this->validate($request, [
                'name' => 'required|unique:roles|max:20|min:2',
                'permissions' => 'required',
            ]
        );

        $name = $request['name'];
        $role = new Role();
        $role->name = $name;

        $permissions = $request['permissions'];

        $role->save();
        //Looping thru selected permissions
        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            //Fetch the newly created role and assign permission
            $role = Role::where('name', '=', $name)->first();
            $role->givePermissionTo($p);
        }

        return redirect()->route('system-settings.access-rights.system-roles.index')
            ->with('flash_message',
                'Role "<b>' . $role->name . '</b>" added!');

    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('systemsettingsmodule::access-rights.system-roles.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('systemsettingsmodule::access-rights.system-roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);//Get role with the given id

        //Validate name and permission fields
        $this->validate($request, [
            'name' => 'required|max:20|min:2|unique:roles,name,' . $id,
            'permissions' => 'required',
        ]);

        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];
        $role->fill($input)->save();

        $p_all = Permission::all();//Get all permissions

        foreach ($p_all as $p) {
            $role->revokePermissionTo($p); //Remove all permissions associated with role
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form //permission in db
            $role->givePermissionTo($p);  //Assign permission to role
        }

        return redirect()->route('system-settings.access-rights.system-roles.index')
            ->with('flash_message',
                'Role "<b>' . $role->name . '</b>" updated!');
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('system-settings.access-rights.system-roles.index')
            ->with('flash_message',
                'Role deleted!');

    }


    //----------------------------------AJAX CALLS-----------------------------------------------------

    public function jsonRoleById($id)
    {

        $role = Role::findOrFail($id);
        $permissions = $role->permissions;



        $r['id'] = $role->id;
        $r['name'] = $role->name;

        $p = array_map(function ($permission) {
            $data['id'] = $permission['id'];
            $data['name'] = $permission['name'];

            return $data;

        }, $permissions->toArray());

        $all_permissions = Permission::all()->toArray();

        $all = array_map(function ($permission) {
            $data['id'] = $permission['id'];
            $data['name'] = $permission['name'];

            return $data;

        }, $all_permissions);


        return response()->json(['role' => $r, 'role_permissions' => $p, 'all_permissions'=> $all]);
    }

    public function jsonDeleteRole($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return response()->json(['status' => 'success', 'message' => 'Role has been successfully removed from system rights!']);

        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

    }

}
