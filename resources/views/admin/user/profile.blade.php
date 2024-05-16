<x-app-layout>
    <x-slot:title>My Profile</x-slot:title>
    <div class="page-wrapper">
        <x-page-body>
            <div class="row">
                <x-alert type="success" :message="session('success')" />
                <x-alert type="error" :message="session('error')" />
                <x-alert type="warning" :message="session('warning')" />
                @if ($errors->any())
                    <x-alert type="danger" message="Please check the form below for errors" />
                @endif
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">My profile</h3>
                        </div>
                        <div class="card-body">
                            <form id="my-profile" action="{{ route('admin.users.profile.update') }}"
                                method="post">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3 row">
                                    <label class="col-2 col-form-label">Fullname</label>
                                    <div class="col">
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            aria-describedby="nameHelp" placeholder="Enter fullname">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-2 col-form-label">Email address</label>
                                    <div class="col">
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                            class="form-control @error('email') is-invalid @enderror"
                                            aria-describedby="emailHelp" placeholder="Enter email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-end">
                            <button id="save-my-profile" type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Change password</h3>
                        </div>
                        <div class="card-body">
                            <form id="change-password"
                                action="{{ route('admin.users.password.update') }}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">Old password</label>
                                    <div class="col">
                                        <input type="password" name="old_password"
                                            class="form-control @error('old_password') is-invalid @enderror"
                                            placeholder="Old password">
                                        @error('old_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">New password</label>
                                    <div class="col">
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="New password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-3 col-form-label">Password confirmation</label>
                                    <div class="col">
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="new password confirmation">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-end">
                            <button id="save-change-password" type="submit" class="btn btn-primary">Change
                                password</button>
                        </div>
                    </div>
                </div>
            </div>
        </x-page-body>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#save-my-profile').on('click', function() {
                    $('#my-profile').submit();
                });
                $('#save-change-password').on('click', function() {
                    $('#change-password').submit();
                });
            });
        </script>
    @endpush
</x-app-layout>
