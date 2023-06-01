<?php

namespace Modules\EmployeeManagementModule\Entities;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserTransfer extends Model
{

    protected $primaryKey = 'user_id';
    protected $table = "user_transfers";


    protected $fillable = [
        'transfer_date',
        'transfer_company',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['transfer_date'] = $value ? Carbon::parse($value)->format("Y-m-d") : null;
    }
    /**
     * @param $value
     * @return string
     */

    public function getStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format("d-m-Y") : null;
    }
}
