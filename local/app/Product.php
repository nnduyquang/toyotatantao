<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'id','name','path','description','content','code' ,'image','isActive','price','sale','final_price','user_id','category_product_id','seo_id','created_at','updated_at'
    ];
    protected $hidden = ['id'];
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function categoryproduct()
    {
        return $this->belongsTo('App\CategoryItem', 'category_product_id');
    }
    public function seos(){
        return $this->belongsTo('App\Seo','seo_id');
    }
    public function categoryitems(){
        return $this->belongsToMany('App\CategoryItem','category_many','item_id','category_id')->withTimestamps();
    }
}
