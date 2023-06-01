<?php

namespace Modules\SystemSettingsModule\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SystemSettingsModule\Entities\JobPosition;
use Validator;

class PositionController extends SystemSettingsModuleController
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $positions = JobPosition::all();

        return view('systemsettingsmodule::positions.index', compact('positions'));
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
            'position' => 'required|min:2|max:150'
        ]);

        $position = new JobPosition;
        $position->title = $request->input('position');
        $position->save();

        return redirect()->back()->with(['flash_message' => 'Position created successfully!']);
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
        $position = JobPosition::findOrFail($id);

        return view('systemsettingsmodule::positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'position' => 'required|min:2|max:150'

        ];

        $attributes = [
            'position' => 'job position',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator], 422);
        }

        try {
            $position = JobPosition::findOrFail($id);
            $position->title = $request->input('position');
            $position->save();
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }


        return response()->json(['status' => 'success', 'message' => 'Position successfully updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $position = JobPosition::findOrFail($id);
            $position->delete();
            return response()->json(["status" => "success"]);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}
