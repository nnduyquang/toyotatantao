<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $fillable = [
        'id','seo_title','seo_description','seo_keywords','created_at','updated_at'
    ];
}
