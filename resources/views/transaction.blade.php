@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 style="text-align: center;">My Transactions</h1>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#unverified" role="tab" aria-controls="unverified" onclick="getTrans('unverified')" aria-selected="true">Unverified</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#verified" role="tab" aria-controls="verified" onclick="getTrans('verified')" aria-selected="false">Verified</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#delivered" role="tab" aria-controls="delivered" onclick="getTrans('delivered')" aria-selected="false">Delivered</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#success" role="tab" aria-controls="success" onclick="getTrans('success')" aria-selected="false">Success</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="unverified" role="tabpanel" aria-labelledby="unverified-tab">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="tab-pane fade" id="verified" role="tabpanel" aria-labelledby="verified-tab">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="tab-pane fade" id="delivered" role="tabpanel" aria-labelledby="delivered-tab">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="tab-pane fade" id="success" role="tabpanel" aria-labelledby="success-tab">    
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    function countdown(param,id){
        var hasil = '';
        var tgl = param.split(' ');
        var artgl = tgl[0].split('-');
        
        var countdate = getmonth(artgl[1])+" "+artgl[2]+", "+artgl[0]+" "+tgl[1];
        var countDownDate = new Date(countdate).getTime();

        var x = setInterval(function() {
        // Get today's date and time
        var now = new Date().getTime();
        // console.log(now);
        // console.log(countDownDate);
        // Find the distance between now and the count down date
        var distance = countDownDate-now;
        
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Output the result in an element with id="demo"
        hasil = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";
        
        console.log(hasil);

        $('#batas'+id).html(hasil);

        if (distance < 0) {
            $.ajax({
                url: "/set/expired/"+id, 
                success: function(result){
                    console.log(result)
                }
            });
        }
        return hasil;
    }, 1000);
        
    }

    function getmonth(param){
        if (param == '01'){
            return 'Jan';
        }else if (param == '02'){
            return 'Feb';
        }else if (param == '03'){
            return 'Mar';
        }else if (param == '04'){
            return 'Apr';
        }else if (param == '05'){
            return 'May';
        }else if (param == '06'){
            return 'Jun';
        }else if (param == '07'){
            return 'Jul';
        }else if (param == '08'){
            return 'Aug';
        }else if (param == '09'){
            return 'Sep';
        }else if (param == '10'){
            return 'Oct';
        }else if (param == '11'){
            return 'Nov';
        }else if (param == '12'){
            return 'Dec';
        }
    }


    $(document).ready(function(){
        $.ajax({
            url: "../../trans/unverified/"+<?php echo Auth::guard('web')->user()->id ?>, 
            success: function(result){
                var hasil = JSON.parse(result);
                var insert = '';
                var startDate = new Date();
                if (hasil.length > 0) {
                    for (var i = 0; i < hasil.length; i++) {
                        var disabled = ''; var stat = 'unverified'; var batal = ''; var sisa =countdown(hasil[i].timeout, hasil[i].id);
                        var tgl = new Date(hasil[i].created_at);
                        var out = new Date(hasil[i].timeout);
                        if (out < startDate) {
                            disabled = 'disabled';
                            stat = 'expired';
                        }else if (hasil[i].proof_of_payment != "") {
                            disabled = 'disabled';
                        }
                        insert += '<div class="card" style="padding:10px; margin-bottom:10px;">'+
                        '<h4>Tanggal transaksi : ' + (tgl.getDate() + 1 < 10 ? '0' : '') + tgl.getDate()+'-'+(tgl.getMonth() + 1 < 10 ? '0' : '') + tgl.getMonth()+'-'+tgl.getFullYear()+
                        '</h4>'+
                        '<h6>Total : Rp. '+ hasil[i].total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") +'</h6>'+
                        '<h6>Batas upload pembayaran : <span id="batas'+hasil[i].id+'"></span></h6>'+
                        '<h6>Status : '+ stat +'</h6>'+
                        '<div style="display:flex; flex-direction:row; padding-top:10px;">'+
                        '<a href="../../upload/bukti/'+hasil[i].id+'" class="btn btn-success mr-2 '+disabled+'"><i class="fa fa-file"></i> Upload bukti</a>'+
                        '<a class="btn btn-danger mr-2 '+disabled+'" href="../../batal/pesanan/'+hasil[i].id+'"><i class="fa fa-file"></i> Batalkan Transaksi</a>'+
                        '</div>'+
                        '</div>';
                    }
                    $('#unverified').html(insert);
                }else{
                    $('#unverified').html('Tidak ada data');
                }
            }
        });
    });

    function getTrans(param){
        $.ajax({
            url: "../../trans/"+param+"/"+<?php echo Auth::guard('web')->user()->id ?>, 
            success: function(result){
                var hasil = JSON.parse(result);
                console.log(hasil);
                var insert = '';
                var startDate = new Date();
                if (hasil.length > 0) {
                    for (var i = 0; i < hasil.length; i++) {
                        var disabled = ''; var stat = param; var batal = ''; var tblreview = ''; var sisa =countdown(hasil[i].timeout, hasil[i].id);
                        var tgl = new Date(hasil[i].created_at);
                        var out = new Date(hasil[i].timeout);
                        var batas = '';
                        if (param == 'unverified') {
                            if (out < startDate) {
                                disabled = 'disabled';
                                stat = 'expired';
                            }else if (hasil[i].proof_of_payment != "") {
                                disabled = 'disabled';
                                stat = param;
                            }else{
                                batas = '<h6>Batas upload pembayaran : <span id="batas'+hasil[i].id+'"></span></h6>';
                            }
                        }else{
                            disabled = 'disabled';
                            stat = param;
                            batal = 'disabled';
                        }
                        insert += '<div class="card" style="padding:10px; margin-bottom:10px;">'+
                        '<h4>Tanggal transaksi : ' + (tgl.getDate() + 1 < 10 ? '0' : '') + tgl.getDate()+'-'+(tgl.getMonth() + 1 < 10 ? '0' : '') + tgl.getMonth()+'-'+tgl.getFullYear()+
                        '</h4>'+
                        '<h6>Total : Rp. '+ hasil[i].total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") +'</h6>'+
                        batas+
                        '<h6>Status : '+ stat +'</h6>'+
                        '<div style="display:flex; flex-direction:row; padding-top:10px;">'+
                        '<a href="../../upload/bukti/'+hasil[i].id+'" class="btn btn-success mr-2 '+disabled+'"><i class="fa fa-file"></i> Upload bukti</a>'+
                        '<a class="btn btn-danger mr-2 '+disabled+'" href="../../batal/pesanan/'+hasil[i].id+'"><i class="fa fa-file"></i> Batalkan Transaksi</a>'+
                        '</div>'+
                        '</div>';
                    }
                    $('#'+param).html(insert);
                }else{
                    $('#'+param).html('Tidak ada data');
                }
            }
        });
    }
</script>
@endsection
