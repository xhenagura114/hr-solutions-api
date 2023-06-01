<?php

namespace Modules\CalendarModule\Entities;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'color',
        'user_id',
    ];
}
