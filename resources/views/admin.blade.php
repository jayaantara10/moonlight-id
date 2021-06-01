@extends('layouts.admin-app')

@section('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.1/dist/chart.min.js"></script>
<style>
</style>
@endsection

@section('content')

            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>
                <div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ubah Status</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('ubah.status.trans') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" id="id" name="id">
                                    <select class="form-control" name="status">
                                        <option value="unverified" >Unverivied</option>
                                        <option value="verified" >Verivied</option>
                                        <option value="delivered" >Delivered</option>
                                        <option value="success" >Success</option>
                                        <option value="expired" >Expired</option>
                                        <option value="canceled" >Canceled</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6>Jenis transaksi</h6>   
                    <div class="form-group">
                        <select class="form-control" onchange="gettrans(this.value)">
                            <option value="">--Select Here--</option>
                            <option value="unverified">unverified</option>
                            <option value="verified">verified</option>
                            <option value="delivered">delivered</option>
                            <option value="success">success</option>
                            <option value="expired">expired</option>
                            <option value="canceled">canceled</option>
                        </select>
                    </div>

                    <a href="print" class="btn btn-primary" target="_blank">CETAK PDF</a>

                    <table class="table table-striped mt-3">
                        <thead style="text-align: center;">
                            <th>No</th>
                            <th>Sub Total</th>
                            <th>Ongkir</th>
                            <th>Total</th>
                            <th>Kurir</th>
                            <th>Bukti</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="show">
                            @foreach($trans as $t)
                            <tr style="text-align: center;">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$t->sub_total}}</td>
                                <td>{{$t->shipping_cost}}</td>
                                <td>{{$t->total}}</td>
                                <td>{{$t->courier}}</td>
                                <td><center><a href="{{asset('bukti/'.$t->proof_of_payment)}}" target="_blank"><img width="100px" src="{{asset('bukti/'.$t->proof_of_payment)}}" /></a></center></td>
                                <td>{{$t->status}}</td>
                                <td>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#modalstatus{{$t->id}}">{{$t->status}}</button>
                                    <div class="modal fade" id="modalstatus{{$t->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ubah Status</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('ubah.status.trans') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="{{$t->id}}">
                                                        <select class="form-control" name="status">
                                                            <option value="unverified">Unverivied</option>
                                                            <option value="verified">Verivied</option>
                                                            <option value="delivered">Delivered</option>
                                                            <option value="success">Success</option>
                                                            <option value="expired">Expired</option>
                                                            <option value="canceled">Canceled</option>
                                                        </select>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  -->
@endsection
