<?php

namespace Modules\SystemSettingsModule\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

//use App\User;

//Importing laravel-permission models

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class SystemPermissionController extends SystemSettingsModuleController
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $permissions = Permission::all(); //Get all permissions

        $roles = Role::get();

        return view('systemsettingsmodule::access-rights.system-permissions.index', ['permissions' => $permissions, 'roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('systemsettingsmodule::access-rights.system-permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|min:1|max:40',
        ]);


        $name = $request['name'];
        $permission = new Permission();
        $permission->name = $name;

        $roles = $request['roles'];

        $permission->save();

        if (!empty($request['roles'])) { //If one or more role is selected
            foreach ($roles as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail(); //Match input role to db record

                $permission = Permission::where('name', '=', $name)->first(); //Match input //permission to db record
                $r->givePermissionTo($permission);
            }
        }

        return redirect()->route('system-settings.access-rights.system-permissions.index')
            ->with('flash_message',
                'Permission "<b>' . $permission->name . '</b>" added!');

    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('systemsettingsmodule::access-rights.system-permissions.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('systemsettingsmodule::access-rights.system-permissions.edit', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $permission_old_name = $permission->name;

        $this->validate($request, [
            'name' => 'required|min:1|max:40',
        ]);

        $input = $request->all();
        $permission->fill($input)->save();

        return redirect()->route('system-settings.access-rights.system-permissions.index')
            ->with('flash_message',
                'Permission "<b>' . $permission_old_name . '" </b> updated to <b> "' . $permission->name . '"</b>');

    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {

            $permission = Permission::findOrFail($id);
            $permission->delete();

            return response()->json(["status" => "success", "message" => 'Permission <b>' . $permission->name . '</b> deleted!']);

//            return redirect()->route('system-settings.access-rights.system-permissions.index')->with('flash_message',
//                'Permission "<b>' . $permission->name . '</b>" deleted!');

        } catch (\Exception $e) {

            return response()->json(["status" => "error", "message" => $e->getMessage()]);

//            return redirect()->route('system-settings.access-rights.system-permissions.index')->with('flash_message',
//                $e->getMessage());
        }

//        dd($id);
//        dd($request->method());
    }

    //----------------------------------AJAX CALLS-----------------------------------------------------

    public function jsonPermissionById($id)
    {

        try {
            $permission = Permission::findOrFail($id);

            $p['id'] = $permission->id;
            $p['name'] = $permission->name;

            return response()->json(['permissions' => $p]);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Permission not found']);
        }

    }

    public function jsonDeletePermission($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();

            return response()->json(['status' => 'success', 'message' => 'Permission has been successfully removed from system rights!']);

        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

    }

}
