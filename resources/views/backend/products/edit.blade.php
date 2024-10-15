@extends('backend.layouts.master')

@section('title') Product @endsection

@section('content')

<style>
    input[switch]:checked+label:after {
        left: 58px;
    }
</style>

@component('backend.components.breadcrumb')
@slot('li_1') <a href="{{ route('backend.product.index') }}">Product</a> @endslot
@slot('title') Edit @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">

        <!-- Display validation errors -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('backend.product.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <!-- Product Info Section -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="header-title">Product Information</h4>
                                </div>
                                <div class="col-md-6 text-end">
                                    <a target="_blank" href="{{ route('frontend.product-detail', $product->slug) }}"><i class="fa fa-eye"></i> View Product</a>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $category->id == old('category_id', $product->category_id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter product name" value="{{ old('name', $product->name) }}">
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Slug Field (Auto-generated, Read-only) -->
                            <div class="form-group mb-3">
                                <label for="slug" class="form-label">Slug (Auto-generated)</label>
                                <input type="text" class="form-control" value="{{ $product->slug }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Short Description</label>
                                <input type="text" name="short_description" class="form-control @error('short_description') is-invalid @enderror" id="short_description" placeholder="Enter product short description" value="{{ old('short_description', $product->short_description) }}">
                                @error('short_description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="4">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="Enter product price" value="{{ old('price', $product->price) }}">
                                @error('price')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="unit" class="form-label">Unit</label>
                                <select name="unit_id" id="unit_id" class="form-select">
                                    <option value="">Select Unit</option>
                                    @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" data-can_have_variations="{{ $unit->can_have_variations }}" {{ $unit->id == old('unit_id', $product->unit_id) ? 'selected' : '' }}>{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                                @error('unit_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3" id="stock-container">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" id="stock" placeholder="Enter product stock" value="{{ old('stock', __productStock($product->id)) }}">
                                @error('stock')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Product Images -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Product Images</h4>

                            <div class="mb-3">
                                <label for="images" class="form-label">Upload Images</label>
                                <input type="file" name="images[]" class="form-control @error('images.*') is-invalid @enderror" id="images" multiple>
                                @error('images.*')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            @if($product->images->isNotEmpty())
                            <div class="row">

                                @foreach($product->images as $image)
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <button type="button" class="btn-close position-absolute top-0 end-0 p-2 remove_image" aria-label="Close" data-href="{{ route('backend.product.image.remove', $image) }}"></button>
                                                <img src="{{ $image->image_url }}" alt="Product Image" class="img-fluid" style="height:60px;">
                                            </div>
                                            <div class="card-footer bg-white">
                                                <div class="simple-switch text-center">
                                                    <input type="checkbox" id="square-switch{{ $image->id }}" class="make_primary_image" data-action="{{ route('backend.product.image.make-primary', $image) }}" switch="none" style="width: 80px;" {{ $image->is_primary == '1' ? 'checked' : '' }}>
                                                    <label for="square-switch{{ $image->id }}" data-on-label="Primary" data-off-label="Off" style="width: 80px;"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @endif

                            <div class="mb-3">
                                <label for="public_visibility" class="form-label">{{ __trans('Public Visibility') }}</label>
                                <select name="public_visibility" class="form-select @error('public_visibility') is-invalid @enderror">
                                    <option value="1" @if($product->public_visibility == 1) selected @endif>{{ __trans('Yes') }}</option>
                                    <option value="0" @if($product->public_visibility == 0) selected @endif>{{ __trans('No') }}</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Variations -->
            <div class="row">
                <div class="col-12" id="variations-section" style="display: none;">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Product Variations</h4>

                            <div id="variations-container">
                                @if($product->variations->isNotEmpty())
                                    @foreach($product->variations as $index => $variation)
                                        <div class="variation-row row mb-3">
                                            <!-- Hidden input for the variation ID -->
                                            <input type="hidden" name="variations[{{ $index }}][id]" value="{{ $variation->id }}">
                                            <div class="col-md-3">
                                                <label for="variation_name" class="form-label">Variation Name</label>
                                                <input type="text" name="variations[{{ $index }}][name]" class="form-control" placeholder="XL, RED, etc" value="{{ old('variations.' . $index . '.name', $variation->name) }}">
                                                @error('variations.' . $index . '.name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <label for="variation_price" class="form-label">Price</label>
                                                <input type="number" name="variations[{{ $index }}][price]" class="form-control" value="{{ old('variations.' . $index . '.price', $variation->price) }}">
                                                @error('variations.' . $index . '.price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <label for="variation_stock" class="form-label">Stock</label>
                                                <input type="number" name="variations[{{ $index }}][stock]" class="form-control" value="{{ old('variations.' . $index . '.stock', __productStock($product->id, $variation->id)) }}">
                                                @error('variations.' . $index . '.stock')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-1">
                                                <label style="visibility:hidden;" for="variation_remove" class="form-label">remove</label>
                                                <button type="button" class="btn btn-danger btn-remove-variation">Remove</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>


                            <button type="button" class="btn btn-secondary" id="add-variation">Add Another Variation</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-success btn-rounded">Update Product</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    var total_variations = '<?php echo $product->variations->isNotEmpty() ? $product->variations->count() : 0 ?>';
    let variationIndex = parseInt(total_variations) + 1;
    document.getElementById('add-variation').addEventListener('click', function () {
        const container = document.getElementById('variations-container');
        const variationRow = `
        <div class="variation-row row mb-3">
        <input type="hidden" name="variations[${variationIndex}][id]" value="">
        <div class="col-md-3">
        <label for="variation_name_${variationIndex}" class="form-label">Variation Name</label>
        <input type="text" name="variations[${variationIndex}][name]" class="form-control">
        </div>
        <div class="col-md-3">
        <label for="variation_price_${variationIndex}" class="form-label">Price</label>
        <input type="number" name="variations[${variationIndex}][price]" class="form-control">
        </div>
        <div class="col-md-2">
        <label for="variation_stock_${variationIndex}" class="form-label">stock</label>
        <input type="number" name="variations[${variationIndex}][stock]" class="form-control">
        </div>
        <div class="col-md-1">
        <label for="variation_price_${variationIndex}" class="form-label" style="visibility:hidden;">remove</label>
        <button type="button" class="btn btn-danger btn-remove-variation">Remove</button>
        </div>
        </div>
        `;
        container.insertAdjacentHTML('beforeend', variationRow);
        variationIndex++;
    });

    // Event listener for dynamically removing a variation row
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('btn-remove-variation')) {
            e.target.closest('.variation-row').remove();
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const unitSelect = document.getElementById('unit_id');
        const mainStockContainer = document.getElementById('stock-container');
        const variationsSection = document.getElementById('variations-section');

        function toggleVariationsSection() {
            // Get the selected option
            const selectedOption = unitSelect.options[unitSelect.selectedIndex];

            // Check the data-can_have_variations attribute of the selected option
            const canHaveVariations = selectedOption.getAttribute('data-can_have_variations') == 1;

            // Show or hide the variations section based on the attribute
            if (canHaveVariations) {
                variationsSection.style.display = 'block';
                mainStockContainer.style.display = 'none';
            } else {
                variationsSection.style.display = 'none';
                mainStockContainer.style.display = 'block';
            }
        }

        // Show/hide variations on page load
        toggleVariationsSection();

        // Listen for change events on the select element
        unitSelect.addEventListener('change', function () {
            toggleVariationsSection();
        });
    });

    $(document).on('click', '.remove_image', function(e) {
        e.preventDefault();

        var url = $(this).data('href');
        var imageElement = $(this).closest('.col-md-3');

        // Ask for confirmation
        if (confirm('Are you sure you want to remove this image?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // On success, remove the image element from the DOM
                    if(response.success) {
                        imageElement.remove();
                    } else {
                        alert('Something went wrong. Please try again.');
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Error removing image.');
                }
            });
        }
    });

    $('.make_primary_image').on('click', function() {
        var obj = $(this);
        $.ajax({
            url: $(this).data('action'),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('.make_primary_image').prop('checked', false);
                $(obj).prop('checked', true);
                toastr.success(response.message)
            },
            error: function(xhr) {
            }
        });
    });

</script>
@endsection