<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function product_review()
    {
        return $this->hasMany('App\ProductReview');
    }

    public function product_image()
    {
        return $this->hasMany('App\ProductImage', 'admin_product_id');
    }

    public function discount()
    {
        return $this->hasMany('App\discount');
    }
    
    public function transaction_detail()
    {
        return $this->hasMany('App\transaction_detail');
    }

}
