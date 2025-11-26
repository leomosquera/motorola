{{-- Footer --}}

<div class="footer bg-white py-4 d-flex flex-lg-column {{ Metronic::printClasses('footer', false) }}" id="kt_footer">
    {{-- Container --}}
    <div class="{{ Metronic::printClasses('footer-container', false) }} d-flex flex-column flex-md-row align-items-center justify-content-between">
        {{-- Copyright --}}
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted font-weight-bold mr-2">{{ date("Y") }} &copy;</span> <a href="javascript:;" class="text-dark-75 text-hover-primary">{{ Config::get('app.name') }} - Administrator</a>
        </div>

        {{-- Nav --}}
        <div class="nav nav-dark order-1 order-md-2">
            <a href="javascript:;" class="nav-link pr-3 pl-0">Nosotros</a>
            <a href="javascript:;" class="nav-link px-3">Términos y Condiciones</a>
            <a href="javascript:;" class="nav-link pl-3 pr-0">Contáctenos</a>
        </div>
    </div>
</div>
