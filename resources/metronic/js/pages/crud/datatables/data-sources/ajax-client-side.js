'use strict';
var KTDatatablesDataSourceAjaxClient = function() {

    /** Display Errors */
    $.fn.dataTable.ext.errMode = 'none';

    /** Ajax CSRF **/
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /** Delay Filters */
    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    }

    var
    timeDelay = 1000,
    initTable1 = function() {
        var table =
        $('#kt_datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            language: {
                processing: '<div class="spinner-border text-custom" style="width: 3rem; height:3rem; position: absolute; top: 50%; margin-top: -1.5rem;"></div>',
                sZeroRecords: '<div class="alert alert-danger alert-light-danger fade show mb-5" role="alert"><div class="alert-icon"><div class="alert-text">No se encontraron resultados!</div></div>'
            },
			ajax: {
				url: HOST_URL + '/admin/usuario/dt',
                type: 'POST'
			},
			columns: [
				{ sTitle: 'ID', data: 'id', sWidth: '50px' },
                { sTitle: 'Email', data: 'email' },
                { sTitle: 'Nombre y Apellido', data: 'namelastname' },
                { sTitle: 'Roles', data: 'roles', render: function (roles) {
                    var res = '';
                    $.each(roles.split(','), function( index, value ) {
                        res += '<span class="label label-dark label-inline mr-2">'+value+'</span>';
                    });
                    return res;
                  }
                },
                { sTitle: 'Logueos', data: 'history_logged', sWidth: '80px' },
                { sTitle: 'Contraseña', data: 'password_changed_status', orderable: false, sWidth: '80px' },
                { sTitle: 'Acción', data: 'action', orderable: false, sWidth: '80px', sClass: 'ico-l-action' }
            ],
            initComplete : function() {
                /* searchdefault */
                $(".dataTables_filter input")
                .unbind()
                .bind('keyup', delay(function(e) {
                    table
                    .search(this.value)
                    .draw();
                },timeDelay));

                /* inicializo luego de la carga */
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
