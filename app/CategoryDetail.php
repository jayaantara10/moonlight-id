<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryDetail extends Model
{
    //
    
    protected $table='product_category_details';

    protected $fillable = ['product_id', 'category_id'];

    protected $dates = ['deleted_at'];
}
