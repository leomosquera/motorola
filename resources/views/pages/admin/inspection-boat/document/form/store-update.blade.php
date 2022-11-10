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
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <path d="M6,5 L18,5 C19.6568542,5 21,6.34314575 21,8 L21,17 C21,18.6568542 19.6568542,20 18,20 L6,20 C4.34314575,20 3,18.6568542 3,17 L3,8 C3,6.34314575 4.34314575,5 6,5 Z M5,17 L14,17 L9.5,11 L5,17 Z M16,14 C17.6568542,14 19,12.6568542 19,11 C19,9.34314575 17.6568542,8 16,8 C14.3431458,8 13,9.34314575 13,11 C13,12.6568542 14.3431458,14 16,14 Z" fill="#000000"/>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                <span class="nav-text font-size-lg">Imagen</span>
                            </a>
                        </li>
                        <!--end::Item-->
                    </ul>
                </div>
                <!--end::Toolbar-->
                <!--start::Toolbar-->
                <div class="card-toolbar">
                    <a href="{{ URL::previous() }}" class="btn btn-light-custom font-weight-bolder mr-2"><i class="ki ki-long-arrow-back icon-sm"></i>Volver</a>
                <a href="javascript:;" class="btn btn-custom font-weight-bolder mr-2 btn-crop" data-route="{{ route('inspection-car-document-replace') }}" data-id="{{ $data->id }}">Guardar</a>
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-3" style="max-height: 550px">
                        <img id="image" src="{{ URL::to('/').Storage::url(Config::get('models.inspection-car.document.dir')).$data->image }}" width="500" alt="" />
                        </div>
                        <div id="cropper-buttons">
                            <div class="btn-group">
                                <button type="button" class="btn btn-custom mb-3" data-method="setDragMode" data-option="move" title="Move">
                                    <span data-toggle="tooltip" title="cropper.setDragMode(&quot;move&quot;)">
                                        <span class="fa fa-arrows-alt"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-custom mb-3" data-method="setDragMode" data-option="crop" title="Crop">
                                    <span data-toggle="tooltip" title="cropper.setDragMode(&quot;crop&quot;)">
                                        <span class="fa fa-crop-alt"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-custom mb-3" data-method="zoom" data-option="0.1" title="Zoom In">
                                    <span data-toggle="tooltip" title="cropper.zoom(0.1)">
                                        <span class="fa fa-search-plus"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-custom mb-3" data-method="zoom" data-option="-0.1" title="Zoom Out">
                                    <span title="cropper.zoom(-0.1)">
                                        <span class="fa fa-search-minus"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-custom mb-3" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                                    <span data-toggle="tooltip" title="cropper.move(-10, 0)">
                                        <span class="fa fa-arrow-left"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-custom mb-3" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                                    <span data-toggle="tooltip" title="cropper.move(10, 0)">
                                        <span class="fa fa-arrow-right"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-custom mb-3" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                                    <span data-toggle="tooltip" title="cropper.move(0, -10)">
                                        <span class="fa fa-arrow-up"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-custom mb-3" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                                    <span data-toggle="tooltip" title="cropper.move(0, 10)">
                                        <span class="fa fa-arrow-down"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-custom mb-3" data-method="rotate" data-option="-45" title="Rotate Left">
                                    <span data-toggle="tooltip" title="cropper.rotate(-45)">
                                        <span class="fa fa-undo-alt"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-custom mb-3" data-method="rotate" data-option="45" title="Rotate Right">
                                    <span data-toggle="tooltip" title="cropper.rotate(45)">
                                        <span class="fa fa-redo-alt"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-custom mb-3" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                                    <span data-toggle="tooltip" title="cropper.scaleX(-1)">
                                        <span class="fa fa-arrows-alt-h"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-custom mb-3" data-method="scaleY" data-option="-1" title="Flip Vertical">
                                    <span data-toggle="tooltip" title="cropper.scaleY(-1)">
                                        <span class="fa fa-arrows-alt-v"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-custom mb-3" data-method="crop" title="Crop">
                                    <span data-toggle="tooltip" title="cropper.crop()">
                                        <span class="fa fa-check"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-custom mb-3" data-method="clear" title="Clear">
                                    <span data-toggle="tooltip" title="cropper.clear()">
                                        <span class="fa fa-times"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-custom mb-3" data-method="reset" title="Reset">
                                    <span data-toggle="tooltip" title="cropper.reset()">
                                        <span class="fa fa-sync-alt"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="btn-group d-none">
                                <button type="button" class="btn btn-custom mb-3" data-method="disable" title="Disable">
                                    <span data-toggle="tooltip" title="cropper.disable()">
                                        <span class="fa fa-lock"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-custom mb-3" data-method="enable" title="Enable">
                                    <span data-toggle="tooltip" title="cropper.enable()">
                                        <span class="fa fa-unlock"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="btn-group">
                                <button class="btn btn-custom btn-upload mb-3 d-none" title="Upload image file">
                                    <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*" />
                                    <span class="kt-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
                                        <span class="fa fa-upload"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-custom mb-3 d-none" data-method="destroy" title="Destroy">
                                    <span data-toggle="tooltip" title="cropper.destroy()">
                                        <span class="fa fa-power-off"></span>
                                    </span>
                                </button>
                            </div>
                            <div class="btn-group btn-group-crop d-none">
                                <button type="button" data-toggle="modal" data-target="#getCroppedCanvasModal" class="btn btn-success mb-3" data-method="getCroppedCanvas" data-option="{ &quot;maxWidth&quot;: 540, &quot;maxHeight&quot;: 260 }">
                                    <span data-toggle="tooltip" title="cropper.getCroppedCanvas({ maxWidth: 540, maxHeight: 260 })">Get Cropped Canvas</span>
                                </button>
                                <button type="button" data-toggle="modal" data-target="#getCroppedCanvasModal" class="btn btn-success mb-3" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 160, &quot;height&quot;: 90 }">
                                    <span data-toggle="tooltip" title="cropper.getCroppedCanvas({ width: 160, height: 90 })">160×90</span>
                                </button>
                                <button type="button" data-toggle="modal" data-target="#getCroppedCanvasModal" class="btn btn-success mb-3" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 320, &quot;height&quot;: 180 }">
                                    <span data-toggle="tooltip" title="cropper.getCroppedCanvas({ width: 320, height: 180 })">320×180</span>
                                </button>
                            </div>
                            <!-- Show the cropped image in modal -->
                            <div class="modal fade cropper-cropped d-none" id="getCroppedCanvasModal" role="dialog" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.modal -->
                            <div class="d-none">
                                <button type="button" class="btn btn-secondary mb-3" data-method="getData" data-target="#putData">
                                    <span data-toggle="tooltip" title="cropper.getData()">Get Data</span>
                                </button>
                                <button type="button" class="btn btn-secondary mb-3" data-method="setData" data-target="#putData">
                                    <span data-toggle="tooltip" title="cropper.setData(data)">Set Data</span>
                                </button>
                                <button type="button" class="btn btn-secondary mb-3" data-method="getContainerData" data-target="#putData">
                                    <span data-toggle="tooltip" title="cropper.getContainerData()">Get Container Data</span>
                                </button>
                                <button type="button" class="btn btn-secondary mb-3" data-method="getImageData" data-target="#putData">
                                    <span data-toggle="tooltip" title="cropper.getImageData()">Get Image Data</span>
                                </button>
                                <button type="button" class="btn btn-secondary mb-3" data-method="getCanvasData" data-target="#putData">
                                    <span data-toggle="tooltip" title="cropper.getCanvasData()">Get Canvas Data</span>
                                </button>
                                <button type="button" class="btn btn-secondary mb-3" data-method="setCanvasData" data-target="#putData">
                                    <span data-toggle="tooltip" title="cropper.setCanvasData(data)">Set Canvas Data</span>
                                </button>
                                <button type="button" class="btn btn-secondary mb-3" data-method="getCropBoxData" data-target="#putData">
                                    <span data-toggle="tooltip" title="cropper.getCropBoxData()">Get Crop Box Data</span>
                                </button>
                                <button type="button" class="btn btn-secondary mb-3" data-method="setCropBoxData" data-target="#putData">
                                    <span data-toggle="tooltip" title="cropper.setCropBoxData(data)">Set Crop Box Data</span>
                                </button>
                                <button type="button" class="btn btn-secondary mb-3" data-method="moveTo" data-option="0">
                                    <span data-toggle="tooltip" title="cropper.moveTo(0)">Move to [0,0]</span>
                                </button>
                                <button type="button" class="btn btn-secondary mb-3" data-method="zoomTo" data-option="1">
                                    <span data-toggle="tooltip" title="cropper.zoomTo(1)">Zoom to 100%</span>
                                </button>
                                <button type="button" class="btn btn-secondary mb-3" data-method="rotateTo" data-option="180">
                                    <span data-toggle="tooltip" title="cropper.rotateTo(180)">Rotate 180°</span>
                                </button>
                                <button type="button" class="btn btn-secondary mb-3" data-method="scale" data-option="-2" data-second-option="-1">
                                    <span data-toggle="tooltip" title="cropper.scale(-2, -1)">Scale (-2, -1)</span>
                                </button>
                                <label for="putData"></label>
                                <textarea class="form-control" id="putData" placeholder="Get data to here or set data with this value"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cropper-preview clearfix mb-3">
                            <h3 class="mb-1 text-center pt-5">Previsualización</h3>
                            <span class="text-muted d-block text-center mb-4">Imagen apróximada que se generará.</span>
                            <div id="cropper-preview-lg" class="img-preview preview-lg img-fluid mb-3" style="width: 100%; height: 400px; overflow: hidden; background-color: #f7f7f7;"></div>
                            <div id="cropper-preview-md" class="img-preview preview-md float-left d-none" style="width: 128px; height: 80px; overflow: hidden; background-color: #f7f7f7;"></div>
                            <div id="cropper-preview-sm" class="img-preview preview-sm float-left ml-3 d-none" style="width: 64px; height: 40px; overflow: hidden; background-color: #f7f7f7;"></div>
                            <div id="cropper-preview-xs" class="img-preview preview-xs float-left ml-3 d-none" style="width: 32px; height: 20px; overflow: hidden; background-color: #f7f7f7;"></div>
                        </div>
                        <!-- <h3>Data:</h3> -->
                        <div id="cropper-data">
                            <div class="form-group d-none">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="dataX">X</label>
                                    </div>
                                    <input type="text" class="form-control" id="dataX" placeholder="x" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-none">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="dataY">Y</label>
                                    </div>
                                    <input type="text" class="form-control" id="dataY" placeholder="y" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-none">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="dataWidth">Width</label>
                                    </div>
                                    <input type="text" class="form-control" id="dataWidth" placeholder="width" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-none">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="dataHeight">Height</label>
                                    </div>
                                    <input type="text" class="form-control" id="dataHeight" placeholder="height" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">px</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-none">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="dataRotate">Rotate</label>
                                    </div>
                                    <input type="text" class="form-control" id="dataRotate" placeholder="rotate" />
                                    <div class="input-group-append">
                                        <span class="input-group-text">deg</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-none">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="dataScaleX">ScaleX</label>
                                    </div>
                                    <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX" />
                                </div>
                            </div>
                            <div class="form-group d-none">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="dataScaleY">ScaleY</label>
                                    </div>
                                    <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY" />
                                </div>
                            </div>
                        </div>
                        <div class="btn-group flex-nowrap d-none" data-toggle="buttons" id="setAspectRatio">
                            <label class="btn btn-custom active">
                                <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.7777777777777777" />
                                <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 16 / 9">16:9</span>
                            </label>
                            <label class="btn btn-custom">
                                <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1.3333333333333333" />
                                <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 4 / 3">4:3</span>
                            </label>
                            <label class="btn btn-custom">
                                <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="1" />
                                <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 1 / 1">1:1</span>
                            </label>
                            <label class="btn btn-custom">
                                <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="0.6666666666666666" />
                                <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 2 / 3">2:3</span>
                            </label>
                            <label class="btn btn-custom">
                                <input type="radio" class="sr-only" id="aspectRatio5" name="aspectRatio" value="NaN" />
                                <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: NaN">Free</span>
                            </label>
                        </div>
                        <div class="btn-group flex-nowrap d-none" data-toggle="buttons" id="viewMode">
                            <label class="btn btn-custom active">
                                <input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked="checked" />
                                <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 0">VM0</span>
                            </label>
                            <label class="btn btn-custom">
                                <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1" />
                                <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">VM1</span>
                            </label>
                            <label class="btn btn-custom">
                                <input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2" />
                                <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 2">VM2</span>
                            </label>
                            <label class="btn btn-custom">
                                <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3" />
                                <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">VM3</span>
                            </label>
                        </div>
                        <div class="btn-group d-none flex-nowrap" id="toggleOptionButtons">
                            <div class="dropdown" style="width: 100%;">
                                <button class="btn btn-brand dropdown-toggle" style="width: 100%;" type="button" id="toggleOption" data-toggle="dropdown">Toggle options</button>
                                <ul class="dropdown-menu" aria-labelledby="toggleOption">
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="responsive" checked="checked" />
                                        <span></span>responsive</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="restore" checked="checked" />
                                        <span></span>restore</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="checkCrossOrigin" checked="checked" />
                                        <span></span>checkCrossOrigin</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="checkOrientation" checked="checked" />
                                        <span></span>checkOrientation</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="modal" checked="checked" />
                                        <span></span>modal</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="guides" checked="checked" />
                                        <span></span>guides</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="center" checked="checked" />
                                        <span></span>center</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="highlight" checked="checked" />
                                        <span></span>highlight</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="data-toggle=" tooltip="">
                                        <input type="checkbox" name="background" checked="checked" />
                                        <span></span>background</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="autoCrop" checked="checked" />
                                        <span></span>autoCrop</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="movable" checked="checked" />
                                        <span></span>movable</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="rotatable" checked="checked" />
                                        <span></span>rotatable</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="scalable" checked="checked" />
                                        <span></span>scalable</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="zoomable" checked="checked" />
                                        <span></span>zoomable</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="zoomOnTouch" checked="checked" />
                                        <span></span>zoomOnTouch</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="zoomOnWheel" checked="checked" />
                                        <span></span>zoomOnWheel</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="cropBoxMovable" checked="checked" />
                                        <span></span>cropBoxMovable</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="cropBoxResizable" checked="checked" />
                                        <span></span>cropBoxResizable</label>
                                    </li>
                                    <li class="dropdown-item">
                                        <label class="checkbox">
                                        <input type="checkbox" name="toggleDragModeOnDblclick" checked="checked" />
                                        <span></span>toggleDragModeOnDblclick</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!--begin::Code example-->
                <div class="example-code mt-10 d-none">
                    <ul class="example-nav nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-2x">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#example_code_html">HTML</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#example_code_js">JS</a>
                        </li>
                    </ul>
                    <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                    <div class="tab-content">
                        <div class="tab-pane active" id="example_code_html" role="tabpanel">
                            <div class="example-highlight">
                                <pre>
                                <code class="language-html">&lt;!-- Wrap the image or canvas element with a block element (container) --&gt;
                                &lt;div&gt;
                                    &lt;img id="image" src="picture.jpg" alt=""/&gt;
                                &lt;/div&gt;</code>
                                </pre>
                            </div>
                        </div>
                        <div class="tab-pane" id="example_code_js">
                            <div class="example-highlight">
                                <pre style="height:500px">
                                    <code class="language-js">// import 'cropperjs/dist/cropper.css';
                                    import Cropper from 'cropperjs';

                                    const image = document.getElementById('image');
                                    const cropper = new Cropper(image, {
                                        aspectRatio: 16 / 9,
                                        crop(event) {
                                            console.log(event.detail.x);
                                            console.log(event.detail.y);
                                            console.log(event.detail.width);
                                            console.log(event.detail.height);
                                            console.log(event.detail.rotate);
                                            console.log(event.detail.scaleX);
                                            console.log(event.detail.scaleY);
                                        },
                                    });</code>
                            </pre>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Code example-->
            </div>
            <!--begin::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

