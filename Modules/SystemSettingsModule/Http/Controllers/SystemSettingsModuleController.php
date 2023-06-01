<?php

namespace Modules\SystemSettingsModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Include core controller to share global variables if needed
 *
 * Krisid Misso
 */

use \App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class SystemSettingsModuleController extends Controller
{

    public function defaultView()
    {
        return view('systemsettingsmodule::index');
    }

}
