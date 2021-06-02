<?php

namespace App\Http\Controllers;
use App\Courier;
use App\Transaction;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index() {
        $couriers= Courier::where('status',null)->get();
        return view ('couriers.ListCourier',compact('couriers'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create(){
        //
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function store (Request $request){
        $request->validate([
            'courier' => 'required'
        ]);

        $couriers = new Courier;
        $couriers->courier = $request->courier;
        $couriers->save();
        return redirect('courier')->with('success', 'Data kurir berhasil ditambahkan');
    }

    /** 
    * Display the specified resource.
    *
    * @param \App\Courier $courier
    * @return \Illuminate\Http\Response
    */
    public function show (Courier $couriers){
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param \App\Courier $courier
    * @return \Illuminate\Http\Response
    */
    public function edit($id){

        $couriers = Courier::where('id',$couriers->id)->first();
        return view('couriers.EditCourier', compact('couriers'));
    }
 
    /**
    * Update the specified resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @param \App\Courier $courier
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Courier $couriers, $id){
        
        $request->validate([
            'courier' => 'required',
        ]);

        Courier::where('id', $id)->update([
            'courier' => $request->courier,
        ]);
        //Courier::where('id', $id)->update(['courier'=>$request->courier]);
        return redirect ('courier')->with('success', 'Kurir Berhasil Diubah!');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param \App\Courier $courier
    * @return \Illuminate\Http\Response
    */
    public function destroy($id){
        // $trans = Transaction::where('courier_id', $id)->get();
        // foreach ($trans as $key) {
        //     TransactionDetail::where('transaction_id', $key->id)->delete();
        // }
        // Transaction::where('courier_id', $id)->delete();
        Courier::with('transaksi')->where('couriers.id',$id)->delete();
        // $couriers=Courier::find($id);
        return redirect('courier')->with('delete','Data Telah Dihapus');
        
    }

    public function deletecou($id){
        Courier::where('id',$id)->update([
            'status' => 'deleted'
        ]);
        // $couriers=Courier::find($id);
        return redirect('/deleted/courier')->with('delete','Data Telah Dihapus');
        
    }

    public function balikcou($id){
        Courier::where('id',$id)->update([
            'status' => null
        ]);
        // $couriers=Courier::find($id);
        return redirect('/courier')->with('success','Data Telah Dikembalikan');
        
    }
}
