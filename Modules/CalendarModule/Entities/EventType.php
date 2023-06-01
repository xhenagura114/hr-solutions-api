<?php

namespace Modules\CalendarModule\Entities;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    protected $fillable = [
        'type',
        'color'
    ];
}
