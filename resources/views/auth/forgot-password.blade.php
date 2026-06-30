@extends('layouts.auth')

@section('title', 'Recuperar contraseña')

@section('content')
    @session('status')
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ $value }}
        </div>
    @endsession

    <flux:text class="mb-4">
        Introduce tu email y te enviaremos un enlace para crear una nueva contraseña.
    </flux:text>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
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

        <flux:button type="submit" class="w-full" variant="primary">
            Enviar enlace
        </flux:button>

        <flux:text class="mt-2 text-center">
            <flux:link href="{{ route('login') }}">Volver al login</flux:link>
        </flux:text>
    </form>
@endsection
