<?php

namespace Modules\SystemSettingsModule\Entities;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = "agenda";

    protected $fillable = [
        'day',
        'title'
    ];
}

