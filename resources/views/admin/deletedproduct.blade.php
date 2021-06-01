@extends('layouts.admin-app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header"><h4>Deleted Product</h4></div>
				<div class="card-body">
					<table id="example" class="table  table-bordered table-hover " style="width:100%">
						<thead>
							<tr>
								<th>No</th>
								<th>Product</th>
								<th class="text-center">Kategori</th>
								<th class="text-center">Harga</th>
								<th class="text-center">Deskripsi</th>
								<th class="text-center">Stok</th>
								<th class="text-center">Berat</th>
								<th class="text-center">Rate Produk</th>
								<th class="text-center">Image</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($products as $products)
							<tr>
								<td>{{$loop->iteration }}</td>
								<td>{{$products->product_name}}</td>

								<td class="text-center">
									@foreach ($products->RelasiCategory as $productCategory)
									{{$productCategory->category_name}}
									@endforeach
								</td>

								<td>{{$products->price}}</td>
								<td>{{$products->description}}</td>
								<td>{{$products->stock}}</td>
								<td>{{$products->weight}} gram</td>
								<td>{{$products->product_rate}}</td>
								<td class="text-center"> 
									@foreach ($products->RelasiImage as $productImage)
									<img width="100px" src="{{asset('product_images/'.$productImage->image_name)}}">
									@endforeach
								</td>
								<td style="display: flex; flex-direction: row;">
									<a href="{{ route('balikan.produk', ['id' => $products->id]) }}" class="btn btn-success" onclick="return confirm('Yakin kembalikan produk ? ')">Kembalikan</a>
									<a href="{{ route('hapus.produk.permanen', ['id' => $products->id]) }}" class="btn btn-danger" onclick="return confirm('Yakin hapus produk secara permanen ? ')">Hapus</a>
								</td>
							</tr>
							@empty
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
		</div>
	</div>
</div>
<script type="text/javascript">
</script>
@endsection
