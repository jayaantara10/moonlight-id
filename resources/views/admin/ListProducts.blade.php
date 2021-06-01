@extends('layouts.admin-app')
@section('content')

<br>
<div class="card mb-4">
    <div class="card-header">
        <h5>PRODUCTS</h5>
    </div>
    <div class="card-body" style="background: #cccabb">
        <button type="button" class="edit btn btn-outline-primary float-xl-left" data-toggle="modal"
        data-target="#tambahdata">
        Tambah Data
        <i class="nc-icon nc-send"></i>
    </button>

    {{-- PESAN FEED BACK --}}
    @if(Session::has('success'))
    <div class="alert alert-success">
        <p>{{Session::get('success') }}</p>
    </div>
    <button type="button" class="edit btn btn-outline-primary float-xl-left" data-toggle="modal"
    data-target="#tambahdata">
    Tambah Data
</button>
@endif

@if(Session::has('delete'))
<div class="alert alert-danger">
    <p>{{Session::get('delete') }}</p>
</div>
<button type="button" class="edit btn btn-outline-primary float-xl-left" data-toggle="modal"
data-target="#tambahdata">
Tambah Data
</button>
@endif

@if(Session::has('gagal'))
<div class="alert alert-danger">
    <p>{{Session::get('gagal') }}</p>
</div>
<button type="button" class="edit btn btn-outline-primary float-xl-left" data-toggle="modal"
data-target="#tambahdata">
Tambah Data
</button>
@endif
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
<button type="button" class="edit btn btn-outline-primary float-xl-left" data-toggle="modal"
data-target="#tambahdata">
Tambah Data
</button>
@endif

<br><br>

<!--------------------------------------- DATA TABLE--------------------------------------------- -->
<table id="example" class="table  table-bordered table-hover " style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Product</th>
            <th class="text-center">Kategori</th>
            <th class="text-center">Harga</th>
            <th class="text-center">Deskripsi</th>
            <th class="text-center">Stok</th>
            <th class="text-center">Berat</th>
            <th class="text-center">Rate Produk</th>
            <th class="text-center">Image</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $products)
        <tr>
            <td>{{$loop->iteration }}</td>
            <td>{{$products->product_name}}</td>

            <td class="text-center">
                @foreach ($products->RelasiCategory as $productCategory)
                {{$productCategory->category_name}}
                @endforeach
            </td>

            <td>{{$products->price}}</td>
            <td>{{$products->description}}</td>
            <td>{{$products->stock}}</td>
            <td>{{$products->weight}} gram</td>
            <td>
                <?php $jml=0; $rate=0; ?>
                @foreach($products->rating as $r)
                <?php $jml++; $rate += $r->rate ?>
                @if($jml == 0)
                {{'0'}}
                @else
                {{$rate/$jml}}
                @endif
                @endforeach
            </td>
            <td class="text-center"> 
                @foreach ($products->RelasiImage as $productImage)
                <img width="100px" src="{{asset('product_images/'.$productImage->image_name)}}">
                @endforeach
            </td>

            <td class="text-center">


                {{-- TOMBOL EDIT --}}
                <button type="button" class="edit btn btn-outline-primary" data-toggle="modal"
                data-target="#editdata{{$products->id}}">
                Edit
            </button>
            <div class="modal fade" id="editdata{{$products->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="background: #cccabb">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Data Produk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('ubah.produk')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$products->id}}">
                            <div class="modal-body" style="text-align: left;">
                                {{-- Nama products --}}
                                <div class="panel panel-body">
                                    <label class="col-sm-3 col-form-label">Kategori</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="kategori">
                                            <option value="">--Select Here--</option>
                                            @foreach($categories as $c)
                                            <option value="{{$c->id}}" 
                                                @foreach($products->RelasiCategory as $p)
                                                    @if($p->id == $c->id)
                                                        {{'selected'}}
                                                    @endif
                                                @endforeach>{{$c->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="panel panel-body">
                                    <label class="col-sm-3 col-form-label">Product</label>
                                    <div class="col-sm-9">
                                        <input name="product_name" value="{{$products->product_name}}" type="text" class="form-control"
                                        placeholder="Produk yang ingin ditambahkan"><span class="error text-danger"><p id="jenis_error"></p></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <label class="col-sm-3 col-form-label">Description</label>
                                    <div class="col-sm-9">
                                        <input value="{{$products->description}}" name="description" type="textArea" class="form-control"
                                        placeholder="Deskripsi yang ingin ditambahkan"><span class="error text-danger"><p id="jenis_error"></p></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <label class="col-sm-3 col-form-label">Price</label>
                                    <div class="col-sm-9">
                                        <input value="{{$products->price}}" name="price" type="textArea" class="form-control"
                                        placeholder="Harga produk yang ingin ditambahkan"><span class="error text-danger"><p id="jenis_error"></p></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <label class="col-sm-3 col-form-label">Stock</label>
                                    <div class="col-sm-9">
                                        <input value="{{$products->stock}}" name="stock" type="textArea" class="form-control"
                                        placeholder="stok yang ingin ditambahkan"><span class="error text-danger"><p id="jenis_error"></p></span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <label class="col-sm-3 col-form-label">Weight</label>
                                    <div class="col-sm-9">
                                        <input value="{{$products->weight}}" name="weight" type="textArea" class="form-control"
                                        placeholder="Berat produk yang ingin ditambahkan"><span class="error text-danger"><p id="jenis_error"></p></span>
                                    </div>
                                </div>
                                <!-- <div class="panel-body">
                                    <label class="col-sm-3 col-form-label">Photo</label>
                                    <div class="col-sm-9">
                                        <input multiple type="file" class="form-control " name="insert_photo[]">
                                    </div>
                                </div> -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- TOMBOL DELETE --}}
            <a onclick="return confirm('Yakin melanjutkan hapus data?')" href="{{ route('hapus.produk', ['id'=> $products->id]) }}" class="btn btn-outline-danger"> 
                Delete
            </a>
        </td>
    </tr>

    @empty
    <tr>
        <td class="text-center" colspan="3">
            <p>Tidak ada data</p>
        </td>
    </tr>
    @endforelse
