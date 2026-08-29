<x-auth-split-layout>

    @section('title', 'Verificar E-mail')

    <p style="text-align: center; font-size: 0.95rem; color: #64748B; line-height: 1.6; margin-bottom: 35px;">
        Obrigado por se registar! Antes de começar, verifique o seu endereço de e-mail clicando no link que acabámos de enviar. Se não recebeu o e-mail, teremos todo o gosto em enviar outro.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div style="margin-bottom: 20px; padding: 14px 20px; background: rgba(97, 208, 173, 0.1); border: 1px solid rgba(97, 208, 173, 0.3); border-radius: 12px; font-size: 0.9rem; color: #224F52; text-align: center;">
            Um novo link de verificação foi enviado para o endereço de e-mail que indicou durante o registo.
        </div>
    @endif

    <div style="display: flex; align-items: center; justify-content: space-between; gap: 15px;">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-auth-submit" style="font-size: 0.85rem; padding: 14px 28px;">
                REENVIAR E-MAIL
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background: none; border: none; color: #224F52; font-size: 0.9rem; font-weight: 600; cursor: pointer; text-decoration: underline;">
                Terminar Sessão
            </button>
        </form>
    </div>

</x-auth-split-layout>
