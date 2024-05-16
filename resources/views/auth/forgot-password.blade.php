<x-auth-layout>
    <x-slot:title>Forgot password</x-slot:title>
    <form action="{{ route('password.email') }}" method="POST" autocomplete="off" novalidate="">
        @csrf
        <h2 class="card-title text-center mb-4">Forgot password</h2>
        @if (session('status'))
        <div class="alert alert-success">
            <i class="ti ti-alert-circle-check"></i>
            {{ session('status') }}
        </div>
        @endif
        <p class="text-secondary mb-4">Enter your email address and your password will be reset and emailed to you.</p>
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" placeholder="Enter email">
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">
                <i class="ti ti-mail fs-2 fw-normal px-2"></i>
                Send me new password
            </button>
        </div>
    </form>
    <div class="text-center text-secondary mt-3">
        Don't have account yet? <a href="{{ route('register') }}" tabindex="-1">Sign up</a>
    </div>
    <div class="text-center text-secondary mt-3">
        <a href="{{ route('login') }}" tabindex="-1">Back to login</a>
    </div>
</x-auth-layout>
