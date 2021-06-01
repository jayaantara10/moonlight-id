@extends('layouts.admin-app')
@section('content')

<br>
<div class="card mb-4">
    <div class="card-header">
        <h5>COURIERS</h5>
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
                    <th>Kurir</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($couriers as $couriers)
                <tr>
                    <td>{{$loop->iteration }}</td>
                    <td>{{$couriers->courier}}</td>
                    <td class="text-center">
                        {{-- TOMBOL DELETE DAN EDIT --}}
                        <form action="/courier/{{$couriers->id}}" method="POST">
                            @csrf
                            {{method_field('DELETE')}}

                            {{-- TOMBOL EDIT --}}
                            <button type="button" class="edit btn btn-outline-primary" data-toggle="modal"
                                data-target="#editdata{{$couriers->id}}">
                                Edit
                            </button>
                        </form>
                        <a href="{{ route('delete.courier', ['id' => $couriers->id]) }}" class="btn btn-danger">Hapus</a>

                        <!--------------------------------------- Modal Edit data---------------------------------------------->
                        <div class="modal fade" id="editdata{{$couriers->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content" style="background: #cccabb">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Kurir</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/courier/{{$couriers->id}}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        {{ method_field('PUT') }}
                                        <div class="modal-body">

                                            @include('couriers.EditCourier')

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
                    <form action="/courier" method="POST"  name="courier" id="courier" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            {{-- Nama kurir --}}
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Kurir</label>
                                <div class="col-sm-9">
                                    <input name="courier" type="text" class="form-control"
                                        placeholder="Kurir yang ingin ditambahkan"><span class="error text-danger"><p id="jenis_error"></p></span>
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
