var Usulan = function() {

	return {
		//main function to initiate the module
		proses: function(options) {
            options = $.extend({
                table: "",
                modalId: ""
            }, options);

            $(options.table).on('click', '.btn-proses', function () {
                var modal = $(options.modalId);
                var url = $(this).data('url');
                $.get(url, function (html) {
                    $('.modal-content', modal).html(html);
                    modal.modal('show');
                });
            });
        },

		verif: function(options) {
            options = $.extend({
                table: "",
                modalId: ""
            }, options);

            $(options.table).on('click', '.btn-verif', function () {
                var modal = $(options.modalId);
                var url = $(this).data('url');
                $.get(url, function (html) {
                    $('.modal-content', modal).html(html);
                    modal.modal('show');
                });
            });
        },

        next: function (options) {
            options = $.extend({
                table: "",
                modalId: ""
            }, options);

            $(options.table).on('click', '.btn-next', function () {
                var modal = $(options.modalId);
                var url = $(this).data('url');
                $.get(url, function (html) {
                    $('.modal-content', modal).html(html);
                    modal.modal('show');
                });
            });
        },

        doc: function (options) {
            options = $.extend({
                table: "",
                modalId: ""
            }, options);

            $(options.table).on('click', '.btn-doc', function () {
                var modal = $(options.modalId);
                var url = $(this).data('url');
                $.get(url, function (html) {
                    $('.modal-content', modal).html(html);
                    modal.modal('show');
                });
            });
        }
	};

}();