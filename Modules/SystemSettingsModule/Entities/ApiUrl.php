<?php

namespace Modules\SystemSettingsModule\Entities;

use Illuminate\Database\Eloquent\Model;

class ApiUrl extends Model
{
    protected $fillable = [
        'code',
        'url'
    ];
}
