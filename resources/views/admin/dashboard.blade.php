<x-app-layout>
    <x-slot:title>List Triase</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="List triase">
            <div class="btn-list">
                <a href="{{ route('admin.triage.step.one.process.reset') }}" class="btn btn-primary d-none d-sm-inline-block">
                    <i class="ti ti-plus fs-3"></i>
                    Triase
                </a>
                <a href="{{ route('admin.triage.step.one.process.reset') }}" class="btn btn-primary d-sm-none btn-icon">
                    <i class="ti ti-plus fs-3"></i>
                </a>
            </div>
        </x-page-header>
        <x-page-body>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped table-hover" id="triage-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Umur</th>
                                            <th>Gender</th>
                                            <th>Level Triase</th>
                                            <th>Keluhan Utama</th>
                                            <th>Tanggal & Waktu</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-page-body>
    </div>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/vendor/DataTables/datatables.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/vendor/DataTables/datatables.js') }}" defer></script>

        <script text="text/javascript">
            $(document).ready(function() {
                let triageId = "xxx";

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let table = $('#triage-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('admin.dashboard') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            searchable: false,
                        },
                        {
                            data: 'name',
                            name: 'name',
                            render: function(data, type, full, meta) {
                                return '<p class="text-capitalize">' + data + '</p>';
                            }
                        },
                        {
                            data: 'age',
                            name: 'age'
                        },
                        {
                            data: 'gender',
                            name: 'gender',
                            render: function(data, type, full, meta) {
                                if (data == 'male') {
                                    return 'Laki-laki';
                                } else {
                                    return 'Perempuan';
                                }
                            }
                        },
                        {
                            data: 'validation',
                            name: 'validation',
                            render: function(data, type, full, meta) {
                                if (data == '1') {
                                    return '<span class="badge bg-danger text-danger-fg">Level ' + data + '</span>';
                                } else if(data == '2'){
                                    return '<span class="badge bg-orange text-orange-fg">Level ' + data + '</span>';
                                } else if(data == '3'){
                                    return '<span class="badge bg-yellow text-yellow-fg">Level ' + data + '</span>';
                                } else if(data == '4'){
                                    return '<span class="badge bg-success text-success-fg">Level ' + data + '</span>';
                                } else{
                                    return '<span class="badge bg-primary text-primary-fg">Level ' + data + '</span>';
                                }
                            }
                        },
                        {
                            data: 'chief_complaint',
                            name: 'chief_complaint'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });

                $('body').on('click', '.delete-triage-action', function() {
                    let result = confirm('Are you sure you want to delete this item?');

                    triageId = $(this).data('id');
                    console.log(triageId);

                    if (result) {
                        $.ajax({
                            url: '{{ route('admin.triage.delete', ['triage' => ':triageId']) }}'.replace(
                                ':triageId', triageId),
                            type: 'DELETE',
                            success: function(response) {
                                showToast(response.success, 'success');
                                table.ajax.reload(null, false);
                            },
                            error: function(error) {
                                showToast('Terjadi kesalah saat ingin menghapus data triase.', 'error');
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
