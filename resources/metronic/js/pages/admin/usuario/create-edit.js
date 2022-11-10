'use strict';

var KTBootstrapSwitch = function() {
    // Private functions
    var switchs = function() {
        // minimum setup
        $('[data-switch=true]').bootstrapSwitch();
    };

    return {
        // public functions
        init: function() {
            switchs();
        }
    };
}();

var KTCroppie = function() {

    var croppieAvatar = function() {
        // minimum setup
        MyCroppie.new= false;
        MyCroppie.preview = $('#image-preview').croppie({
            enableExif:true,
            viewport:{
                width:200,
                height:200,
                type:'square'
            },
            boundary:{
                width:200,
                height:200
            }
        });
    };

    return {
        // public functions
        init: function() {
            croppieAvatar();
        }
    };

}();

// Class definition
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

                    excluded: new FormValidation.plugins.Excluded({
                        excluded: function(field, ele, eles) {
                            const passChangeConfirm = form.querySelector('[name="password_change_confirm"]');

                            return (field === 'password' && passChangeConfirm !== null && passChangeConfirm.checked === false) || (field === 'password_confirmation' && passChangeConfirm !== null && passChangeConfirm.checked === false);
                        },
                    })
				}
			}
		).on('core.form.validating', function() {
            // Send the form data to back-end
            // You need to grab the form data and create an Ajax request to send them
            /** croppie */
            if(MyCroppie.new){
                MyCroppie.preview.croppie('result', {
                    type:'canvas',
                    size:{ width: 512, height: 512 }
                }).then(function(response){
                    $('input[name=image_up]').val(response);
                });
            }

        });
	}



	return {
		// public functions
		init: function() {
			_initFormPrinc();
		}
	};
}();

jQuery(document).ready(function() {

    /** Init */
    KTBootstrapSwitch.init();
    KTCroppie.init();
    KTFormControls.init();

    /** croppie upload image */
    $('.croppie-upload-msg').css({
        'width': $('#image-preview').find('div[aria-dropeffect]:first').width(),
        'height': $('#image-preview').find('div[aria-dropeffect]:first').height(),
        'left': '50%',
        'margin-left': '-' + ($('#image-preview').find('div[aria-dropeffect]:first').width()/2) + 'px',
    });

    $('input[name=upload_image]').change(function(){
    var
        content = $(this).parent('a:first'),
        reader = new FileReader();
        $('.croppie-upload-msg').empty().html('<div class="spinner-border text-secondary m-auto" role="status"><span class="sr-only">Loading...</span></div>');
        MyCroppie.new= true;
        reader.onload = function(event){
            MyCroppie.preview.croppie('bind', {
            url:event.target.result
            }).then(function(){
            content.find('input[name=image_delete]:first').val(0);
            $('.croppie-upload-msg').removeClass('d-flex').addClass('d-none');
            });
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('.file-delete').on('click', function () {
        var content = $(this).parent('div:first');
        content.find('input[name=image_delete]:first').val(1);
        $('.croppie-upload-msg').empty().html(
            '<p><i class="la la-photo"></i><br>Subir Imagen</p>'
        );
        $('.croppie-upload-msg').removeClass('d-none').addClass('d-flex');
    });

});
