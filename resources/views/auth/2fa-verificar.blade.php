<x-guest-layout>
<style>
    .tonal-card {
        background: #ffffff;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 95, 95, 0.05);
    }
    .code-input:focus {
        outline: none;
        border-color: #0060ac;
        box-shadow: 0 0 0 2px rgba(0, 96, 172, 0.2);
    }
</style>
<div class="min-h-screen flex items-center justify-center bg-surface px-4 py-8">
    <div class="w-full max-w-[500px]">
        <div class="text-center mb-8">
            <img src="{{ asset('assets/logoti.png') }}" alt="MindCare" class="h-12 mx-auto mb-4" loading="lazy" decoding="async">
            <h2 class="font-headline-lg text-headline-lg text-on-surface">Verificação 2FA</h2>
            <p class="font-body-md text-on-surface-variant mt-2">Insira o código do seu aplicativo autenticador.</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-700 text-sm p-3 rounded-xl mb-6 shadow-sm border border-red-100">
                @foreach($errors->all() as $error)
                    <p class="font-body-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="tonal-card rounded-xl p-stack-lg flex flex-col gap-stack-lg mb-6">
            <section class="space-y-6">
                <form method="POST" action="{{ route('2fa.verificar') }}" class="w-full">
                    @csrf
                    <div class="max-w-md mx-auto">
                        <p class="font-body-md text-on-surface-variant mb-6 text-center">Abra o Google Authenticator ou similar para ver o código atual.</p>
                        
                        <div class="mb-8">
                            <input type="text" name="codigo" inputmode="numeric" pattern="[0-9]*" maxlength="6"
                                   class="w-full text-center text-headline-md font-bold rounded-xl border border-outline-variant bg-surface py-4 tracking-[0.5em] focus:ring-2 focus:ring-primary focus:border-transparent outline-none code-input"
                                   placeholder="••••••" required autofocus>
                        </div>
                    </div>

                    <div class="flex flex-col items-center justify-center gap-4 pt-2">
                        <button type="submit"
                                class="w-full px-8 py-3 rounded-full bg-primary text-on-primary font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all active:scale-95 flex items-center justify-center gap-2">
                            <span>Verificar Código</span>
                            <span class="material-symbols-outlined">lock_open</span>
                        </button>
                    </div>
                </form>
            </section>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="text-center mt-6">
            @csrf
            <button type="submit" class="text-sm font-bold text-on-surface-variant hover:text-error transition-colors flex items-center justify-center gap-2 mx-auto">
                <span class="material-symbols-outlined text-[20px]">logout</span> Sair da Conta
            </button>
        </form>
    </div>
</div>
</x-guest-layout>
