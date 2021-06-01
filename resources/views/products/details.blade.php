@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('products') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
        <div class="col-md-12 mt-2">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('products') }}">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $products->product_name }}</li>
              </ol>
            </nav>
        </div>
        <div class="col-md-12 mt-1">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ url('uploads') }}/{{ $products->images }}" class="rounded mx-auto d-block" width="100%" alt=""> 
                        </div>
                        <div class="col-md-6 mt-5">
                            <h2>{{ $products->product_name }}</h2>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Price</td>
                                        <td>:</td>
                                        <td>Rp. {{ number_format($products->price) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Stock</td>
                                        <td>:</td>
                                        <td>{{ number_format($products->stock) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td>:</td>
                                        <td>{{ ($products->description) }}</td>
                                    </tr>
                                   
                                    <tr>
                                        <td></td>
                                        <td>:</td>
                                        <td>
                                             <form method="post" action="{{ url('cart') }}/{{ $products->id }}" >
                                            @csrf
                                                <input id="txtPassportNumber" name="qty" type="number" min="0" max="{{ $products->stok }}" onkeyup="EnableDisable(this)">
                                                <button type="submit" class="btn btn-primary mt-2"><i class="fa fa-shopping-cart"></i> Add to cart</button>
                                            </form>
                                        </td>
                                    </tr>
                                   
                                    
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection