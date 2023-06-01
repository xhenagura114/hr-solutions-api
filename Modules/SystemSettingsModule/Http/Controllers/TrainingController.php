<?php

namespace Modules\SystemSettingsModule\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Modules\EmployeeManagementModule\Entities\UserTraining;
use Modules\SystemSettingsModule\Entities\Department;
use Modules\SystemSettingsModule\Entities\Training;

class TrainingController extends SystemSettingsModuleController
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //$trainingWithDpartments = Department::with('trainings')->get();
        $trainings = UserTraining::all();
        $departments = Department::all();
        return view('systemsettingsmodule::trainings.index', compact('trainings', 'departments'));
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

        $this->validate($request, [
            'title' => 'required|min:2|max:150',
            'department_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);


        $training = UserTraining::create($request->all());

        if(isset($request->training_file)){
            $docName = date("YmdHis_") . $request->training_file->getClientOriginalName();
            $trainingFileUrl =  $save_cv = Storage::disk("public")->putFileAs('trainings', $request->training_file, $docName);

            $training->update([
                "training_file" => $trainingFileUrl,
            ]);
        }

        return redirect()->back()->with(['flash_message' => 'Training created successfully']);
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

        $training = UserTraining::findOrFail($id);
        $departments = Department::all();


        return view('systemsettingsmodule::trainings.edit', compact('training', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
//        dd($request->all());
        $this->validate($request, [
            'training_title' => 'required|min:2|max:150',
            'department_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $training = UserTraining::findOrFail($id);
        $training->title = $request->input('training_title');
        $training->department_id = $request->input('department_id');
        $training->training_description = $request->input('training_description');
        if(isset($request->training_file)) {
            $docName = date("YmdHis_") . $request->training_file->getClientOriginalName();
            $trainingFileUrl = $save_cv = Storage::disk("public")->putFileAs('trainings', $request->training_file, $docName);
            $training->training_file = $trainingFileUrl;
        }

        $training->start_date = $request->input('start_date');
        $training->end_date = $request->input('end_date');
        try{
            $training->save();

            return response()->json([
                "success" => true,
                "message" => "Successfully Updated",
                "status" => "ok",
            ], 200);

        }catch (\Exception $e){
            \Log::info($e);
        }

        return response()->json([
            "success" => false,
            "message" => "Changes not saved, an error occurred!",
            "status" => "Unprocessable Entity",
        ], 422);
//        $training->save();
//
//        return redirect()->back()->with(['flash_message' => 'Training edited successfully']);
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        $training = UserTraining::find($id);
        $training->user()->detach();
        try {
            $training->delete();
            return response()->json(["status" => "success"]);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }

    }
}
