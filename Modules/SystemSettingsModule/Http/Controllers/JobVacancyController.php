<?php

namespace Modules\SystemSettingsModule\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SystemSettingsModule\Entities\JobPosition;
use Modules\SystemSettingsModule\Entities\JobVacancy;

class JobVacancyController extends SystemSettingsModuleController
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $job_positions = JobPosition::all();
        $jobVacancies = JobVacancy::all();
        return view('systemsettingsmodule::job-vacancies.index', compact('jobVacancies', 'job_positions'));
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
            'job_position' => 'required|min:2|max:150'
        ]);

        JobVacancy::create([
            'position' => $request->job_position,
            'description' => $request->description,
            'expiration' => $request->expiration,
        ]);

        return redirect()->back()->with(['flash_message' => 'Job vacancy added successfully!']);
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
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $job_vacancy = JobVacancy::findOrFail($id);

        return view('systemsettingsmodule::job-vacancies.edit', compact('job_vacancy'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'job_position' => 'required|min:2|max:150'
        ]);

        $job_vacancy = JobVacancy::findOrFail($id);
        $job_vacancy->position = $request->input('job_position');
        $job_vacancy->expiration = $request->input('expiration');
        $job_vacancy->description = $request->input('description');
        try{
            $job_vacancy->save();

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
//        $job_vacancy->save();

//        return redirect()->back()->with(['flash_message' => 'Job vacancy updated successfully!']);


    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $job_vacancy = JobVacancy::findOrFail($id);
            $job_vacancy->delete();
            return response()->json(["status" => "success"]);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }


    }
}
