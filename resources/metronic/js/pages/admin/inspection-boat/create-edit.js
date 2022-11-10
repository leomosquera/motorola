'use strict';

// Class definition
var KTSelect2 = function() {
    // Private functions
    var inputSelect2 = function() {
        // basic
        $('[name="usuario_id"]').select2({
            placeholder: 'Seleccionar Usuario'
        });
    }

    // Public functions
    return {
        init: function() {
            inputSelect2();
        }
    };
}();

var KTBootstrapDatepicker = function () {

    var arrows;
    if (KTUtil.isRTL()) {
        arrows = {
            leftArrow: '<i class="la la-angle-right"></i>',
            rightArrow: '<i class="la la-angle-left"></i>'
        }
    } else {
        arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }

    // Private functions
    var datePickers = function () {
        // input group layout
        $('[name="date"]').datepicker({
            rtl: KTUtil.isRTL(),
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            orientation: "bottom left",
            templates: arrows
        });
    }

    return {
        // public functions
        init: function() {
            datePickers();
        }
    };
}();

var KTJqueryMask = function () {

    // private functions
    var jqueryMasks = function () {

        $('.mask-price').mask("#,##0.00", {
            reverse: true
        });

    }

    return {
        // public functions
        init: function() {
            jqueryMasks();
        }
    };
}();

