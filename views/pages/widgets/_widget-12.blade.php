{{-- List Widget 8 --}}


<div class="card card-custom {{ @$class }}">
    <!--begin::Body-->
    <div class="card-body">
        <!--begin::Nav Tabs-->
        <ul class="dashboard-tabs nav nav-pills nav-custom row row-paddingless m-0 p-0 flex-column flex-sm-row" role="tablist">
            <!--begin::Item-->
            <li class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                <a href="{{ route('usuario') }}" class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center">
                    <span class="nav-icon py-2 w-auto">
                        <span class="svg-icon svg-icon-3x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                    <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                </g>
                            </svg>
                        </span>
                    </span>
                    <span class="nav-text font-size-lg py-2 font-weight-bold text-center">Usuarios</span>
                </a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                <a href="{{ route('advice') }}" class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center">
                    <span class="nav-icon py-2 w-auto">
                        <span class="svg-icon svg-icon-3x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M9,10 L9,19 L10.1525987,19.3841996 C11.3761964,19.7920655 12.6575468,20 13.9473319,20 L17.5405883,20 C18.9706314,20 20.2018758,18.990621 20.4823303,17.5883484 L21.231529,13.8423552 C21.5564648,12.217676 20.5028146,10.6372006 18.8781353,10.3122648 C18.6189212,10.260422 18.353992,10.2430672 18.0902299,10.2606513 L14.5,10.5 L14.8641964,6.49383981 C14.9326895,5.74041495 14.3774427,5.07411874 13.6240179,5.00562558 C13.5827848,5.00187712 13.5414031,5 13.5,5 L13.5,5 C12.5694044,5 11.7070439,5.48826024 11.2282564,6.28623939 L9,10 Z" fill="#000000"/>
                                    <rect fill="#000000" opacity="0.3" x="2" y="9" width="5" height="11" rx="1"/>
                                </g>
                            </svg>
                        </span>
                    </span>
                    <span class="nav-text font-size-lg py-2 font-weight-bolder text-center">Insp. Autos</span>
                </a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                <a href="{{ route('tip') }}" class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center">
                    <span class="nav-icon py-2 w-auto">
                        <span class="svg-icon svg-icon-3x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <circle fill="#000000" opacity="0.3" cx="12" cy="9" r="8"/>
                                    <path d="M14.5297296,11 L9.46184488,11 L11.9758349,17.4645458 L14.5297296,11 Z M10.5679953,19.3624463 L6.53815512,9 L17.4702704,9 L13.3744964,19.3674279 L11.9759405,18.814912 L10.5679953,19.3624463 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                    <path d="M10,22 L14,22 L14,22 C14,23.1045695 13.1045695,24 12,24 L12,24 C10.8954305,24 10,23.1045695 10,22 Z" fill="#000000" opacity="0.3"/>
                                    <path d="M9,20 C8.44771525,20 8,19.5522847 8,19 C8,18.4477153 8.44771525,18 9,18 C8.44771525,18 8,17.5522847 8,17 C8,16.4477153 8.44771525,16 9,16 L15,16 C15.5522847,16 16,16.4477153 16,17 C16,17.5522847 15.5522847,18 15,18 C15.5522847,18 16,18.4477153 16,19 C16,19.5522847 15.5522847,20 15,20 C15.5522847,20 16,20.4477153 16,21 C16,21.5522847 15.5522847,22 15,22 L9,22 C8.44771525,22 8,21.5522847 8,21 C8,20.4477153 8.44771525,20 9,20 Z" fill="#000000"/>
                                </g>
                            </svg>
                        </span>
                    </span>
                    <span class="nav-text font-size-lg py-2 font-weight-bolder text-center">Tips del día</span>
                </a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                <a href="{{ route('test') }}" class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center">
                    <span class="nav-icon py-2 w-auto">
                        <span class="svg-icon svg-icon-3x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"/>
                                    <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000"/>
                                    <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
                                </g>
                            </svg>
                        </span>
                    </span>
                    <span class="nav-text font-size-lg py-2 font-weight-bolder text-center">Tests</span>
                </a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0">
                <a href="{{ route('policy') }}" class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center">
                    <span class="nav-icon py-2 w-auto">
                        <span class="svg-icon svg-icon-3x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"/>
                                    <path d="M14.5,11 C15.0522847,11 15.5,11.4477153 15.5,12 L15.5,15 C15.5,15.5522847 15.0522847,16 14.5,16 L9.5,16 C8.94771525,16 8.5,15.5522847 8.5,15 L8.5,12 C8.5,11.4477153 8.94771525,11 9.5,11 L9.5,10.5 C9.5,9.11928813 10.6192881,8 12,8 C13.3807119,8 14.5,9.11928813 14.5,10.5 L14.5,11 Z M12,9 C11.1715729,9 10.5,9.67157288 10.5,10.5 L10.5,11 L13.5,11 L13.5,10.5 C13.5,9.67157288 12.8284271,9 12,9 Z" fill="#000000"/>
                                </g>
                            </svg>
                        </span>
                    </span>
                    <span class="nav-text font-size-lg py-2 font-weight-bolder text-center">Pólizas</span>
                </a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-0 mb-3 mb-lg-0">
                <a href="{{ route('message') }}" class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center">
                    <span class="nav-icon py-2 w-auto">
                        <span class="svg-icon svg-icon-3x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M14.4862 18L12.7975 21.0566C12.5304 21.54 11.922 21.7153 11.4386 21.4483C11.2977 21.3704 11.1777 21.2597 11.0887 21.1255L9.01653 18H5C3.34315 18 2 16.6569 2 15V6C2 4.34315 3.34315 3 5 3H19C20.6569 3 22 4.34315 22 6V15C22 16.6569 20.6569 18 19 18H14.4862Z" fill="black"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6 7H15C15.5523 7 16 7.44772 16 8C16 8.55228 15.5523 9 15 9H6C5.44772 9 5 8.55228 5 8C5 7.44772 5.44772 7 6 7ZM6 11H11C11.5523 11 12 11.4477 12 12C12 12.5523 11.5523 13 11 13H6C5.44772 13 5 12.5523 5 12C5 11.4477 5.44772 11 6 11Z" fill="black"/>
                                </g>
                            </svg>
                        </span>
                    </span>
                    <span class="nav-text font-size-lg py-2 font-weight-bolder text-center">Mensajes</span>
                </a>
            </li>
            <!--end::Item-->
        </ul>
        <!--end::Nav Tabs-->
        <!--begin::Nav Content-->
        <div class="tab-content m-0 p-0">
            <div class="tab-pane active" id="forms_widget_tab_1" role="tabpanel"></div>
            <div class="tab-pane" id="forms_widget_tab_2" role="tabpanel"></div>
            <div class="tab-pane" id="forms_widget_tab_3" role="tabpanel"></div>
            <div class="tab-pane" id="forms_widget_tab_4" role="tabpanel"></div>
            <div class="tab-pane" id="forms_widget_tab_6" role="tabpanel"></div>
        </div>
        <!--end::Nav Content-->
    </div>
    <!--end::Body-->
</div>
