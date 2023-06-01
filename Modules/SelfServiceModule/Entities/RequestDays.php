<?php

namespace Modules\SelfServiceModule\Entities;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\SystemSettingsModule\Entities\Department;
use Modules\SystemSettingsModule\Entities\OfficialHoliday;
use OwenIt\Auditing\Contracts\Auditable;

class RequestDays extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'requests';

    protected $fillable = [
        'user_id',
        'reason',
        'department_id',
        'description',
        'start_date',
        'end_date',
        'status',
        'photo_path',
        'reject_reason'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'approvers' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class, "department_id");
    }


    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = Carbon::parse($value)->format("Y-m-d H:i:s");
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = Carbon::parse($value)->format("Y-m-d H:i:s");
    }

    public function getWorkingDaysAttribute()
    {
        $officialHolidays = OfficialHoliday::pluck('day')->toArray();
        $holidaysCarbonized = array_map(function($h){return Carbon::parse($h);}, $officialHolidays);

        $end_date = Carbon::parse($this->end_date);
        $start_date = Carbon::parse($this->start_date);

        return $end_date->diffInDaysFiltered(function (Carbon $date) use ($holidaysCarbonized) {
            if ($date->isWeekend()) {return false;}
            if (in_array($date, $holidaysCarbonized)) {return false;}
            return true;
        }, $start_date);
    }

    /**
     * @param $value
     * @return string
     */
    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format("Y-m-d H:i:s");
    }

    /**
     * @param $value
     * @return string
     */
    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value)->format("Y-m-d H:i:s");
    }

    public function getStartDateNoTimeAttribute()
    {
        return Carbon::parse($this->start_date)->format("M d Y");
    }

    public function getEndDateNoTimeAttribute()
    {
        return Carbon::parse($this->end_date)->format("M d Y");
    }
}
