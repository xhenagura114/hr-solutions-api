<?php

use App\Mail\HappyBirthdayMail;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

/**
 * Created by PhpStorm.
 * User: Krisid Misso
 * Date: 28/2/2018
 * Time: 2:44 PM
 */

/**
 * @param null $module_prefix
 *
 * selected class for top navigation items (modules)
 */
function if_module_active($module_prefix = null)
{

    $current_route_name = Route::currentRouteName();

    $route_name_exploded = explode(".", $current_route_name);

    if (strtolower($route_name_exploded[0]) == strtolower($module_prefix)) {
        echo "active";
    }
}

/**
 * @param $full_route_name
 * selected class for sidemenu items
 */
function if_sidemenu_active($full_route_name)
{
    $current_route_name = Route::currentRouteName();
    $route_name_exploded = explode(".", $current_route_name);

    $full_route_name_exploded = explode(".", $full_route_name);

    if (strtolower($route_name_exploded[1]) == strtolower($full_route_name_exploded[1])) {
        echo "default-color";
    }
}

/**
 * @param null $mime_type
 * @return string
 *
 * returns fontawesome icon based on mime type
 */
function return_fa_icon_class($mime_type = null)
{
    switch ($mime_type) {

        case (explode('/', $mime_type)[0] == 'image'):
            return 'fa fa-file-image-o';
            break;
        case (explode('/', $mime_type)[0] == 'video'):
            return 'fa fa-file-video-o';
            break;
        case (explode('/', $mime_type)[1] == 'pdf'):
            return 'fa fa-file-pdf-o';
            break;
        case (explode('/', $mime_type)[1] == 'msword' || explode('/', $mime_type)[1] == 'vnd.openxmlformats-officedocument.wordprocessingml.document'):
            return 'fa fa-file-word-o';
            break;
        case (explode('/', $mime_type)[1] == 'vnd.ms-excel' || explode('/', $mime_type)[1] == 'vnd.openxmlformats-officedocument.spreadsheetml.sheet'):
            return 'fa fa-file-excel-o';
            break;
        case (explode('/', $mime_type)[1] == 'x-rar-compressed' || explode('/', $mime_type)[1] == 'zip'):
            return 'fa fa-file-archive-o';
            break;
        case (explode('/', $mime_type)[1] == 'x-rar-compressed' || explode('/', $mime_type)[1] == 'zip'):
            return 'fa fa-file-archive-o';
            break;
        default:
            return 'fa fa-paperclip';
            break;

    }
}

function get_enums($table, $column)
{
    $type = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '{$column}'"))[0]->Type;
    preg_match('/^enum\((.*)\)$/', $type, $matches);
    $enum = array();
    foreach (explode(',', $matches[1]) as $value) {
        $v = trim($value, "'");
        $enum = array_add($enum, $v, $v);
    }
    return $enum;
}

function calc_working_days($from, $to)
{
    // timestamps
    $from_timestamp = strtotime($from);
    $to_timestamp = strtotime($to);

    // work day seconds
    $workday_start_hour = 9;
    $workday_end_hour = 18;
    $workday_seconds = ($workday_end_hour - $workday_start_hour) * 3600;

    // work days beetwen dates, minus 1 day
    $from_date = date('Y-m-d', $from_timestamp);
    $to_date = date('Y-m-d', $to_timestamp);
    $workdays_number = 0;

    try {
        if ($from_date != $to_date) {
            $workdays_number = count(get_workdays($from_date, $to_date)) - 1;
            $workdays_number = $workdays_number < 0 ? 0 : $workdays_number;
        } else {
            $workdays_number = 0;
        }

    } catch (\Exception $e) {
//dd($from_date, $to_date, $e);
    }

    // start and end time
    $start_time_in_seconds = date("H", $from_timestamp) * 3600 + date("i", $from_timestamp) * 60;
    $end_time_in_seconds = date("H", $to_timestamp) * 3600 + date("i", $to_timestamp) * 60;


    if (get_workdays($from_date, $to_date) == 0) {

        $working_hours = 0;
    } else {
        $working_hours = ($workdays_number * $workday_seconds + $end_time_in_seconds - $start_time_in_seconds) / 86400 * 24;

    }

    return $working_hours;
}


