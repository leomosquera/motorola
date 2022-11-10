// Class definition
var KTFormControls = function () {
	// Private functions
	var _initForm = function () {
		FormValidation.formValidation(
			document.getElementById('form_login'),
			{
				fields: {
					email: {
						validators: {
							notEmpty: {
								message: 'Email requerido.'
							},
							emailAddress: {
								message: 'El email ingresado es incorrecto.'
							}
						}
					},

					password: {
						validators: {
							notEmpty: {
								message: 'Contraseña requerida.'
							},
							stringLength: {
								min:4,
								max:30,
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
			_initForm();
		}
	};
}();

jQuery(document).ready(function() {
	KTFormControls.init();
});
