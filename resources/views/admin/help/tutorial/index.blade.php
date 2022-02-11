@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                <div class="page-title">
                                    <a class="title active" href="{{ route($config['route'] . '.show', 0) }}">
                                        {{ $config['pageTitle'] }}
                                    </a>
                                </div>
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            @permission('create-' . $config['permission'])
                            <li class="m-portlet__nav-item">
                                <a href="{{ route($config['route'] . '.data') }}" class="btn btn-primary m-btn m-btn--icon ajaxify">
                                    <span>
                                        <i class="la la-plus"></i>
                                        <span> Edit {{ $config['pageTitle'] }} </span>
                                    </span>
                                </a>
                            </li>
                            @endpermission
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body" style="min-height: 600px;">
                    <div class="row con-document">
                        @include('admin.help.tutorial.show')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tooltips').tooltip();
            $('.con-document').on('click', 'a.folder', function () {
                let ele = $(this);
                showDoc(ele, 'push');
                return false;
            });

            $('.page-title').on('click', '.title', function () {
                let ele = $(this);
                showDoc(ele, 'back');
                return false;
            });

            function showDoc(ele, type) {
                mApp.block('.m-portlet__body', {
                    type: 'loader',
                    state: 'success',
                    message: 'Please wait...'
                });

                let url = ele.attr('href');
                $.get(url, function (html) {
                    $('.con-document').html(html);

                    setupBackButton(ele, type);
                    mApp.unblock('.m-portlet__body');
                    $('.tooltip').remove();
                    $('.tooltips').tooltip();
                });
            }

            function setupBackButton(ele, type) {
                if(type === 'push') {
                    let name = $('.doc-filename', ele).text();
                    let id = ele.data('id');
                    let html = `<a class="title active" href="{{ route($config['route'] . '.show') }}/`+id+`">
                        <i class="fa fa-chevron-right"></i> `+name+`
                    </a>`;

                    $('.page-title .title.active').removeClass('active');
                    $('.page-title').append(html);
                } else {
                    ele.addClass('active');
                    ele.nextAll().remove();
                }
            }
        });
    </script>
@endpush