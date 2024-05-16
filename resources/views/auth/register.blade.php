<x-auth-layout>
    <x-slot:title>Register</x-slot:title>
    <h2 class="h3 text-center mb-3">
        Create new account
    </h2>
    <form action="{{ route('registering') }}" method="post" autocomplete="off" novalidate="">
        @method('POST')
        @csrf
        <div class="mb-3">
            <label class="form-label">Fullname</label>
            <input type="text" name="name" class="form-control @error('name')is-invalid @enderror" placeholder="Jhon doe"
                value="{{ old('name') }}" autocomplete="off">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" name="email" class="form-control @error('email')is-invalid @enderror"
                value="{{ old('email') }}" placeholder="your@email.com" autocomplete="off">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control @error('password')is-invalid @enderror"
                placeholder="your password" autocomplete="off">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Password confirmation</label>
            <input type="password" name="password_confirmation" class="form-control @error('password')is-invalid @enderror"
                placeholder="confirm your password" autocomplete="off">
        </div>
        <div class="mb-2">
            <label class="form-check  @error('tos')is-invalid @enderror">
                <input type="checkbox" name="tos" class="form-check-input">
                <span class="form-check-label">Agree the <a href="#" tabindex="-1">terms and policy</a>.</span>
            </label>
            @error('tos')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </div>
    </form>
    <div class="text-center text-secondary mt-3">
        Already have account? <a href="{{ route('login') }}" tabindex="-1">Login</a>
    </div>
</x-auth-layout>
