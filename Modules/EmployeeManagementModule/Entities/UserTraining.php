<?php

namespace Modules\EmployeeManagementModule\Entities;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\SystemSettingsModule\Entities\Department;

class UserTraining extends Model
{
    protected $table = "trainings";

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'department_id',
        'start_date',
        'end_date',
        'training_file',
        'training_description',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user(){
        return $this->belongsToMany(User::class, "trainings_users", "training_id");
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departments(){
        return $this->belongsTo(Department::class, 'department_id')->select('id', 'name');
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = Carbon::parse($value)->format("Y-m-d");
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = Carbon::parse($value)->format("Y-m-d");
    }


    /**
     * @param $value
     * @return string
     */
    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format("d-m-Y");
    }

    /**
     * @param $value
     * @return string
     */
    public function getEndDateAttribute($value)
    {
        return  Carbon::parse($value)->format("d-m-Y");
    }
}
