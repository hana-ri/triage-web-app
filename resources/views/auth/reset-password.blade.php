<x-auth-layout>
    <x-slot:title>Reset password</x-slot:title>
    @if ($errors->any())
        <div class="alert alert-warning">
            <i class="ti ti-alert-triangle-filled"></i>
            {{ $errors->first() }}
        </div>
    @endif
    <form action="{{ route('password.store') }}" method="post" autocomplete="off" novalidate="">
        @method('POST')
        @csrf
        <h2 class="card-title text-center mb-4">Forgot password</h2>
        @if (session('status'))
            <div class="alert alert-success">
                <i class="ti ti-alert-circle-check"></i>
                {{ session('status') }}
            </div>
        @endif
        <p class="text-secondary mb-4">Enter your email address and your password will be reset and emailed to you.</p>
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" placeholder="Enter email"
                value="{{ old('email', $request->email) }}" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                placeholder="Enter password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Password confirmation</label>
            <input type="password" name="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                placeholder="Enter password confirmation">
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">
                Reset password
            </button>
        </div>
    </form>
</x-auth-layout>
