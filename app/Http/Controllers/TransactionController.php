<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\TransactionDetail;
use App\Cart;
use App\Courier;
use App\Product;
use App\Admin;
use App\User;
use App\Response;
use App\ProductReview;
use Auth;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;
use App\Notifications\AdminNotification;
class TransactionController extends Controller
{
	function index(){
		return view('transaction');
	}

	function ubahstatus(){
		$transaction=Transaction::find($_POST['id']);
		// $transaction=Transaction::where('id', $_POST['id'])->update([
		// 	'status' => $_POST['status']
		// ]);
		$transaction->update([
			'status' => $_POST['status']
		]);
		if ($_POST['status'] == 'success') {
			$trans = Transaction::with('detail')->where('id', $_POST['id'])->first();
			foreach($trans->detail as $t){
				$produk = Product::where('id', $t->product_id)->first();
				Product::where('id', $t->product_id)->update([
					'stock' => $produk->stock - 1
				]);
			}
		}
		$response=new Response();
		$user=User::find($transaction->user_id);
		Notification::send($user, new UserNotification($transaction, $response, "transaction"));
		return redirect('/admin')->with('success', 'Transaksi berhasil diubah statusnya');
	}

	function gettrans($param){
		$data = Transaction::join('couriers', 'transactions.courier_id', 'couriers.id')->where('transactions.status', $param)->select('transactions.*', 'couriers.courier')->get();
		echo json_encode($data);
	}

	function mycart(){
		$data['provinsi'] = RajaOngkir::provinsi()->all();
		$data['courier'] = Courier::all();
		$data['cart'] = Cart::join('products', 'carts.product_id', 'products.id')->where('carts.status','notyet')->where('user_id', Auth::guard('web')->user()->id)->select('carts.*','products.product_name','products.price','products.weight')->get();
		// dd($data['provinsi']);
		// exit();
		return view('cart', $data);
	}

	function getCity($param){
		$city = RajaOngkir::kota()->dariProvinsi($param)->get();
		echo json_encode($city);
	}

	function getOngkir($from, $to, $kurir, $berat){
		$ongkir = RajaOngkir::ongkosKirim([
		    'origin'        => $from,     // ID kota/kabupaten asal
		    'destination'   => $to,      // ID kota/kabupaten tujuan
		    'weight'        => $berat,    // berat barang dalam gram
		    'courier'       => $kurir    // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
		])->get();
		echo json_encode($ongkir);
	}

	function addcart(){
		Cart::create([
			'user_id' => Auth::guard('web')->user()->id,
			'product_id' => $_GET['id'],
			'qty' => '1',
			'status' => 'notyet'
		]);
		return redirect('/home');
	}

	function deleteitemcart(){
		Cart::findOrFail($_GET['id']);
		Cart::where('id', $_GET['id'])->delete();
		return redirect('/my/cart');
	}

	function expired($id){
		Transaction::where('id', $id)->update([
			'status' => 'expired'
		]);

		echo json_encode("transaksi expired");
	}

	function checkout(Request $req){
		$data = Cart::join('products', 'carts.product_id', 'products.id')->where('carts.user_id', Auth::guard('web')->user()->id)->select('carts.*', 'products.price')->get();
		$total = Cart::join('products', 'carts.product_id', 'products.id')->where('carts.user_id', Auth::guard('web')->user()->id)->sum('price'); 
		$transaction = Transaction::create([
			'timeout' => date('Y-m-d H:i:s', strtotime('+1 days')),
			'address' => $req->alamat,
			'regency' => $req->kab,
			'province' => $req->prov,
			'total' => $total + $req->ongkir,
			'shipping_cost' => $req->ongkir,
			'sub_total' => $req->total,
			'user_id' => Auth::guard('web')->user()->id,
			'courier_id' => $req->cou,
			'proof_of_payment' => "",
			'status' => 'unverified'
		]);
		foreach ($data as $key) {
			TransactionDetail::create([
				'transaction_id' => $transaction->id,
				'product_id' => $key->product_id,
				'qty' => $key->qty,
				'selling_price' => $key->price
			]);
		}
		$review= new ProductReview();
		$admin=Admin::find(2);
		Cart::where('user_id', Auth::guard('web')->user()->id)->delete();
		Notification::send($admin, new AdminNotification(0,$transaction, $review, "transaction"));
		return redirect('/my/cart');
	}

	function dataUnverified($id){
		$data = Transaction::with('detail')->where('user_id', $id)->where('status', 'unverified')->get();
		echo json_encode($data);
	}

	function dataVerified($id){
		$data = Transaction::with('detail')->where('user_id', $id)->where('status', 'verified')->get();
		echo json_encode($data);
	}

	function dataDelivered($id){
		$data = Transaction::with('detail')->where('user_id', $id)->where('status', 'delivered')->get();
		echo json_encode($data);
	}

	function dataSuccess($id){
		$data = Transaction::with('detail')->where('user_id', $id)->where('status', 'success')->get();
		echo json_encode($data);
	}

	function formupload($id){
		$data['id'] = $id;
		return view('formupload', $data);
	}

	function uploadbukti(Request $req){
		
		$file = $req->file('bukti');

		$tujuan_upload = 'bukti';

		$namafile = $file->getClientOriginalName();
		$file->move(public_path($tujuan_upload),$namafile);

		$hasil = Transaction::where('id', $req->id)->update([
			'proof_of_payment' => $namafile
		]);

		return redirect('/my/transaction');
	}

	function batal($id){
		Transaction::findOrFail($id);
		Transaction::where('id', $id)->update([
			'status' => 'canceled'
		]);

		return redirect('/my/transaction');
	}


}
