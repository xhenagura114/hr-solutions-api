<?php

namespace Modules\EmployeeManagementModule\Entities;

use App\User;
use Modules\EmployeeManagementModule\Entities\UserProject;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'title',
        'mainCategory',
        'superCategory'
    ];
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skills');
    }

    public function projects()
    {
        return $this->belongsToMany(UserProject::class, 'project_skills','project_id','skill_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function applicants()
    {
        return $this->belongsToMany(Applicant::class, 'applicant_skills')
            ->withPivot('month_of_experience')
            ->withPivot('level')
            ->withPivot('other_technology')
            ->withPivot('seniority');
    }
}