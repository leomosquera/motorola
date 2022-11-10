"use strict";

jQuery(function($) {
    /** global */
    var
    dtTables = [],
    MyDataTable;

    MyDataTable = {
        processing : function(callback, ms) {
            return '<div class="spinner-border text-custom" style="width: 3rem; height:3rem; position: absolute; top: 50%; margin-top: -1.5rem;"></div>';
        },
        sZeroRecords : function(callback, ms) {
            return '<div class="alert alert-danger alert-light-danger fade show mb-5" role="alert"><div class="alert-icon"><div class="alert-text">No se encontraron resultados!</div></div>';
        },
        delay : function(callback, ms) {
            var timer = 0;
            return function() {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                    callback.apply(context, args);
                }, ms || 0);
            };
        },
        delayTime: function() {
            return 1000;
        },
        rowStatus : function(obj, table) {
            var
            status = 0;
            if (obj.is(':checked'))
                status = 1;
            else
                status = 0;
            $.ajax({
                url: obj.attr('data-route'),
                type: 'POST',
                headers: MyHeaderAjax.csrf(),
                data: { id:obj.attr('data-id'), status: status },
            error: function( msg ){
                //alert( JSON.stringify(msg) );
                MyToastr.defaultAjaxError(msg);
            },
            success: function( msg ) {
                //alert( JSON.stringify(msg) );
                MyToastr.defaultByType(msg['response'][0],'Modificación correcta!', 'Se modificó el usuario seleccionado.');
            }
            });
        },
        reload : function(obj, table) {
            table.draw();
        },
        rowRemove: function(obj, table, route = false) {
            $('[data-toggle="tooltip"]').tooltip('dispose');
            Swal.fire({
                title: obj.attr('data-question'),
                text: 'Esta acción no podrá deshacerse.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        url: obj.attr('data-route'),
                        type: 'POST',
                        headers: MyHeaderAjax.csrf(),
                        data: { id:obj.attr('data-id') },
                        error: function( msg ){
                            //alert( JSON.stringify(msg) );
                            MyToastr.defaultAjaxError(msg);
                        },
                        success: function( msg ) {
                            //alert( JSON.stringify(msg) );
                            table.draw();
                            Swal.fire({
                                type: msg['response'][0],
                                title: msg['response'][1],
                                text: msg['response'][2],
                                confirmButtonText: 'Cerrar',
                                confirmButtonClass: 'btn btn-'+(msg['response'][0]=='success'?'success':'primary'),
                            });
                        }
                    });
                }
                else if (result.dismiss === Swal.DismissReason.cancel) {
                    swal.close();
                    setTimeout(function(){
                        $('[data-toggle="tooltip"]').tooltip();
                    }, 500);
                }
            });
        }
    };

    window.MyDataTable = MyDataTable;

})(window, document, jQuery);
