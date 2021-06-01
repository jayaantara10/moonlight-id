@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        @foreach($products as $p)
        <div class="col-md-8 col-sm-12 mb-3">
            <div class="card">
                <img src="{{ asset('product_images/'.$p->product_image[0]->image_name) }}" class="tengah" alt="...">

                <div class="card-body">
                    <div class="card-title"><h4>{{$p->product_name}}</h4></div>
                    <h6>Price : Rp. {{ number_format($p->price,'0',',','.')}}</h6>
                    <h6>{{ $p->description}}</h6>
                    <?php $jml =0; $rate = 0; ?>
                    @foreach($p->product_review as $rev)
                    <?php $jml++; $rate += $rev->rate; ?>
                    @endforeach
                    <h6>Rating : @if($jml == 0){{ 0 }}@else{{$rate/$jml}}@endif</h6>
                    <h4>Review</h4>
                    <ul>
                        @foreach($p->product_review as $rev)
                        <li>{{$rev->rate}} - {{$rev->content}}</li>
                        @foreach($rev->tanggapan as $balas)
                        Balasan admin : {{$balas->content}}<br>
                        @endforeach
                        @endforeach
                    </ul>
                </div>

                <div class="card-footer">
                    <button  data-toggle="modal" data-target="#buynow" class="btn btn-primary">Buy Now</button>
                    <div class="modal fade" id="buynow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{$p->product_name}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('buy.now') }}" method="post">
                                @csrf
                                <input type="hidden" name="produkid" value="{{$p->id}}">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Jumlah</label>                                        
                                        <input class="form-control" onchange="changeJml(this.value)" type="number" value="1" min="1" name="jml" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Harga</label>
                                        <input class="form-control" id="harga" type="number" readonly value="{{$p->price}}" name="harga" required/>
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
                                    <button type="submit" class="btn btn-primary">Buy</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <a href="{{ route('add.cart', ['id' => $p->id])}}" class="btn btn-success">Add to chart</a>
                <button class="btn btn-info" data-toggle="modal" data-target="#modalreview" style="color: #fff">Review</button>
                <div class="modal fade" id="modalreview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Review Produk</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/give/review" method="post">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="pid" value="{{$p->id}}">
                                    <div class="form-group">
                                        <label>Rating</label>
                                        <input type="number" name="rate" min="1" max="5" placeholder="1-5" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea name="content" class="form-control">Masukkan review produk disini</textarea>
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
    </div>
    @endforeach
</div>
</div>
<script type="text/javascript">
    function changeJml(param){
        var tot = <?php echo $products[0]->price?> * param;
        document.getElementById('harga').value = tot;
    }
</script>
<script type="text/javascript">
    var berat = <?php echo $products[0]->weight; ?>;

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
