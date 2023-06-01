<?php

namespace Modules\SystemSettingsModule\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SystemSettingsModule\Entities\Role;
use Route;
use Sentinel;

class RoleController extends SystemSettingsModuleController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $roles = Role::where("id", "!=", 1 )->get();

        $usersWithRoles = User::whereHas("roles")->where("id", '!=', 1)->get();

        $users = User::where("id", '!=', 1)->get();

        return view('systemsettingsmodule::access-control.index', compact('roles', 'users', 'usersWithRoles'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('systemsettingsmodule::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $role = Role::create(
            [
                'name' => $request->role["name"],
                'slug' => $request->role["name"],
            ]
        );

        if(isset( $request->role["permissions"])){
            foreach ( $request->role["permissions"] as $persmission) {
                $role->addPermission($persmission);
            }
        }

        $role->save();

        if ($role) {
            return redirect()->back();
        }

        return response()->json([
            "success" => false,
            "status" => "Unprocessable entity",
            "message" => "An error occurred",
        ], 422);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('systemsettingsmodule::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $role = $user = null;
        if(!key_exists("action-for", Route::getFacadeRoot()->current()->getAction())){
            $role = Role::find($id);
        }else{
            $user = User::find($id);
        }

        $routes =  Route::getRoutes()->getRoutes();

        $modules = [];
        foreach ($routes as $route){
            //return ();
            if($route->getName() && explode(".", $route->getName())[0] !== "debugbar" && explode(".", $route->getName())[0] !== "passport") {
                $module = explode(".", $route->getName());
                $title = $module[0].' '.$module[1];
                $modules[$title]["title"][] = $module[2] ;
                $modules[$title]["routes"][] = $route->getName() ;
            }
        }

        return view('systemsettingsmodule::access-control.edit', compact('role', 'modules', 'user'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = null;
        $success = false;

        if(!key_exists("action-for", Route::getFacadeRoot()->current()->getAction())){
            $role = Role::find($id);
            $data = $role;
        }else{
            $user = User::find($id);
            $data = $user;
        }

        if(isset($request->role['permissions']) && count($request->role['permissions']) > 0 ){
            if($data && count($data->permissions) >= 0){
                foreach ($data->permissions as $key => $permission){
                    $data->removePermission($key);
                }

                foreach ($request->role['permissions'] as $reqPermission){
                    $data->addPermission($reqPermission);
                }

                $success = true;
            }
        }
        else{
            foreach ($data->permissions as $key => $permission){
                $data->removePermission($key);
            }
            $success = true;
        }

        if($success){
            $data->save();
            return redirect()->back()->with(["success_updated" => "Success Updated"]);
        }

        return redirect()->back()->with(["fail_update" => "Fail to update role"]);


    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id)->delete();

        if($role){
            return response()->json([
                "success" => true,
                "status" => "Ok",
                "message" => "Successfully deleted",
            ], 200);
        }

        return response()->json([
            "success" => false,
            "status" => "Unprocessable Entity",
            "message" => "Role not deleted",
        ], 422);
    }


    public function setRole(Request $request){

        $user = User::findOrFail($request->user);

        $role = Role::findOrFail($request->role);

        try{
            $user->roles()->detach();
        }catch (\Exception $e){
            Log::info($e);
        }

        $role->users()->attach($user);

        if($request->ajax()){
            return response()->json([
                "success" => true,
                "status" => "Ok",
                "message" => "Successfully deleted",
                "role" => $user->roles->first()->name,
            ], 200);
        }
        return redirect()->back();
    }
}
