<?php

namespace Modules\SystemSettingsModule\Entities;

use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{
    protected $fillable = [
        'logo_path',
        'dark_mode',
        'theme_path',
        'system_email'
    ];
}
