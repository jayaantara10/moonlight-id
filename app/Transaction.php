<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['timeout','address','regency','province','total','shipping_cost','sub_total','user_id','courier_id','proof_of_payment','status'];

    function detail(){
    	return $this->hasMany('App\TransactionDetail', 'transaction_id');
    }
}
