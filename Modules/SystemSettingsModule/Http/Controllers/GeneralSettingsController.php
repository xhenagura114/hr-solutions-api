<?php

namespace Modules\SystemSettingsModule\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Modules\SystemSettingsModule\Entities\Department;
use Modules\SystemSettingsModule\Entities\GeneralSettings;
use Sentinel;

class GeneralSettingsController extends SystemSettingsModuleController
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $settings = GeneralSettings::all()->last();

        if (!$settings) {
            $setting = new GeneralSettings;
            $setting->save();
            $settings = GeneralSettings::all()->last();
        }

        return view('systemsettingsmodule::general-settings.index', compact('settings'));
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
    public function edit()
    {
        return view('systemsettingsmodule::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $settings = GeneralSettings::firstOrCreate(['id' => $id]);

        $file = $request->file('logo');

        if ($file) {

            $file_extension = $file->clientExtension();

            //try and delete previous logo
            try {
                unlink(public_path($settings->logo_path));
            } catch (\Exception $e) {
                //
            }
            //copy file to images
            try {
                $file->move(public_path('images'), 'logo.' . $file_extension);
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->withErrors(['message' => 'Error uploading file! ' . $e->getMessage()]);
            }

            $settings->logo_path = 'images/logo.' . $file_extension;

        }

        if ($request->input('dark_mode') == "1") {
            $settings->dark_mode = true;
        } else {
            $settings->dark_mode = false;
        }

        if ($request->input('theme')) {
            $settings->theme_path = $request->input('theme');
        }

        if ($request->input('system_email')) {
            $settings->system_email = $request->input('system_email');
        }

        $settings->save();

        clearstatcache();

        return redirect()->back()->with(['flash_message' => 'Settings saved!']);


    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function dark_mode()
    {
        try {
            $dark_mode = Sentinel::getUser();
            $dark_mode->dark_mode = !$dark_mode->dark_mode;
            $dark_mode->save();

            return \response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return \response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

    }
    public function hierarchy(){
        $departments_name = Department::all();
        return view('systemsettingsmodule::hierarchy.tree', compact('departments_name'));
    }
}
