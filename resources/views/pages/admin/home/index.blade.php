{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

    {{-- Dashboard 1 --}}

    <div class="row">

        <div class="col-12 order-0">
            @include('pages.widgets._widget-10', ['class' => 'card-stretch gutter-b'])
        </div>

        <div class="col-12 col-xl-4">
            @include('pages.widgets._widget-3')
        </div>

        <div class="col-12 col-xl-4">
            @include('pages.widgets._widget-5')
        </div>

        <div class="col-12 col-xl-4">
            @include('pages.widgets._widget-4')
        </div>

        <div class="col-12 col-xl-4">
            <div class="card card-custom gutter-b" style="height: 150px">
                <!--begin::Body-->
                <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
                    <div class="mr-2">
                        <h3 class="font-weight-bolder">Automólives</h3>
                        <div class="text-dark-50 font-size-lg mt-2">{{ App\Models\InspectionCar::where('id', '>', 0)->count() }} inspecciones realizadas</div>
                    </div>
                    <a href="{{ route('inspection-car') }}" class="btn btn-custom font-weight-bold py-3 px-6">Acceder</a>
                </div>
                <!--end::Body-->
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card card-custom gutter-b" style="height: 150px">
                <!--begin::Body-->
                <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
                    <div class="mr-2">
                        <h3 class="font-weight-bolder">Embarcaciones</h3>
                        <div class="text-dark-50 font-size-lg mt-2">{{ App\Models\InspectionBoat::where('id', '>', 0)->count() }} inspecciones realizadas</div>
                    </div>
                    <a href="javascript:;" class="btn btn-primary font-weight-bold py-3 px-6">Acceder</a>
                </div>
                <!--end::Body-->
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="card card-custom gutter-b" style="height: 150px">
                <!--begin::Body-->
                <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
                    <div class="mr-2">
                        <h3 class="font-weight-bolder">Siniestros</h3>
                        <div class="text-dark-50 font-size-lg mt-2">{{ App\Models\SinisterCar::where('id', '>', 0)->count() }} inspecciones realizadas</div>
                    </div>
                    <a href="javascript:;" class="btn btn-danger font-weight-bold py-3 px-6">Acceder</a>
                </div>
                <!--end::Body-->
            </div>
        </div>

    </div>

@endsection

{{-- Scripts Section --}}
@section('scripts')
    <script src="{{ asset('js/pages/my-global.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
@endsection
