<br><br>
<div class="card mb-4">
    <div class="card-header">
        Edit Produk
    </div>
    <br><br>
        <div class="card-body" style="background: #cccabb">
            <form action="/courier/{{$products->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PUT')}}
                            <div class="panel panel-body">
                                <label class="col-sm-3 col-form-label">Product</label>
                                <div class="col-sm-9">
                                    <input name="product_name" type="text" class="form-control" value="{{$products->product_name}}">
                                </div>
                            </div>
                            <div class="panel panel-body">
                                <div class="row">
                                    <label class="col-md-1">Category</label>
                                    <div class="col-md-11">
                                        <select  multiple name="category_id[]" class="form-control select2" id="category_id">                    
                                            @foreach ($daftar_category as $list_category)
                                                <option selected value="{{ $list_category->id }}">{{ $list_category->category_name }}</option>  
                                            @endforeach
                                            
                                            @foreach($categoryproduct as $kategori)
                                                <option value="{{ $kategori->id }}">{{ $kategori->category_name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="panel-body">
                                <label class="col-sm-3 col-form-label">Description</label>
                                <div class="col-sm-9">
                                    <input name="description" type="textArea" class="form-control" value="{{$products->description}}><span class="error text-danger"><p id="jenis_error"></p></span>
                                </div>
                            </div>
                            <div class="panel-body">
                                <label class="col-sm-3 col-form-label">Price</label>
                                <div class="col-sm-9">
                                    <input name="price" type="text" class="form-control" value="{{$products->price}}">
                                </div>
                            </div>
                            <div class="panel-body">
                                <label class="col-sm-3 col-form-label">Stock</label>
                                <div class="col-sm-9">
                                    <input name="stock" type="text" class="form-control" value="{{$products->stock}}">
                                </div>
                            </div>
                            <div class="panel-body">
                                <label class="col-sm-3 col-form-label">Weight</label>
                                <div class="col-sm-9">
                                    <input name="weight" type="text" class="form-control" value="{{$products->weight}}">
                                </div>
                            </div>
                            <div class="panel-body">
                                <label class="col-sm-3 col-form-label">Photo</label>
                                <div class="col-sm-9">
                                
                                @foreach ($daftar_gambar as $list_gambar)
                                    <img width="100px" src="{{asset('product_image/'.$list_gambar->image_name)}}">
                                @endforeach
                                <br>
                                <input multiple type="file" class="form-control " name="insert_photo[]">

                                </div>
                            </div>
                        
                <br>
            </form>
        </div>
    </div>