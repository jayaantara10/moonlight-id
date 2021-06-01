<br><br>
<div class="card mb-4">
    <div class="card-header">
        Edit Discount
    </div>
    <br><br>
        <div class="card-body" style="background: #cccabb">
            <form action="/discount/{{$discount->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PUT')}}
                    <div class="form-group row">
                        <label class="col-sm-6 col-form-label">Discount</label>
                        <div class="col-sm-8">
                            <input name="courier" type="text" id="couriers" class="form-control" value="{{$couriers->courier}}" placeholder="courier">
                        </div>
                    </div>
                <br>
            </form>
        </div>
    </div>
