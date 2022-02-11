<table class="table m-table m-table--head-bg-metal table-hover">
    <thead>
    <tr>
        <th rowspan="2" width="50px" class="text-center align-middle"> No  </th>
        <th rowspan="2" class="text-center align-middle"> {{ $table['header'] }} </th>
        <th colspan="3" class="text-center m--bg-brand">Kelengkapan Data Asset</th>
        <th rowspan="2" width="80px" class="bg-info text-center align-middle"> Total </th>
    </tr>
    <tr>
        <th width="130px" class="bg-danger text-center"> Belum Lengkap </th>
        <th width="130px" class="bg-warning text-center"> Kurang Lengkap </th>
        <th width="80px" class="bg-success text-center"> Lengkap </th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; $totLow=0;$totMid=0;$totHigh=0;$tot=0;?>
    @foreach($datas as $k => $data)
        <tr {!! $i == 1 ? 'class="top-border-double"' : '' !!}>
            <td scope="row" class="text-center"> {{ $i }} </td>
            <td>
                @if(isset($request['display']))
                    @switch($request['display'])
                        @case('satker')
                        <a href="{{ route($config['route'] . '.satker.asset', ['satker' => $data->kode, 'asset' => $asset->data, 'filter' => $filterParam]) }}" class="ajaxify" style="color: #000;">  {{ $data->name }} </a>
                        @break
                        @case('wilayah')
                        <a href="{{ route($config['route'] . '.asset.detail', ['slug' => $asset->data, 'display' => 'satker', 'filter' => array_merge($filterParam, ['wilayah' => $data->id]) ]) }}" class="ajaxify" style="color: #000;"> {{ $data->name }} </a>
                        @break
                        @case('lingkungan')
                        <a href="{{ route($config['route'] . '.asset.detail', ['slug' => $asset->data, 'display' => 'satker', 'filter' => array_merge($filterParam, ['lingkungan' => $data->id])]) }}" class="ajaxify" style="color: #000;"> {{ $lingkungan[$data->name] or $data->name }} </a>
                        @break
                        @default
                        {{ $data->name }}
                    @endswitch
                @else
                    <a href="{{ route($config['route'] . '.satker.asset', ['satker' => $data->kode, 'asset' => $asset->data]) }}" class="ajaxify" style="color: #000;">  {{ $data->name }} </a>
                @endif
            </td>
            <td class="text-right bg-danger-soft"> {{ numberFormatIndo($data->low) }} </td>
            <td class="text-right bg-warning-soft"> {{ numberFormatIndo($data->mid) }} </td>
            <td class="text-right bg-success-soft"> {{ numberFormatIndo($data->high) }} </td>
            <td class="text-right bg-info-soft"> {{ numberFormatIndo($data->total) }} </td>
        </tr>
        <?php $i++;$totLow += $data->low;$totMid += $data->mid;$totHigh += $data->high;$tot += $data->total; ?>
    @endforeach
    <tr class="top-border-double total-row">
        <td colspan="2" class="text-center font-weight-bold m--bg-metal"> Total </td>
        <td class="text-right bg-danger font-weight-bold"> {{ numberFormatIndo($totLow) }} </td>
        <td class="text-right bg-warning font-weight-bold"> {{ numberFormatIndo($totMid) }} </td>
        <td class="text-right bg-success font-weight-bold"> {{ numberFormatIndo($totHigh) }} </td>
        <td class="text-right bg-info font-weight-bold"> {{ numberFormatIndo($tot) }} </td>
    </tr>
    </tbody>
</table>