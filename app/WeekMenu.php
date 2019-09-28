<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeekMenu extends Model
{
    protected $table = "week_menu";

    protected $fillable = [
    	"menu_id",
    	"week_day_id",
    ];

    protected $hidden = [
    	"created_at",
    	"updated_at",
    ];
}
