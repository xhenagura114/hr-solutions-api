<?php

namespace Modules\EmployeeManagementModule\Entities;

use App\User;
use Modules\EmployeeManagementModule\Entities\Skill;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserProject extends Model
{
    protected $table = "user_projects";

    /**
     * @var array
     */
    protected $fillable = [
        'start_training',
        'project_name',
        'end_training',
        'training_skills',
        'project_estimation',
        'project_type',
        'project_company',
        'evaluation_date',
        'skill_id',
        'performance_level',
        'unlimited_project',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projectSkills()
    {
        return $this->belongsToMany(Skill::class, 'project_skills', 'project_id','skill_id');
    }

    public function setStartTrainingAttribute($value)
    {
        $this->attributes['start_training'] = $value ? Carbon::parse($value)->format("Y-m-d") : null;
    }

    public function setEndTrainingAttribute($value)
    {
        $this->attributes['end_training'] = $value ? Carbon::parse($value)->format("Y-m-d") : null;
    }

    public function setEvaluationDateAttribute($value)
    {
        $this->attributes['evaluation_date'] = $value ? Carbon::parse($value)->format("Y-m-d") : null;
    }

    /**
     * @param $value
     * @return string
     */
    public function getStartTrainingAttribute($value)
    {
        return $value ? Carbon::parse($value)->format("d-m-Y") : null;
    }

    /**
     * @param $value
     * @return string
     */
    public function getEndTrainingAttribute($value)
    {
        return $value ? Carbon::parse($value)->format("d-m-Y") : null;
    }

    public function getEvaluationDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format("d-m-Y") : null;
    }
}