<?php

namespace Modules\SystemSettingsModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\SystemSettingsModule\Entities\ApiUrl;
use Validator;

class ApiUrlController extends SystemSettingsModuleController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $apiUrls = ApiUrl::get();

        return view('systemsettingsmodule::api-urls.index', compact('apiUrls'));
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
            'code' => 'required|min:8|max:150',
            'url' => 'required'
        ]);

        $apiUrl = new ApiUrl();
        $apiUrl->code = $request->input('code');
        $apiUrl->url = $request->input('url');
        $apiUrl->save();

        return redirect()->back()->with(['flash_message' => 'API data added successfully!']);
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
        $apiUrl = ApiUrl::findOrFail($id);
        return view('systemsettingsmodule::api-urls.edit', compact('apiUrl'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'code' => 'required|min:8|max:150',
            'url' => 'required'

        ];

        $attributes = [
            'code' => 'org code',
            'url' => 'org url'
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator], 422);
        }

        try {
            $apiUrl = ApiUrl::findOrFail($id);
            $apiUrl->code = $request->input('code');
            $apiUrl->url = $request->input('url');
            $apiUrl->save();
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }

        return response()->json(['status' => 'success', 'message' => 'API URL successfully updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $apiUrl = ApiUrl::findOrFail($id);
            $apiUrl->delete();
            return response()->json(["status" => "success"]);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}
