<br><br>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-pencil-alt mr-1"></i>
        Edit Kategori
    </div>
    <br><br>
    <div class="card-body" style="background: #cccabb">
        <form action="/kategori/{{$categories->id}}" method="POST" enctype="multipart/form-data">
            @csrf
            {{method_field('PUT')}}
            <div class="form-group row">
                <label class="col-sm-6 col-form-label">Kategori</label>
                <div class="col-sm-8">
                    <input name="category_name" type="text" id="categories" class="form-control" value="{{$categories->category_name}}" placeholder="category_name">
                </div>
            </div>
            <br>
        </form>
    </div>
</div>

