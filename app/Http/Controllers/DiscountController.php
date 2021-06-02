<?php

namespace App\Http\Controllers;
use App\AdminProduct;
use App\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
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
        $discount= Discount::join('products', 'discounts.id_product', 'products.id')->select('discounts.*','products.product_name')->where('discounts.status', null)->get();
        $products = AdminProduct::all();
        return view ('discount.ListDiscount',compact('discount', 'products'));
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
            'produk' => 'required',
            'percentage' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);
        
        $discount = new Discount;
        $discount->id_product = $request->produk;
        $discount->percentage = $request->percentage;
        $discount->start = $request->get('start');
        $discount->end = $request->get('end');
        $discount->save();
        return redirect('discount')->with('success', 'Data berhasil ditambahkan');
    }

    /** 
    * Display the specified resource.
    *
    * @param \App\Discount $discount
    * @return \Illuminate\Http\Response
    */
    public function show (Discount $discount){
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param \App\Discount $discount
    * @return \Illuminate\Http\Response
    */
    public function edit($id){

        $discount = Discount::where('id',$discount->id)->first();
        return view('discount.ListDiscount', compact('discount'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @param \App\Discount $discount
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id){

        $request->validate([
            'product_id' => 'required',
            'percentage' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);

        Discount::where('id', $id)->update([
            'id_product' => $request->product_id,
            'percentage' => $request->percentage,
            'start' => $request->get('start'),
            'end' => $request->get('end'),
        ]);
        return redirect ('discount')->with('success', 'Data Berhasil Diubah!');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param \App\Discount $discount
    * @return \Illuminate\Http\Response
    */
    public function destroy($id){

        Discount::where('id',$id)->delete();
        $discount=Discount::find($id);
        return redirect('discount')->with('delete','Data Telah Dihapus');
        
    }

    function deletediscount($id){
        Discount::where('id',$id)->update([
            'status' => "deleted"
        ]);

        return redirect('/deleted/discount')->with('success','Data Telah Dihapus');
    }

    function balikdiscount($id){
        Discount::where('id',$id)->update([
            'status' => null
        ]);

        return redirect('/discount')->with('success','Data Telah Berhasil dikembalikan');   
    }

}
