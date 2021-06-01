@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-interval="2000">
                    <img src="{{asset('photos/header_4.jpg')}}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item" data-interval="2000">
                    <img src="{{asset('photos/header_3.jpg')}}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item" data-interval="2000">
                    <img src="{{asset('photos/header_5.jpg')}}" class="d-block w-100" alt="...">
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="shadow-lg p-6 mb-8 bg-secondary rounded">
        <div class="jumbotron jumbotron-fluid" style="background: #d7d0c8">
            <div class="container">
                <h2 class="display-4">Welcome to Moonlight!</h2>
                <h1 class="lead">"We'll shine your darkest night"</h1>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($products as $p)
        <div class="col-md-4 col-sm-12 mb-3">
            <div class="card">
                <img src="{{ asset('product_images/'.$p->gambar) }}" class="tengah" alt="...">
    
                <div class="shadow-lg p-6 mb-8 bg-white rounded">
                <div class="card-body">
                    <div class="card-title"><h4>{{$p->product_name}}</h4></div>
                </div>
                </div>
    
                <div class="card-footer">
                    <a href="{{ route('select.product', ['id' => $p->id])}}" class="card-link">More</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
