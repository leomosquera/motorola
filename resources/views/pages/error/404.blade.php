{{-- Extends layout --}}
@extends('layout.default')

{{-- Page Title --}}
@section('title', '404')

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('css/pages/error/error-3.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Content --}}
@section('content')
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Error-->
        <div class="error error-3 d-flex flex-row-fluid bgi-size-cover bgi-position-center" style="background-image: url({{ asset('media/error/bg3.jpg') }}">
            <!--begin::Content-->
            <div class="px-10 px-md-30 py-10 py-md-0 d-flex flex-column justify-content-md-center">
                <h1 class="error-title text-stroke text-transparent"><img src="{{ asset('media/logos/logo.svg') }}" class="max-h-100px" alt="" />  404</h1>
                <p class="display-4 font-weight-boldest text-white mb-12">¿Cómo has llegado hasta aquí?</p>
                <p class="font-size-h1 font-weight-boldest text-dark-75">No podemos encontrar la página que está buscando.</p>
                <p class="font-size-h4 line-height-md">Es posible que su usario no tenga permisos para ingresar a esta página o la misma ya no exista.</p>
                <a href="{{ route('home') }}" class="btn btn-custom font-weight-bolder font-size-h6 px-8 py-4 max-w-200px">Regresar al inicio</a>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Error-->
    </div>
    <!--end::Main-->
@endsection

{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

    {{-- page scripts --}}
    <script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
@endsection
