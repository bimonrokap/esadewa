@extends('template.admin.content')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text"> {{ $config['pageTitle'] }}</h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <a href="#" class="m-portlet__nav-link m-btn--pill">
                                    <div class="m-input-icon m-input-icon--right">
                                        <input type="text" class="form-control m-input m-input--solid m-input--pill" placeholder="Cari">
                                        <span class="m-input-icon__icon m-input-icon__icon--right">
                                            <span> <i class="la la-search m--font-brand"></i> </span>
                                        </span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-accordion m-accordion--section m-accordion--padding-lg" id="m_section_1_content">
                        @foreach($faqs as $faq)
                            <div class="m-accordion__item">
                                <div class="m-accordion__item-head collapsed" role="tab" id="m_section_1_content_{{ $faq->id }}_head" data-toggle="collapse" href="#m_section_1_content_{{ $faq->id }}_body" >
                                    <span class="m-accordion__item-title"> {{ $faq->question }} </span>
                                    <span class="m-accordion__item-mode"></span>
                                </div>
                                <div class="m-accordion__item-body collapse" id="m_section_1_content_{{ $faq->id }}_body" role="tabpanel" aria-labelledby="m_section_1_content_{{ $faq->id }}_head" data-parent="#m_section_1_content">
                                    <div class="m-accordion__item-content">
                                        {!! nl2br($faq->answer) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection