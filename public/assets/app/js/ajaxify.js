var Flying = function () {

    $(window).bind('popstate', function(e) {
        var pageContentBody = $('.m-content');

        mApp.blockPage({
            overlayColor: '#000000',
            type: 'loader',
            state: 'success',
            message: 'Please wait...'
        });

        $.ajax({
            type: "GET",
            cache: false,
            url: window.location.href,
            dataType: "html",
            success: function(res) {
                pageContentBody.html(res);
                // mApp.initAjax(); // initialize core stuff
                $('.tooltip').tooltip('hide');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                pageContentBody.html(xhr.responseText);
            }
        }).always(function() {
            mApp.unblockPage();
        });
    });

    var ajaxify = [null, null, null];
    var f = function(e, ele){
        e.preventDefault();
        mApp.scrollTop();

        var url = $(ele).attr("href");
        var pageContentBody = $('.m-content');

        if(url != ajaxify[2]){
            ajaxify.push(url);
        }
        ajaxify = ajaxify.slice(-3, 5);

        mApp.blockPage({
            overlayColor: '#000000',
            type: 'loader',
            state: 'success',
            message: 'Please wait...'
        });

        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res) {
                pageContentBody.html(res);
                mApp.initAjax();
                $('.tooltip').tooltip('hide');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                pageContentBody.html(xhr.responseText);
            }
        }).always(function() {
            history.pushState(null, null, url);
            mApp.unblockPage();
        });
    };

    var ajax = function (url, data, title) {
        mApp.scrollTop();
        var pageContentBody = $('.m-content');

        title = title + ' | ' + appName;

        $('title').text(title);

        if(url != ajaxify[2]){
            ajaxify.push(url);
        }
        ajaxify = ajaxify.slice(-3, 5);

        mApp.blockPage({
            overlayColor: '#000000',
            type: 'loader',
            state: 'success',
            message: 'Please wait...'
        });

        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            data: data,
            dataType: "html",
            success: function(res) {
                $('.grid-bottom').addClass('m--hide');
                pageContentBody.html(res);
                mApp.initAjax();
                $('.tooltip').tooltip('hide');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                if(xhr.status == 401) {
                    // TODO Auth
                }

                pageContentBody.html(xhr.responseText);
            }
        }).always(function() {

            history.pushState(null, null, url);
            mApp.unblockPage();
        });
    };

    var ajaxifyMenu = function(e, ele){
        e.preventDefault();
        mApp.scrollTop();

        var url = $(ele).attr("href");
        var pageContentBody = $('.m-content');
        var title = $('span.m-menu__link-text', ele).data('title');

        title = title + ' | ' + appName;

        $('title').text(title);

        $('.m-menu__nav li.m-menu__item--active').removeClass('m-menu__item--active');
        $(ele).closest('li.m-menu__item').addClass('m-menu__item--active');

        setActiveMenu($(ele));

        function setActiveMenu(ele) {
            if(ele.closest('li.m-menu__item--submenu').length){
                var thisEle = ele.closest('li.m-menu__item--submenu');
                thisEle.addClass('m-menu__item--active');

                setActiveMenu(thisEle.parent());
            }
        }

        if(url != ajaxify[2]){
            ajaxify.push(url);
        }
        ajaxify = ajaxify.slice(-3, 5);

        mApp.blockPage({
            overlayColor: '#000000',
            type: 'loader',
            state: 'success',
            message: 'Please wait...'
        });

        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res) {
                $('.grid-bottom').addClass('m--hide');
                pageContentBody.html(res);
                mApp.initAjax();
                $('.tooltip').tooltip('hide');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                if(xhr.status == 401) {
                    // TODO Auth
                }

                pageContentBody.html(xhr.responseText);
            }
        }).always(function() {

            history.pushState(null, null, url);
            mApp.unblockPage();
        });
    };

    return {
        ajaxify: function () {
            this.initMenu();
            this.initTopMenu();
            $(document).on('click', '.m-content .ajaxify', function(e){
                f(e, this);
            });
        },

        initMenu: function () {
            $(document).on('click', '.m-menu__nav .ajaxify', function(e){
                ajaxifyMenu(e, this);
            });
        },

        initTopMenu: function () {
            $(document).on('click', '.m_header_menu .ajaxify', function(e){
                ajaxifyMenu(e, this);
            });
        },

        tabTitle: function() {
            $(document).on('click', '.nav-tabs a', function(){
                var title = $(this).data('title');
                $('#tab-title').text(title);

                var open = $(this).data('open');
                if(open == false){
                    var url = $(this).data('content');
                    var tabUrl = $(this).attr('href');
                    var ele = $(this);

                    if(url != '#' && url != ''){
                        App.blockUI();
                        $.get(url, function(html){
                            $(tabUrl).html(html);
                            mApp.unblockPage();
                            ele.data('open', 'true');
                        }).fail(function(){
                            console.log('Fail Get Content');
                            mApp.unblockPage();
                        });
                    }
                }
            })
        },

        ajax: function (url, data, title) {
            ajax(url, data, title);
        }
    };
}();