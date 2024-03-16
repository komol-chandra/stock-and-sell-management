@extends('layouts.backend.app')
@section('title','Order View')
@push('css')
@endpush
@section('content')
<div class="row">
    {{-- <h4 class="fw-bold py-3 mb-4">Product List</h4>--}}
    <div class="card">
        <div class="card-header">
            <h5 class="modal-title" id="exampleModalLabel1">Order Information</h5>
            <a href="{{route('admin.order-list')}}" class="btn btn-outline-primary">Back</a>
        </div>
        <div class="card-body">
            <div class="row g-2">
                <div class="col mb-0">
                    <label for="nameBasic" class="form-label">Data</label>
                    <input type="text" id="nameBasic" class="form-control" disabled value="{{$order->date}}">
                </div>
                <div class="col mb-0">
                    <label for="emailBasic" class="form-label">Invoice Id</label>
                    <input type="text" id="emailBasic" class="form-control" disabled value="{{$order->invoice_id}}">
                </div>
                <div class="col mb-0">
                    <label for="dobBasic" class="form-label">Customer</label>
                    <input type="text" id="dobBasic" class="form-control" disabled value="{{$order->customer_name}}">
                </div>

            </div>
            <div class="row mt-2 mb-2">
                <table class=" table">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Product</th>
                            <th>Branch</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($order->items as $key => $value)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $value->product->name }}</td>
                            <td>{{ $value->branch->name }}</td>
                            <td>{{ $value->qty }}</td>
                            <td>{{ $value->price }}</td>
                            <td>{{ $value->price * $value->qty }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="mb-3 col-md-6">
                    <label for="product_search" class="form-label">Note</label>
                    <p>{{$order->note??''}}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="grand_total" class="form-label">Grand Total </label>
                    <input class="form-control" type="number" id="grand_total" name="grand_total" disabled
                        value="{{$order->grand_total}}">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
