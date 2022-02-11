//== Class Definition
var SnippetLogin = function() {

    var login = $('#m_login');

    var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="m-alert m-alert--outline alert alert-' + type + ' alert-dismissible" role="alert">\
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
			<span></span>\
		</div>');

        form.find('.alert').remove();
        alert.prependTo(form);
        //alert.animateClass('fadeIn animated');
        mUtil.animateClass(alert[0], 'fadeIn animated');
        alert.find('span').html(msg);
    }

    var handleSignInFormSubmit = function() {
        $('#m_login_signin_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    username: {
                        required: true
                    },
                    password: {
                        required: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('m-loader m-loader--right m-loader--light').attr('disabled', true);

            form.ajaxSubmit({
                url: form.attr('action'),
                success: function(response, status, xhr, $form) {
                    if(response.status == 1) {
                        window.location = response.url;
                    } else if(response.status == 0) {
                        showErrorMsg(form, 'danger', 'Salah nik atau password. Silakan coba lagi.');
                    }

                    btn.removeClass('m-loader m-loader--right m-loader--light').attr('disabled', false);
                }
            });
        });
    }

    //== Public Functions
    return {
        // public functions
        init: function() {
            handleSignInFormSubmit();
        }
    };
}();

//== Class Initialization
jQuery(document).ready(function() {
    SnippetLogin.init();
});