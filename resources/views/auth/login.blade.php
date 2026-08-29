<x-auth-split-layout>

    @section('title', 'Entrar')

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="auth-group">
            <label for="email" class="auth-label">E-mail</label>
            <input id="email" type="email" name="email" class="auth-input" placeholder="exemplo@mail.com" value="{{ old('email') }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        <!-- Password -->
        <div class="auth-group">
            <label for="password" class="auth-label">Palavra-passe</label>
            <input id="password" type="password" name="password" class="auth-input" placeholder="••••••••" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="auth-error" />
        </div>

        <!-- Remember Me -->
        <div class="auth-group" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <label for="remember_me" style="display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: #475569; cursor: pointer;">
                <input id="remember_me" type="checkbox" name="remember" style="width: 16px; height: 16px; cursor: pointer; accent-color: #61D0AD;">
                Lembrar-me
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size: 0.85rem; color: #224F52; text-decoration: none; font-weight: 600;">
                    Esqueceu a palavra-passe?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-auth-submit">
            ENTRAR
        </button>

        
    </form>

</x-auth-split-layout>
