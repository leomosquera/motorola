{{-- List Widget 8 --}}

<div class="col-xl-8">
    <!--begin::Engage Widget 1-->
    <div class="card card-custom card-stretch gutter-b">
        <div class="card-body d-flex p-0">
            <div class="flex-grow-1 p-8 card-rounded bgi-no-repeat d-flex align-items-center" style="background-color: #FFF4DE; background-position: left bottom; background-size: auto 100%; background-image: url({{ asset('/media/svg/humans/custom-2.svg') }})">
                <div class="row w-100">
                    <div class="col-12 col-xl-3"></div>
                    <div class="col-12 col-xl-9">
                        <h4 class="text-danger font-weight-bolder">Administración de Usuarios</h4>
                        <p class="text-dark-50 my-5 font-size-xl font-weight-bold">Crear usuarios para que ingresen <br />a la app de infnityLife.</p>
                        <a href="{{ route('usuario-create') }}" class="btn btn-danger font-weight-bold py-2 px-6">Crear Usuario</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Engage Widget 1-->
</div>
<div class="col-xl-4">
    <!--begin::Engage Widget 2-->
    <div class="card card-custom card-stretch gutter-b">
        <div class="card-body d-flex p-0">
            <div class="flex-grow-1 bg-danger p-8 card-rounded flex-grow-1 bgi-no-repeat" style="background-position: calc(100% + 0.5rem) bottom; background-size: auto 70%; background-image: url({{ asset('/media/svg/humans/custom-3.svg') }})">
                <h4 class="text-inverse-danger mt-2 font-weight-bolder">Tips del día</h4>
                <p class="text-inverse-danger my-6">Enviar a tus usuarios el
                <br />del día que están esperando.</p>
                <a href="{{ route('tip') }}" class="btn btn-warning font-weight-bold py-2 px-6">Ingresar</a>
            </div>
        </div>
    </div>
    <!--end::Engage Widget 2-->
</div>
