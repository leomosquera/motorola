{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles Section --}}
@section('styles')
<link href="{{ asset('plugins/custom/cropper/cropper.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Content --}}
@section('content')

<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    @include('layout.partials.subheader._subheader-form')

    @include('pages/admin/inspection-car/gnc/form/store-update')

</div>
<!--end::Content-->

@endsection

{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors scripts --}}
    <script src="{{ asset('plugins/custom/cropper/cropper.bundle.js') }}"></script>
    {{-- page scripts --}}
    <script src="{{ asset('js/pages/my-global.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/admin/inspection-car/gnc/image-replace.js') }}"></script>
@endsection