var KTFormControls = function () {
	// Private functions
	var _initFormPrinc = function () {
        const form = document.getElementById('form-princ');
		FormValidation.formValidation(
			form,
			{
				fields: {
                    username: {
						validators: {
							notEmpty: {
								message: 'Username es requerido'
							},
							regexp: {
                                regexp: /^[a-zA-Z0-9_]+$/,
                                message: 'Ingrese correctamente el username'
							}
						}
                    },

					email: {
						validators: {
							notEmpty: {
								message: 'Email es requerido'
							},
							emailAddress: {
								message: 'El email ingresado no es correcto'
							}
						}
                    },

                    name: {
						validators: {
							notEmpty: {
								message: 'El nombre es requerido'
							},
							stringLength: {
								min:3,
								max:100,
								message: 'Ingrese el nombre correctamente'
							}
						}
                    },

                    lastname: {
						validators: {
							notEmpty: {
								message: 'El apellido es requerido'
							},
							stringLength: {
								min:3,
								max:100,
								message: 'Ingrese el apellido correctamente'
							}
						}
                    },

                    password: {
						validators: {
                            notEmpty: {
								message: 'Contraseña requerida'
							},
							regexp: {
                                regexp: /^[a-zA-Z0-9_.-]+$/,
                                message: 'Ingrese correctamente la contraseña'
                            },
                            stringLength: {
								min:6,
								max:20,
								message: 'Mínimo de caracteres 6 y máximo 20'
							}
						}
                    },

                    password_confirmation: {
                        validators: {
                            notEmpty: {
								message: 'Contraseña requerida'
							},
                            regexp: {
                                regexp: /^[a-zA-Z0-9_.-]+$/,
                                message: 'Ingrese correctamente la contraseña'
                            },
                            identical: {
                                compare: function() {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'La contraseña y su confimación deben ser iguales'
                            }
                        }
                    },

                    'roles[]': {
						validators: {
							choice: {
								min:1,
								message: 'Seleccionar al menos un tipo de rol de usuario'
							}
						}
					},


				},

				plugins: { //Learn more: https://formvalidation.io/guide/plugins
					trigger: new FormValidation.plugins.Trigger(),
					// Bootstrap Framework Integration
					bootstrap: new FormValidation.plugins.Bootstrap(),
					// Validate fields when clicking the Submit button
					submitButton: new FormValidation.plugins.SubmitButton(),
            		// Submit the form when all fields are valid
                    defaultSubmit: new FormValidation.plugins.DefaultSubmit(),

				}
			}
		);
	}

	return {
		// public functions
		init: function() {
			_initFormPrinc();
		}
	};
}();


var KTImageUpload = function () {// Private functions
	var _initImageUpload1 = function () {

        //Carousel Modal
        var
        imgup = $('[data-imageupload="1"]'),
        id = imgup.attr('data-imageupload'),
        carou = imgup.find('[data-carousel="true"]'),
        modal = false;
        imgup.find('[data-modal="true"]:first').attr('data-modal',id);
        modal = imgup.find('[data-modal="'+id+'"]:first');

        $(carou).find('.carousel-item:first').addClass('active');
        $(carou).carousel({
            ride: 'carousel',
            interval: false
        });
        $(imgup).on('click', '[data-modal="'+id+'"] a[data-slide]', function(){
            $(carou).carousel($(this).attr('data-slide'));
            $(carou).carousel('pause');
            return false;
        });
        $(imgup).on('click', '.btn-image-modal', function(){
            var
            item = $(this).attr('data-id');
            $(carou).find('.carousel-item').each(function (index) {
                if($(this).attr('data-id')==item){
                    $(carou).carousel(index);
                    return false;
                }
            });
            $(modal).modal('show');
            return false;
        });
        /*
            $(imgup).on('click', '.btn-image-remove', function(){
            var
            obj  = $(this),
            item = $(this).attr('data-id');
            Swal.fire(
                {
                    title: 'Desea eliminar la imagen seleccionada ?',
                    text: "Esta acción no podrá deshacerse.",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si, Eliminar!',
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonText: 'Cancelar',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                }).then(function (result){
                    if (result.value){
                        $.ajax({
                            url: obj.attr('data-route'),
                            type: 'POST',
                            headers: MyHeaderAjax.csrf(),
                            data: { id:obj.attr('data-id'), dir:'tip' },
                            error: function( msg ){
                                //alert(JSON.stringify(msg));
                                Swal.fire({
                                    type: "error",
                                    title: 'No se eliminó!',
                                    text: 'Su usuario no posee permisos para eliminar la imagen.',
                                    confirmButtonText: 'Cerrar',
                                    confirmButtonClass: 'btn btn-primary',
                                });
                            },
                            success: function( msg ) {
                                //alert(JSON.stringify(msg));
                                if(msg['response'][0]=='success'){
                                    $(carou+' .carousel-item').removeClass('active');
                                    $(carou+' .carousel-item').each(function (index) {
                                        if($(this).attr('data-id')==item){
                                            $(this).remove();
                                            return false;
                                        }
                                    });
                                    obj.parents('.image-thumb:first').remove();
                                    if($('#file-list').find('.image-thumb').length==0){
                                        $('#file-list').remove();
                                    }else{
                                        $(carou).find('.carousel-item:first').addClass('active');
                                    }
                                }
                                Swal.fire({
                                    type: msg['response'][0],
                                    title: msg['response'][1],
                                    text: msg['response'][2],
                                    confirmButtonText: 'Cerrar',
                                    confirmButtonClass: 'btn btn-success',
                                });
                            }
                        });
                    }else if (result.dismiss === Swal.DismissReason.cancel) {
                        swal.close();
                    }
                });
                return false;
        });


        //upload images
        var
        _gl  = {
            file_upload    : {
                files         : {},
                up            : false,
                up_count      : 0,
                up_ok         : 0,
                up_error      : 0,
                up_loaded     : 0,
                up_max        : 1,
                extension_msg : '( jpeg, jpg y png )',
                extension     : ['image/jpeg', 'image/jpg', 'image/png']
            }
        };

        function fileUploadListEmpty(){
            var
            msg  = '<tr><td colspan="5" class="list-empty"><div class="pt-3 pb-3">';
            msg += '<div class="dropzone dropzone-default dropzone-primary file-upload-btn"><div class="dropzone-msg dz-message needsclick"><h3 class="dropzone-msg-title">Usted puede subir archivos haciendo click aquí.</h3><span class="dropzone-msg-desc">Archivos permitidos '+ _gl.file_upload.extension_msg +'.</span></div></div>';
            msg += '</div></td></tr>';
            if($('input:file[id^="filesupload"]').length==0){
                $('.table-images tbody').append(msg);
            }
        }

        function FileListItems (files) {
            var b = new ClipboardEvent("").clipboardData || new DataTransfer()
            for (var i = 0, len = files.length; i<len; i++) b.items.add(files[i])
            return b.files
        }

        fileUploadListEmpty();

        $(document).on('click', '.btn-upload, .file-upload-btn', function(){
            $('#upload_images').val('');
            $('#upload_images').click();
        });

        $(document).on('click', '.btn-file-delete', function(){
            var
            tableTr  = $(this).parents('tr:first'),
            fileName = $(this).attr('data-name'),
            fileSize = $(this).attr('data-size');
            if($('input:file[id^="filesupload"]').length>0){
            $('input:file[id^="filesupload"]').each(function () {
                if($(this)[0].files[0].name == fileName && $(this)[0].files[0].size == fileSize){
                $(this).remove();
                tableTr.remove();
                return false;
                }
            });
            }
            fileUploadListEmpty();
            return false;
        });

        $('body').on('change', 'input[id^=upload_images]', function(event){

            var
            data           = $(this).attr('id').split('_'),
            form           = $(this).parents('form:first'),
            fileExtension  = _gl.file_upload.extension,
            fileErrorSize  = 0,
            fileErrorType  = 0,
            fileErrorExist = 0;
            //alert($(this).prop("files").length);

            if( $(this).prop("files").length + form.find('input:file[id^="filesupload"]').length <= _gl.file_upload.up_max ){
                for (var i = 0; i < $(this).prop("files").length; i++){
                    var
                    ftype      = $(this)[0].files[i].type,
                    fname      = $(this)[0].files[i].name,
                    fsize      = $(this)[0].files[i].size,
                    fsizeMB    = Math.round((fsize / 1024)),
                    files      = [],
                    file_exist = false,
                    item       = '';

                    if ($.inArray(ftype.toLowerCase(), fileExtension) == -1 || fsizeMB > 2048) {
                        if($.inArray(ftype.toLowerCase(), fileExtension) == -1)
                            fileErrorType++;
                        if(fsizeMB > 2048)
                            fileErrorSize++;
                    } else {
                        if($('input:file[id^="filesupload"]').length>0){
                            $('input:file[id^="filesupload"]').each(function () {
                                if($(this)[0].files[0].name == fname && $(this)[0].files[0].size == fsize){
                                    file_exist = true;
                                    fileErrorExist++;
                                    return false;
                                }
                            });
                        }
                        if(!file_exist){
                            form.prepend('<input type="file" name="filesupload[]" id="filesupload[]" class="d-none"/>');
                            files.push($(this)[0].files[i]);
                            form.find('input:file[id^="filesupload"]:first')[0].files = new FileListItems(files);
                            //insert item on table
                            item += '<tr>';
                            item += '<td>'+fname+'</td>';
                            item += '<td>'+ftype+'</td>';
                            item += '<td><span class="label label-inline label-light-primary font-weight-bold">Imagen</span></td>';
                            item += '<td>'+fsizeMB.toFixed(2)+' KB</td>';
                            item += '<td>';
                            item += '<a href="javascript:;" class="btn btn-icon btn-light btn-hover-primary btn-sm btn-file-delete" data-name="'+fname+'" data-size="'+fsize+'"><span class="svg-icon svg-icon-md svg-icon-primary"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path><path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path></g></svg></span></a>';
                            item += '</td>';
                            item += '</tr>';
                            if($('.table-images tbody tr td:first').attr('class')=='list-empty'){
                            $('.table-images tbody tr td:first').remove();
                            }
                            $('.table-images tbody').append(item);
                        }
                    }
                }
                if(fileErrorType || fileErrorSize){
                    Swal.fire({
                        type: 'warning',
                        title: 'Atención!',
                        html: 'Algunas imágenes no se agregaron porque superan los 2MB o el formato no es igual a <br>JPG/JPEG o PNG</b>.',
                        confirmButtonText: 'Cerrar',
                        confirmButtonColor: '#0193cf'
                    });
                }
                if(fileErrorExist){
                    Swal.fire({
                        type: 'warning',
                        title: 'Atención!',
                        html: 'Algunas imágenes no se agregaron porque ya existen.',
                        confirmButtonText: 'Cerrar',
                        confirmButtonColor: '#0193cf'
                    });
                }
            }else{
                Swal.fire({
                    type: 'warning',
                    title: 'Atención!',
                    html: 'La cantidad permitida de imágenes es de <b>'+_gl.file_upload.up_max+'</b>. Elimine imágenes o vuelva a seleccionar la cantidad permitida.',
                    confirmButtonText: 'Cerrar',
                    confirmButtonColor: '#0193cf'
                });
            }
        });
        */

    }

    var _initImageUpload2 = function () {

        //Carousel Modal
        var
        imgup = $('[data-imageupload="2"]'),
        id = imgup.attr('data-imageupload'),
        carou = imgup.find('[data-carousel="true"]'),
        modal = false;
        imgup.find('[data-modal="true"]:first').attr('data-modal',id);
        modal = imgup.find('[data-modal="'+id+'"]:first');

        $(carou).find('.carousel-item:first').addClass('active');
        $(carou).carousel({
            ride: 'carousel',
            interval: false
        });
        $(imgup).on('click', '[data-modal="'+id+'"] a[data-slide]', function(){
            $(carou).carousel($(this).attr('data-slide'));
            $(carou).carousel('pause');
            return false;
        });
        $(imgup).on('click', '.btn-image-modal', function(){
            var
            item = $(this).attr('data-id');
            $(carou).find('.carousel-item').each(function (index) {
                if($(this).attr('data-id')==item){
                    $(carou).carousel(index);
                    return false;
                }
            });
            $(modal).modal('show');
            return false;
        });

    }

    var _initImageUpload3 = function () {

        //Carousel Modal
        var
        imgup = $('[data-imageupload="3"]'),
        id = imgup.attr('data-imageupload'),
        carou = imgup.find('[data-carousel="true"]'),
        modal = false;
        imgup.find('[data-modal="true"]:first').attr('data-modal',id);
        modal = imgup.find('[data-modal="'+id+'"]:first');

        $(carou).find('.carousel-item:first').addClass('active');
        $(carou).carousel({
            ride: 'carousel',
            interval: false
        });
        $(imgup).on('click', '[data-modal="'+id+'"] a[data-slide]', function(){
            $(carou).carousel($(this).attr('data-slide'));
            $(carou).carousel('pause');
            return false;
        });
        $(imgup).on('click', '.btn-image-modal', function(){
            var
            item = $(this).attr('data-id');
            $(carou).find('.carousel-item').each(function (index) {
                if($(this).attr('data-id')==item){
                    $(carou).carousel(index);
                    return false;
                }
            });
            $(modal).modal('show');
            return false;
        });

    }

	return {
		// public functions
		init: function() {
            _initImageUpload1();
            _initImageUpload2();
            _initImageUpload3();
		}
	};
}();

jQuery(document).ready(function() {

    /** Init */
    KTSelect2.init();
    KTBootstrapDatepicker.init();
    KTJqueryMask.init();
    KTFormControls.init();
    KTImageUpload.init();

});
