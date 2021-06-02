<?php

namespace App\Http\Controllers;
use App\Admin;
use Illuminate\Http\Request;

class AdminListController extends Controller
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
        $admins= Admin::all();
        return view ('admin.ListAdmin',compact('admins'));
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
    * Remove the specified resource from storage.
    *
    * @param \App\Admin $admins
    * @return \Illuminate\Http\Response
    */
    public function destroy($id){
        
        Admin::where('id',$id)->delete();
        $admins=Admin::find($id);
        return redirect('adminlist')->with('delete','Data Telah Dihapus');
        
    }
}
