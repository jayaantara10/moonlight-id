<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    //
    protected $table = 'discounts';
    
    protected $fillable = ['id_product', 'percentage', 'start', 'end','status'];
}
