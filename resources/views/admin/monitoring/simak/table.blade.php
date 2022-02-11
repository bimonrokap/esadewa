<table class="table table-striped table-bordered table-hover m-table m-table--border-metal m-table--head-bg-metal">
    <thead>
        <tr>
            <th rowspan="2" width="50px" class="text-center">No</th>
            <th rowspan="2" class="text-center">Bulan</th>
            <th colspan="10" class="text-center">Tahun</th>
        </tr>
        <tr>
            @for($i = $limit['start'];$i <= $limit['end'];$i++)
            <th class="text-center" width="100px">{{ $i }}</th>
            @endfor
        </tr>
    </thead>
    <tbody>
        @for($i=1;$i<=12;$i++)
            <tr>
                <td class="text-center font-weight-bold">{{ $i }}</td>
                <td class="font-weight-bold">{{ \Carbon\Carbon::now()->day(1)->month($i)->format('F') }}</td>
                @for($j = $limit['start'];$j <= $limit['end'];$j++)
                    @php
                        $ifNotSelectedDate = ($limit['start'] == $j && $i < $limit['startMonth']) || ($limit['end'] == $j && $i > $limit['endMonth']);
                    @endphp
                    <td class="text-center con-upload-simak {{ $ifNotSelectedDate ? 'disabled' : '' }}">
                        @if(!$ifNotSelectedDate && $j >= $now->year && $i > $now->format('n'))
                            -
                        @else
                            @if(isset($data[$i.'-'.$j]))
                                @php
                                    $item = $data[$i.'-'.$j];
                                @endphp
                                <img class="tooltips data-download" data-id="{{ $item->id }}" title="Upload at {{ \Carbon\Carbon::parse($item->updated_at)->format('j F Y') }}<br> {{ $item->user != null ? $item->user->name : '' }} ({{ $item->user != null ? $item->user->nip : '' }})" width="20px" src="{{ asset('assets/app/media/img/icon/icon_download.png') }}" />
                                @if($canUploadBackup)
                                <img class="tooltips data-upload" data-date="{{ $i.'-'.$j }}" title="Klik untuk Unggah Berkas .BAC" width="20px" src="{{ asset('assets/app/media/img/icon/icon_reupload.png') }}" />
                                <img class="tooltips data-delete" data-id="{{ $item->id }}" data-date="{{ $i.'-'.$j }}" title="Klik untuk hapus data" width="20px" src="{{ asset('assets/app/media/img/icon/icon_trash.png') }}" />
                                    @endif
                            @else
                                @if($canUploadBackup && !$ifNotSelectedDate)
                                    <img class="tooltips data-upload" data-date="{{ $i.'-'.$j }}" title="Klik untuk Unggah Berkas .BAC" width="20px" src="{{ asset('assets/app/media/img/icon/icon_upload.png') }}" />
                                @else
                                    @if(!$ifNotSelectedDate)
                                    -
                                        @endif
                                @endif
                            @endif
                        @endif
                    </td>
                @endfor
            </tr>
            @endfor
    </tbody>
</table>