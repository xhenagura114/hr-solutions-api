<?php
/**
 * Created by PhpStorm.
 * User: klajdi
 * Date: 18-04-23
 * Time: 3.37.MD
 */

namespace App\Helpers;

use Sentinel;

class AuthenticatedUser implements \OwenIt\Auditing\Contracts\UserResolver
{
    /**
     * Resolve the User.
     *
     * @return mixed|null
     */
    public static function resolve() : int
    {
        return Sentinel::check() ? Sentinel::getUser()->id : null;
    }

    /**
     * @return int
     */
    public function userField() : int
    {
        return Sentinel::check() ? Sentinel::getUser()->id : null;
    }
}