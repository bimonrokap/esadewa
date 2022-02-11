@extends(!Request::ajax() ? 'template.admin.base' : 'template.admin.ajax')

@section('fullcontent')

    <!-- BEGIN: Subheader -->
    @include('template.admin.subheader')
    <!-- END: Subheader -->

    <!-- BEGIN: Content -->
    @yield('content')
    <!-- END: Content -->
@endsection