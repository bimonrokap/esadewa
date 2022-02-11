var FormValidation = function () {

    var validate = function(options, customCallback){

        options = $.extend(true, {
            form : "#form",
            message : {},
            rules : {},
            data : {},
            dataType : 'json',
            modal: ''
        }, options);

        var alertDanger = $('.alert-validation', options.form);
        var alertError = $('.alert-error', options.form);
        var alertValidation = $('.alert-validation-backend', options.form);

        $(options.form).validate({
            // define validation rules
            rules: options.rules,
            messages: options.message,

            //display error alert on form submit
            invalidHandler: function(event, validator) {
                alertDanger.removeClass('m--hide').show();
                mApp.scrollTo(alertDanger, -200);
            },

            highlight: function(element) { // hightlight error inputs
                var group = $(element).closest('.m-form__group-sub').length > 0  ? $(element).closest('.m-form__group-sub') : $(element).closest('.m-form__group');

                group.addClass('has-danger'); // set error class to the control groupx
            },

            submitHandler: function (form) {
                alertDanger.hide();
                alertError.hide();
                alertValidation.hide();

                mApp.block(options.form, {
                    overlayColor: '#000000',
                    type: 'loader',
                    state: 'success',
                    message: 'Please wait...'
                });

                var optionsAjax = {
                    data:           options.data,
                    dataType:       options.dataType,
                    success:        typeof customCallback !== "undefined" ? customCallback : callback_form, // Callback jika form success
                    error:          callback_error // Callback jika form error
                };

                $(options.form).ajaxSubmit(optionsAjax);
            }
        });

        function callback_error(xhr, statusText, thrown){
            var message = 'Something Went Wrong!';
            alertError.removeClass('m--hide').show();

            if(xhr.status === 419) {
                message = 'Form Expired, refresh (F5) halaman dan coba lagi.';
            }

            $('.m-alert__text', alertError).text(message);
            mApp.unblock(options.form);
        }

        function callback_form(res, statusText, xhr, form) // Callback form success
        {
            if(res.status == 1){ // Jika respond status bernilai benar

                var reload = $('#reload', form);
                if(reload.length) {
                    var url = reload.attr('href');
                    if(reload.hasClass('ajaxify')) {
                        if(options.modal !== '') {
                            $(options.modal).modal('hide').on('hidden.bs.modal', function () {
                                reload.trigger('click');
                            });
                        } else {
                            reload.trigger('click');
                        }
                    } else {
                        window.location = url;
                    }
                }

                var content = {};
                content.message = res.message;
                content.title = 'Success';
                content.icon = 'icon la la-check';

                $.notify(content, {
                    type: "success",
                    allow_dismiss: true,
                    timer: 1000,
                    delay: 3000,
                    animate: {
                        enter: 'animated bounceIn',
                        exit: 'animated bounceOut'
                    }
                });
            }else if(res.status == 0){ // Error Gagal
                alertError.removeClass('m--hide').show();
                $('.m-alert__text', alertError).html(res.message);
                mApp.scrollTo(alertError, -200);
            }else if(res.status == 2) { // Error Validasi
                alertValidation.removeClass('m--hide').show();
                $('.m-alert__text', alertValidation).html(res.message);
                mApp.scrollTo(alertValidation, -200);
            }

            mApp.unblock(options.form);
        }
    };

    return {
        //main function to initiate the module
        init: function (options, customCallback) {
            validate(options, customCallback)
        }

    };

}();