{{-- Extends layout --}}
@extends('layout.default')

{{-- Page Title --}}
@section('title', 'Login')

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('css/pages/login/login-1.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Content --}}
@section('content')
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
            <!--begin::Aside-->
            <div class="login-aside d-flex flex-column flex-row-auto bg-custom">
                <!--begin::Aside Top-->
                <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                    <!--begin::Aside header-->
                    <a href="javascript:;" class="text-center mb-10">
                        <img src="{{ asset('media/logos/logo.svg') }}" class="max-h-100px" alt="" />
                    </a>
                    <!--end::Aside header-->
                    <!--begin::Aside title-->
                    <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg text-white">Bienvenidos</h3>
                    <h4 class="font-weight-bolder text-center font-size-h6 font-size-h3-lg text-white">Administración - {{ Config::get('app.version') }}</h4>
                    <!--end::Aside title-->
                </div>
                <!--end::Aside Top-->
                <!--begin::Aside Bottom-->
                <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url({{ asset('media/svg/illustrations/login-visual-2.svg') }})"></div>
                <!--end::Aside Bottom-->
            </div>
            <!--begin::Aside-->
            <!--begin::Content-->
            <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
                <!--begin::Content body-->
                <div class="d-flex flex-column-fluid flex-center">
                    <!--begin::Signin-->
                    <div class="login-form login-signin">
                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-danger font-size-h4 font-size-h1-lg">¡Se encontró un error!</h3>
                            <span class="text-muted font-weight-bold font-size-h4">Usuario sin permiso de acceso. Comuníquese
                            <strong class="text-custom font-weight-bolder">con un Administrador</strong></span>
                        </div>
                        <!--end::Title-->
                        <div>
                            <form id="logout-form" action="{{route('login-logout')}}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Volver al inicio</button>
                            </form>
                        </div>
                    </div>
                    <!--end::Signin-->
                </div>
                <!--end::Content body-->
                <!--begin::Content footer-->
                <div class="d-flex justify-content-lg-start justify-content-center align-items-end py-7 py-lg-0">
						<div class="text-dark-50 font-size-lg font-weight-bolder mr-10">
                            <span class="mr-1">{{ date('Y')}} © {{ Config::get('app.name') }} - Administrator</span>
						</div>
					</div>
                <!--end::Content footer-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Login-->
    </div>
@endsection

{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    {{-- page scripts --}}
    <script src="{{ asset('js/pages/login/login.js') }}" type="text/javascript"></script>
@endsection
