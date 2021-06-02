<?php

namespace App\Http\Controllers;
use App;
use App\User;
use App\AdminProduct;
use App\ProductImage;
use App\CategoryDetail;
use App\ProductCategories;
use App\TransactionDetail;
use App\Discount;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $products=AdminProduct::with('RelasiCategory','RelasiImage', 'rating')->where('products.status', null)->get();
        $categories = ProductCategories::all();
        // dd($products);
        // exit();
        return view('admin.ListProducts',compact(['products','categories']));
        
    }

    function deletedproduct(){
        $products=AdminProduct::with('RelasiCategory','RelasiImage')->where('products.status', 'deleted')->get();
        return view('admin.deletedproduct',compact(['products']));
    }

    function balikanproduct(){
         AdminProduct::where('id', $_GET['id'])->update(['status' => null]);

        return redirect('listproducts')->with('success', 'Data berhasil dikembalikan');
    }

    function deleteprodukpermanent(){
        AdminProduct::findOrFail($_GET['id']);

        Discount::where('id_product', $_GET['id'])->delete();
        CategoryDetail::where('product_id', $_GET['id'])->delete();
        TransactionDetail::where('product_id', $_GET['id'])->delete();
        AdminProduct::where('id', $_GET['id'])->delete();

        return redirect('/deleted/product');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryproduct = ProductCategories::all();
        //return view('admin.ListProducts',compact(['categoryproduct']));
        return $categoryproduct;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'weight' => 'required',
            'description' => 'required',
            'kategori' => 'required'
        ]);

        $id = AdminProduct::create([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'weight' => $request->weight,
            'description' => $request->description,
        ])->id;

        CategoryDetail::create([
            'product_id' => $id,
            'category_id' => $request->kategori
        ]);
 
        $files = [];
        foreach($request->file('insert_photo') as $file){
            // $file = $request->file('insert_photo');
    
            $nama_file = time()."_".$file->getClientOriginalName();
            
            $tujuan_upload = 'product_images';
            $file->move($tujuan_upload,$nama_file);
                
            ProductImage::create([
                'image_name' => $nama_file,
                'admin_product_id' => $id,
            ]);
        }
        return redirect('listproducts')->with('success', 'Data berhasil ditambahkan');
    }

    public function ubahproduk(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'weight' => 'required',
            'description' => 'required',
            'kategori' => 'required'
        ]);

        AdminProduct::where('id', $request->id)->update([
            'product_name' => $request->product_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'weight' => $request->weight,
            'description' => $request->description,
        ]);

        CategoryDetail::where('product_id', $request->id)->update([
            'category_id' => $request->kategori
        ]);
 
        return redirect('listproducts')->with('success', 'Data berhasil diubah');
    }

    function deleteproduk(){
        AdminProduct::findOrFail($_GET['id']);

        // Discount::where('id_product', $_GET['id'])->delete();
        // CategoryDetail::where('product_id', $_GET['id'])->delete();
        // TransactionDetail::where('product_id', $_GET['id'])->delete();
        AdminProduct::where('id', $_GET['id'])->update(['status' => 'deleted']);

        return redirect('listproducts')->with('success', 'Data berhasil dihapus');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$data = AdminProduct::where('id',$id)->with('RelasiImage')->get();
        //return view ('admin.ListProducts',compact (['products']));
    }

    // public function ProductImage($id, Request $request)
    // {
    //     $products = AdminProduct::find($id);

    //     if($products){
    //         $ProductImage = ProductImage::where('admin_product_id',$products->id)->paginate(5);
    //     }
    // }

    // public function destroy(AdminProduct $products, $id)
    // {

    //     AdminProduct::where('id',$id)->delete();
    //     $products=AdminProduct::find($id);

    //     return redirect('listproducts')->with('delete','Data Telah Dihapus');
    // }

}