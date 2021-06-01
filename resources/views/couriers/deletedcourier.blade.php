@extends('layouts.admin-app')
@section('content')

<br>
<div class="card mb-4">
    <div class="card-header">
        <h5>DELETED COURIERS</h5>
    </div>
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
                <th>Kurir</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($couriers as $couriers)
            <tr style="text-align: center;">
                <td>{{$loop->iteration }}</td>
                <td>{{$couriers->courier}}</td>
                <td class="text-center">
                    <a href="{{ route('balik.courier', ['id' => $couriers->id]) }}" class="btn btn-success">Kembalikan</a>
                    <form action="/courier/{{$couriers->id}}" method="POST">
                        @csrf
                        {{method_field('DELETE')}}

                        {{-- TOMBOL DELETE --}}
                        <button type="submit" name="submit" class="btn btn-danger"> 
                            Delete
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
@endsection
