<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = "menu";

    protected $fillable = [
    	"title",
    	"description",
    	"weight",
    	"valume",
    	"price",
    	
    ];

    protected $hidden = [
    	"created_at",
    	"updated_at",
    ];
}
