@extends('layouts.auth')

@section('title', 'Nueva contraseña')

@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <flux:field>
            <flux:label>Email</flux:label>
            <flux:input
                type="email"
                name="email"
                :value="old('email', $request->email)"
                required
                autofocus
                autocomplete="username"
            />
            <flux:error name="email" />
        </flux:field>

        <flux:field>
            <flux:label>Nueva contraseña</flux:label>
            <flux:input
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />
            <flux:error name="password" />
        </flux:field>

        <flux:field>
            <flux:label>Confirmar contraseña</flux:label>
            <flux:input
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />
            <flux:error name="password_confirmation" />
        </flux:field>

        <flux:button type="submit" class="w-full" variant="primary">
            Cambiar contraseña
        </flux:button>
    </form>
@endsection
