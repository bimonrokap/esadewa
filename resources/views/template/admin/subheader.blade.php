@if(isset($config['breadcrumb']))
    <div class="m-subheader ">
        <div class="row">
            <div class="col-md-6">
                <h3 class="m-subheader__title ">
                    {{ $config["pageTitle"] }}
                </h3>
            </div>
            <div class="col-md-6">
                <div class="breadcrumbs-top float-md-right">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            @foreach($config['breadcrumb'] as $k => $v)
                                <li class="breadcrumb-item"><a class="{{ $v == null ? 'javascript:;' : 'ajaxify' }}" href="{{ $v == null ? 'javascript:;' : $v }}">{{ $k }}</a></li>
                                @endforeach
                                </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif