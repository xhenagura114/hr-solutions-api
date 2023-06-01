<?php

namespace Modules\EmployeeManagementModule\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'partners';

    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'birthday',
        'company',
        'job_position',
        'email',
        'contact',
    ];

    /**
     * @param $value
     */
    public function setBirthdayAttribute($value)
    {
        \Log::info($value);
        $date = date("Y-m-d", strtotime($value));
        $this->attributes['birthday'] = Carbon::parse($date)->format("Y-m-d");
    }


    /**
     * @param $value
     * @return string
     */
    public function getBirthdayAttribute($value)
    {
        \Log::info("sssssssssssssssss");
        \Log::info($value);
        return Carbon::parse($value)->format("d-m-Y");
    }
}
