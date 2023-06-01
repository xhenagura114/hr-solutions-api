<?php

namespace Modules\CalendarModule\Http\Controllers;

use App\Helpers\MailManager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Include core controller to share global variables if needed
 *
 * Krisid Misso
 */
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\CalendarModule\Entities\Event;
use Modules\CalendarModule\Entities\EventType;
use Modules\EmployeeManagementModule\Entities\UserTraining;
use Modules\SystemSettingsModule\Entities\Agenda;
use Modules\SystemSettingsModule\Entities\OfficialHoliday;
use Sentinel;
use \App\Http\Controllers\Controller;
class CalendarModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $event_types = EventType::all();

        $all_events = $this->all_events();

        foreach ($all_events as $key => $event) {
            if (date("H:i", strtotime($event['start'])) !== "00:00") {
                $all_events[$key]['title'] = date("H:i", strtotime($event['start'])) . " " . $event['title'];
            }
        }

        return view('calendarmodule::index', compact('event_types', 'all_events'));
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $currentUser = \Sentinel::getUser();

        //after this feature is tested, we should add fisnik and erion addresses
        $user = array(
//            "erion.isufi@landmark.al",
//            "fisnik.kruja@landmark.al",
            // "alisa.kike@landmark.al",
            "xhena.gura@landmark.al"
        );

        $title = $request->input('title');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $color = $request->input('color');
        $event_type_id = $request->input('event_type_id');

        $fileName = null;
        if (request()->hasFile('cv_path')) {
            $file = request()->file('cv_path');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move('uploads', $fileName);

        }  else {
            $fileName = 'no-cv';
        }
        try {
            $event = new Event;
            $event->title = $title;
            $event->user_id = Sentinel::getUser()->id;
            $event->start_date = new Carbon($start_date);
            $event->end_date = new Carbon($end_date);
            $event->color = $color ? $color : null;
            $event->event_type_id = $event_type_id ? $event_type_id : null;
            $event->cv_path = $fileName ? $fileName : null;
            $event->save();

            $view = view("calendarmodule::email", compact('user', 'start_date','end_date', 'title', 'fileName', 'event_type_id'));
            MailManager::sendEmail($currentUser->email, "Agenda", $user, $view);

            $status = 'success';
        } catch (\Exception $e) {
            $status = 'ERROR: ' . $e->getMessage();
        }

        return back()->with(['flash_message' => 'Agenda successfully added!']);
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
        return view('calendarmodule::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('calendarmodule::edit');
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        try {
            $message = 'success';
        } catch (\Exception $e) {
            $message = 'ERROR: ' . $e->getMessage();
        }
        Event::destroy($id);

        return response()->json(['status' => $message]);
    }

    /**
     * Create the specified resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createType(Request $request)
    {
        $type = $request->input('type');
        $color = $request->input('color');

        try {

            $event_type = new EventType;
            $event_type->type = $type;
            $event_type->color = $color;
            $event_type->save();

            return response()->json(['status' => 'success', 'created_event_type' => $event_type]);

        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    /**
     * Edit the specified resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editType(Request $request)
    {
        $id = $request->input('id');
        $type = $request->input('type');
        $color = $request->input('color');

        try {
            $event_type = EventType::findOrFail($id);
            $event_type->type = $type;
            $event_type->color = $color;
            $event_type->save();

            //update old events color
            Event::where('event_type_id', $event_type->id)->update(['color' => $event_type->color]);

            $all_events = $this->all_events();

            return response()->json(['status' => 'success', 'edited_event_type' => $event_type, 'all_events' => $all_events]);

        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteType(Request $request)
    {
        $id = $request->input('id');

        try {
            EventType::destroy($id);

            Event::where('event_type_id', $id)->update(['color' => null]);

            $all_events = $this->all_events();

            return response()->json(['status' => 'success', 'message' => 'Event type deleted successfully', 'all_events' => $all_events]);

        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function event_modal()
    {
        $event_types = EventType::all();

        return view('calendarmodule::event-modal', compact('event_types'));
    }

    private function all_events()
    {
        //return events with new color
        $events = Event::all()->toArray();
        $all_events = [];

        if ($events) {
            $all_events = array_map(function ($event) {
                $data['id'] = $event['id'];
                $data['title'] = $event['title'];
                $data['start'] = $event['start_date'];
                $data['end'] = $event['end_date'];
                $data['color'] = $event['color'];
                $data['cv_path'] = $event['cv_path'];
                $data['delete'] = true;

                return $data;

            }, $events);
        }

        $holidays = Agenda ::all()->toArray();
        $all_holidays = array_map(function ($holiday) {
            $data['id'] = $holiday['id'];
            $data['title'] = $holiday['title'];
            $data['start'] = date('Y') . '-' . str_pad($holiday['month'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($holiday['day'], 2, '0', STR_PAD_LEFT);

            // 2 days off if holiday is on sunday
            $data['end'] = (Carbon::parse($data['start'])->dayOfWeek == Carbon::SUNDAY) ? Carbon::parse($data['start'])->addDays(2)->toDateString() : $data['start'];
            $data['color'] = ''; //default color
            $data['delete'] = false;

            return $data;

        }, $holidays);

        $return_events = array_merge($all_events, $all_holidays);

        return $return_events;
    }
}
