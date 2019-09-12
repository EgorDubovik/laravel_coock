<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = "address";

    protected $fillable = [
    	"lng",
    	"lat",
    ];

    protected $hidden = [
    	"created_at",
    	"updated_at",
    ];
}
