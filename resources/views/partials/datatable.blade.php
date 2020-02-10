@section('head-scripts-table')
    <link href="{{ asset('adminbsb/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endsection

@section('end-scripts-table')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    {{-- <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminbsb/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script> --}}

    <!-- Custom Js -->
    <script src="{{ asset('adminbsb/js/pages/tables/jquery-datatable.js') }}"></script>
@endsection
