@section('extra-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <style>
        @media print {
            .no-print, .sidebar, .navbar, footer, form, .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate {
                display: none !important;
            }

            main {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
            }
        }
    </style>
@endsection

@section('extra-js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(function () {
            $('.datatable').DataTable({
                paging: false,
                searching: false,
                info: false,
                ordering: true,
                responsive: true,
                language: {
                    emptyTable: 'Tidak ada data laporan',
                    zeroRecords: 'Data tidak ditemukan'
                }
            });
        });
    </script>
@endsection
