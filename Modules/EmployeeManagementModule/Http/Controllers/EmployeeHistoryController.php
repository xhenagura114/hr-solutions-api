<?php

namespace Modules\EmployeeManagementModule\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class EmployeeHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $users = User::with('departments')->onlyTrashed()->where("id", "!=", 1)->orderBy('contract_end', 'desc')->get();
        $departments = User::with('departments')->onlyTrashed()->where("id", "!=", 1)->distinct()->whereNotNull('department_id')->get(['department_id']);
        $company_enum = get_enums('users', 'company');

        return view('employeemanagementmodule::employee-history.index', compact('users', 'departments', 'company_enum'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('employeemanagementmodule::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('employeemanagementmodule::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('employeemanagementmodule::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->where("id", "!=", 1);
        if($user){
            $user->forceDelete();
            return response()->json([
                "success" => true,
                "message" => "Successfully Deleted",
                "status" => "Ok",
            ], 200);
        }

        return response()->json([
            "success" => false,
            "message" => "Employee not deleted",
            "status" => "Unprocessable Entity",
        ], 422);
    }

    /**
     * Restore the specified resource.
     * @param $id
     *
     * @return Response
     */
    public function restore($id)
    {
        $user = User::where('id', $id)->where("id", "!=", 1);
        if($user){
            $user->restore();
            return response()->json([
                "success" => true,
                "message" => "Successfully Restored",
                "status" => "Ok",
            ], 200);
        }

        return response()->json([
            "success" => false,
            "message" => "Employee not restored",
            "status" => "Unprocessable Entity",
        ], 422);
    }
}
