@extends('layouts.admin-app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			@if(Session::has('success'))
			<div class="alert alert-success">{{Session::get('success')}}</div>
			@endif
			<div class="card">
				<div class="card-header"><h4>Reviews</h4></div>
				<div class="card-body">
					<table id="example" class="table table-bordered table-hover " style="width:100%">
						<thead>
							<tr>
								<th class="text-center">No</th>
								<th class="text-center">Product</th>
								<th class="text-center">User</th>
								<th class="text-center">Rating</th>
								<th class="text-center">Konten</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@forelse ($reviews as $products)
							<tr style="text-align: center;">
								<td>{{$loop->iteration }}</td>
								<td>{{$products->product_name}}</td>
								<td>{{$products->name}}</td>
								<td>{{$products->rate}}</td>
								<td>{{$products->content}}</td>
								<td>
									<button class="btn btn-success" data-toggle="modal" data-target="#modalulasan{{$products->id}}">Beri Tanggapan</button>
									<div class="modal fade" id="modalulasan{{$products->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Beri Tanggapan</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form style="text-align: left;" method="post" action="/beri/tanggapan">
													@csrf
													<input type="hidden" name="id" value="{{$products->id}}">
													<div class="modal-body">
														<div class="form-group">
															<label>Tanggapan</label>
															<textarea name="tanggapan" class="form-control">
																Beri tanggapan
															</textarea>
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
