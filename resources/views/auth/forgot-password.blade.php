<x-auth-split-layout>

    @section('title', 'Recuperar Palavra-passe')

    <p style="text-align: center; font-size: 0.95rem; color: #64748B; line-height: 1.6; margin-bottom: 35px;">
        Esqueceu a sua palavra-passe? Sem problema. Introduza o seu endereço de e-mail e enviaremos um link para criar uma nova palavra-passe.
    </p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="auth-group">
            <label for="email" class="auth-label">E-mail</label>
            <input id="email" type="email" name="email" class="auth-input" placeholder="exemplo@mail.com" value="{{ old('email') }}" required autofocus>
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        <button type="submit" class="btn-auth-submit">
            ENVIAR LINK DE RECUPERAÇÃO
        </button>

        <div class="auth-terms" style="margin-top: 25px;">
            Lembrou-se da palavra-passe? <a href="{{ route('login') }}" style="color: #224F52; text-decoration: underline; font-weight: 600;">Voltar ao Login</a>
        </div>
    </form>

</x-auth-split-layout>
