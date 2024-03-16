@extends('layouts.backend.app')
@section('title','Create Product')
@push('css')
@endpush
@section('content')
<div class="row">
    {{-- <h4 class="fw-bold py-3 mb-4">Create Product</h4>--}}
    <div class="card mb-4">
        <h5 class="card-header">Create Product</h5>
        <!-- Account -->

        <div class="card-body">
            <form id="formAccountSettings" method="POST" action="{{route('admin.product.store')}}"
                enctype="multipart/form-data">@csrf
                <div class="row mt-2 mb-2">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{asset('uploads/no-img.png')}}" alt="user-avatar" class="d-block rounded"
                            height="100" width="100" id="uploadedAvatar">
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Upload new photo</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" name="image" class="account-file-input" hidden=""
                                    accept="image/png, image/jpeg">
                            </label>
                            <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                <i class="bx bx-reset d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                            </button>
                            <p class="text-muted mb-0">Allowed JPG or PNG. Max size of 1024 kilobytes</p>
                            @error('image')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <hr class="my-0">
                <div class="row mt-2 mb-2">
                    <div class="mb-3 col-md-12">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span> </label>
                        <input class="form-control" type="text" id="name" name="name" value="{{old('name')}}"
                            autofocus="">
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select id="category_id" name="category_id" class="select2 form-select">
                            <option disabled>Select One</option>
                            @foreach ($formData['categories'] as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="brand_id" class="form-label">Brand <span class="text-danger">*</span></label>
                        <select id="brand_id" name="brand_id" class="select2 form-select">
                            <option disabled>Select One</option>
                            @foreach ($formData['brands'] as $brand)
                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="unit_id" class="form-label">Unit <span class="text-danger">*</span></label>
                        <select id="unit_id" name="unit_id" class="select2 form-select">
                            <option disabled>Select One</option>
                            @foreach ($formData['units'] as $unit)
                            <option value="{{$unit->id}}">{{$unit->name}}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="is_active" class="form-label">Status <span class="text-danger">*</span></label>
                        <select id="is_active" name="is_active" class="select2 form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('is_active')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="short_description" class="form-label">Short Description</label>
                        <input class="form-control" type="text" id="short_description" name="short_description"
                            value="{{old('short_description')}}" placeholder="enter product short description">
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" type="text" id="description" name="description"
                            placeholder="enter product full description"></textarea>
                    </div>

                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary me-2">Save changes</button>
                    <a href="{{route('admin.product.index')}}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /Account -->
    </div>
</div>
@endsection
@push('js')
<script src="{{asset('backend_assets/js/pages-account-settings-account.js')}}"></script>
@endpush