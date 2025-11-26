{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles Section --}}
@section('styles')
@endsection

{{-- Content --}}
@section('content')

<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    @include('layout.partials.subheader._subheader-v0')

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b">
                        @php
                        $limit = 12;
                        @endphp
                        <!--begin::Header-->
                        <div class="card-header h-auto">
                            <!--begin::Title-->
                            <div class="card-title py-5">
                                <h3 class="card-label">Últimos {{ $limit }} meses</h3>
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                        <div class="card-body">
                            <!--begin::Chart-->
                            <div id="chart_1" data-route="{{ route('inspection-boat-chart-line-month') }}" data-info="{{ $limit }}"></div>
                            <!--end::Chart-->
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
                <div class="col-lg-6">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Comparación últimos 2 meses</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin::Chart-->
                            <div id="chart_2" data-route="{{ route('inspection-boat-chart-line-month-compare') }}" data-info="{{ $limit }}"></div>
                            <!--end::Chart-->
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @php
                    $limit = 12;
                    @endphp
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Últimos {{ $limit }} meses</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin::Chart-->
                            <div id="chart_3" data-route="{{ route('inspection-boat-chart-bar-month-compare') }}" data-info="{{ $limit }}"></div>
                            <!--end::Chart-->
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->

@endsection

{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors scripts --}}
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    {{-- page scripts --}}
    <script src="{{ asset('js/pages/my-global.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/my-dttables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/admin/inspection-boat/charts.js') }}"></script>
@endsection
