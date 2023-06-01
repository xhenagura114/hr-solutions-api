<?php

namespace Modules\SystemSettingsModule\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    protected $fillable = [
        'position',
        'expiration',
        'description',
    ];

    public function setExpirationAttribute($value)
    {
        $this->attributes['expiration'] = Carbon::parse($value)->format("Y-m-d");
    }


    /**
     * @param $value
     * @return string
     */
    public function getExpirationAttribute($value)
    {
        return Carbon::parse($value)->format("d-m-Y");
    }

}
