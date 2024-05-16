@extends('layout.admin')

@section('title', 'Users')

@section('page-pretitle', 'Overview')

@section('page-title', 'Users')

@section('action')
    <div class="btn-list">
        <a href="#" id="create-user-button" class="btn btn-primary d-none d-sm-inline-block">
            <i class="ti ti-plus fs-3"></i>
            Create user
        </a>
        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-user"
            aria-label="Create user">
            <i class="ti ti-plus fs-3"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive p-1">
                        <table class="table table-striped table-hover users-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Email verification</th>
                                    <th>created at</th>
                                    <th>updated at</th>
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
    <!-- Modal -->
    @include('admin.user.user_modal')
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/DataTables/datatables.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="{{ asset('assets/vendor/DataTables/datatables.js') }}"></script>

    <script type="text/javascript">
        $(function() {
            let userId = null;
            let table = $('.users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.users.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'email_verified_at',
                        name: 'email_verified_at',
                        searchable: false,
                        render: function(data, type, full, meta) {
                            if (data) {
                                return '<span class="badge bg-green text-green-fg">Verified</span>';
                            } else {
                                return '<span class="badge bg-red text-red-fg">Not verified</span>';
                            }
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('click', '#create-user-button', function() {
                $('#user-modal-label').text('Create new user')
                $('#form-user').trigger('reset');
                $('#form-user .info-fields').show();
                $('#form-user .password-fields').show();
                $('#modal-user').modal('show');

                isUpdateMode = false;
            });

            $('body').on('click', '.edit-user-button', function() {
                $('#user-modal-label').text('Edit user information')
                $('#form-user').trigger('reset');
                $('#form-user .info-fields').show();
                $('#form-user .password-fields').hide();

                isUpdateMode = true;

                userId = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.users.show', ['user' => ':userId']) }}'.replace(':userId',
                        userId),
                    type: 'GET',
                    success: function(response) {
                        $('#form-user input[name="id"]').val(response.id);
                        $('#form-user input[name="name"]').val(response.name);
                        $('#form-user input[name="email"]').val(response.email);

                        $('#modal-user').modal('show');
                    },
                    error: function(error) {
                        console.log(error.responseJSON.errors);
                        alert('Gagal memuat data. Silakan coba lagi.');
                    }
                });
            });

            $('body').on('click', '.change-password-user-button', function() {
                $('#user-modal-label').text('Set new password')
                $('#form-user').trigger('reset');
                $('#form-user .info-fields').hide();
                $('#form-user .password-fields').show();
                $('#modal-user').modal('show');

                isUpdateMode = true;

                userId = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.users.show', ['user' => ':userId']) }}'.replace(':userId',
                        userId),
                    type: 'GET',
                    success: function(response) {
                        $('#form-user input[name="id"]').val(response.id);

                        $('#modal-user').modal('show');
                    },
                    error: function(error) {
                        console.log(error.responseJSON.errors);
                        alert('Gagal memuat data. Silakan coba lagi.');
                    }
                });

            });

            $('#save-user').click(function() {
                if (!isUpdateMode) {
                    createUSer()
                } else {
                    updateUser()
                }
            });

            function createUSer() {
                let userFormData = $('#form-user').serializeArray();
                $.ajax({
                    url: '{{ route('admin.users.store') }}',
                    type: 'POST',
                    data: userFormData,
                    success: function(response) {
                        $('#modal-user').modal('hide');
                        table.ajax.reload();
                    },
                    error: function(errors) {
                        console.log('error');
                        alert('Gagal menyimpan data. Silakan coba lagi.');
                    }
                });
            }

            function updateUser() {
                let userFormData = $('#form-user').serializeArray();

                $.ajax({
                    url: '{{ route('admin.users.update', ['user' => ':userId']) }}'.replace(':userId',
                        userId),
                    type: 'PUT',
                    data: userFormData,
                    success: function(response) {
                        $('#modal-user').modal('hide');
                        table.ajax.reload();
                    },
                    error: function(error) {
                        console.log('error');
                        alert('Gagal memperbarui data. Silakan coba lagi.');
                    }
                });
            }

            $('body').on('click', '.delete-user-action', function() {
                let result = confirm('Are you sure you want to delete this item?');

                userId = $(this).data('id');

                if (result) {
                    $.ajax({
                        url: '{{ route('admin.users.destroy', ['user' => ':userId']) }}'.replace(
                            ':userId', userId),
                        type: 'DELETE',
                        success: function(response) {
                            table.ajax.reload();
                        },
                        error: function(error) {
                            console.log('error');
                            alert('Gagal menghapus data. Silakan coba lagi.');
                        }
                    });
                }
            });
        });
    </script>
@endpush
