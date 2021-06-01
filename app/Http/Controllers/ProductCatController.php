<?php

namespace App\Http\Controllers;
use App\ProductCategories;
use Illuminate\Http\Request;

class ProductCatController extends Controller
{
    private $messages = [
        'required'=>'Mohon diisi!',
        'unique'=>'sudah digunakan!',
        'string'=>'harus berupa abjad!',
        'same'=>':attribute harus memiliki email yang sama :other!'
    ];

    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index() {
        $categories= ProductCategories::where('status', null)->get();
        return view ('categories.ListCategories',compact('categories'));
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
            'category_name' => 'required'
        ]);

        $categories = new ProductCategories;
        $categories->category_name = $request->category_name;
        $categories->save();
        return redirect('kategori')->with('success', 'Data kategori berhasil ditambahkan');
    }

    /** 
    * Display the specified resource.
    *
    * @param \App\ProductCategories $category
    * @return \Illuminate\Http\Response
    */
    public function show (ProductCategories $categories){
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param \App\ProductCategories $category
    * @return \Illuminate\Http\Response
    */
    public function edit($id){

        $categories = ProductCategories::where('id',$id)->first();
        return view('categories.EditCategories', compact('categories'));
        
    }

    /**
    * Update the specified resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @param \App\ProductCategories $category
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, ProductCategories $categories, $id){
        
        ProductCategories::where('id',$id)->update(['category_name'=>$request->category_name]);
        return redirect('kategori')->with('success', 'Data kategori berhasil diubah');
        // return $id;
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param \App\ProductCategories $category
    * @return \Illuminate\Http\Response
    */
    public function destroy($id){
        
        ProductCategories::where('id',$id)->delete();
        $categories=ProductCategories::find($id);
        return redirect('kategori')->with('delete','Data Telah Dihapus');
        
    }
}

