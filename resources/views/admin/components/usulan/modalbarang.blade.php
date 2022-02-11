<div class="modal fade" id="modalBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 1200px" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Pilih Barang </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times; </span>
                </button>
            </div>
            <form class="m-form m-form--label-align-right" action="#" method="POST" id="form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 col-form-label"> Kategori Barang </label>
                        <div class="col-lg-3">
                            <select id="kategori-barang" class="form-control m-bootstrap-select m_selectpicker" title="Pilih Kategori Barang" data-style="btn-primary">
                                @if(is_array($kategoriBarang))
                                    @foreach($kategoriBarang as $kategori)
                                        <option value="{{ $kategori['id'] }}"> {{ $kategori['name'] }} </option>
                                    @endforeach
                                @else
                                    <option value="{{ $kategoriBarang['id'] }}"> {{ $kategoriBarang['name'] }} </option>
                                    @endif
                            </select>
                        </div>
                    </div>

                    <div id="con-table"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Tutup </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/app/js/barang.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var tableFilter = {};
        $(".m_selectpicker").selectpicker()
    </script>
    @endpush