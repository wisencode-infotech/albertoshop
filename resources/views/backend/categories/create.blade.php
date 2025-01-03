@extends('backend.layouts.master')

@section('title') Category @endsection

@section('content')

@component('backend.components.breadcrumb')
@slot('li_1') Category @endslot
@slot('title') Create @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">{{ __('Create New Category') }}</div>

            <div class="card-body">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('backend.category.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Name Field -->
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3 form-group">
                        <label for="parent_id" class="form-label">Parent Category</label>
                        <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                            <option value="">Select Parent Category</option>
                            @foreach($parent_categories as $parent_category_id => $parent_category_name)
                                <option value="{{ $parent_category_id }}" {{ old('parent_id') == $parent_category_id ? 'selected' : '' }}>
                                    {{ $parent_category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- description Field -->
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Category Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}"></textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Image Field -->
                    <div class="form-group mb-3">
                        <label for="image" class="form-label">Category Image</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="order" class="form-label">Sorting Order</label>
                        <input type="text" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}" required>
                        @error('order')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-success btn-rounded">Create Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
@endsection