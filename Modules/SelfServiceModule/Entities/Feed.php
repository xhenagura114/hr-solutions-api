<?php

namespace Modules\SelfServiceModule\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Modules\SystemSettingsModule\Entities\Department;

class Feed extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'attachments',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'attachments' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class, "user_id")->select(["id", "first_name", "last_name"]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function departments(){
        return $this->belongsToMany(Department::class, "feed_departments", "feed_id", "department_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(){
        return $this->belongsToMany(User::class, "feed_users", "feed_id", "user_id");
    }
}
