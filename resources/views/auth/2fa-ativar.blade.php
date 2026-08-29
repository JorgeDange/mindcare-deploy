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
    <div class="w-full max-w-[800px]">
        <div class="text-center mb-8">
            <img src="{{ asset('assets/logoti.png') }}" alt="MindCare" class="h-12 mx-auto mb-4">
            <h2 class="font-headline-lg text-headline-lg text-on-surface">Autenticação de Dois Fatores</h2>
            <p class="font-body-md text-on-surface-variant mt-2">Adicione uma camada extra de segurança à sua conta clínica MindCare.</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-700 text-sm p-3 rounded-xl mb-6 shadow-sm border border-red-100">
                @foreach($errors->all() as $error)
                    <p class="font-body-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="tonal-card rounded-xl p-stack-lg flex flex-col gap-stack-lg mb-6">
            <!-- Step 1: Scan QR -->
            <section class="flex flex-col md:flex-row gap-8 items-start">
                <div class="w-full md:w-1/3 flex flex-col items-center">
                    <div class="relative p-4 bg-white rounded-xl border border-outline-variant shadow-sm flex items-center justify-center">
                        {!! $qrCode !!}
                    </div>
                    <p class="font-label-md text-on-surface-variant mt-3 text-center uppercase tracking-wider">Digitalize com seu app autenticador</p>
                </div>
                <div class="w-full md:w-2/3 space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold">1</span>
                        <h3 class="font-title-lg text-title-lg">Configurar Aplicativo</h3>
                    </div>
                    <p class="font-body-md text-on-surface-variant">Abra seu aplicativo de autenticação (Google Authenticator, Authy ou Microsoft Authenticator) e digitalize o código QR ao lado.</p>

                    <div class="mt-6 bg-surface-container-low p-4 rounded-xl border border-secondary/10">
                        <label class="font-label-md text-on-surface-variant mb-2 block uppercase tracking-wider">Inserção Manual</label>
                        <div class="flex items-center justify-between bg-white border border-outline-variant rounded-lg p-3">
                            <code class="font-mono text-body-md text-primary font-bold break-all" id="backupCode">{{ $secret }}</code>
                        </div>
                        <p class="font-body-sm text-on-surface-variant mt-3 italic">Use esta chave caso não consiga ler o código QR.</p>
                    </div>
                </div>
            </section>
            
            <hr class="border-outline-variant my-2"/>

            <!-- Step 2: Verify Code -->
            <section class="space-y-6">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold">2</span>
                    <h3 class="font-title-lg text-title-lg">Verificar Código</h3>
                </div>
                
                <form method="POST" action="{{ route('2fa.ativar') }}" class="w-full">
                    @csrf
                    <div class="max-w-md">
                        <p class="font-body-md text-on-surface-variant mb-4">Insira o código numérico de 6 dígitos gerado pelo seu aplicativo para confirmar a ativação.</p>
                        
                        <div class="mb-8">
                            <input type="text" name="codigo" inputmode="numeric" pattern="[0-9]*" maxlength="6"
                                   class="w-full text-center text-headline-md font-bold rounded-xl border border-outline-variant bg-surface py-4 tracking-[0.5em] focus:ring-2 focus:ring-primary focus:border-transparent outline-none code-input"
                                   placeholder="••••••" required autofocus>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-4 border-t border-outline-variant/50">
                        <button type="submit"
                                class="w-full sm:w-auto px-8 py-3 rounded-full bg-primary text-on-primary font-bold shadow-lg shadow-primary/20 hover:opacity-90 transition-all active:scale-95 flex items-center justify-center gap-2">
                            <span>Ativar e Confirmar</span>
                            <span class="material-symbols-outlined">verified_user</span>
                        </button>
                    </div>
                </form>
            </section>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="text-center mt-6">
            @csrf
            <button type="submit" class="text-sm font-bold text-on-surface-variant hover:text-error transition-colors flex items-center justify-center gap-2 mx-auto">
                <span class="material-symbols-outlined text-[20px]">logout</span> Sair e voltar depois
            </button>
        </form>
    </div>
</div>
</x-guest-layout>
