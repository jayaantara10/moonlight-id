@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 style="text-align: center;">My Cart</h1>
            <?php $total = 0; $count = 0; $weight = 0; ?>
            @foreach($cart as $c)
            <div class="card" style="padding: 10px; margin-bottom: 10px;">
                <div style="display: flex-end; flex-direction: row;">
                    <a style="width: 150px;" class="btn btn-danger pull-right" href="{{ route('delete.item.cart', ['id' => $c->id]) }}"><i class="fa fa-trash"></i> Hapus</a>
                </div>
                <h4>Nama Produk : {{$c->product_name}}</h4>
                <h4>Harga : {{$c->price}}</h4>
                <h5>Jumlah : {{$c->qty}}</h5>
            </div>
            <?php $total += $c->price; $count++; $weight+= $c->weight; ?>
            @endforeach
            @if($count > 0)
            <center><button class="btn btn-success" onclick="checkout(<?php echo $weight; ?>)" data-toggle="modal" data-target="#checkout">Check Out</button></center>
            @endif
        </div>
        <div class="modal fade" id="checkout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form Checkout</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('checkout') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Total</label>
                                <input class="form-control" id="harga" type="number" readonly value="{{$total}}" name="total" readonly />
                            </div>
                            <div class="form-group">
                                <label>Alamat Pengiriman</label>
                                <input class="form-control" type="text" name="alamat" required />
                            </div>
                            <div class="form-group">
                                <label>Provinsi</label>
                                <select class="form-control" onchange="getCityTo(this.value)" id="provto">
                                    <option value="">--Select Option--</option>
                                    @for($i = 0; $i < sizeof($provinsi); $i++)
                                    <option value="{{$provinsi[$i]['province_id']}}">{{$provinsi[$i]['province']}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kabupaten</label>
                                <select class="form-control" onchange="cityTo(this)" id="kabto" required>
                                </select>
                            </div>
                            <input type="hidden" name="kab" id="kab">
                            <input type="hidden" name="prov" id="prov">
                            <div class="form-group">
                                <label>Dikirim dari (Provinsi)</label>
                                <select class="form-control" onchange="getCityFrom(this.value)" name="provfrom" id="provfrom">
                                    <option value="">--Select Option--</option>
                                    @for($i = 0; $i < sizeof($provinsi); $i++)
                                    <option value="{{$provinsi[$i]['province_id']}}">{{$provinsi[$i]['province']}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Dikirim dari (Kabupaten)</label>
                                <select class="form-control" id="kabfrom" name="kabfrom" required>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Ongkos Kirim</label>
                                <input class="form-control" id="ongkir" type="number" name="ongkir" required readonly />
                            </div>
                            <div class="form-group">
                                <label>Kurir</label>
                                <select class="form-control" id="kurir" name="cou" required>
                                    <option value="">--Select Here--</option>
                                    @foreach($courier as $c)
                                    <option value="{{$c->id}}">{{$c->courier}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" style="text-align: center;">
                                <button type="button" class="btn btn-success" onclick="getongkir()">Get Ongkir</button>
                            </div>
                            <div class="form-group">
                                <label>Paket</label>
                                <select class="form-control" onchange="setongkir(this.value)" id="paket" name="pkt" required>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    var berat = 0;

    function getongkir(){
        var from = $('#kabfrom').val();
        var to = $('#kabto').val();
        var kurir = $('#kurir option:selected').text();

        if (from == null) {
            alert("Pilih Kota pengiriman dahulu");
        }else if (to == null) {
            alert("Pilih Kota tujuan dahulu");
        }else if (kurir == "--Select Here--") {
            alert("Pilih kurir dahulu");
        }else{
            $.ajax({
                url: "/get/ongkir/"+from+"/"+to+"/"+kurir+"/"+berat, 
                success: function(result){
                    var hasil = JSON.parse(result);
                    console.log(hasil);
                    var ins = '<option value="">--Select Here--</option>';
                    for (var i = 0; i < hasil[0].costs.length; i++) {
                        ins += '<option value="'+hasil[0].costs[i].cost[0].value+'">'+hasil[0].costs[i].service+'</option>';
                    }
                    $('#paket').html(ins);
                }
            });
        }
    }

    function setongkir(param){
        $('#ongkir').val(param);
    }

    function cityTo(param){
        var optionText = $("#kabto option:selected").text();
        console.log(optionText);
        $('#kab').val(optionText);
    }

    function getCityTo(param){
        $.ajax({
            url: "/get/city/"+param, 
            success: function(result){
                var hasil = JSON.parse(result);
                console.log(hasil);
                var ins = '<option value="">--Select Here--</option>';
                var kab = '';
                for (var i = 0; i < hasil.length; i++) {
                    if (hasil[i].type == 'Kabupaten') {
                        kab = 'Kabupaten';
                    }else if (hasil[i].type == 'Kota'){
                        kab = 'Kota';
                    }
                    ins += '<option value="'+hasil[i].city_id+'">'+kab+' '+hasil[i].city_name+'</option>'
                }
                $('#kabto').html(ins);
            }
        });
        var optionText = $("#provto option:selected").text();
        console.log(optionText);
        $('#prov').val(optionText);
    }

    function getCityFrom(param){
        $.ajax({
            url: "/get/city/"+param, 
            success: function(result){
                var hasil = JSON.parse(result);
                var ins = '<option value="">--Select Here--</option>';
                var kab = '';
                for (var i = 0; i < hasil.length; i++) {
                    if (hasil[i].type == 'Kabupaten') {
                        kab = 'Kabupaten';
                    }else if (hasil[i].type == 'Kota'){
                        kab = 'Kota';
                    }
                    ins += '<option value="'+hasil[i].city_id+'">'+kab+' '+hasil[i].city_name+'</option>'
                }
                $('#kabfrom').html(ins);
            }
        });
    }

    function checkout(param){
        berat = param;
    }
</script>
@endsection
