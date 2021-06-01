<!DOCTYPE html>
<html>
<head>
	<title>Laporan PDF</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>Laporan Transaksi Toko</h5>
	</center>
 
	<!--------------------------------------- DATA TABLE--------------------------------------------- -->
    <table id="example" class="table  table-bordered table-hover " style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th class="text-center">Tanggal</th> 
                    <th class="text-center">Alamat</th>
                    <th class="text-center">Kabupaten</th>
                    <th class="text-center">Provinsi</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Ongkir</th>
                    <th class="text-center">Subtotal</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transactions)
                <tr>
                    <td>{{$loop->iteration }}</td>
                    <td>{{$transactions->created_at}}</td>
                    <td>{{$transactions->address}}</td>
                    <td>{{$transactions->regency}}</td>
                    <td>{{$transactions->province}}</td>
                    <td>{{$transactions->total}}</td>
                    <td>{{$transactions->shipping_cost}}</td>
                    <td>{{$transactions->sub_total}}</td>
                    <td>{{$transactions->status}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
 
</body>
</html>