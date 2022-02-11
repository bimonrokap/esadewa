<table class="table table-striped table-bordered m-table m-table--head-bg-success" id="con-barang">
    <thead>
    <tr>
        <th width="10px"> No </th>
        <th> Oleh </th>
        <th width="330px"> Status </th>
        <th width="180px"> Tanggal </th>
    </tr>
    </thead>
    <tbody>
    @foreach($logs as $key => $row)
        <tr>
            <td class="text-center">{{ $key + 1 }}</td>
            <td>{!! $row->user->name. ($row->user->satker != null ? ' <strong>( '.$row->user->satker->name.' )</strong>' : null) !!}</td>
            <td class="text-center"><span class="m-badge m-badge--{{ $row->status->state }} m-badge--wide">{{ $row->status->name }}</span></td>
            <td class="text-center">{{ \Carbon\Carbon::parse($row->created_at)->format('j F Y, H:s') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>