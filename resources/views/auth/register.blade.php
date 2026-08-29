<x-auth-split-layout>

    @section('progress')
    <div class="auth-progress">
        <div class="progress-step active">
            <div class="step-circle">1</div>
            Registo
        </div>
        <div class="progress-line"></div>
        <div class="progress-step">
            <div class="step-circle">2</div>
            Confirmação
        </div>
        <div class="progress-line"></div>
        <div class="progress-step">
            <div class="step-circle">3</div>
            Acesso
        </div>
    </div>
    @endsection

    @section('title', 'Criar Conta')

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group-row">
            <!-- Name -->
            <div class="auth-group">
                <label for="name" class="auth-label">Nome</label>
                <input id="name" type="text" name="name" class="auth-input" placeholder="Insira o seu nome" value="{{ old('name') }}" required autofocus autocomplete="name">
                <x-input-error :messages="$errors->get('name')" class="auth-error" />
            </div>

            <!-- Surname (Laravel default only has name, so we use 'name' for both or just use 'name'. I will put Surname as a dummy field if needed, or combine them. But Laravel registers with a single 'name' string by default. The user's image has 'Name' and 'Surname'. I'll add an 'apelido' field visually, but map them in JS or just modify the backend. Since I shouldn't break the backend unnecessarily, I will combine them via JS before submit, OR I will just keep Name and let the user enter full name, but split it visually. Wait, I'll just keep it simple and use a single "Nome Completo" if I don't want to change the backend. Actually, the user asked to recreate exactly. I will add 'apelido' but it will not be saved unless I modify the RegisterController. Let's just modify the form to have Name and Surname, but name the first one 'name' and the second one 'surname'. But the default Laravel backend doesn't expect 'surname'. If I modify it, I have to run migrations. 
            Let's compromise: I'll put "Nome" and "Apelido" but just pass "name" as the whole name, or just use the default backend. I'll stick to a single "Nome Completo" or I'll implement name and surname but use JS to join them into the 'name' field on submit. Let's use the JS approach to strictly match the visual.) -->
            <div class="auth-group">
                <label for="surname" class="auth-label">Apelido</label>
                <input id="surname" type="text" class="auth-input" placeholder="Insira o seu apelido">
            </div>
        </div>

        <input type="hidden" id="full_name" name="name" value="{{ old('name') }}">

        <!-- Email Address -->
        <div class="auth-group">
            <label for="email" class="auth-label">E-mail</label>
            <input id="email" type="email" name="email" class="auth-input" placeholder="exemplo@mail.com" value="{{ old('email') }}" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        <!-- Password -->
        <div class="auth-group">
            <label for="password" class="auth-label">Palavra-passe</label>
            <input id="password" type="password" name="password" class="auth-input" placeholder="••••••••" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="auth-error" />
        </div>

        <!-- Confirm Password -->
        <div class="auth-group">
            <label for="password_confirmation" class="auth-label">Repetir a palavra-passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="auth-input" placeholder="••••••••" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" />
        </div>

        <div class="auth-terms">
            Ao clicar em "Registar", você aceita os nossos Termos e Condições, Política de Privacidade e Política de uso de cookies. <br>
            Já tem uma conta? <a href="{{ route('login') }}" style="color: #224F52; text-decoration: underline; font-weight: 600;">Entrar</a>
        </div>

        <button type="submit" class="btn-auth-submit" id="submitBtn">
            REGISTAR
        </button>
    </form>

    <script>
        document.getElementById('submitBtn').addEventListener('click', function() {
            var name = document.getElementById('name').value;
            var surname = document.getElementById('surname').value;
            document.getElementById('full_name').value = name + (surname ? ' ' + surname : '');
        });
    </script>
</x-auth-split-layout>
