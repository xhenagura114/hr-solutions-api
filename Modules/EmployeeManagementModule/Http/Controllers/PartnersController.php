<?php

namespace Modules\EmployeeManagementModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\EmployeeManagementModule\Entities\Partner;
use Validator;


class PartnersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $partners = Partner::get();
        return view('employeemanagementmodule::partners.index', compact('partners'));
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
        $rules = [
            'first_name_create' => 'required',
            'last_name_create'  => 'required',
        ];

        $attributes = [
            'first_name_create' => 'firstname',
            'last_name_create'  => 'lastname',
            'birthday_create'  => 'birthday',
            'contact_create'    => 'contact',
            'company_create'  => 'interests',
            'job_position_create'  => 'institution',
            'email_create'      => 'email',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $createRequest = [
            "first_name" =>  $request->first_name_create,
            "last_name" =>  $request->last_name_create,
            "email" =>  $request->email_create,
            "contact" =>  $request->contact_create,
            "birthday" => $request->birthday_create,
            "company" => $request->company_create,
            "job_position" => $request->job_position_create,
        ];

        $partner = new Partner;

        $response = $this->applyChanges($partner, $createRequest, 'create');

        if($response)
            return redirect()->route('module.partners.index')->with(['flash_message' => 'Business Partner added successfully!']);

        return redirect()->route('module.partners.index')->with(['flash_message' => 'An error occurred! Business Partner couldn\'t be created!']);
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
    public function edit($id)
    {
        $partner = Partner::findOrFail($id);
        return view('employeemanagementmodule::partners.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'first_name_edit' => 'required',
            'last_name_edit'  => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json($validator->errors(), 200);
        }

        $updateRequest = [
            "first_name" =>  $request->first_name_edit,
            "last_name" =>  $request->last_name_edit,
            "email" =>  $request->email_edit,
            "contact" =>  $request->contact_edit,
            "birthday" => $request->birthday_edit,
            "company" => $request->company_edit,
            "job_position" => $request->job_position_edit,
        ];

        $partner = Partner::findOrFail($id);

        $response = $this->applyChanges($partner, $updateRequest, 'update');

        if($response)
            return response()->json([
                "success" => true,
                "message" => "Business Partner updated successfully!",
                "status" => "Ok",
            ], 200);

        return response()->json([
            "success" => false,
            "message" => "An error occurred!",
            "status" => "Error",
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $partner = Partner::where('id', $id);
        if($partner){
            $partner->delete();
            return response()->json([
                "success" => true,
                "message" => "Successfully Deleted",
                "status" => "Ok",
            ], 200);
        }

        return response()->json([
            "success" => false,
            "message" => "Partner not deleted",
            "status" => "Unprocessable Entity",
        ], 422);
    }

    /**
     * @return Response
     */
    public function loadTable()
    {
        $partners = Partner::get();

        return view('employeemanagementmodule::partners.load-table', compact('partners'));
    }

    /**
     * @param $object
     * @param $action
     * @param $data
     * @return bool
     */
    protected function applyChanges(Partner $object, $data, $type) : bool {
        try {
            if ($type === 'update')
                $object->update($data);
            else
                $object->create($data);
            return true;
        } catch (\Exception $e) {
            \Log::info($e);
            return false;
        }
    }
}
