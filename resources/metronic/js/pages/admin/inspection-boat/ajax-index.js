'use strict';
var KTDatatablesDataSourceAjaxClient = function() {

    /** Display Errors */
    $.fn.dataTable.ext.errMode = 'none';

    /** Columns Titles */
    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });

    /** Delay Filters */
    var
    initTable1 = function() {
        var table =
        $('#kt_datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            dom: `<'row'<'col-sm-12'tr>>
            <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            language: {
                processing: MyDataTable.processing(),
                sZeroRecords: MyDataTable.sZeroRecords()
            },
			ajax: {
				url: HOST_URL + '/admin/inspection/boat/dt',
                type: 'POST',
                headers: MyHeaderAjax.csrf()
			},
			columns: [
                { sTitle: 'ID', data: 'id', sWidth: '50px' },
                { sTitle: 'Perfil', data: 'profile', sWidth: '75px', render: function (data)
                    {
                        var profile = {
                            0 : {
                                'title': 'SIN PERFIL',
                                'class': 'label-gray'
                            },
                            1 : {
                                'title': 'ASEGURADO',
                                'class': 'label-success'
                            },
                            2 : {
                                'title': 'TALLER',
                                'class': 'label-warning'
                            }
                        };

                        if (typeof profile[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="label ' + profile[data].class + ' label-inline mr-2">' + profile[data].title + '</span>';
                    }
                },
                { sTitle: 'Nombre', data: 'name' },
                { sTitle: 'Tipo', data: 'type_name', sWidth: '75px' },
                { sTitle: 'Estado', data: 'status', sWidth: '75px', render: function (data) {
                        var status = {
                            'EN PROCESO': {
                                'title': 'EN PROCESO',
                                'class': 'label-gray'
                            }
                        };

                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="label ' + status[data].class + ' label-inline mr-2">' + status[data].title + '</span>';
                    }
                },
                { sTitle: 'Rey', data: 'rey' },
                { sTitle: 'Fecha', data: 'date_take', sWidth: '75px' },
                { sTitle: 'Acción', data: 'action', orderable: false, sWidth: '90px', sClass: 'ico-l-action' }
            ],
            searchCols: [
                null,
                null,
                null,
                null,
                null,
                { search: MyURL.getUrlParamReturnBlank('search') },
                null,
                null
            ],
            order: [[ 0, 'desc' ]],
            initComplete : function() {
                /* searchdefault */
                $(".dataTables_filter input")
                .unbind()
                .bind('keyup', MyDataTable.delay(function(e) {
                    table
                    .search(this.value)
                    .draw();
                },MyDataTable.delayTime()));

                /* inicializo tooltips */
                KTApp.initTooltips();

                /* acciones */
                $(document).on('change', 'table [data-action=status]', function(){
                    MyDataTable.rowStatus($(this),table);
                });

                $(document).on('click', 'table [data-action=delete]', function(){
                    MyDataTable.rowRemove($(this),table);
                });

                /* filters */
                var thisTable = this;
                var rowFilter = $('<tr class="filter"></tr>').appendTo($(table.table().header()));

                this.api().columns().every(function() {
                    var column = this;
                    var input;

                    switch (column.title()) {
                        case 'ID':
                        case 'Nombre':
                            input = $(`<input type="text" class="form-control form-control-sm form-filter datatable-input" data-col-index="` + column.index() + `"/>`);
                        break;
                        case 'Rey':
                            input = $(`<input type="text" value="` + MyURL.getUrlParamReturnBlank('search') + `" class="form-control form-control-sm form-filter datatable-input" data-col-index="` + column.index() + `"/>`);
                        break;
                        case 'Tipo':
                            var status = {
                                'VELERO': {
                                    'title': 'Velero',
                                    'class': 'label-light-primary'
                                },
                                'LANCHA / SEMI-RIGIDO': {
                                    'title': 'Lancha / Semi-rigido',
                                    'class': ' label-light-danger'
                                },
                                'CRUCERO': {
                                    'title': 'Crucero',
                                    'class': ' label-light-danger'
                                }
                            };
                            input = $(`<select class="form-control form-control-sm form-filter datatable-input" title="Select" data-col-index="` + column.index() + `">
										<option value="">Elegir</option></select>`);
                            column.data().unique().sort().each(function(d, j) {
                                $(input).append('<option value="' + d + '">' + status[d].title + '</option>');
                            });
                        break;
                        case 'Perfil':
                            var profile = {
                                0 : {
                                    'title': 'SIN PERFIL',
                                    'class': 'label-gray'
                                },
                                1 : {
                                    'title': 'ASEGURADO',
                                    'class': 'label-success'
                                },
                                2 : {
                                    'title': 'TALLER',
                                    'class': 'label-warning'
                                }
                            };
                            input = $(`<select class="form-control form-control-sm form-filter datatable-input" title="Select" data-col-index="` + column.index() + `">
										<option value="">Elegir</option></select>`);
                            column.data().unique().sort().each(function(d, j) {
                                $(input).append('<option value="' + d + '">' + profile[d].title + '</option>');
                            });
                        break;
                        case 'Estado':
                            var status = {
                                'EN PROCESO': {
                                    'title': 'EN PROCESO',
                                    'class': 'label-light-primary'
                                },
                                'PROCESADA': {
                                    'title': 'PROCESADA',
                                    'class': ' label-light-danger'
                                }
                            };
                            input = $(`<select class="form-control form-control-sm form-filter datatable-input" title="Select" data-col-index="` + column.index() + `">
										<option value="">Elegir</option></select>`);
                            column.data().unique().sort().each(function(d, j) {
                                $(input).append('<option value="' + d + '">' + status[d].title + '</option>');
                            });
                        break;
                        case 'Fecha':
                            input = $(`<input type="text" class="form-control form-control-sm datatable-input" readonly placeholder="Fecha" id="kt_datepicker_1"
    								 data-col-index="` + column.index() + `"/>`);
                            break;
                        break;
                        case 'Acción':
                            var search = $(`
                                <button class="btn btn-primary kt-btn btn-sm kt-btn--icon">
							        <span>
							            <i class="la la-search pr-0"></i>
							        </span>
							    </button>`);

                            var reset = $(`
                                <button class="btn btn-secondary kt-btn btn-sm kt-btn--icon mt-0 ml-1">
							        <span>
							           <i class="la la-close pr-0"></i>
							        </span>
							    </button>`);

                            $('<th>').append(search).append(reset).appendTo(rowFilter);

                            $(search).on('click', function(e) {
                                e.preventDefault();
                                var params = {};
                                $(rowFilter).find('.datatable-input').each(function() {
                                    var i = $(this).data('col-index');
                                    if (params[i]) {
                                        params[i] += '|' + $(this).val();
                                    } else {
                                        params[i] = $(this).val();
                                    }
                                });
                                $.each(params, function(i, val) {
                                    // apply search params to datatable
                                    table.column(i).search(val ? val : '', false, false);
                                });
                                table.table().draw();
                            });

                            $(reset).on('click', function(e) {
                                e.preventDefault();
                                $(rowFilter).find('.datatable-input').each(function(i) {
                                    $(this).val('');
                                    table.column($(this).data('col-index')).search('', false, false);
                                });
                                table.table().draw();
                            });
                        break;
                    }

                    if (column.title() !== 'Acción') {
                        $(input).appendTo($('<th>').appendTo(rowFilter));
                    }
                });

                // hide search column for responsive table
                var hideSearchColumnResponsive = function() {
                    thisTable.api().columns().every(function() {
                        var column = this
                        if (column.responsiveHidden()) {
                            $(rowFilter).find('th').eq(column.index()).show();
                        } else {
                            $(rowFilter).find('th').eq(column.index()).hide();
                        }
                    })
                };

                // init on datatable load
                hideSearchColumnResponsive();
                // recheck on window resize
                window.onresize = hideSearchColumnResponsive;
                // datepicker
                $('#kt_datepicker_1').datepicker({
                    format: 'dd/mm/yyyy',
                    todayHighlight: true,
                    orientation: "bottom left",
                });
                // init url
                history.replaceState(null, "", location.href.split("?")[0]);
            },
            drawCallback: function( settings ) {
                /* inicializo tooltips */
                KTApp.initTooltips();
            }
		});
	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

jQuery(document).ready(function() {
    /** Init */
    KTDatatablesDataSourceAjaxClient.init();
});
