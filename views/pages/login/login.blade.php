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
                        <!--begin::Form-->
                        <form method="POST" action="{{ route('login-post') }}" id="form" class="form">
                            @csrf
                            <!--begin::Title-->
                            <div class="pb-13 pt-lg-0 pt-5">
                                <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Bienvenidos a {{ Config::get('app.name') }}</h3>
                                <span class="text-muted font-weight-bold font-size-h4">Posee un Usuario?
                                <a href="javascript:;" id="kt_login_signup" class="text-custom font-weight-bolder">Crear uno Aquí</a></span>
                            </div>
                            <!--begin::Title-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">Usuario</label>
                                <input id="username" type="text" class="form-control form-control-solid h-auto py-6 px-6 rounded-lg @error('username') is-invalid @enderror" name="username" placeholder="Usuario" value="{{ old('username') }}"  autocomplete="off" autofocus>
                                @error('username')
                                    <div class="invalid-feedback">El usuario ingresado es incorrecto.</div>
                                @enderror
                            </div>
                            <!--end::Form group-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <div class="d-flex justify-content-between mt-n5">
                                    <label class="font-size-h6 font-weight-bolder text-dark pt-5">Contraseña</label>
                                    <a href="javascript:;" class="text-custom font-size-h6 font-weight-bolder text-hover-primary pt-5" id="kt_login_forgot">Olvidó su Contraseña ?</a>
                                </div>
                                <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="password" name="password" placeholder="Contraseña" autocomplete="off" />
                            </div>
                            <!--end::Form group-->
                            <!--begin::Action-->
                            <div class="pb-lg-0 pb-5">
                                <button type="submit" class="btn btn-custom font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3" name="submitButton">Ingresar</button>
                            </div>
                            <!--end::Action-->
                        </form>
                        <!--end::Form-->
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
