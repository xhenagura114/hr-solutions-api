<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Task extends Model
{

    /**
     * @var string
     */
    protected $table = "tasks_email";

    /**
     * @var array
     */
    protected $fillable = [
        "from",
        "to",
        "command",
        "status",
        "type"
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

}