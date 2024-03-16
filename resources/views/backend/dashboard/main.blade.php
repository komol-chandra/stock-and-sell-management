@extends('layouts.backend.app')
@section('title','Backend Home')
@push('css')
@endpush
@section('content')
<div class="row">
    <div class="col-md-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Congratulations {{auth()->user()->name}}! 🎉</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 ">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title "> Product Count</h5>
                        <h6 class="card-title ">{{$report['product_count']}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 ">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title "> Purchases Count</h5>
                        <h6 class="card-title ">{{$report['purchases_count']}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 ">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title "> User Count</h5>
                        <h6 class="card-title ">{{$report['user_count']}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 ">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title "> Branch Count</h5>
                        <h6 class="card-title ">{{$report['branch_count']}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 ">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title "> Brand Count</h5>
                        <h6 class="card-title ">{{$report['brand_count']}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 ">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title "> Category Count</h5>
                        <h6 class="card-title ">{{$report['category_count']}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 ">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title "> Supplier Count</h5>
                        <h6 class="card-title ">{{$report['supplier_count']}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 ">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title "> Order Count</h5>
                        <h6 class="card-title ">{{$report['order_count']}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 ">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title "> Purchase Count</h5>
                        <h6 class="card-title ">{{$report['purchase_count']}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 ">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title "> Total order Amount</h5>
                        <h6 class="card-title ">{{$report['total_order_amount']}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4 ">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title "> Total Purchase Amount</h5>
                        <h6 class="card-title ">{{$report['total_purchase_amount']}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4 ">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title "> Total Profit Amount</h5>
                        <h6 class="card-title ">{{$report['total_profit_amount']}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
