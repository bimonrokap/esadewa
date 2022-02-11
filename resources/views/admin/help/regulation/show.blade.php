@foreach($regulations as $regulation)
    <div class="col-md-2 document tooltips" title="{{ $regulation->filename }}">
        <a class="{{ $regulation->type }}" data-id="{{ $regulation->id }}" {!! $regulation->type != 'folder' ? 'target="_blank"' : '' !!} href="{{ $regulation->type == 'folder' ? route($config['route'] . '.show', $regulation->id) : asset('file/regulations/'.$regulation->file) }}">
            <div class="doc-img">
                @if($regulation->type == 'folder')
                    <img src="{{ asset('assets/app/media/img/icon/folder_fit.png') }}" />
                @else
                    <img src="{{ asset('assets/app/media/img/icon/'.$regulation->filetype.'_fit.png') }}" />
                @endif
            </div>
            <div class="doc-filename"> {{ $regulation->filename }} </div>
        </a>
    </div>
@endforeach
@if($regulations->isEmpty())
    <h3 style="margin: 200px auto;">Folder ini kosong!</h3>
    @endif