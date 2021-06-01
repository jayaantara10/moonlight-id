<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $table = 'product_reviews';

    protected $fillable = ['product_id','user_id','rate','content'];

    function tanggapan(){
    	return $this->hasMany('App\Response', 'review_id');
    }
}
