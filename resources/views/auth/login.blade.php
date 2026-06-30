@extends('layouts.auth')

@section('title', 'Iniciar sesión')

@section('content')
    @session('status')
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ $value }}
        </div>
    @endsession

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <flux:field>
            <flux:label>Email</flux:label>
            <flux:input
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
            />
            <flux:error name="email" />
        </flux:field>

        <flux:field>
            <flux:label>Contraseña</flux:label>
            <flux:input
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />
            <flux:error name="password" />
        </flux:field>

        <flux:checkbox name="remember" label="Recordarme" />

        <flux:button type="submit" class="w-full" variant="primary">
            Iniciar sesión
        </flux:button>

        @if (\Laravel\Fortify\Features::enabled(\Laravel\Fortify\Features::resetPasswords()))
            <flux:text class="mt-2 text-center">
                <flux:link href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</flux:link>
            </flux:text>
        @endif
    </form>
@endsection
