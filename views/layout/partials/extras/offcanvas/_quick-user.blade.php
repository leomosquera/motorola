@php
	$direction = config('layout.extras.user.offcanvas.direction', 'right');
@endphp
 {{-- User Panel --}}
<div id="kt_quick_user" class="offcanvas offcanvas-{{ $direction }} p-10">
	{{-- Header --}}
	<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
		<h3 class="font-weight-bold m-0">
			Usuario
			<small class="text-muted font-size-sm ml-2">12 mensajes</small>
		</h3>
		<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
			<i class="ki ki-close icon-xs text-muted"></i>
		</a>
	</div>

	{{-- Content --}}
    <div class="offcanvas-content pr-5 mr-n5">
		{{-- Header --}}
        <div class="d-flex align-items-center mt-5">
            <div class="symbol symbol-100 mr-5">
                <div class="symbol-label" style="background-image:url('{{ URL::to('/').Storage::url(Config::get('models.usuario.avatar.dir')).Session::get('avatar') }}')"></div>
				<i class="symbol-badge bg-success"></i>
            </div>
            <div class="d-flex flex-column">
                <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">
					{{  Auth::user()->name.' '.Auth::user()->lastname }}
				</a>
                <div class="text-muted mt-1">
                    {{ Session::get('role_name') }}
                </div>
                <div class="navi mt-2">
                    <a href="#" class="navi-item">
                        <span class="navi-link p-0 pb-2">
                            <span class="navi-icon mr-1">
								{{ Metronic::getSVG("media/svg/icons/Communication/Mail-notification.svg", "svg-icon-lg svg-icon-custom") }}
							</span>
                            <span class="navi-text text-muted text-hover-primary">{{ Auth::user()->email }}</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>

		{{-- Separator --}}
		<div class="separator separator-dashed mt-8 mb-5"></div>

		{{-- Nav --}}
		<div class="navi navi-spacer-x-0 p-0">
            {{-- Item --}}
            @if( session()->get('role_name') == 'superadmin' )
		    <a href="{{ route('admin-account-edit') }}" class="navi-item">
		        <div class="navi-link">
		            <div class="symbol symbol-40 bg-light mr-3">
		                <div class="symbol-label">
							{{ Metronic::getSVG("media/svg/icons/General/Notification2.svg", "svg-icon-md svg-icon-custom") }}
						</div>
		            </div>
		            <div class="navi-text">
		                <div class="font-weight-bold">
		                    Mis Datos
		                </div>
		                <div class="text-muted">
		                    Información de usuario
		                    <span class="label label-light-danger label-inline font-weight-bold">actualizar</span>
		                </div>
		            </div>
		        </div>
            </a>
            @elseif(  session()->get('role_name') == 'usuario' )
            <a href="{{ route('account-edit') }}" class="navi-item">
		        <div class="navi-link">
		            <div class="symbol symbol-40 bg-light mr-3">
		                <div class="symbol-label">
							{{ Metronic::getSVG("media/svg/icons/General/Notification2.svg", "svg-icon-md svg-icon-custom") }}
						</div>
		            </div>
		            <div class="navi-text">
		                <div class="font-weight-bold">
		                    Mis Datos
		                </div>
		                <div class="text-muted">
		                    Información de usuario
		                    <span class="label label-light-danger label-inline font-weight-bold">actualizar</span>
		                </div>
		            </div>
		        </div>
            </a>
            @endif

            {{-- Item --}}
            @if(session()->has('roles') && count(session('roles'))>1)
            <form id="login-role-change-form" action="{{route('login-role-change')}}" method="POST">
            @csrf
		    <a href="javascript:;"  class="navi-item" data-role="change">
		        <div class="navi-link">
					<div class="symbol symbol-40 bg-light mr-3">
						<div class="symbol-label">
 						   {{ Metronic::getSVG("media/svg/icons/Navigation/Arrows-h.svg", "svg-icon-md svg-icon-custom") }}
 					   </div>
				   	</div>
		            <div class="navi-text">
		                <div class="font-weight-bold">
		                    Roles
		                </div>
		                <div class="text-muted">
		                    Cambio de rol
		                </div>
		            </div>
		        </div>
            </a>
            </form>
            @endif

            {{-- Item --}}
            <form id="logout-form" action="{{route('login-logout')}}" method="POST">
            @csrf
		    <a href="javascript:;"  class="navi-item" data-logout="true">
		        <div class="navi-link">
					<div class="symbol symbol-40 bg-light mr-3">
						<div class="symbol-label">
							{{ Metronic::getSVG("media/svg/icons/Navigation/Sign-out.svg", "svg-icon-md svg-icon-danger") }}
						</div>
				   	</div>
		            <div class="navi-text">
		                <div class="font-weight-bold">
		                    Salir
		                </div>
		                <div class="text-muted">
		                    Del sistema
		                </div>
		            </div>
		        </div>
            </a>
            </form>

		</div>

		{{-- Separator --}}
		<div class="separator separator-dashed my-7"></div>

		{{-- Notifications --}}

        <!--
        <div>
			{{-- Heading --}}
        	<h5 class="mb-5">
            	Notificaciones Recientes
        	</h5>

			{{-- Item --}}
	        <div class="d-flex align-items-center bg-light-warning rounded p-5 gutter-b">
	            <span class="svg-icon svg-icon-warning mr-5">
	                 Metronic::getSVG("media/svg/icons/Home/Library.svg", "svg-icon-lg")
	            </span>

	            <div class="d-flex flex-column flex-grow-1 mr-2">
	                <a href="#" class="font-weight-normal text-dark-75 text-hover-primary font-size-lg mb-1">Nuevos Productores</a>
	                <span class="text-muted font-size-sm">+25 últimos 7 días</span>
	            </div>

	            <span class="font-weight-bolder text-warning py-1 font-size-lg">+28%</span>
	        </div>

	        {{-- Item --}}
	        <div class="d-flex align-items-center bg-light-success rounded p-5 gutter-b">
	            <span class="svg-icon svg-icon-success mr-5">
	                 Metronic::getSVG("media/svg/icons/Communication/Write.svg", "svg-icon-lg")
	            </span>
	            <div class="d-flex flex-column flex-grow-1 mr-2">
	                <a href="#" class="font-weight-normal text-dark-75 text-hover-primary font-size-lg mb-1">Creación de Usuarios</a>
	                <span class="text-muted font-size-sm">3 en los últimos 3 días</span>
	            </div>

	            <span class="font-weight-bolder text-success py-1 font-size-lg">+50%</span>
	        </div>

	        {{-- Item --}}
	        <div class="d-flex align-items-center bg-light-danger rounded p-5 gutter-b">
	            <span class="svg-icon svg-icon-danger mr-5">
	                 Metronic::getSVG("media/svg/icons/Communication/Group-chat.svg", "svg-icon-lg")
	            </span>
	            <div class="d-flex flex-column flex-grow-1 mr-2">
	                <a href="#" class="font-weight-normel text-dark-75 text-hover-primary font-size-lg mb-1">Baja de Inspecciones</a>
	                <span class="text-muted font-size-sm">+ 15 últimos 20 días</span>
	            </div>

	            <span class="font-weight-bolder text-danger py-1 font-size-lg">-27%</span>
	        </div>

		</div>
    </div>
    -->
</div>
