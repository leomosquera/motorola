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
                            <a class="nav-link active" data-toggle="tab" href="#kt_user_edit_tab_1">
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
                                <span class="nav-text font-size-lg">Profile</span>
                            </a>
                        </li>
                        <!--end::Item-->
                    </ul>
                </div>
                <!--end::Toolbar-->
                <!--start::Toolbar-->
                <div class="card-toolbar">
                    <a href="{{ URL::previous() }}" class="btn btn-light-primary font-weight-bolder mr-2"><i class="ki ki-long-arrow-back icon-sm"></i>Volver</a>
                    <button type="submit" class="btn btn-primary font-weight-bolder"><i class="ki ki-check icon-sm"></i>Guardar</button>
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body">
                <form class="form" id="kt_form">
                    <div class="tab-content">
                        <!--begin::Tab-->
                        <div class="tab-pane show active px-7" id="kt_user_edit_tab_1" role="tabpanel">
                            <!--begin::Row-->
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Username <span class="text-muted font-size-sm">"Sin especios y caracteres especiales"</span></label>
                                            <div class="input-group">
                                                <input
                                                name="username"
                                                type="text"
                                                class="form-control"
                                                placeholder="Username"
                                                value="{{old('username', $data->username ?? '')}}"
                                                autocomplete="off"
                                                />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-user"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Email</label>
                                            <div class="input-group">
                                                <input
                                                name="email"
                                                type="email"
                                                class="form-control"
                                                placeholder="Email"
                                                value="{{old('email', $data->email ?? '')}}"
                                                autocomplete="off"
                                                />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-envelope"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-lg-6">
                                            <label>Contraseña:</label>
                                            <div class="input-group">
                                                <input
                                                name="password"
                                                type="password"
                                                class="form-control"
                                                placeholder="Constraseña"
                                                value="{{old('password' ?? '')}}"
                                                autocomplete="off"
                                                />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-lock"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Confirmar contraseña:</label>
                                            <div class="input-group">
                                                <input
                                                name="password_confirmation"
                                                type="password"
                                                class="form-control"
                                                placeholder="Confirmar contraseña"
                                                value="{{old('password_confirmation' ?? '')}}"
                                                autocomplete="off"
                                                />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="la la-lock"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        @if($action=='edit')
                                        <div class="form-group col-6">
                                            <div class="checkbox-inline mt-2">
                                                <label class="checkbox">
                                                    <input
                                                    type="checkbox"
                                                    name="password_change_confirm"
                                                    value="1"
                                                    >
                                                    <span></span>Click aquí para habilitar modificación
                                                </label>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label>Nombre</label>
                                            <input
                                            name="name"
                                            type="text"
                                            class="form-control"
                                            placeholder="Nombre"
                                            value="{{old('name', $data->name ?? '')}}"
                                            />
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Apellido</label>
                                            <input
                                            name="lastname"
                                            type="text"
                                            class="form-control"
                                            placeholder="Apellido"
                                            value="{{old('lastname', $data->lastname ?? '')}}"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center">
                                    <div class="croppie-upload-msg">
                                        @if(!empty($data->image))
                                            <img src="{{ URL::to('/').'/storage/'.Config::get('models.usuario.avatar.dir').$data->image }}" width="150" height="150" style="margin:auto">
                                        @else
                                            <p><i class="la la-photo"></i><br>Subir Imagen</p>
                                        @endif
                                    </div>
                                    <div id="image-preview"></div>
                                    <div>
                                        <a class="btn btn-icon btn-success position-relative">
                                            <i class="la la-photo"></i>
                                            <input type="file" class="custom-file-input position-absolute" name="upload_image">
                                            <input type="hidden" name="image_up" value="">
                                            <input type="hidden" name="image_delete" value="0">
                                        </a>
                                        <a href="javascript:;" class="btn btn-icon btn-danger file-delete"><i class="la la-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Contraseña modificada?</label>
                                    <div>
                                        <input
                                        name="password_changed"
                                        value="1"
                                        data-switch="true"
                                        data-size="small"
                                        type="checkbox"
                                        data-on-color="success"
                                        data-off-color="danger"
                                        data-on-text="SI"
                                        data-off-text="NO"
                                        checked="checked"
                                        {{ !empty($data->password_changed) && $data->password_changed == 1 ? 'checked' : '' }}
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Roles de usuario</label>
                                    <div class="checkbox-inline">
                                        @foreach ($roles as $item)
                                        <label class="checkbox">
                                            <input
                                            type="checkbox"
                                            name="roles[]"
                                            value="{{ $item->id }}"
                                            {{ !empty($data_roles) && in_array($item->id, $data_roles) ? 'checked' : '' }}
                                            >
                                            <span></span>{{ $item->name }}
                                        </label>
                                        @endforeach()
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

