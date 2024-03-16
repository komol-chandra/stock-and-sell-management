@extends('layouts.backend.app')
@section('title','Create Purchase')
@push('css')
@endpush
@section('content')
<div class="row" id="app">
    <create-purchase :suppliers='{{$suppliers}}' :brunches='{{$brunches}}'></create-purchase>
</div>
@endsection