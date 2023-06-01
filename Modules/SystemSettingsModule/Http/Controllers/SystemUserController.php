<?php

namespace Modules\SystemSettingsModule\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use App\User;

//Importing laravel-permission models

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

//use Spatie\Permission\Models\Permission;

//use Illuminate\Contracts\Session\Session;

class SystemUserController extends SystemSettingsModuleController
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

//        $users = User::all();
        $roles = Role::get();

        $users = User::role($roles)->get(); // only users that have roles in db

        $all_other_users = User::select(DB::raw("CONCAT(first_name,' ',last_name) AS full_name"), 'id')->where("id", "!=", 1)->get()->except($users->pluck('id')->toArray());


        return view('systemsettingsmodule::access-rights.system-users.index', compact('users', 'roles', 'all_other_users'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('systemsettingsmodule::access-rights.system-users.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $new_user_id = $request->input('new_user_id');
        $user = User::findOrFail($new_user_id);

        $role = $request->input('role');

        if (isset($role)) {

            $role_DB = Role::where('id', '=', $role)->firstOrFail();
            $user->assignRole($role_DB); //Assigning role to user

            return redirect()->route('system-settings.access-rights.system-users.index')
                ->with('flash_message',
                    'System user added successfully');

        } else {

            return redirect()->route('system-settings.access-rights.system-users.index')
                ->with('flash_message',
                    'System user not added');
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {

        return view('systemsettingsmodule::access-rights.system-users.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); //Get user with specified id
        $roles = Role::get(); //Get all roles

        return view('systemsettingsmodule::access-rights.system-users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); //Get role specified by id

//        $input = $request->only(['name', 'email', 'password']); //Retreive the name, email and password fields
//        $user->fill($input)->save();

        $role = $request['role']; //Retreive all roles
        if (isset($role)) {
            $user->roles()->sync($role);  //If one or more role is selected associate user to roles
        } else {
            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }
        return redirect()->route('system-settings.access-rights.system-users.index')
            ->with('flash_message',
                'User successfully edited.');
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
//        dd($request->method());

        $user = User::findOrFail($id);
        $user->roles()->detach();

        return redirect()->route('system-settings.access-rights.system-users.index')
            ->with('flash_message',
                'User still exists but he/she has no roles in the system!');


    }

//----------------------------------AJAX CALLS-----------------------------------------------------

    public function jsonUserById($id)
    {
        $user = User::findOrFail($id); //Get user with specified id
        $roles = $user->roles; //Get all roles

        $u['id'] = $user->id;
        $u['full_name'] = $user->first_name . ' ' . $user->last_name;
        $u['photo_path'] = $user->photo_path;

        $r = array_map(function ($role) {
            $data['id'] = $role['id'];
            $data['name'] = $role['name'];

            return $data;

        }, $roles->toArray());


        $all_roles = Role::all()->toArray();

        $all = array_map(function ($role) {
            $data['id'] = $role['id'];
            $data['name'] = $role['name'];

            return $data;

        }, $all_roles);


        return response()->json(['user' => $u, 'user_roles' => $r, 'all_roles' => $all]);
    }

    public function jsonDeleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->roles()->detach();

            return response()->json(['status' => 'success', 'message' => 'User has been successfully removed from system rights!']);

        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

    }
}
