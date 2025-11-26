<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">

        @include('includes.form-errors')

        <!--begin::Card-->
        <div class="card card-custom card-sticky" id="kt_page_sticky_card">
            <!--begin::Card header-->
            <div class="card-header card-header-tabs-line nav-tabs-line-3x">
                <!--begin::Toolbar-->
                <div class="card-toolbar">
                    <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
                        <!--begin::Item-->
                        <li class="nav-item mr-3">
                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_1">
                                <span class="nav-icon">
                                    <span class="svg-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
                                                <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                <span class="nav-text font-size-lg">Información</span>
                            </a>
                        </li>
                        <li class="nav-item mr-3">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_2">
                                <span class="nav-icon">
                                    <span class="svg-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <path d="M6,5 L18,5 C19.6568542,5 21,6.34314575 21,8 L21,17 C21,18.6568542 19.6568542,20 18,20 L6,20 C4.34314575,20 3,18.6568542 3,17 L3,8 C3,6.34314575 4.34314575,5 6,5 Z M5,17 L14,17 L9.5,11 L5,17 Z M16,14 C17.6568542,14 19,12.6568542 19,11 C19,9.34314575 17.6568542,8 16,8 C14.3431458,8 13,9.34314575 13,11 C13,12.6568542 14.3431458,14 16,14 Z" fill="#000000"/>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                <span class="nav-text font-size-lg">Fotos</span>
                            </a>
                        </li>
                        <li class="nav-item mr-3">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_3">
                                <span class="nav-icon">
                                    <span class="svg-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M16.3740377,19.9389434 L22.2226499,11.1660251 C22.4524142,10.8213786 22.3592838,10.3557266 22.0146373,10.1259623 C21.8914367,10.0438285 21.7466809,10 21.5986122,10 L17,10 L17,4.47708173 C17,4.06286817 16.6642136,3.72708173 16.25,3.72708173 C15.9992351,3.72708173 15.7650616,3.85240758 15.6259623,4.06105658 L9.7773501,12.8339749 C9.54758575,13.1786214 9.64071616,13.6442734 9.98536267,13.8740377 C10.1085633,13.9561715 10.2533191,14 10.4013878,14 L15,14 L15,19.5229183 C15,19.9371318 15.3357864,20.2729183 15.75,20.2729183 C16.0007649,20.2729183 16.2349384,20.1475924 16.3740377,19.9389434 Z" fill="#000000"/>
                                                <path d="M4.5,5 L9.5,5 C10.3284271,5 11,5.67157288 11,6.5 C11,7.32842712 10.3284271,8 9.5,8 L4.5,8 C3.67157288,8 3,7.32842712 3,6.5 C3,5.67157288 3.67157288,5 4.5,5 Z M4.5,17 L9.5,17 C10.3284271,17 11,17.6715729 11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L4.5,20 C3.67157288,20 3,19.3284271 3,18.5 C3,17.6715729 3.67157288,17 4.5,17 Z M2.5,11 L6.5,11 C7.32842712,11 8,11.6715729 8,12.5 C8,13.3284271 7.32842712,14 6.5,14 L2.5,14 C1.67157288,14 1,13.3284271 1,12.5 C1,11.6715729 1.67157288,11 2.5,11 Z" fill="#000000" opacity="0.3"/>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                <span class="nav-text font-size-lg">DAÑOS</span>
                            </a>
                        </li>
                        <li class="nav-item mr-3">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_4">
                                <span class="nav-icon">
                                    <span class="svg-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <path d="M6,5 L18,5 C19.6568542,5 21,6.34314575 21,8 L21,17 C21,18.6568542 19.6568542,20 18,20 L6,20 C4.34314575,20 3,18.6568542 3,17 L3,8 C3,6.34314575 4.34314575,5 6,5 Z M5,17 L14,17 L9.5,11 L5,17 Z M16,14 C17.6568542,14 19,12.6568542 19,11 C19,9.34314575 17.6568542,8 16,8 C14.3431458,8 13,9.34314575 13,11 C13,12.6568542 14.3431458,14 16,14 Z" fill="#000000"/>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                <span class="nav-text font-size-lg">GNC</span>
                            </a>
                        </li>
                        <!--end::Item-->
                    </ul>
                </div>
                <!--end::Toolbar-->
                <!--start::Toolbar-->
                <div class="card-toolbar">
                    <a href="{{ URL::previous() }}" class="btn btn-light-custom font-weight-bolder mr-2"><i class="ki ki-long-arrow-back icon-sm"></i>Volver</a>
                    <button type="submit" class="btn btn-custom font-weight-bolder"><i class="ki ki-check icon-sm"></i>Guardar</button>
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body">
                <form class="form" id="kt_form">
                    <div class="tab-content">
                        <!--begin::Tab-->
                        <div class="tab-pane show active px-7" id="kt_tab_1" role="tabpanel">
                            <!--begin::Row-->
                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <label>Estado</label>
                                    <select name="status" class="form-control">
                                        @foreach( Config::get('models.inspection-car.status') as $key => $node )
                                            <option value="{{ $key }}" {{ old('icon', $data->status ?? '')==$key ? 'selected' : '' }}>{{ $node }}
                                            </option>
                                        @endforeach()
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label>Fecha</label>
                                    <div class="input-group date">
                                        <input
                                        name="date"
                                        type="text"
                                        class="form-control"
                                        readonly="readonly"
                                        placeholder="Seleccion fecha"
                                        value="{{old('date', $data->date ?? '')}}"
                                        " />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar-check-o"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Productor / Emisor</label>
                                    <select name="usuario_id" class="form-control">
                                        @foreach( $usuarios as $key => $node )
                                            <option
                                            value="{{ $node->id }}" {{ old('usuario_id', $data->usuario_id ?? '')==$node->id ? 'selected' : '' }}
                                            >{{ $node->name.' '.$node->lastname }}
                                            </option>
                                        @endforeach()
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Tipo de Vehículo</label>
                                    <select name="car_type_id" class="form-control">
                                        @foreach( $car_types as $key => $node )
                                            <option
                                            value="{{ $node->id  }}" {{ old('car_type_id', $data->car_type_id ?? '')==$node->id ? 'selected' : '' }}
                                            >{{ $node->name }}
                                            </option>
                                        @endforeach()
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label>Patente</label>
                                    <input
                                    name="patent"
                                    type="text"
                                    class="form-control text-uppercase"
                                    placeholder="Patente"
                                    value="{{old('date', $data->patent ?? '')}}"
                                    />
                                </div>
                                <div class="col-lg-3">
                                    <label>Año</label>
                                    <input
                                    name="year"
                                    type="text"
                                    class="form-control"
                                    placeholder="Año"
                                    value="{{old('year', $data->year ?? '')}}"
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Nombre</label>
                                    <input
                                    name="name"
                                    type="text"
                                    class="form-control"
                                    placeholder="Nombre"
                                    value="{{old('date', $data->name ?? '')}}"
                                    />
                                </div>
                                <div class="col-lg-6">
                                    <label>Motivo</label>
                                    <input
                                    name="reason"
                                    type="text"
                                    class="form-control"
                                    placeholder="Motivo"
                                    value="{{old('reason', $data->reason ?? '')}}"
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Teléfono</label>
                                    <input
                                    name="phone"
                                    type="text"
                                    class="form-control"
                                    placeholder="Teléfono"
                                    value="{{old('phone', $data->phone ?? '')}}"
                                    />
                                </div>
                                <div class="col-lg-6">
                                    <label>Email</label>
                                    <input
                                    name="email"
                                    type="text"
                                    class="form-control"
                                    placeholder="Email"
                                    value="{{old('email', $data->email ?? '')}}"
                                    />
                                </div>
                            </div>
                        </div>
                        <!--end::Tab-->
                        <!--begin::Tab-->
                        <div class="tab-pane show px-7" id="kt_tab_2" data-imageupload="1" role="tabpanel">
                            @if(!empty($images['images']) && count($images['images'])>0)
                            <div id="file-list">
                                <div class="row justify-content-md-center thumb-list">
                                    @foreach ($images['images'] as $image)
                                    <div class="col-lg-3 image-thumb mb-10">
                                        <div class="card card-custom card-shadowless">
                                            <div class="card-header border-0 pt-5 p-0">
												<h3 class="card-title align-items-start flex-column">
                                                <span class="card-label font-weight-bolder text-dark">{{ $image->type->name }}</span>
                                                <span class="text-muted mt-1 font-weight-bold font-size-sm">Inspección: {{ $data->id }}</span>
												</h3>
												<div class="card-toolbar">
													<div class="dropdown dropdown-inline">
														<a href="#" class="btn btn-light-custom btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<i class="ki ki-bold-more-hor"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
															<!--begin::Navigation-->
															<ul class="navi navi-hover py-5">
																<li class="navi-item">
																	<a href="{{ route('inspection-car-image-edit', $image->id) }}" class="navi-link">
																		<span class="navi-icon">
																			<i class="flaticon2-pen"></i>
																		</span>
																		<span class="navi-text">Editar</span>
																	</a>
																</li>
																<li class="navi-item">
																	<a href="{{ URL::to('/').Storage::url(Config::get('models.inspection-car.image.dir')).($images['type']=='unique' ? $image : $image->image) }}" class="navi-link" target="_blank" download>
																		<span class="navi-icon">
																			<i class="flaticon2-download-2"></i>
																		</span>
																		<span class="navi-text">Descargar</span>
																	</a>
																</li>
																<li class="navi-item">
																	<a href="javascript:;" class="navi-link">
																		<span class="navi-icon">
																			<i class="flaticon2-trash"></i>
																		</span>
																		<span class="navi-text">Eliminar</span>
																	</a>
																</li>
															</ul>
															<!--end::Navigation-->
														</div>
													</div>
												</div>
											</div>
                                            <div class="card-body p-0">
                                                <!--begin::Image-->
                                                <div class="overlay">
                                                    <div class="overlay-wrapper rounded bg-light text-center" style="background-image: url({{ URL::to('/').Storage::url(Config::get('models.inspection-car.image.dir')).($images['type']=='unique' ? $image : $image->image) }}); min-height: 250px; background-size: cover; background-position: center center; background-repeat: no-repeat; background-color: #a7a7a7;">
                                                    </div>
                                                    <div class="overlay-layer">
                                                        <a href="javascript:;" class="btn font-weight-bolder btn-sm btn-primary mr-2 btn-image-modal" data-id="{{ $images['type']=='unique' ? $data->id : $image->id }}">Ver imagen</a>
                                                        <a href="javascript:;" class="btn font-weight-bolder btn-sm btn-danger btn-image-remove" data-route="{{ $images['type']=='unique' ? route('inspection-car-image-destroy') : route('inspection-car-image-destroy') }}" data-id="{{ $images['type']=='unique' ? $data->id : $image->id }}">Eliminar</a>
                                                    </div>
                                                </div>
                                                <!--end::Image-->

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>



                                <div class="modal modal-h80 fade text-left" data-modal="true" tabindex="-1" role="dialog" aria-labelledby="true" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" modal-id="true" id="true">Galería de imágenes</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body p-0">
                                                @if(!empty($images['images']) && count($images['images'])>0)
                                                <div class="carousel slide carousel-images" data-carousel="true" id="carou-1">
                                                    <!-- The slideshow -->
                                                    <div class="carousel-inner">
                                                        @foreach ($images['images'] as $image)
                                                            <div class="carousel-item" style="background-image: url()" data-id="{{ $images['type']=='unique' ? $data->id : $image->id }}">
                                                                <div class="panzoom-elements h-100">
                                                                    <div class="panzoom text-center h-100">
                                                                        <img src="{{ URL::to('/').Storage::url(Config::get('models.inspection-car.image.dir')).($images['type']=='unique' ? $image : $image->image) }}" height="100%">
                                                                    </div>
                                                                    <div class="buttons text-center position-absolute" style="bottom:2.5%; z-index:1; width:100%;">
                                                                        <a href="javascript:;" class="zoom-out"><i class="far fa-minus-square"></i></a>
                                                                        <a href="javascript:;" class="zoom-in"><i class="far fa-plus-square"></i></a>
                                                                        <a href="javascript:;" class="reset"><i class="fas fa-undo"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <!-- Left and right controls -->
                                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            @else
                            <div class="alert alert-custom alert-secondary fade show" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                <div class="alert-text">No se encontraron imágenes del Automóvil.</div>
                                <div class="alert-close">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                    </button>
                                </div>
                            </div>
                            @endif

                            <div class="form-group row d-none">
                                <div class="col-12">
                                    <h5 class="font-weight-bold mb-3">Imágenes a subir:</h5>
                                    <div class="separator separator-dashed my-5"></div>
                                    <table class="table table-images">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Extensión</th>
                                                <th scope="col">Tipo</th>
                                                <th scope="col">Peso</th>
                                                <th scope="col" width="100">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <input type="file" id="upload_images" class="d-none" multiple />
                                    <a href="javascript:;" class="btn btn-primary mr-3 btn-upload">
                                        <span class="svg-icon">
                                            <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Mail-opened.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                                    <rect fill="#000000" opacity="0.3" x="11" y="5" width="2" height="14" rx="1"/>
                                                    <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero"/>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>Agregar imágenes
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--end::Tab-->
                        <!--begin::Tab-->
                        <div class="tab-pane show px-7" id="kt_tab_3" role="tabpanel">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">Daños</span>
                                <p class="text-muted mt-3 font-weight-bold font-size-sm">Descripción de los daños ingresados</p>
                            </h3>
                            @if( count($data->damages()->get()) == 0 )
                            <div class="alert alert-custom alert-secondary fade show" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                <div class="alert-text">No se encontraron daños en la inspeción.</div>
                                <div class="alert-close">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                    </button>
                                </div>
                            </div>
                            @else
                            <div class="table-responsive">
                                <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_1">
                                    <thead>
                                        <tr class="text-left">
                                            <th class="pl-0" style="width: 20px">
                                                <label class="checkbox checkbox-lg checkbox-inline">
                                                    <input type="checkbox" value="1" />
                                                    <span></span>
                                                </label>
                                            </th>
                                            <th style="min-width: 200px">Parte</th>
                                            <th style="min-width: 150px">Daño</th>
                                            <th style="min-width: 150px">Estado</th>
                                            <th class="pr-0 text-right" style="min-width: 150px">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach( $data->damages()->get() as $node )
                                        <tr>
                                            <td class="pl-0">
                                                <label class="checkbox checkbox-lg checkbox-inline">
                                                    <input type="checkbox" value="1" />
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{ $node->part->name }}</span>
                                                <span class="text-muted font-weight-bold text-muted d-block">Cód. Gaus: {{ $node->gaus_code }}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $node->type->name }}</span>
                                                <span class="text-muted font-weight-bold">Valor Gaus: {{ $node->value }}</span>
                                            </td>
                                            <td>
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{ $node->status }}</span>
                                                <span class="text-muted font-weight-bold">Gaus: {{ $node->gaus_description }}</span>
                                            </td>
                                            <td class="pr-0 text-right">
                                                <a href="javascript:;" class="btn btn-icon btn-light btn-hover-ligth btn-sm mx-3">
                                                    <span class="svg-icon svg-icon-md svg-icon-ligth">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Write.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
                                                                <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </a>
                                                <a href="javascript:;" class="btn btn-icon btn-light btn-hover-ligth btn-sm">
                                                    <span class="svg-icon svg-icon-md svg-icon-ligth">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/Trash.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24" />
                                                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero" />
                                                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                        <!--end::Tab-->
                        <!--begin::Tab-->
                        <div class="tab-pane show px-7" id="kt_tab_4" data-imageupload="2" role="tabpanel">
                            @if(!empty($gnc['images']) && count($gnc['images'])>0)
                            <div id="file-list">
                                <div class="row justify-content-md-center thumb-list">
                                    @foreach ($gnc['images'] as $image)
                                    <div class="col-lg-3 image-thumb mb-10">
                                        <div class="card card-custom card-shadowless">
                                            <div class="card-header border-0 pt-5 p-0">
												<h3 class="card-title align-items-start flex-column">
                                                <span class="card-label font-weight-bolder text-dark">{{ $image->type->name }}</span>
                                                <span class="text-muted mt-1 font-weight-bold font-size-sm">Inspección: {{ $data->id }}</span>
												</h3>
												<div class="card-toolbar">
													<div class="dropdown dropdown-inline">
														<a href="#" class="btn btn-light-custom btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															<i class="ki ki-bold-more-hor"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
															<!--begin::Navigation-->
															<ul class="navi navi-hover py-5">
																<li class="navi-item">
																	<a href="{{ route('inspection-car-gnc-edit', $image->id) }}" class="navi-link">
																		<span class="navi-icon">
																			<i class="flaticon2-pen"></i>
																		</span>
																		<span class="navi-text">Editar</span>
																	</a>
																</li>
																<li class="navi-item">
																	<a href="{{ URL::to('/').Storage::url(Config::get('models.inspection-car.gnc.dir')).($gnc['type']=='unique' ? $image : $image->image) }}" class="navi-link" target="_blank" download>
																		<span class="navi-icon">
																			<i class="flaticon2-download-2"></i>
																		</span>
																		<span class="navi-text">Descargar</span>
																	</a>
																</li>
																<li class="navi-item">
																	<a href="javascript:;" class="navi-link">
																		<span class="navi-icon">
																			<i class="flaticon2-trash"></i>
																		</span>
																		<span class="navi-text">Eliminar</span>
																	</a>
																</li>
															</ul>
															<!--end::Navigation-->
														</div>
													</div>
												</div>
											</div>
                                            <div class="card-body p-0">
                                                <!--begin::Image-->
                                                <div class="overlay">
                                                    <div class="overlay-wrapper rounded bg-light text-center" style="background-image: url({{ URL::to('/').Storage::url(Config::get('models.inspection-car.gnc.dir')).($gnc['type']=='unique' ? $image : $image->image) }}); min-height: 250px; background-size: cover; background-position: center center; background-repeat: no-repeat; background-color: #a7a7a7;">
                                                    </div>
                                                    <div class="overlay-layer">
                                                        <a href="javascript:;" class="btn font-weight-bolder btn-sm btn-primary mr-2 btn-image-modal" data-id="{{ $gnc['type']=='unique' ? $data->id : $image->id }}">Ver imagen</a>
                                                        <a href="javascript:;" class="btn font-weight-bolder btn-sm btn-danger btn-image-remove" data-route="{{ $gnc['type']=='unique' ? route('inspection-car-image-destroy') : route('inspection-car-image-destroy') }}" data-id="{{ $gnc['type']=='unique' ? $data->id : $image->id }}">Eliminar</a>
                                                    </div>
                                                </div>
                                                <!--end::Image-->

                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>



                                <div class="modal modal-h80 fade text-left" data-modal="true" tabindex="-1" role="dialog" aria-labelledby="true" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" modal-id="true" id="true">Galería de imágenes</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @if(!empty($gnc['images']) && count($gnc['images'])>0)
                                                <div class="carousel slide carousel-images" data-carousel="true" id="carou-2">
                                                    <!-- The slideshow -->
                                                    <div class="carousel-inner">
                                                        @foreach ($gnc['images'] as $image)
                                                            <div class="carousel-item" style="background-image: url({{ URL::to('/').Storage::url(Config::get('models.inspection-car.image.dir')).($images['type']=='unique' ? $image : $image->image) }})" data-id="{{ $images['type']=='unique' ? $data->id : $image->id }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <!-- Left and right controls -->
                                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Previous</span>
                                                    </a>
                                                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="sr-only">Next</span>
                                                    </a>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            @else
                            <div class="alert alert-custom alert-secondary fade show" role="alert">
                                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                                <div class="alert-text">No se encontraron imágenes de GNC.</div>
                                <div class="alert-close">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                    </button>
                                </div>
                            </div>
                            @endif

                            <div class="form-group row d-none">
                                <div class="col-12">
                                    <h5 class="font-weight-bold mb-3">Imágenes a subir:</h5>
                                    <div class="separator separator-dashed my-5"></div>
                                    <table class="table table-images">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Extensión</th>
                                                <th scope="col">Tipo</th>
                                                <th scope="col">Peso</th>
                                                <th scope="col" width="100">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <input type="file" id="upload_images" class="d-none" multiple />
                                    <a href="javascript:;" class="btn btn-primary mr-3 btn-upload">
                                        <span class="svg-icon">
                                            <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Mail-opened.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                                    <rect fill="#000000" opacity="0.3" x="11" y="5" width="2" height="14" rx="1"/>
                                                    <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z" fill="#000000" fill-rule="nonzero"/>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>Agregar imágenes
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--end::Tab-->
                    </div>
                </form>
            </div>
            <!--begin::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

