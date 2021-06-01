@extends('layouts.admin-app')
@section('content')

<br>
<div class="card mb-4">
    <div class="card-header">
        <h5>DISCOUNT</h5>
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
            <th>Produk</th>
            <th>Discount</th>
            <th>Start</th>
            <th>End</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($discount as $discount)
        <tr>
            <td>{{$loop->iteration }}</td>
            <td>{{$discount->product_name}}</td>
            <td>{{$discount->percentage}}%</td>
            <td>{{date('Y-m-d', strtotime( $discount->start ))}}</td>
            <td>{{date('Y-m-d', strtotime( $discount->end ))}}</td>
            <td class="text-center">
                {{-- TOMBOL DELETE DAN EDIT --}}
                <form action="/discount/{{$discount->id}}" method="POST">
                    @csrf
                    {{method_field('DELETE')}}

                    {{-- TOMBOL EDIT --}}
                    <button type="button" class="edit btn btn-outline-primary" data-toggle="modal"
                    data-target="#editdata{{$discount->id}}">
                    Edit
                </button>
            </form>
            <a href="{{route('delete.discount', ['id' => $discount->id])}}" class="btn btn-outline-danger">Hapus</a>


            <!--------------------------------------- Modal Edit data---------------------------------------------->
            <div class="modal fade" id="editdata{{$discount->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="background: #cccabb">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Kurir</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="/discount/{{$discount->id}}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PUT') }}
                            <div class="modal-body"> 
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Produk</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="product_id">
                                            <option value="">--Select Here--</option>
                                            @foreach($products as $p)
                                            <option value="{{$p->id}}" @if($discount->id_product == $p->id) {{ 'selected' }} @endif>{{$p->product_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Discount</label>
                                    <div class="col-sm-9">
                                        <input name="percentage" type="text" class="form-control"
                                        placeholder="Diskon yang ingin ditambahkan" value="{{$discount->percentage}}"><span class="error text-danger"><p id="jenis_error"></p></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Start</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control" name="start" id="start" value="{{$discount->start}}"><span class="error text-danger"><p id="jenis_error"></p></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">End</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control" name="end" id="end" value="{{$discount->end}}"><span class="error text-danger"><p id="jenis_error"></p></span>
                                    </div>
                                </div>
                            </div>                       
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</tbody>
@empty
<tbody>
    <tr>
        <td class="text-center" colspan="6">
            <p>Tidak ada data</p>
        </td>
    </tr>
    @endforelse
</tbody>
</table>

<!--------------------------------------- Modal Tambah data--------------------------------------------- -->
<div class="modal fade" id="tambahdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background: #cccabb">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Menambahkan Data Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/discount" method="POST"  name="discount" id="discount" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    {{-- Diskon --}}
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Produk</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="produk">
                                <option value="">--Select Here--</option>
                                @foreach($products as $p)
                                <option value="{{$p->id}}">{{$p->product_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Discount</label>
                        <div class="col-sm-9">
                            <input name="percentage" type="text" class="form-control"
                            placeholder="Diskon yang ingin ditambahkan"><span class="error text-danger"><p id="jenis_error"></p></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Start</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="start" id="start"><span class="error text-danger"><p id="jenis_error"></p></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">End</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="end" id="end"><span class="error text-danger"><p id="jenis_error"></p></span>
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
