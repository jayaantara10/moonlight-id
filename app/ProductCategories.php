<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategories extends Model
{
    //
    protected $table='product_categories';

    public $timestamps = false;
    
    protected $fillable=['category_name','status'];

    protected $dates = ['deleted_at'];
}
