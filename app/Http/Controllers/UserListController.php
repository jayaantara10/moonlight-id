<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class UserListController extends Controller
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
        $users= User::all();
        return view ('admin.ListUser',compact('users'));
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
    * @param \App\User $users
    * @return \Illuminate\Http\Response
    */
    public function destroy($id){
        
        User::where('id',$id)->delete();
        $users=User::find($id);
        return redirect('userlist')->with('delete','Data Telah Dihapus');
        
    }
}
