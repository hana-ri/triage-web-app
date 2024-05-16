@props([
    'modalId' => 'modal-roles',
    'formId' => 'form-roles-and-permissions',
])

<x-app-layout>
    <x-slot:title>Dashboard</x-slot:title>
    <div class="page-wrapper">
        <x-page-header title="Roles and permissions">
            <div class="btn-list">
                <a href="#" class="btn btn-primary d-none d-sm-inline-block create-roles-modal"
                    data-bs-toggle="modal" data-bs-target="#{{ $modalId }}" aria-label="Create role">
                    <i class="ti ti-plus fs-3"></i>
                    Create role
                </a>
                <a href="#" class="btn btn-primary d-sm-none btn-icon create-roles-modal" data-bs-toggle="modal"
                    data-bs-target="#{{ $modalId }}" aria-label="Create role">
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
                                <table class="table table-striped table-hover" id="roles-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
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
        <x-modal :id="$modalId">
            <form action="" id="{{ $formId }}">
                <input type="hidden" name="id">
                <div class="mb-3">
                    <label class="form-label">Role name</label>
                    <input type="text" class="form-control" name="name" placeholder="Super Admin">
                </div>
                <div class="mb-3">
                    <label class="form-label">Permissions</label>
                    <div class="row g-5">
                        @foreach ($permissionsCollection as $groupName => $group)
                            <div class="col-md-6 col-sm-6">
                                <label class="mb-3 d-flex">
                                    <span class="form-label pe-2 py-0">
                                        {{ str_replace('admin', 'Section', $groupName) }}
                                    </span>
                                    <input class="form-check-input toggle-group" type="checkbox"
                                        data-group="{{ str_replace(' ', '-', $groupName) }}">
                                </label>
                                @foreach ($group as $permission)
                                    <label class="form-check mb-1">
                                        <input class="form-check-input permission-checkbox" type="checkbox"
                                            id="switch-{{ $permission['id'] }}" name="permissions[]"
                                            value="{{ $permission['name'] }}"
                                            data-group="{{ str_replace(' ', '-', $groupName) }}">
                                        <span class="form-check-label">
                                            {{ str_replace('.', ' ', str_replace('admin.', '', $permission['name'])) }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        @endforeach

                    </div>
                </div>
            </form>
        </x-modal>
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/vendor/DataTables/datatables.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendor/tom-select/tom-select.base.min.js') }}">
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/vendor/DataTables/datatables.js') }}" defer></script>

        <script text="text/javascript">
            $(document).ready(function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let roleId = 'xxx';

                let table = $('#roles-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "{{ route('admin.roles.index') }}",
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

                $('body').on('click', '.create-roles-modal', function() {
                    $('#{{ $modalId }}-label').text('Create new roles')
                    $('#{{ $formId }}').trigger('reset');
                    $('#{{ $modalId }}').modal('show');

                    isUpdateMode = false;
                });

                $('body').on('click', '.edit-roles-modal', function() {
                    $('#{{ $modalId }}-label').text('Edit roles and permissions')
                    $('#{{ $formId }}').trigger('reset');
                    $('#{{ $formId }} .info-fields').show();
                    $('#{{ $formId }} .password-fields').show();

                    isUpdateMode = true;

                    roleId = $(this).data('id');
                    let url = '{{ route('admin.roles.show', ['role' => 'xxx']) }}'

                    $.ajax({
                        url: url.replace('xxx', roleId),
                        type: 'GET',
                        success: function(response) {
                            $('#{{ $formId }} input[name="id"]').val(response.role.id);
                            $('#{{ $formId }} input[name="name"]').val(response.role.name);
                            $('#{{ $modalId }}').modal('show');
                            $.each(response.permissions, function(index, permission) {
                                let checkboxId = '#switch-' + permission.id;
                                $(checkboxId).prop('checked', true);
                            });
                        },
                        error: function(error) {
                            // console.log(error.responseJSON.errors);
                            showToast('Error in show role.', 'error');
                        }
                    });
                });

                $('#{{ $modalId }}-btn').click(function() {
                    if (!isUpdateMode) {
                        createRole()
                    } else {
                        updateRole()
                    }
                });

                function createRole() {
                    let roleFormData = $('#{{ $formId }}').serializeArray();
                    $.ajax({
                        url: '{{ route('admin.roles.store') }}',
                        type: 'POST',
                        data: roleFormData,
                        success: function(response) {
                            $('#{{ $modalId }}').modal('hide');
                            showToast(response.success, 'success');
                            table.ajax.reload();
                        },
                        error: function(errors) {
                            // console.log(error.responseJSON.errors);
                            showToast('Error in create role.', 'error');
                        }
                    });
                }

                function updateRole() {
                    let roleFormData = $('#{{ $formId }}').serializeArray();
                    let url = '{{ route('admin.roles.update', ['role' => 'xxx']) }}'
                    console.log(roleFormData);
                    $.ajax({
                        url: url.replace('xxx', roleId),
                        type: 'PUT',
                        data: roleFormData,
                        success: function(response) {
                            $('#{{ $modalId }}').modal('hide');
                            showToast(response.success, 'success');
                            table.ajax.reload(null, false).page().draw();
                        },
                        error: function(error) {
                            // console.log(error.responseJSON.errors);
                            showToast('Error in update role.', 'error');
                        }
                    });
                }

                $('body').on('click', '.delete-roles-action', function() {
                    let result = confirm('Are you sure you want to delete this item?');
                    let url = '{{ route('admin.roles.delete', ['role' => 'xxx']) }}'

                    roleId = $(this).data('id');

                    if (result) {
                        $.ajax({
                            url: url.replace('xxx', roleId),
                            type: 'DELETE',
                            success: function(response) {
                                showToast(response.success, 'success');
                                table.ajax.reload(null, false).page().draw();
                            },
                            error: function(error) {
                                // console.log(error.responseJSON.errors);
                                showToast('Error in delete role.', 'error');
                            }
                        });
                    }
                });

                // untuk cek all
                $(".toggle-group").change(function() {
                    let group = $(this).data("group");
                    let checkboxesInGroup = $(".permission-checkbox[data-group='" + group + "']");

                    if ($(this).prop("checked")) {
                        checkboxesInGroup.prop("checked", true);
                    } else {
                        checkboxesInGroup.prop("checked", false);
                    }
                });

                // Fungsi untuk mengatur cek semua pada izin individual
                $(".permission-checkbox").change(function() {
                    let group = $(this).data("group");
                    let checkboxesInGroup = $(".permission-checkbox[data-group='" + group + "']");
                    let toggleGroupCheckbox = $(".toggle-group[data-group='" + group + "']");

                    if (checkboxesInGroup.length === checkboxesInGroup.filter(":checked").length) {
                        toggleGroupCheckbox.prop("checked", true);
                    } else {
                        toggleGroupCheckbox.prop("checked", false);
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
