@extends('layouts.admin-app')
@section('content')

<br>
<div class="card mb-4">
    <div class="card-header">
        <h5>ADMIN</h5>
    </div>
    <div class="card-body" style="background: #cccabb">
    <br><br>

        <!--------------------------------------- DATA TABLE--------------------------------------------- -->
        <table id="example" class="table  table-bordered table-hover " style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Phone</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($admins as $admins)
                <tr>
                    <td>{{$loop->iteration }}</td>
                    <td>{{$admins->username}}</td>
                    <td>{{$admins->phone}}
                    <td class="text-center">
                        {{-- TOMBOL DELETE DAN EDIT --}}
                        <form action="/adminlist/{{$admins->id}}" method="POST">
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
</div>

@endsection