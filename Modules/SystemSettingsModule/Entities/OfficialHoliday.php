<?php

namespace Modules\SystemSettingsModule\Entities;

use Illuminate\Database\Eloquent\Model;

class OfficialHoliday extends Model
{
    protected $fillable = [
        'day',
        'title',
        'date'
    ];
}
