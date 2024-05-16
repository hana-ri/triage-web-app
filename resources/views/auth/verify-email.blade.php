<x-auth-layout>
    <x-slot:title>Email verification</x-slot:title>
    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            {{ $message }}
        </div>
    @endif
    Before proceeding, please check your email for a verification link. If you did not receive the email,
    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">click here to request another</button>.
    </form>
    <a href="{{ route('logout') }}" class="btn btn-link d-block">Logout</a>
</x-auth-layout>
