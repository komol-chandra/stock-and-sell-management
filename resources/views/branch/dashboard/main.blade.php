@extends('layouts.backend.app')
@section('title','Backend Home')
@push('css')
@endpush
@section('content')
<div class="row">
    <div class="col-lg-8 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Congratulations {{auth()->user()->name}}! 🎉</h5>
                        <p class="mb-4">
                            Count Product:{{$products}}
                        </p>
                        <p class="mb-4">
                            Count Order Item:{{$purchases}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection