<x-app-layout>
    <x-slot:title>Dashboard</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Dashboard" />
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
                                            <th>SBP</th>
                                            <th>DBP</th>
                                            <th>HR</th>
                                            <th>RR</th>
                                            <th>BT</th>
                                            <th>Saturation</th>
                                            <th>Tiba dengan</th>
                                            <th>Cedera?</th>
                                            <th>AVPU Scale</th>
                                            <th>Nyeri</th>
                                            <th>Scala Nyeri</th>
                                            <th>Prediksi Triase</th>
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
                            name: 'name'
                        },
                        {
                            data: 'age',
                            name: 'age'
                        },
                        {
                            data: 'gender',
                            name: 'gender'
                        },
                        {
                            data: 'sbp',
                            name: 'sbp'
                        },
                        {
                            data: 'dbp',
                            name: 'dbp'
                        },
                        {
                            data: 'hr',
                            name: 'hr'
                        },
                        {
                            data: 'rr',
                            name: 'rr'
                        },
                        {
                            data: 'bt',
                            name: 'bt'
                        },
                        {
                            data: 'saturation',
                            name: 'saturation'
                        },
                        {
                            data: 'arrival_mode',
                            name: 'arrival_mode'
                        },
                        {
                            data: 'injury',
                            name: 'injury',
                            render: function(data, type, full, meta) {
                                if (data) {
                                    return '<span class="badge bg-danger text-danger-fg">Yes</span>';
                                } else {
                                    return '<span class="badge bg-primary text-primary-fg">No</span>';
                                }
                            }
                        },
                        {
                            data: 'AVPU_scale',
                            name: 'AVPU_scale'
                        },
                        {
                            data: 'is_pain',
                            name: 'is_pain',
                            render: function(data, type, full, meta) {
                                if (data) {
                                    return '<span class="badge bg-danger text-danger-fg">Yes</span>';
                                } else {
                                    return '<span class="badge bg-primary text-primary-fg">No</span>';
                                }
                            }
                        },
                        {
                            data: 'nrs_pain',
                            name: 'nrs_pain'
                        },
                        {
                            data: 'prediction_level',
                            name: 'prediction_level',
                            render: function(data, type, full, meta) {
                                if (data == 'Level 1') {
                                    return '<span class="badge bg-danger text-danger-fg">' + data + '</span>';
                                } else if(data == 'Level 2'){
                                    return '<span class="badge bg-orange text-orange-fg">' + data + '</span>';
                                } else if(data == 'Level 3'){
                                    return '<span class="badge bg-yellow text-yellow-fg">' + data + '</span>';
                                } else if(data == 'Level 4'){
                                    return '<span class="badge bg-success text-success-fg">' + data + '</span>';
                                } else{
                                    return '<span class="badge bg-primary text-primary-fg">' + data + '</span>';
                                }
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>
