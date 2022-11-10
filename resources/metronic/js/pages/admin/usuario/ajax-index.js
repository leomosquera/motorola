'use strict';
var KTDatatablesDataSourceAjaxClient = function() {

    /** Display Errors */
    $.fn.dataTable.ext.errMode = 'none';

    /** Delay Filters */
    var
    initTable1 = function() {
        var table =
        $('#kt_datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            language: {
                processing: MyDataTable.processing(),
                sZeroRecords: MyDataTable.sZeroRecords()
            },
			ajax: {
				url: HOST_URL + '/admin/usuario/dt',
                type: 'POST',
                headers: MyHeaderAjax.csrf()
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
