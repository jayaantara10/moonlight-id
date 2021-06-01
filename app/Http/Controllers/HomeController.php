<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Product;
use App\DatabaseUserNotif;
use App\Transaction;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['products'] = Product::join('product_images', 'products.id', 'product_images.admin_product_id')->select('product_images.image_name as gambar', 'products.id as id', 'products.product_name')->where('products.status', null)->get();
        return view('home', $data);
    }
    public function bacaNotif(){
        $id=(int)request()->input('id_notif');
        $notif=DatabaseUserNotif::find($id);
        $notif->update(['read_at'=>now()->toDateTimeString()]);
        return redirect()->to('my/transaction');
    }
}
