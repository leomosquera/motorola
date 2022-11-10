"use strict";

jQuery(function($) {
    /** global */
    var
    MyHeaderAjax,
    MyToastr,
    MyCroppie,
    MyURL;

    MyHeaderAjax = {
        csrf: function() {
            return {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
        }
    };

    MyToastr = {
        defaultByType:function(type, title, desc) {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            switch (type) {
                case 'success':
                    toastr.success(desc, title);
                break;
                case 'error':
                    toastr.error(desc, 'Error');
                break;
            }
        },
        defaultAjaxError: function(msg) {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr.error(msg, 'Error');
        }
    };

    MyCroppie = {
        'preview' : 'Atux',
        'new'     : '',
        'info'    : ''
    };

    MyURL = {
        getUrlParameter : function(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        },
        getUrlParamReturnBlank : function(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return '';
        }
    };

    /** globals */
    window.MyHeaderAjax = MyHeaderAjax;
    window.MyToastr     = MyToastr;
    window.MyCroppie    = MyCroppie;
    window.MyURL        = MyURL;

})(window, document, jQuery);
