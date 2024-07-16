<x-auth-layout>
    <x-slot:title>Login</x-slot:title>
    <h2 class="h3 text-center mb-3">
        Masuk menggunakan akun yang sudah didaftarkan oleh Admin
    </h2>

    @if (session('message'))
        <div class="alert alert-success">
            <i class="ti ti-alert-circle-check"></i>
            {{ session('message') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-warning">
            <i class="ti ti-alert-triangle-filled"></i>
            {{ $errors->first() }}
        </div>
    @endif
    <form action="{{ route('authenticate') }}" method="POST" autocomplete="off" novalidate="">
        @method('POST')
        @csrf
        <div class="mb-3">
            <label class="form-label">Alamat email</label>
            <input type="email" class="form-control" name="email" placeholder="your@email.com" autocomplete="off"
                required>
        </div>
        <div class="mb-2">
            <label class="form-label">
                Kata sandi
                <span class="form-label-description">
                    <a href="{{ route('password.request') }}">Lupa kata sandi</a>
                </span>
            </label>
            <input type="password" class="form-control" name="password" placeholder="your password" autocomplete="off"
                required>
        </div>
        <div class="mb-2">
            <label class="form-check">
                <input type="checkbox" name="remember" class="form-check-input" value="1">
                <span class="form-check-label">Ingat saya</span>
            </label>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </div>
    </form>
    {{-- <div class="text-center text-secondary mt-3">
        Don't have account yet? <a href="{{ route('register') }}" tabindex="-1">Sign up</a>
    </div> --}}
</x-auth-layout>