</tbody>
</table>

<!--------------------------------------- Modal Tambah data---------------------------------------------> 
<div class="modal fade" id="tambahdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #cccabb">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Menambahkan Data Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/add/product" method="POST"  name="products" id="products" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    {{-- Nama products --}}
                    <div class="panel panel-body">
                        <label class="col-sm-3 col-form-label">Kategori</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="kategori">
                                <option value="">--Select Here--</option>
                                @foreach($categories as $c)
                                <option value="{{$c->id}}">{{$c->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="panel panel-body">
                        <label class="col-sm-3 col-form-label">Product</label>
                        <div class="col-sm-9">
                            <input name="product_name" type="text" class="form-control"
                            placeholder="Produk yang ingin ditambahkan"><span class="error text-danger"><p id="jenis_error"></p></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <label class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <input name="description" type="textArea" class="form-control"
                            placeholder="Deskripsi yang ingin ditambahkan"><span class="error text-danger"><p id="jenis_error"></p></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <label class="col-sm-3 col-form-label">Price</label>
                        <div class="col-sm-9">
                            <input name="price" type="textArea" class="form-control"
                            placeholder="Harga produk yang ingin ditambahkan"><span class="error text-danger"><p id="jenis_error"></p></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <label class="col-sm-3 col-form-label">Stock</label>
                        <div class="col-sm-9">
                            <input name="stock" type="textArea" class="form-control"
                            placeholder="stok yang ingin ditambahkan"><span class="error text-danger"><p id="jenis_error"></p></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <label class="col-sm-3 col-form-label">Weight</label>
                        <div class="col-sm-9">
                            <input name="weight" type="textArea" class="form-control"
                            placeholder="Berat produk yang ingin ditambahkan"><span class="error text-danger"><p id="jenis_error"></p></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <label class="col-sm-3 col-form-label">Photo</label>
                        <div class="col-sm-9">
                            <input multiple type="file" class="form-control " name="insert_photo[]">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


</div>
</div>
@endsection