function get_workdays($from, $to)
{
    // arrays
    $days_array = array();
    $skipdays = array("Saturday", "Sunday");
    $skipdates = get_holidays();

    // other variables
    $i = 0;
    $current = $from;
    $timestamp = strtotime($from);
    $day = date('l', $timestamp);

    if ($current == $to) // same dates
    {
        $timestamp = strtotime($from);
        if (!in_array(date("l", $timestamp), $skipdays) && !in_array(date("Y-m-d", $timestamp), $skipdates)) {
            $days_array[] = date("Y-m-d", $timestamp);
        }
        if (in_array(date("l", $timestamp), $skipdays) || in_array(date("Y-m-d", $timestamp), $skipdates)) {
            $days_array = 0;
        }
    } elseif ($current < $to) // different dates
    {
        while ($current < $to) {
            $timestamp = strtotime($from . " +" . $i . " day");
            if (date("l", $timestamp) === 'Monday') {
                $saturdayTimestamp = strtotime($from . " +" . ($i - 2) . " day");
                $sundayTimestamp = strtotime($from . " +" . ($i - 1) . " day");
                if (in_array(date("Y-m-d", $saturdayTimestamp), $skipdates) || in_array(date("Y-m-d", $sundayTimestamp), $skipdates)) {


                    $i++;
                    continue;
                }
            }

            if (!in_array(date("l", $timestamp), $skipdays) && !in_array(date("Y-m-d", $timestamp), $skipdates)) {
                $days_array[] = date("Y-m-d", $timestamp);
            }

            $current = date("Y-m-d", $timestamp);
            $i++;
        }
    }

    return $days_array;
}

function get_holidays()
{
    $holidays_db = \Modules\SystemSettingsModule\Entities\OfficialHoliday::all()->toArray();

    // get official holidays from db and build array
    $days_array = [];

    array_map(function ($holiday) use (&$days_array) {
        array_push($days_array, $holiday['day']);
    }, $holidays_db);

    return $days_array;
}

function request_status_icon($status)
{

    switch ($status) {
        case 'APPROVED':
            return 'fa fa-check';
            break;
        case 'REJECTED':
            return 'fa fa-ban';
            break;
        default:
            return 'fa fa-pause';
            break;
    }
}

function convertTime($dayCount)
{
    $days = "";
    $hours = "";
    $minutes = "";
    $empty = "";


    $d = floor($dayCount / 540);
    $h = floor(($dayCount - $d * 540) / 60);
    $m = $dayCount - ($d * 540) - ($h * 60);


    if ($d != 0) {
        $days = $d . " days\n";
    }
    if ($h != 0) {
        $hours = $h . " hours\n";
    }
    if ($m != 0) {
        $minutes = $m . " minutes\n";
    }
    if ($d == 0 && $h == 0 && $m == 0) {
        $empty = "-";
    }

    return $dayCount = $days . $hours . $minutes . $empty;
}

function auth_info()
{

    $info = DB::table('users')
        ->where('users.id', Sentinel::getUser()->id)
        ->leftJoin('job_positions', 'users.job_position_id', '=', 'job_positions.id')
        ->leftJoin('departments', 'departments.id', '=', 'users.department_id')
        ->select('users.*', 'job_positions.title as job_position_title', 'job_positions.id as job_position_id', 'departments.name as department_name', 'departments.color as department_color')
        ->where('users.deleted_at', null)
        ->first();

    return $info;
}

function visual_settings()
{
    $visual = DB::table('general_settings')->first();

    return $visual;

}


function get_months()
{
    return [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July ',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];
}

function sendBirthdayMails()
{
    try {
        $partyPeople = User::getUsersWithBirthday()->get();

        foreach ($partyPeople as $partyPerson) {
            Mail::to($partyPerson)->send(new HappyBirthdayMail($partyPerson));
        }
    } catch (ExceptionWithThrowable $e){
        //
    }
}
