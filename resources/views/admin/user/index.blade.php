@props([
    'modalId' => 'modal-user',
    'formId' => 'form-user',
])

<x-app-layout>
    <x-slot:title>Users</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Users">
            <div class="btn-list">
                <a href="#" id="create-user-button" class="btn btn-primary d-none d-sm-inline-block">
                    <i class="ti ti-plus fs-3"></i>
                    Create user
                </a>
                <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                    data-bs-target="#{{ $modalId }}" aria-label="Create user">
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
                                <table class="table table-striped table-hover users-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Roles</th>
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
        </x-page-body>
    </div>



    <x-modal :id="$modalId">
        <form action="" id="{{ $formId }}">
            <input type="hidden" name="id">
            <div class="info-fields">
                <div class="mb-3">
                    <label class="form-label">Fullname</label>
                    <input type="text" name="name" class="form-control" name="example-text-input"
                        placeholder="Jhon doe">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" name="example-text-input"
                        placeholder="jhon.doe@example.com">
                </div>
                <div class="mb-3">
                    <div class="form-label">Role</div>
                    <select class="form-select" name="role">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 password-fields">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" name="example-text-input"
                    placeholder="Password">
            </div>
            <div class="mb-3 password-fields">
                <label class="form-label">Password confirmation</label>
                <input type="password" name="password_confirmation" class="form-control" name="example-text-input"
                    placeholder="Password confirmation">
            </div>
        </form>
    </x-modal>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/vendor/DataTables/datatables.css') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/vendor/DataTables/datatables.js') }}"></script>

        <script type="text/javascript">
            $(function() {
                let userId = "xxx";
                let table = $('.users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('admin.users.index') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id',
                            searchable: false,
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
                            data: 'roles',
                            name: 'roles'
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
                    $('#{{ $modalId }}-label').text('Create new user')
                    $('#{{ $formId }}').trigger('reset');

                    $('#{{ $formId }} .info-fields').show();
                    $('.info-fields input').prop('disabled', false);
                    $('.info-fields select').prop('disabled', false);

                    $('#{{ $formId }} .password-fields').show();
                    $('#{{ $modalId }}').modal('show');

                    isUpdateMode = false;
                });

                $('body').on('click', '.edit-user-button', function() {
                    $('#{{ $modalId }}-label').text('Edit user information')
                    $('#{{ $formId }}').trigger('reset');

                    $('#{{ $formId }} .info-fields').show();
                    $('.info-fields input').prop('disabled', false);
                    $('.info-fields select').prop('disabled', false);

                    $('#{{ $formId }} .password-fields').hide();

                    isUpdateMode = true;

                    userId = $(this).data('id');

                    $.ajax({
                        url: '{{ route('admin.users.show', ['user' => ':userId']) }}'.replace(
                            ':userId',
                            userId),
                        type: 'GET',
                        success: function(response) {
                            console.log(response.role);
                            $('#{{ $formId }} input[name="id"]').val(response.user.id);
                            $('#{{ $formId }} input[name="name"]').val(response.user.name);
                            $('#{{ $formId }} input[name="email"]').val(response.user.email);
                            $("select[name='role']").val(response.role);

                            $('#{{ $modalId }}').modal('show');                        },
                        error: function(error) {
                            // console.log(error.responseJSON.errors);
                            showToast(error.responseJSON.errors, 'error');
                        }
                    });
                });

                $('body').on('click', '.change-password-user-button', function() {
                    $('#{{ $modalId }}-label').text('Set new password')
                    $('#{{ $formId }}').trigger('reset');
                    $('#{{ $formId }} .info-fields').hide(); // hide selain password
                    $('.info-fields input').prop('disabled',
                    true); // disable input selain password biar gk ngebug
                    $('.info-fields select').prop('disabled',
                    true); // disable input selain password biar gk ngebug
                    $('#{{ $formId }} .password-fields').show();
                    $('#{{ $modalId }}').modal('show');

                    isUpdateMode = true;

                    userId = $(this).data('id');

                    $.ajax({
                        url: '{{ route('admin.users.show', ['user' => ':userId']) }}'.replace(
                            ':userId',
                            userId),
                        type: 'GET',
                        success: function(response) {
                            $('#{{ $formId }} input[name="id"]').val(response.id);
                            $('#{{ $modalId }}').modal('show');
                        },
                        error: function(error) {
                            // console.log(error.responseJSON.errors);
                            showToast('Error in show user.', 'error');
                        }
                    });

                });

                $('#{{ $modalId }}-btn').click(function() {
                    if (!isUpdateMode) {
                        createUSer()
                    } else {
                        updateUser()
                    }
                });

                function createUSer() {
                    let userFormData = $('#{{ $formId }}').serializeArray();
                    $.ajax({
                        url: '{{ route('admin.users.store') }}',
                        type: 'POST',
                        data: userFormData,
                        success: function(response) {
                            $('#{{ $modalId }}').modal('hide');
                            showToast(response.success);
                            table.ajax.reload();
                        },
                        error: function(errors) {
                            // console.log(error.responseJSON.errors);
                            showToast('Error in creating user.', 'error');
                        }
                    });
                }

                function updateUser() {
                    let userFormData = $('#{{ $formId }}').serializeArray();

                    $.ajax({
                        url: '{{ route('admin.users.update', ['user' => ':userId']) }}'.replace(':userId',
                            userId),
                        type: 'PUT',
                        data: userFormData,
                        success: function(response) {
                            $('#{{ $modalId }}').modal('hide');
                            showToast(response.success, 'success');
                            table.ajax.reload(null, false).page().draw();
                        },
                        error: function(error) {
                            // console.log(error.responseJSON.errors);
                            showToast('Error in updating user.', 'error');
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
                                showToast(response.success, 'success');
                                table.ajax.reload(null, false).page().draw();
                            },
                            error: function(error) {
                                showToast('Error in delete action user.', 'error');
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
