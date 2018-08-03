<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $fillable = [

        'name','path','level', 'order','parent_id','content_id','type','is_active','created_at','updated_at'

    ];
}
