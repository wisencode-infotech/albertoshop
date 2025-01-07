@extends('backend.layouts.master')

@section('title') Coupon @endsection

@section('content')

@component('backend.components.breadcrumb')
@slot('li_1') <a href="{{ route('backend.coupon.index') }}">Coupon</a> @endslot
@slot('title') Edit @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">{{ __('Edit Coupon') }}</div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('backend.coupon.update', $coupon) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Code Field -->
                    <div class="form-group mb-3">
                        <label for="code" class="form-label">Coupon Code</label>
                        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $coupon->code) }}" required>
                        @error('code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Discount Value Field -->
                    <div class="form-group mb-3">
                        <label for="discount_value" class="form-label">Discount Value</label>
                        <input type="text" name="discount_value" class="form-control @error('discount_value') is-invalid @enderror" value="{{ old('discount_value', $coupon->discount_value) }}" required>
                        @error('discount_value')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Valid From Field -->
                    <div class="form-group mb-3">
                        <label for="valid_from" class="form-label">Valid From</label>
                        <input type="date" name="valid_from" class="datepicker form-control @error('valid_from') is-invalid @enderror" value="{{ old('valid_until', $coupon->valid_from ? \Carbon\Carbon::parse($coupon->valid_from)->format('Y-m-d') : '') }}" required>
                        @error('valid_from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Valid Until Field -->
                    <div class="form-group mb-3">
                        <label for="valid_until" class="form-label">Valid Until</label>
                        <input type="date" name="valid_until" class="datepicker form-control @error('valid_until') is-invalid @enderror" value="{{ old('valid_until', $coupon->valid_until ? \Carbon\Carbon::parse($coupon->valid_until)->format('Y-m-d') : '') }}" required>
                        @error('valid_until')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Usage Limit Field -->
                    <div class="form-group mb-3">
                        <label for="usage_limit" class="form-label">Usage Limit</label>
                        <input type="number" name="usage_limit" class="form-control @error('usage_limit') is-invalid @enderror" value="{{ old('usage_limit', $coupon->usage_limit) }}" required>
                        @error('usage_limit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Discount Type Field -->
                    <div class="form-group mb-3">
                        <label for="discount_type" class="form-label">Discount Type</label>
                        <select name="discount_type" class="form-select @error('discount_type') is-invalid @enderror">
                            <option value="percentage" {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                            <option value="flat" {{ old('discount_type', $coupon->discount_type) == 'flat' ? 'selected' : '' }}>Flat</option>
                        </select>
                        @error('discount_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-primary btn-rounded">Update Coupon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script src="{{ URL::asset('assets/backend/libs/datepicker/datepicker.min.js')}}"></script>

<script>
    $(document).ready(function () {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd', // Date format
            autoclose: true,      // Close calendar when date is selected
            todayHighlight: true  // Highlight today's date
        });
    });
</script>
@endsection
