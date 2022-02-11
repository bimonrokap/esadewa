<div class="table-responsive">
    <table class="table m-table m-table--head-bg-metal table-hover table-freeze" id="table-satker" style="width: {{ count($categories) <= 2 ? '100%' : (500 + (count($categories)*420)).'px' }}; max-width: none;">
        <thead>
            <tr>
                <th rowspan="2" width="50px" class="text-center align-middle"> No  </th>
                <th rowspan="2" class="text-center align-middle"> {{ $header }} </th>
                @foreach($categories as $k => $category)
                    <th colspan="4" class="bg-primary text-center align-middle"> {{ $k }} </th>
                @endforeach
            </tr>
            <tr>
                <?php $total = []; ?>
                @foreach($categories as $k => $category)
                    <?php $total[] = 0;$total[] = 0;$total[] = 0;$total[] = 0; ?>
                    <th width="130px" class="bg-danger text-center"> Belum Lengkap </th>
                    <th width="130px" class="bg-warning text-center"> Kurang Lengkap </th>
                    <th width="80px" class="bg-success text-center"> Lengkap </th>
                    <th width="80px" class="bg-info text-center"> Total </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach($satkers as $satker)
                <tr {!! $i == 1 ? 'class="top-border-double"' : '' !!}>
                    <td scope="row" class="text-center"> {{ $i }} </td>
                    <td>
                        @if($header == 'Satker')
                        <a style="color: black" href="{{ route($config['route'].'.satker', $satker->kode) }}" class="ajaxify">{{ $satker->name }}</a>
                        @else
                            {{ $satker->name }}
                        @endif
                    </td>
                    <?php $j=0; ?>
                    @foreach($categories as $k => $category)
                        <?php $total[$j++] += $satker->{$category['data'].'_low'};$total[$j++] += $satker->{$category['data'].'_mid'};$total[$j++] += $satker->{$category['data'].'_high'};$total[$j++] += $satker->{$category['data'].'_total'}; ?>
                        <td class="text-right bg-danger-soft"> {{ numberFormatIndo($satker->{$category['data'].'_low'}) }} </td>
                        <td class="text-right bg-warning-soft"> {{ numberFormatIndo($satker->{$category['data'].'_mid'}) }} </td>
                        <td class="text-right bg-success-soft"> {{ numberFormatIndo($satker->{$category['data'].'_high'}) }} </td>
                        <td class="text-right bg-info-soft"> {{ numberFormatIndo($satker->{$category['data'].'_total'}) }} </td>
                    @endforeach
                </tr>
                <?php $i++; ?>
            @endforeach
            <tr class="top-border-double total-row">
                <td colspan="2" class="text-center font-weight-bold m--bg-metal"> Total </td>
                <?php $j=0; ?>
                @foreach($categories as $k => $category)
                    <td class="text-right bg-danger-soft"> {{ numberFormatIndo($total[$j++]) }} </td>
                    <td class="text-right bg-warning-soft"> {{ numberFormatIndo($total[$j++]) }} </td>
                    <td class="text-right bg-success-soft"> {{ numberFormatIndo($total[$j++]) }} </td>
                    <td class="text-right bg-info-soft"> {{ numberFormatIndo($total[$j++]) }} </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>
{{--<div class="table__pager m-datatable--paging-loaded clearfix">--}}
    {{--<ul class="table__pager-nav" style="float: right;">--}}
        {{--<li><a data-href="{{ route($config['route'] . '.table', 1) }}" title="First" class="table__pager-link table__pager-link--first {{ $pagination['page'] == 1 ? 'table__pager-link--disabled' : '' }}" {!! $pagination['page'] == 1 ? 'disabled="disabled"' : '' !!}><i class="la la-angle-double-left"></i></a></li>--}}
        {{--<li><a data-href="{{ route($config['route'] . '.table', $pagination['page']-1) }}" title="Previous" class="table__pager-link table__pager-link--prev {{ $pagination['page'] == 1 ? 'table__pager-link--disabled' : '' }}" {!! $pagination['page'] == 1 ? 'disabled="disabled"' : '' !!}><i class="la la-angle-left"></i></a></li>--}}
        {{--@if($pagination['page'] > $pagination['pageLimit'])--}}
        {{--<li><a data-href="{{ route($config['route'] . '.table', $pagination['first'] - 1) }}" title="More pages" class="table__pager-link table__pager-link--more-prev"><i class="la la-ellipsis-h"></i></a></li>--}}
        {{--@endif--}}

        {{--@for($i = $pagination['first'];$i <= ($pagination['first'] + 4 > $pagination['totalPage'] ? $pagination['totalPage'] : $pagination['first'] + 4);$i++)--}}
            {{--<li><a data-href="{{ route($config['route'] . '.table', $i) }}" class="table__pager-link table__pager-link-number {{ $i == $pagination['page'] ? 'table__pager-link--active' : '' }}">{{ $i }}</a></li>--}}
        {{--@endfor--}}

        {{--@if($pagination['page'] < ($pagination['totalPage'] - $pagination['pageLimit']))--}}
            {{--<li><a data-href="{{ route($config['route'] . '.table', $pagination['first'] + 5) }}" title="More pages" class="table__pager-link table__pager-link--more-next" ><i class="la la-ellipsis-h"></i></a></li>--}}
        {{--@endif--}}
        {{--<li><a data-href="{{ route($config['route'] . '.table', $pagination['first']+1) }}" title="Next" class="table__pager-link table__pager-link--next {{ $pagination['page'] == $pagination['totalPage'] ? 'table__pager-link--disabled' : '' }}" {!! $pagination['page'] == $pagination['totalPage'] ? 'disabled="disabled"' : '' !!}><i class="la la-angle-right"></i></a></li>--}}
        {{--<li><a data-href="{{ route($config['route'] . '.table', $pagination['totalPage']) }}" title="Last" class="table__pager-link table__pager-link--last {{ $pagination['page'] == $pagination['totalPage'] ? 'table__pager-link--disabled' : '' }}" {!! $pagination['page'] == $pagination['totalPage'] ? 'disabled="disabled"' : '' !!}><i class="la la-angle-double-right"></i></a></li>--}}
    {{--</ul>--}}
{{--</div>--}}