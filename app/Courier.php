<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    //
    protected $table='couriers';
    public $timestamps = false;
    protected $fillable=['courier','status'];

    function transaksi(){
    	return $this->hasMany('App\Transaction', 'courier_id');
    }
}
