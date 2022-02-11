@foreach($tutorials as $tutorial)
    <div class="col-md-2 document">
        <a class="{{ $tutorial->type }}" data-id="{{ $tutorial->id }}" {!! $tutorial->type != 'folder' ? 'target="_blank"' : '' !!} href="{{ $tutorial->type == 'folder' ? route($config['route'] . '.show', $tutorial->id) : asset('file/tutorials/'.$tutorial->file) }}">
            <div class="doc-img">
                @if($tutorial->type == 'folder')
                    <img src="{{ asset('assets/app/media/img/icon/folder_fit.png') }}" />
                @else
                    <img src="{{ asset('assets/app/media/img/icon/'.$tutorial->filetype.'_fit.png') }}" />
                @endif
            </div>
            <div class="doc-filename"> {{ $tutorial->filename }} </div>
        </a>
    </div>
@endforeach
@if($tutorials->isEmpty())
    <h3 style="margin: 200px auto;">Folder ini kosong!</h3>
    @endif