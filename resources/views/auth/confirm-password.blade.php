<x-auth-split-layout>

    @section('title', 'Confirmar Palavra-passe')

    <p style="text-align: center; font-size: 0.95rem; color: #64748B; line-height: 1.6; margin-bottom: 35px;">
        Esta é uma área segura da aplicação. Por favor, confirme a sua palavra-passe antes de continuar.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="auth-group">
            <label for="password" class="auth-label">Palavra-passe</label>
            <input id="password" type="password" name="password" class="auth-input" placeholder="••••••••" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="auth-error" />
        </div>

        <button type="submit" class="btn-auth-submit">
            CONFIRMAR
        </button>
    </form>

</x-auth-split-layout>
