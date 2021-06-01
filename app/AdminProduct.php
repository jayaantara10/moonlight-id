<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminProduct extends Model
{
    //
    protected $table='products';
    protected $fillable = ['product_name','price', 'description','stock','weight','status'];

    public function RelasiImage()
    {   
        return $this->hasMany(ProductImage::class);
    }
    protected $dates = ['deleted_at'];

    public function RelasiCategory()
    {
        return $this->belongsToMany(ProductCategories::class,'product_category_details','product_id','category_id');
    }

    function rating(){
        return $this->hasMany('App\ProductReview', 'product_id');
    }
}
