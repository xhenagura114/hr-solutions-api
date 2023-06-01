<?php

namespace Modules\SystemSettingsModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\EmployeeManagementModule\Entities\Skill;
use phpDocumentor\Reflection\Types\Null_;
use Validator;

class SkillsSettingsController extends SystemSettingsModuleController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $skills = Skill::Where('title', '!=', Null)->get();
        $category = get_enums('skills', 'mainCategory');
        $super_category = get_enums('skills', 'superCategory');
        return view('systemsettingsmodule::skills.index', compact('skills', 'category', 'super_category'));
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
            'mainCategory' => 'required|min:2|max:150',
            ]);

        $skill = new Skill;
        $skill->mainCategory = $request->input('mainCategory');
        $skill->superCategory = $request->input('superCategory');
        $skill->title = $request->input('title');

        $skill->save();

        return redirect()->back()->with(['flash_message' => 'Skill created successfully!']);
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
        $skill = Skill::findOrFail($id);

        return view('systemsettingsmodule::skills.edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'mainCategory' => 'required|min:2|max:150'
        ];

        $attributes = [
            'mainCategory' => 'mainCategory',
            'title' => 'title',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator], 422);
        }

        try {
            $skill = Skill::findOrFail($id);
            $skill->mainCategory = $request->input('mainCategory');
            $skill->title = $request->input('title');
            $skill->save();
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }


        return response()->json(['status' => 'success', 'message' => 'Skill successfully updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $skill = Skill::findOrFail($id);
            $skill->delete();
            return response()->json(["status" => "success"]);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}