{{-- Extends layout --}}
@extends('layout.default')

{{-- Styles Section --}}
@section('styles')
@endsection

{{-- Content --}}
@section('content')

<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    @include('layout.partials.subheader._subheader-form')

    <form action="{{ route('usuario-store') }}" method="POST" data-action="save" data-id="" id="form-princ" enctype="multipart/form-data" novalidate>
        @csrf
        @include('pages/admin/usuario/form/store-update')
    </form>

</div>
<!--end::Content-->

@endsection

{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors scripts --}}
    {{-- page scripts --}}
    <script src="{{ asset('js/pages/my-global.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/admin/usuario/create-edit.js') }}"></script>
@endsection
