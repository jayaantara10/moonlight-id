<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    //
    protected $table='product_images';
    protected $fillable = ['admin_product_id','image_name'];

    //
    public function RelasiImage()
    {
        return $this->hasMany(AdminProduct::class,'product_id');
    }
}
