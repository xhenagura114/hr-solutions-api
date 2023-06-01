<?php

namespace Modules\EmployeeManagementModule\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\SystemSettingsModule\Entities\JobVacancy;

class Applicant extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'applicants';

    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'job_vacancy_id',
        'contact',
        'gender',
        'application_date',
        'status',
        'cv_path',
        'form_path',
        'italian_language',
        'quit_date',
        'required_salary',
        'actual_salary',
        'user_experiences_id',
        'comments',
        'economic_offer',
        'response',
        'economic_comments',
        'actual_company',
        'actual_position',
        'languages',
        'interview_date',
        'professional_self_evaluation',
        'technical_evaluation',
        'possible_position',
        'soft_skills',
        'seniority',
        'comment',
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jobVacancies(){
        return $this->belongsTo(JobVacancy::class, "job_vacancy_id");
    }

    /**
     * @param $value
     */
    public function setApplicationDateAttribute($value)
    {
        $date = date("Y-m-d", strtotime($value));
        $this->attributes['application_date'] = Carbon::parse($date)->format("Y-m-d");
    }
    /**
     * @param $value
     * @return string
     */
    public function getApplicationDateAttribute($value)
    {
        return Carbon::parse($value)->format("d-m-Y");
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'applicant_skills')
            ->withPivot('month_of_experience')
            ->withPivot('level')
            ->withPivot('other_technology')
            ->withPivot('seniority');
    }
}