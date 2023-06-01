<?php


namespace Modules\EmployeeManagementModule\Entities;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class InterviewExperience extends Model
{
    protected $table = "applicant_experiences";

    protected $fillable = [
        'start_date',
        'left_date',
        'position_title',
        'company_name',
        'quit_reason',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = $value ? Carbon::parse($value)->format("Y-m-d") : null;
    }

    public function setLeftDateAttribute($value)
    {
        $this->attributes['left_date'] = $value ? Carbon::parse($value)->format("Y-m-d") : null;
    }

    /**
     * @param $value
     * @return string
     */

    public function getStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format("d-m-Y") : null;
    }

    /**
     * @param $value
     * @return string
     */
    public function getLeftDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format("d-m-Y") : null;
    }


}