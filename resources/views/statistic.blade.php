@extends('layouts.admin-app')
<!DOCTYPE html>
<html>
@section('head')
    <title>Report</title>
@endsection

 @section('content')  
<body>
<h1 class="text-center">Report Transaksi Toko</h1>
<div id="container"></div>
<div class='row'>
    
    <div class="col-md-4 col-sm-12 mb-6">   
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mt-2">Transaksi Harian</h5>
                <h6 class="card-subtitle mb-2 textmuted">Transaksi hari ini</h6>
                <br>
                <h2 class="card-text">Rp. {{round($perbulan,2)}},-</h2>
       
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 mb-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mt-2">Transaksi Tahunan</h5>
                <h6 class="card-subtitle mb-2 textmuted">Tahun {{$date->year}}</h6>
                <br>
                <h2 class="card-text">Rp. {{round($datatahunan3,2)}},-
                </h2>
                <h6 class="card-text">({{$year->count}} Penjualan tahun ini)</h6>
            </div>
        </div>
    </div>    
    <div class="col-md-4 col-sm-12 mb-6">   
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mt-2">Transaksi Bulanan</h5>
                <h6 class="card-subtitle mb-2 textmuted">Bulan ke-{{$date->month}}</h6>
                <br>
                <h2 class="card-text">Rp. {{round($datapenghasilan3,2)}},-</h2>
               
            </div>
        </div>
    </div>
    
</div> 
 
</body>
  
<script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
    var transactions =  <?php echo json_encode($transactions) ?>;
   
    Highcharts.chart('container', {
        title: {
            text: 'Transaksi, 2021'
        },
        subtitle: {
            text: 'Data Transaksi'
        },
         xAxis: {
            categories: ['May', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Jumlah Transaksi'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                allowPointSelect: true
            }
        },
        series: [{
            name: 'Transaksi',
            data: transactions
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 200
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
});
</script>
</html>
@endsection