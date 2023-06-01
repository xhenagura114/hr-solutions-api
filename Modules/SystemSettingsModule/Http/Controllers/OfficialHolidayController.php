<?php

namespace Modules\SystemSettingsModule\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SelfServiceModule\Entities\RequestDays;
use Modules\SystemSettingsModule\Entities\OfficialHoliday;

class OfficialHolidayController extends SystemSettingsModuleController
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

        $holidays = OfficialHoliday::all();
        return view('systemsettingsmodule::holidays.index', compact('holidays'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5|max:150',
            'day' => 'required',
        ]);

        $holiday = new OfficialHoliday;
        $holiday->title = $request->input('title');
        $holiday->day = new \Datetime($request->input('day'));
        $holiday->date = Carbon::parse($request->input('day'));
        $holiday->save();

        return redirect()->back()->with(['flash_message' => 'New holiday created!']);

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

        try {
        $holiday = OfficialHoliday::findOrFail($id);

            return view('systemsettingsmodule::holidays.edit', compact('holiday',  'days'));
        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => $e], 404);

        }

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
            'title' => 'required|min:5|max:150',
            'day' => 'required',
        ]);


        $holiday = OfficialHoliday::findOrFail($id);

        $holiday->title = $request->input('title');
        $holiday->day = new \DateTime($request->input('day'));

        try{
            $holiday->save();

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
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $holiday = OfficialHoliday::findOrFail($id);
            $holiday->delete();
            return response()->json(["status" => "success"]);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }
}
