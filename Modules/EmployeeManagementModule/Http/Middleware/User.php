<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    /**
    * The attributes that aren't mass assignable.
    *
    * @var array
    */

    use SoftDeletes;

    protected $guarded = [];

    /**
     * Array of fields to be cast to Carbon instance
     *
     * @var array
     */
    protected $dateFormat = 'Y/m/d';

    protected $dates = ['birthdate', 'cont_end'];


    /**
 * Get birthday in human readable format
 *
 * @return mixed
 */
    public function getReadableBirthday()
    {
        $birthday = Carbon::create(date('Y'), $this->birthdate->month, $this->birthdate->day);
        return $birthday->diffForHumans(Carbon::today());
    }

    /**
     * Get birthday in human readable format
     *
     * @return mixed
     */
    public function getReadableExpired()
    {
        $expired = Carbon::create(date('Y'), $this->cont_end->month, $this->cont_end->day);
        return $expired->diffForHumans(Carbon::today());
    }
}
