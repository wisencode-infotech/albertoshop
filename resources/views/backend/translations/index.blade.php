@extends('backend.layouts.master')

@section('title') Translation @endsection

@section('content')

@component('backend.components.breadcrumb')
@slot('li_1') Translation @endslot
@slot('title') Translation @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm">
                        <div class="search-box me-2 d-inline-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" autocomplete="off" id="searchTableList" placeholder="Search...">
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>
                        <div class="search-box me-2 d-inline-block">
                            <div class="position-relative">
                               <select class="form-control" id="locale-select" style="padding-left: 15px;">
                                   <option value="">Select Locale</option>
                                   @foreach($locales as $locale)
                                   <option value="{{ $locale->code }}">{{ strtoupper($locale->code) }}</option>
                                   @endforeach
                               </select>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-sm-auto">
                        <div class="text-sm-end">
                            <a href="{{ route('backend.translation.create') }}" class="btn btn-success btn-rounded" id="addProject-btn"><i class="mdi mdi-plus me-1"></i> Add New</a>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
                <div class="">
                    <div class="table-responsive">
                        <table class="table project-list-table align-middle table-nowrap dt-responsive nowrap w-100 table-borderless" id="translations-table">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 60px">#</th>
                                    <th scope="col">locale</th>                                    
                                    <th scope="col">Key</th>
                                    <th scope="col">Value</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script src="{{ asset('assets/backend/js/datatable/translations.js') }}"></script>
@endsection