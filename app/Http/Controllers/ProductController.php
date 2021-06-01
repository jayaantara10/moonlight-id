<?php
//controller buat nampilin produk di home
namespace App\Http\Controllers;

use App;
use App\AdminProduct;
use App\User;
use App\Product;
use App\Courier;
use Auth;
use App\Transaction;
use App\TransactionDetail;
use App\ProductImage;
use App\ProductReview;
use App\ProductCategories;
use Illuminate\Http\Request;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class ProductController extends Controller
{
    public function index()
    {
        $data['products']=AdminProduct::with('RelasiImage')->get();
        return view('admin.ListProducts',$data);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$categoryproduct = category::all();
        //return view('admin.ProductCreate',compact(['category']));
    }

    function review(Request $req){
        $req->validate([
            'content' => 'required',
            'rate' => 'required'
        ]);

        ProductReview::create([
            'product_id' => $_POST['pid'],
            'user_id' => Auth::guard('web')->user()->id,
            'rate' => $req->rate,
            'content' => $req->content
        ]);

        return redirect('/select/products?id='.$_POST['pid']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Menyimpan id product dan kategori product pada detail product
        //$data -> RelasiCategory()->attach(request('category_id'));
        return redirect()->route('admin.ListProducts')->with('success','Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Product::where('id',$id)->with('RelasiImage')->get();
        return view ('admin.ListProducts',compact (['products']));
    }

    public function ProductImage($id, Request $request)
    {
        $products = Product::find($id);

        if($products){
            $ProductImage = ProductImage::where('product_id',$products->id)->paginate(5);
        }
    }

    function selectproduct(){
        $data['provinsi'] = RajaOngkir::provinsi()->all();
        $data['courier'] = Courier::all();
        $data['products'] = Product::with(['product_review', 'product_image', 'product_review.tanggapan'])->where('products.id', $_GET['id'])->get();
        // dd($data['products']);
        // exit();
        return view('detailproduct', $data);
    }

    function buynow(Request $req){
        $req->validate([
            'jml' => 'required',
            'harga' => 'required',
            'alamat' => 'required',
            'kab' => 'required',
            'prov' => 'required',
            'ongkir' => 'required',
            'cou' => 'required'
        ]);

        $id = Transaction::create([
            'timeout' => date('Y-m-d H:i:s', strtotime('+1 days')),
            'address' => $req->alamat,
            'regency' => $req->kab,
            'province' => $req->prov,
            'total' => $req->harga + $req->ongkir,
            'shipping_cost' => $req->ongkir,
            'sub_total' => $req->harga,
            'user_id' => Auth::guard('web')->user()->id,
            'courier_id' => $req->cou,
            'proof_of_payment' => "",
            'status' => 'unverified'
        ])->id;

        TransactionDetail::create([
            'transaction_id' => $id,
            'product_id' => $req->produkid,
            'qty' => $req->jml,
            'discount' => '0',
            'selling_price' => $req->harga/$req->jml
        ]);

        return redirect('/home');
    }

}