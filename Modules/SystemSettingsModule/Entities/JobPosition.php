<?php

namespace Modules\SystemSettingsModule\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    protected $table = "job_positions";

    protected $fillable = [
        'title'
    ];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(){
        return $this->hasMany(User::class);
    }
}
