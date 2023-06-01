<?php

namespace Modules\SystemSettingsModule\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    /**
     * @var string
     */
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
