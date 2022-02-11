<div class="m-portlet__head-tools">
    @permission('import-asset')
    <ul class="m-portlet__nav">
        <li class="m-portlet__nav-item">
            <button type="button" class="m-portlet__nav-link btn btn-success m-btn btn-sm m-btn--icon"  data-toggle="modal" data-target="#modalImport">
                <i class="la la-upload"></i> Import Data
            </button>
        </li>
    </ul>
    @endpermission
    <ul class="m-portlet__nav">
        <li class="m-portlet__nav-item">
            <a href="{{ route('admin.asset.export', $importSlug) }}" class="m-portlet__nav-link btn btn-info m-btn btn-sm m-btn--icon btn-export">
                <i class="la la-download"></i> Export Data
            </a>
        </li>
    </ul>
</div>


@push('scripts')

    <script type="text/javascript">
        var table;
        var tableFilter = {};
        var tableFilterString = '';
        $(document).ready(function () {
            $('.select2').select2({dropdownCssClass: "select2-sm"});

            $('.btn-export').click(function () {
                var url = $(this).attr('href');

                var add = '';
                if(tableFilterString != '') {
                    add += '?'+tableFilterString;
                }

                let columns = table.table().ajax.params().columns;
                var param = [];
                $.each(columns, function (index, value) {
                    if(value.search.value.length !== 0) {
                        param.push('f_'+value.data + '=' +value.search.value);
                    }
                });
                param = param.join('&');
                if(param !== '') {
                    if(add != '') {
                        add += '&'+param;
                    } else {
                        add += '?'+param;
                    }
                }

                window.location = url+add;

                return false;
            });

            $('select.filter').change(function () {
                if($(this).val() !== '') {
                    $(this).closest('.input-group').addClass('filtered');
                } else {
                    $(this).closest('.input-group').removeClass('filtered');
                }

                let $select = $('select.filter');
                tableFilter = $select.serializeArray();
                tableFilterString = $select.serialize();

                if(typeof table !== 'undefined'){
                    table.table().draw()
                }
            });
        });
    </script>
    @endpush