@extends('layouts.admin-app')
@section('content')

<br>
<div class="card mb-4">
    <div class="card-header">
        <h5>DELETED CATEGORIES</h5>
    </div>
    <div class="card-body" style="background: #cccabb">

        {{-- PESAN FEED BACK --}}
        @if(Session::has('success'))
        <div class="alert alert-success">
            <p>{{Session::get('success') }}</p>
        </div>
        @endif

        @if(Session::has('delete'))
        <div class="alert alert-danger">
            <p>{{Session::get('delete') }}</p>
        </div>
        @endif

        @if(Session::has('gagal'))
        <div class="alert alert-danger">
            <p>{{Session::get('gagal') }}</p>
        </div>
        @endif


        <br><br>

        <!--------------------------------------- DATA TABLE--------------------------------------------- -->
        <table id="example" class="table  table-bordered table-hover " style="width:100%">
            <thead>
                <tr style="text-align: center;">
                    <th>No</th>
                    <th>Kategori</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $categories)
                <tr style="text-align: center;">
                    <td>{{$loop->iteration }}</td>
                    <td>{{$categories->category_name}}</td>
                    <td class="text-center">
                        <a href="{{ route('balik.categories', ['id'=> $categories->id]) }}" class="btn btn-success">Kembalikan</a>
                        <form action="/kategori/{{$categories->id}}" method="POST">
                            @csrf
                            {{method_field('DELETE')}}
                            {{-- TOMBOL DELETE --}}
                            <button type="submit" name="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
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

    </div>
</div>
@endsection
