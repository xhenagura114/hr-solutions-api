<?php

namespace Modules\SelfServiceModule\Http\Controllers;

use App\Helpers\MailManager;
use App\Helpers\ThumbnailGenerator;
use App\Http\Controllers\Controller;
use App\User;
use function foo\func;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Modules\EmployeeManagementModule\Entities\Skill;
use Modules\EmployeeManagementModule\Entities\UserDocument;
use Modules\SelfServiceModule\Entities\Feed;
use Modules\SelfServiceModule\Entities\RequestDays;
use Modules\SystemSettingsModule\Entities\Department;
use Modules\SystemSettingsModule\Entities\JobPosition;
use Modules\SystemSettingsModule\Entities\Training;
use Sentinel;
use Validator;

class UserProfileController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function feed()
    {
        return view('selfservicemodule::user.feed.index');
    }


    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllFeeds(){

        return $feeds = Feed::orderBy('id', 'desc')->orderByDesc("created_at")->paginate(10);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public  function getAllTrainings(){

        $userDepartment = Sentinel::getUser()->departments()->first()->id;
        return $trainings = Training::with(['departments'])->orderBy("id", 'desc')->where("department_id", $userDepartment)->orderByDesc("created_at")->paginate(10);
    }


    public function getPersonalFeeds(){
        $user = Sentinel::getUser();

        $feeds = Feed::whereHas("users", function($query) use ($user){
          $query->where("user_id", $user->id);
        })->orderByDesc("created_at")->paginate(10);

        return $feeds;
    }


    public function getDepartmentFeeds(){
        $user = Sentinel::getUser();

        $feeds = Feed::whereHas("departments", function($query) use ($user){
            $query->where("department_id", $user->departments()->first()->id);
        })->orderByDesc("created_at")->paginate(10);

        return $feeds;
    }

    public function createFeed()
    {
        $departments = Department::all();
        $users = User::where('id','!=', '1')->get(['id', 'first_name', 'last_name']);
        return view('selfservicemodule::user.feed.create', compact('departments', 'users'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeFeed(Request $request)
    {

        //return $request->all();
        $this->validate($request, [
            'title' => 'required|max:150',
            'body' => 'required'
        ]);

        $user = Sentinel::getUser();
        $filesPath = [];

        $title = $request->input('title');
        $body = $request->input('body');
        $attachments = $request->file('attachments');

        $feed = new Feed;
        $feed->title = $title;
        $feed->body = $body;

        if(isset($request->email))
            $feed->isEmail = 1;


        if ($attachments) {
            $files_path = [];
            foreach ($attachments as $attachment) {

                try {
                    $mimeType = $attachment->getClientMimeType();
                    $orinigalFilename = $attachment->getClientOriginalName();
                    $fileSize = $attachment->getClientSize();

                    $path = $attachment->store('announcement_attachments');
                    array_push($files_path, [
                        'originalFilename' => $orinigalFilename,
                        'path' => $path,
                        'mime_type' => $mimeType,
                        'file_size' => $fileSize
                    ]);

                   $filesPath[] = storage_path('app/'.$path);

                } catch (\Exception $e) {
                }
            }

            $feed->attachments = $files_path;
        }

        $feed->user_id = $user->id;
        $feed->save();

        if(isset($request->departments))
            $feed->departments()->attach($request->departments);

        if(isset($request->users))
            $feed->users()->attach($request->users);

        if(isset($request->email)){
            if(isset($request->departments)){
                $users = User::whereIn("department_id", $request->departments)->pluck('email')->toArray();
                MailManager::sendEmail($user->email, $title, $users, $body, count($filesPath) > 0 ? $filesPath : null);
            }

            if(isset($request->users)){
                $users = User::whereIn("id", $request->users)->pluck('email')->toArray();
                MailManager::sendEmail($user->email, $title, $users, $body, count($filesPath) > 0 ? $filesPath : null);
            }
        }

        return redirect()->back()->with(['flash_message' => 'Announcement successfully posted!']);
    }

    public function downloadFile(Request $request)
    {
        $path = $request->input('path');
        $originalName = $request->input('originalName');
        return Storage::download(urldecode($path), urldecode($originalName));
    }

    public function profile()
    {
        $employee = User::findOrFail(Sentinel::getUser()->id);
        $job_positions = JobPosition::all();
        $departments = Department::all();
        $trainings = Training::all();
        $status_enum = get_enums('users', 'status');
        $education_enum = get_enums('users', 'education');
        $reason_enum = get_enums('user_experiences', 'quit_reason');
        $skills = Skill::get();
        $gender_enum = ["F" => "Female", "M" => "Male"];

        return view('selfservicemodule::user.profile', compact('employee', 'job_positions', 'departments', 'trainings', 'status_enum', 'education_enum', 'reason_enum','gender_enum', 'skills'));
    }

    public function requests()
    {
        $reasons = get_enums('requests', 'reason');
        $user_requests = RequestDays::where('user_id', Sentinel::getUser()->id)->get();
        return view('selfservicemodule::user.requests', compact('reasons', 'user_requests'));
    }

    public function createRequest(Request $request)
    {
        $user = Sentinel::getUser();

        $this->validate($request, [
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
            'photo_path' => 'image|mimes:jpg,jpeg,png,gif'
        ]);
         //dd(request()->all());die;
        $fileName = null;
        if (request()->hasFile('photo_path')) {
            $file = request()->file('photo_path');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move('images', $fileName);

        } else {
            $fileName = 'no-report.png';
        }

        $from = $request->input('start_date');
        $to = $request->input('end_date');
        $reason = $request->input('reason');
        $description = $request->input('description');

        $requestDays = new RequestDays;
        $requestDays->user_id = $user->id;
        $requestDays->start_date = $from;
        $requestDays->end_date = $to;
        $requestDays->reason = $reason;
        $requestDays->department_id = $user->departments->id;
        $requestDays->photo_path= $fileName;

        if ($description) {
            $requestDays->description = $description;
        }

        $department = Department::find($user->departments->id);

        $approver = User::where([['request_access', '=', 'personal'],['department_id', '=', $user->departments->id],['id', '!=', $user->id]])->get(['id']);

        $parent_dep = $department->parentRecursive()->get();
        $parent_dep = $parent_dep[0];

        while ($parent_dep != NULL) {
            $dep = User::where([['request_access', '=', 'personal'],['department_id', '=', $parent_dep->id],['id', '!=', $user->id]])->get(['id']);
            if(isset($dep[0]))
                $approver[] = $dep[0];
            $parent_dep = $parent_dep->parentRecursive;
        }

        $approver_list = [];

        foreach ($approver as $approv) {
            $approver_list[$approv->id] = NULL;
        }

        $requestDays->approvers = $approver_list;

        $requestDays->save();

        $dayCount = (calc_working_days($request['start_date'], $request['end_date']))* 60;
        $leave_time = convertTime($dayCount);

        return redirect()->back()->with(['flash_message' => "Request successfully made for <b>$leave_time</b> days!"]);
    }


    public function profileUpdate(Request $request, $id)
    {

        $rules = [
            "user.mobile_phone" => "required",
        ];

        $attributes = [
            'user.mobile_phone' => 'mobile',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {

            $request->flash();
            return redirect()->back()->withInput($request->all())->withErrors($validator)->with([
                "languages" => $request->user["languages"],
            ]);
        }

        $user = User::findOrFail($id);


        $thumbnail = new ThumbnailGenerator();


        if (isset($request->user["photo_path"])) {
            $imageName = date("YmdHis_") . $request->user["photo_path"]->getClientOriginalName();
            $save_photo = Storage::disk('public')->putFileAs('images', $request->user["photo_path"], $imageName);
            Storage::delete($user->photo_path);

        }


        if (isset($request->docs['cv_path'])) {
            $docName = date("YmdHis_") . $request->docs["cv_path"]->getClientOriginalName();
            $save_cv = Storage::disk("public")->putFileAs('docs', $request->docs['cv_path'], $docName);
            $fileUrl = Storage::url($save_cv);
            //$cvThumbnail = $thumbnail->thumbnailGenerator($request->docs['cv_path'], asset($fileUrl));
            Storage::delete($user->cv_path);

        }


        $languages = array_values(array_filter($request->user["languages"]));

        $req = [
            "photo_path" => isset($save_photo) ? Storage::url($save_photo) : $user->photo_path,
            "cv_path" => isset($fileUrl) ? $fileUrl : $user->cv_path,
            "languages" => $languages,
            "password" => bcrypt($request->new_password),
        ];


        $format_request = array_except($request->user, ['cv_path', 'photo_path', 'skills', 'languages']) + $req;

        $user->update($format_request);

//        $userJob = $user->userExperiences();
//        if (count($userJob->get()) > 0) {
//            $userJob->first()->update($request->experience);
//        } else {
//            $userJob->create($request->experience);
//        }
//
//        if (isset($request->companyTrainings)) {
//            $user->userTrainings()->sync($request->companyTrainings);
//        }

        $skills = $request->skills_edit;
        $user->skills()->detach();
        $user->skills()->attach($skills);

        $userDocuments = [];
        if (isset($request->training['docs']) && count($request->training['docs']) > 0) {
            foreach ($request->training['docs'] as $doc) {
                if (isset($doc["title"]) && isset($doc["file"])) {
                    $docName = date("YmdHis_") . $doc["file"]->getClientOriginalName();
                    $save_doc = Storage::disk("public")->putFileAs('docs', $doc["file"], $docName);

                    $thumbnailUrl = $thumbnail->thumbnailGenerator($doc["file"], asset(Storage::url($save_doc)));

                    $userDocuments[] = [
                        "user_id" => $user->id,
                        "file_name" => $doc["file"]->getClientOriginalName(),
                        "file_type" => $doc["file"]->getClientOriginalExtension(),
                        "file_size" => $doc["file"]->getClientSize(),
                        "file_path" => $save_doc,
                        "title" => $doc["title"],
                        "thumbnail" => asset($thumbnailUrl),
                    ];
                }
            }
        }

        if (count($userDocuments) > 0) {
            UserDocument::insert($userDocuments);
        }

        return redirect()->back()->with(["success_updated" => "Successfully Updated"]);

    }


}