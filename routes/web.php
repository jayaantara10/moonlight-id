<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Mail\MailtrapExample;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    $data['products'] = Product::join('product_images', 'products.id', 'product_images.admin_product_id')->select('product_images.image_name as gambar', 'products.id as id', 'products.product_name')->where('products.status', null)->get();
    return view('home', $data);
});

Route::get('/get/city/{para}', 'TransactionController@getcity');
Route::get('/get/trans/{param}', 'TransactionController@gettrans');
Route::get('/get/ongkir/{from}/{to}/{kurir}/{berat}', 'TransactionController@getongkir');

Auth::routes(['verify' => true], function () {

    Mail::to('newuser@example.com')->send(new MailtrapExample());

    return 'A message has been sent to Mailtrap!';

}

);

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/user/logout', 'Auth\LoginController@userLogout')->name('user.logout');


Route::get('admin/cetak_pdf', 'AdminController@cetak_pdf');
Route::get('print', 'AdminController@print');

Route::get('statistic', 'AdminController@statistic');
Route::prefix('admin')->group(function()
{
    // Route Admin
    // Dashboard
    Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::get('dashboard/products', 'AdminController@index')->name('admin.products');
    Route::get('/edit/produk', 'AdminProductController@editproduk')->name('edit.produk');
    Route::post('/ubah/produk', 'AdminProductController@ubahproduk')->name('ubah.produk');
    Route::get('/hapus/produk', 'AdminProductController@deleteproduk')->name('hapus.produk');
    // Login
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    
    Route::post('/ubah/status/trans', 'TransactionController@ubahstatus')->name('ubah.status.trans');
    Route::get('/delete/product/permanent', 'AdminProductController@deleteprodukpermanent')->name('hapus.produk.permanen');
    Route::get('/balikan/product', 'AdminProductController@balikanproduct')->name('balikan.produk');
    
    // Logout
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::post('/notifikasi/baca','AdminController@bacaAdminNotif');
    
});

Route::get('/set/expired/{id}', 'TransactionController@expired');
Route::get('/deleted/courier', 'AdminController@deletedcourier');
Route::get('/deleted/category', 'AdminController@deletedcategories');
Route::get('/deleted/discount', 'AdminController@deleteddiscount');
Route::get('/do/deleted/courier{id}', 'CourierController@deletecou')->name('delete.courier');
Route::get('/do/deleted/category{id}', 'AdminController@deletecategories')->name('delete.categories');
Route::get('/do/deleted/discount{id}', 'DiscountController@deletediscount')->name('delete.discount');
Route::get('/balik/courier/{id}', 'CourierController@balikcou')->name('balik.courier');
Route::get('/balik/category/{id}', 'AdminController@balikcategories')->name('balik.categories');
Route::get('/balik/discount/{id}', 'DiscountController@balikdiscount')->name('balik.discount');

//products
Route::get('/products','ProductController@index')->name('products.index');

Route::get('/select/products','ProductController@selectproduct')->name('select.product');

Route::group(['middleware' => 'auth:web'], function(){
    Route::post('/buy/now','ProductController@buynow')->name('buy.now');
    Route::get('/my/transaction', 'TransactionController@index')->name('my.transaction');
    Route::get('/my/cart', 'TransactionController@mycart')->name('my.cart');
    Route::get('/add/cart', 'TransactionController@addcart')->name('add.cart');
    Route::get('/trans/unverified/{id}', 'TransactionController@dataUnverified');
    Route::get('/trans/verified/{id}', 'TransactionController@dataVerified');
    Route::get('/trans/delivered/{id}', 'TransactionController@dataDelivered');
    Route::get('/trans/success/{id}', 'TransactionController@dataSuccess');
    Route::get('/upload/bukti/{id}', 'TransactionController@formupload');
    Route::post('/do/upload/bukti', 'TransactionController@uploadbukti')->name('uploadbukti');
    Route::post('/do/checkout', 'TransactionController@checkout')->name('checkout');
    Route::get('/batal/pesanan/{id}', 'TransactionController@batal');
    Route::get('/delete/item/cart', 'TransactionController@deleteitemcart')->name('delete.item.cart');
    Route::post('/give/review', 'ProductController@review');
    Route::post('/notifikasi/baca','HomeController@bacaNotif');
    //Route::get('/user/read-notif/{id}','TransactionController@readNotifUser');
    //Route::get('/notifikasi','TransactionController@tampilNotif');
});

Route::post('/add/product','AdminProductController@store')->name('add.product');

//dashboard list user
Route::resource('/userlist','UserListController');

//dashboard list admin
Route::resource('/adminlist','AdminListController');

//dashboard kategori
Route::resource('/kategori','ProductCatController');

//dashboard kurir
Route::resource('/courier','CourierController');

//dashboard produk
Route::resource('/listproducts','AdminProductController');

//dashboard diskon
Route::resource('/discount','DiscountController');

Route::get('/reviews', 'AdminController@reviews');

// Route::resource('/deleted', 'AdminProductController');
Route::get('/deleted/product', 'AdminProductController@deletedproduct')->name('deleted.product');
Route::post('/beri/tanggapan', 'AdminController@beritanggapan');
