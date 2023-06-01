<?php

namespace Modules\EmployeeManagementModule\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    protected $fillable = [
        'category_name',
        'file_name',
        'file_type',
        'file_size',
        'file_path',
        'user_id',
        'title',
        'thumbnail',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
