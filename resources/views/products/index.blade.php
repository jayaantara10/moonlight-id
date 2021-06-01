@extends('layouts.app')

@section('content')


    <div class="container">
    <div class="row justify-content-center">
    @foreach ($products as $product)
        <div class="col-md-4">
            <div class="card">
              <img src="/" class="card-img-top" alt="...">
              <hr>
              <div class="card-body">
                <h5 class="card-title">{{ $product->product_name}}</h5>
                <strong>Price :</strong> Rp. {{ number_format($product->price)}} <br>
                <hr>    
                    <!-- Button details -->
                    <a href="{{ url('product/details') }}/{{ $product->id }}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Detail</a>
              </div>
            </div> 
        </div>
    @endforeach
    </div>
</div>


@endsection
