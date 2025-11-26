{{-- List Widget 8 --}}

<div class="card card-custom {{ @$class }}">
    <div class="card-body rounded p-0 d-flex bg-light">
        <div class="d-flex flex-column flex-lg-row-auto w-auto w-lg-350px w-xl-450px w-xxl-850px py-10 py-md-14 px-10 px-md-20 pr-lg-0">
            <h1 class="font-weight-bolder text-dark mb-0">Buscador de Inspecciones / Siniestros</h1>
            <div class="font-size-h4 mb-8">Ingrese su búsqueda según la opción elegida</div>
            <!--begin::Form-->
            <form action="{{ route('inspection-car') }}" class="d-flex flex-center py-2 px-6 bg-white rounded">
                <span class="svg-icon svg-icon-lg svg-icon-primary">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                            <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
                <input type="text" name="search" class="form-control border-0 font-weight-bold pl-2" placeholder="Buscar por Patente" />
                <span class="svg-icon svg-icon-lg svg-icon-primary">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"/>
                            <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999) "/>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
                <select name='search_type' class="form-control border-0 font-weight-bold pl-2 col-lg-4">
                    <option value="AUTOS" data-redirect="{{ route('inspection-car') }}">AUTOS</option>
                    <option value="EMBARCACIONES" data-redirect="{{ route('inspection-boat') }}">EMBARCACIONES</option>
                    <option value="SINIESTROS" data-redirect="{{ route('sinister-car') }}">SINIESTROS</option>
                </select>
            </form>
            <!--end::Form-->
        </div>
        <div class="d-none d-md-flex flex-row-fluid bgi-no-repeat bgi-position-y-top bgi-position-x-center" style="background-image: url({{ asset('media/svg/illustrations/copy.svg') }}"></div>
    </div>
</div>
