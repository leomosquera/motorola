{{-- Stats Widget 7 --}}

<div class="card card-custom {{ @$class }} gutter-b">
    {{-- Body --}}
    <div class="card-body d-flex flex-column p-0">
        <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
            <div class="d-flex flex-column mr-2">
                <a href="#" class="text-dark-75 text-hover-primary font-weight-bolder font-size-h5">Inspecciones Automóviles</a>
                <span class="text-muted font-weight-bold mt-2">Últimos 7 días</span>
            </div>
            <span class="symbol symbol-light-success symbol-45">
                <span class="symbol-label font-weight-bolder font-size-h6">+149</span>
            </span>
        </div>
        <div id="kt_stats_widget_7_chart" data-route="{{ route('chart-apex-area') }}" class="card-rounded-bottom" style="height: 150px"></div>
    </div>
</div>
