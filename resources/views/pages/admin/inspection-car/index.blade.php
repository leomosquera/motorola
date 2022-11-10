{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
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
            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <span class="icomoon-car text-custom"></span>
                        </span>
                    <h3 class="card-label">Lista de Automóviles</h3>
                    </div>
                    <div class="card-toolbar">
                    <a href="javascript:;" class="btn btn-custom font-weight-bolder">
                            <i class="la la-plus"></i>Nueva Inspección
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-hover table-head-custom table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
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
    <script src="{{ asset('js/pages/admin/inspection-car/ajax-index.js') }}"></script>
@endsection
