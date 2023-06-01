<?php

namespace Modules\EmployeeManagementModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Internship extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'internships';

    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'contact',
        'gender',
        'interests',
        'institution',
        'education',
        'studying_for',
        'comments',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'interests' => 'array',
    ];
}
