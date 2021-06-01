<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Courier;
use App\ProductCategories;
use App\Discount;
use App\Response;
use App\ProductReview;
use Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;
use App\User;
use PDF;
use App\DatabaseAdminNotif;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $data_sukses_per_tahun = [];
        // $data_ongoing_per_tahun = [];
        // $data_cancel_per_tahun = [];
        // $data_penjualan_sukses_5_tahun = [];
        // $data_penjualan_ongoing_5_tahun = [];
        // $data_penjualan_cancel_5_tahun = [];
        // $i = 1;
        // $trans_cancel = Transaction::where('status', 'canceled')->orWhere('status', 'expired')->get();
        // $trans_ongoing = Transaction::where('status', 'unverified')->orWhere('status', 'verified')->orWhere('status', 'delivered')->get();
        // $trans_sukses = Transaction::where('status', 'success')->get();
        // for ($i = 1; $i <= 12; $i++) {
        //     $j = 0;
        //     foreach ($trans_sukses as $t) {
        //         $month_number = (int)date("n", strtotime($t->created_at->format('M')));
        //         if ($month_number == $i) {
        //             $j++;
        //         }
        //     }
        //     array_push($data_sukses_per_tahun, $j);
        // }
        // for ($i = 2021; $i > 2016; $i--) {
        //     $j = 0;
        //     foreach ($trans_sukses as $t) {
        //         $year = (int)$t->created_at->format('Y');
        //         if ($year == $i) {
        //             $j++;
        //         }
        //     }
        //     array_push($data_penjualan_sukses_5_tahun, $j);
        // }
        // for ($i = 1; $i <= 12; $i++) {
        //     $j = 0;
        //     foreach ($trans_ongoing as $t) {
        //         $month_number = (int)date("n", strtotime($t->created_at->format('M')));
        //         if ($month_number == $i) {
        //             $j++;
        //         }
        //     }
        //     array_push($data_ongoing_per_tahun, $j);
        // }
        // for ($i = 2021; $i > 2016; $i--) {
        //     $j = 0;
        //     foreach ($trans_ongoing as $t) {
        //         $year = (int)$t->created_at->format('Y');
        //         if ($year == $i) {
        //             $j++;
        //         }
        //     }
        //     array_push($data_penjualan_ongoing_5_tahun, $j);
        // }
        // for ($i = 1; $i <= 12; $i++) {
        //     $j = 0;
        //     foreach ($trans_cancel as $t) {
        //         $month_number = (int)date("n", strtotime($t->created_at->format('M')));
        //         if ($month_number == $i) {
        //             $j++;
        //         }
        //     }
        //     array_push($data_cancel_per_tahun, $j);
        // }
        // for ($i = 2021; $i > 2016; $i--) {
        //     $j = 0;
        //     foreach ($trans_sukses as $t) {
        //         $year = (int)$t->created_at->format('Y');
        //         if ($year == $i) {
        //             $j++;
        //         }
        //     }
        //     array_push($data_penjualan_cancel_5_tahun, $j);
        // }
        // $data_penjualan_sukses_5_tahun = array_reverse($data_penjualan_sukses_5_tahun);
        // $data_penjualan_ongoing_5_tahun = array_reverse($data_penjualan_ongoing_5_tahun);
        // $data_penjualan_cancel_5_tahun = array_reverse($data_penjualan_cancel_5_tahun);
        
        $data['trans'] = Transaction::join('couriers', 'transactions.courier_id', 'couriers.id')->select('transactions.*', 'couriers.courier')->get();
        // return view('admin', compact('data_sukses_per_tahun', 'data_ongoing_per_tahun', 'data_cancel_per_tahun', 'data_penjualan_sukses_5_tahun', 'data_penjualan_cancel_5_tahun', 'data_penjualan_ongoing_5_tahun'), $data);
        return view('admin', $data);
    }
    public function products()
    {
        return view('dashboard/products', compact('dashboard'));
    }

    function reviews(){
        $data['reviews'] = ProductReview::join('users', 'product_reviews.user_id', 'users.id')->join('products','product_reviews.product_id', 'products.id')->select('product_reviews.*','users.name','products.product_name')->get();
        return view('admin.reviews', $data);
    }

    function beritanggapan(Request $req){
        $response=Response::create([
            'review_id' => $req->id,
            'admin_id' => Auth::guard('admin')->user()->id,
            'content' => $req->tanggapan
        ]);
        $review=ProductReview::find($req->id);
        $transaction= new Transaction();
        $user=User::find($review->user_id);
        Notification::send($user, new UserNotification($transaction, $response, "response"));
        return redirect('/reviews')->with('success', 'Tanggapan berhasil diberikan');
    }

    function deletedcourier(){
        $data['couriers']=Courier::where('status','deleted')->get();
        return view('couriers.deletedcourier', $data);
    }

    function deletedcategories(){
        $data['categories']=ProductCategories::where('status','deleted')->get();
        return view('categories.deletedcategories', $data);
    }

    function deleteddiscount(){
        $data['discount']=Discount::join('products','discounts.id_product','products.id')->select('discounts.*','products.product_name')->where('discounts.status','deleted')->get();
        return view('discount.deleteddiscount', $data);
    }

    function deletecategories($id){
        ProductCategories::where('id', $id)->update([
            'status' => 'deleted'
        ]);
        return redirect('/deleted/category')->with('success', 'Category berhasil dihapus');
    }

    function balikcategories($id){
        ProductCategories::where('id', $id)->update([
            'status' => null
        ]);
        return redirect('/kategori')->with('success', 'Category berhasil dikembalikan');   
    }
    public function bacaAdminNotif(){
        $id=(int)request()->input('id_notif');
        $notif=DatabaseAdminNotif::find($id);
        $notif->update(['read_at'=>now()->toDateTimeString()]);
        return redirect()->to('admin');
    }

    public function statistic(){
        $transactions = Transaction::select(\DB::raw("COUNT(*) as count"))
                    ->whereYear('created_at', date('Y'))
                    ->groupBy(\DB::raw("Month(created_at)"))
                    ->pluck('count');
        
        $month = Transaction::select(\DB::raw("COUNT(*) as count"))
                    ->whereYear('created_at',date('m'))
                    ->whereYear('created_at',date('Y'))
                    ->whereIn('status',['success', 'reviewed'])
                    ->groupBy(\DB::raw("year(created_at)"))
                    ->first();
        $year = Transaction::select(\DB::raw("COUNT(*) as count"))
                    ->whereYear('created_at',date('Y'))
                    ->whereIn('status',['success', 'reviewed'])
                    ->groupBy(\DB::raw("year(created_at)"))
                    ->first();
        $date = now();
          
        $perbulan = Transaction::where('status','==','success')->avg('total');
        $laporan = Transaction::selectRaw('count(*) as jumlah, sum(total) as sub_total, month(created_at) as month')->groupBy('month')->get();
        $tahunan = Transaction::selectRaw('count(*) as jumlah, sum(total) as sub_total, year(created_at) as year')->groupBy('year')->get();
        $json_total = [];
        $json_bulan = [];
        $datapenghasilan1 = 0;
        $datatahunan1=0;
        
        foreach($laporan as $penghasilan){
            $datapenghasilan2 = $datapenghasilan1+$penghasilan->sub_total;
            $datapenghasilan1 = $datapenghasilan2;
        }
            $datapenghasilan3 =$datapenghasilan1/count($laporan);
        foreach ($tahunan as $pendapatantahunan){
            $datatahunan2 = $datatahunan1+$pendapatantahunan->sub_total;
            $datatahunan1 = $datatahunan2;
        }
            $datatahunan3 = $datatahunan1/count($tahunan);




        return view('statistic', compact('transactions', 'month', 'year', 'date', 'datapenghasilan3','datatahunan3', 'perbulan'));
    }

    public function print()
    {
        $transactions = Transaction::all();
        return view('print', compact('transactions'));
    }
    
    public function cetak_pdf()
    {
        $transactions = Transaction::all();
    
        $pdf = PDF::loadview('transaksi_pdf',['transactions'=>$transactions]);
        return $pdf->download('laporan-pdf');
    }
}

// $month = DB::table('transactions')
//  ->select(DB::raw("sum(total) as total, 
// count(*) as count"))
//  -
// >where(DB::raw('month(created_at)'),date('m'))
//  -
// >where(DB::raw('year(created_at)'),date('Y'))
//  ->whereIn('status',['success', 'reviewed'])
//  ->groupBy(DB::raw("year(created_at)"))
//  ->first();
//  $year = DB::table('transactions')
//  ->select(DB::raw("sum(total) as total, 
// count(*) as count"))
//  -
// >where(DB::raw('year(created_at)'),date('Y'))
//  ->whereIn('status',['success', 'reviewed'])
//  ->groupBy(DB::raw("year(created_at)"))
//  ->first();
//  $date = now();
//  return view('pages.dashboard.home', compact('month', 
// 'year', 'date'));

