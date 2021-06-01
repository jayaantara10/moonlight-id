@extends('layouts.admin-app')
@section('content')

<br>
<div class="card mb-4">
    <div class="card-header">
        <h5>CATEGORIES</h5>
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


        <br><br>

        <!--------------------------------------- DATA TABLE--------------------------------------------- -->
        <table id="example" class="table  table-bordered table-hover " style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $categories)
                <tr>
                    <td>{{$loop->iteration }}</td>
                    <td>{{$categories->category_name}}</td>
                    <td class="text-center">
                        {{-- TOMBOL DELETE DAN EDIT --}}
                        <form action="/kategori/{{$categories->id}}" method="POST">
                            @csrf
                            {{method_field('DELETE')}}

                            {{-- TOMBOL EDIT --}}
                            <button type="button" class="edit btn btn-outline-primary" data-toggle="modal"
                                data-target="#editdata{{$categories->id}}">
                                Edit
                            </button>
                        </form>
                        <a href="{{ route('delete.categories', ['id' => $categories->id]) }}" class="btn btn-danger">Hapus</a>
                        <!--------------------------------------- Modal Edit data---------------------------------------------->
                        <div class="modal fade" id="editdata{{$categories->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content" style="background: #cccabb">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Kategori</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/kategori/{{$categories->id}}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        {{ method_field('PUT') }}
                                        <div class="modal-body">

                                            @include('categories.EditCategories')

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
                    <td class="text-center" colspan="3">
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
                    <form action="/kategori" method="POST" name="category_name" id="categories"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            {{-- Nama kategori --}}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Kategori</label>
                                <div class="col-sm-9">
                                    <input name="category_name" type="text" class="form-control"
                                        placeholder="Kategori yang ingin ditambahkan"><span class="error text-danger">
                                        <p id="jenis_error"></p>
                                    </span>
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
