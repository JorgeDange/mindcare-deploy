<x-auth-split-layout>

    @section('title', 'Nova Palavra-passe')

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="auth-group">
            <label for="email" class="auth-label">E-mail</label>
            <input id="email" type="email" name="email" class="auth-input" placeholder="exemplo@mail.com" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        <!-- Password -->
        <div class="auth-group">
            <label for="password" class="auth-label">Nova Palavra-passe</label>
            <input id="password" type="password" name="password" class="auth-input" placeholder="••••••••" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="auth-error" />
        </div>

        <!-- Confirm Password -->
        <div class="auth-group">
            <label for="password_confirmation" class="auth-label">Confirmar Palavra-passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="auth-input" placeholder="••••••••" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" />
        </div>

        <button type="submit" class="btn-auth-submit">
            REDEFINIR PALAVRA-PASSE
        </button>
    </form>

</x-auth-split-layout>
