{{-- Subheader V1 --}}

<div class="subheader py-2 {{ Metronic::printClasses('subheader', false) }}" id="kt_subheader">
    <div class="{{ Metronic::printClasses('subheader-container', false) }} d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">

		{{-- Info --}}
        <div class="d-flex align-items-center flex-wrap mr-1">

			{{-- Page Title --}}
            <h5 class="text-dark font-weight-bold my-2 mr-5">
                {{ @$page_title }}

                @if (isset($page_description) && config('layout.subheader.displayDesc'))
                    <small>{{ @$page_description }}</small>
                @endif
            </h5>

            @if (!empty($page_breadcrumbs))
				{{-- Separator --}}
                <div class="subheader-separator subheader-separator-ver my-2 mr-4 d-none"></div>

				{{-- Breadcrumb --}}
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2">
                    @foreach ($page_breadcrumbs as $k => $item)
						<li class="breadcrumb-item">
                            @if(!empty($item['page']))
                                <a href="{{ url($item['page']) }}" class="text-muted">
                                    {{ $item['title'] }}
                                </a>
                            @else
                                <span class="text-muted">
                                    {{ $item['title'] }}
                                </span>
                            @endif
						</li>
                    @endforeach
                </ul>
            @endif
        </div>

		{{-- Toolbar --}}
        <div class="d-flex align-items-center">
            @hasSection('page_toolbar')
                @section('page_toolbar')
            @endif

            @if (!empty($page_actions))
                <!--begin::Button-->
                <a href="{{ URL::previous() }}" class="btn btn-default font-weight-bold btn-sm px-3 font-size-base">Volver</a>
                <!--end::Button-->

                @if(count($page_actions)==1)
                    @switch($page_actions[0])
                        @case('store')
                            <button type="submit" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base ml-2">Guardar</button>
                            @break
                    @endswitch
                @else
                <!--begin::Dropdown-->
                <div class="btn-group ml-2">
                    <button type="button" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base">Save Changes</button>
                    <button type="button" class="btn btn-primary font-weight-bold btn-sm px-3 font-size-base dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                    <div class="dropdown-menu dropdown-menu-sm p-0 m-0 dropdown-menu-right">
                        <ul class="navi py-5">
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="flaticon2-writing"></i>
                                    </span>
                                    <span class="navi-text">Save &amp; continue</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="flaticon2-medical-records"></i>
                                    </span>
                                    <span class="navi-text">Save &amp; add new</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-icon">
                                        <i class="flaticon2-hourglass-1"></i>
                                    </span>
                                    <span class="navi-text">Save &amp; exit</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--end::Dropdown-->
                @endif
            @endif
        </div>

    </div>
</div>
