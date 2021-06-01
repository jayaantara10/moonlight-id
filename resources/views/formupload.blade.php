@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <h3>Form upload bukti</h3>
            <form action="{{ route('uploadbukti') }}" method="post" enctype="multipart/form-data" style="border: 2px solid; padding: 10px;">
                @csrf
                <input type="hidden" name="id" value="{{$id}}">
                <div class="form-group">
                    <label>File : </label><br>
                    <input type="file" name="bukti">
                </div>
                <center><button type="submit" class="btn btn-success"><i class="fa fa-arrow-up"></i> Upload</button></center>
            </form>  
        </div>
    </div>
</div>
</div>
@endsection
