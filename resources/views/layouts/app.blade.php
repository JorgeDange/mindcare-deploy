<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/logoti.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@1,400..900&family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <title>{{ config('app.name', 'MindCare') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <!-- Loader Component -->
    <x-loader />

    <!-- Header Navigation -->
    <header class="glass-header">
        <nav class="glass-menu-container">
            <div class="glass-pill">
                <a href="{{ route('home') }}"><img src="{{ asset('assets/logot.png') }}" class="logo" alt="MindCare"></a>
                <ul>
                    <li><a href="{{ route('home') }}">Início</a></li>
                    <li><a href="{{ url('/sobre') }}">Sobre nós</a></li>
                    <li><a href="{{ url('/servicos') }}">Serviços</a></li>
                    <li><a href="{{ url('/planos') }}">Planos</a></li>
                    <li><a href="{{ url('/faq') }}">FAQ</a></li>
                </ul>
                <a href="{{ route('login') }}" class="btn-agendar">Agendar Consulta</a>
            </div>

            @guest
                <a href="{{ route('register') }}" class="glass-circle">Cadastrar</a>
                <a href="{{ route('login') }}" class="glass-circle hide-on-mobi">Entrar</a>
            @endguest

            @auth
                <div class="relative" x-data="{ aberto: false }"
                     @click.outside="aberto = false">
                    <button @click="aberto = !aberto"
                            class="glass-circle !p-0 !rounded-full w-10 h-10 flex items-center justify-center focus:outline-none">
                        @if(Auth::user()->foto_perfil)
                            <img src="{{ Auth::user()->foto_url }}"
                                 alt="{{ Auth::user()->name }}"
                                 class="w-full h-full rounded-full object-cover">
                        @else
                            <div class="w-full h-full rounded-full bg-[#005f5f] text-white flex items-center justify-center font-bold text-sm">
                                <span class="leading-none select-none">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(strrchr(Auth::user()->name, ' '), 1, 1) ?: substr(Auth::user()->name, 1, 1)) }}
                                </span>
                            </div>
                        @endif
                    </button>
                    <div x-show="aberto"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                         class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg
                                border border-gray-100 py-1 z-50 origin-top-right">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-900 truncate">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-xs text-gray-500 truncate mt-0.5">
                                {{ Auth::user()->email }}
                            </p>
                        </div>
                        <div class="py-1">
                            @if(Auth::user()->role === 'profissional')
                                <a href="{{ route('profissional.dashboard') }}"
                                   class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700
                                          hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2
                                                 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0
                                                 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Painel Profissional
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}"
                                   class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700
                                          hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2
                                                 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0
                                                 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Meu Painel
                                </a>
                                <a href="{{ route('perfil') }}"
                                   class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700
                                          hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0
                                                 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    O Meu Perfil
                                </a>
                            @endif
                        </div>
                        <div class="border-t border-gray-100 py-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="flex items-center gap-2.5 w-full px-4 py-2 text-sm
                                               text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0
                                                 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3
                                                 3 0 013 3v1"/>
                                    </svg>
                                    Terminar Sessão
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth

            <button class="glass-circle menu-mobi-btn" id="menuToggle" aria-label="Abrir Menu">
                <i class="fa-solid fa-bars"></i>
            </button>
        </nav>

        <!-- Menu mobile -->
        <nav class="menu-mobile" id="menuMobile">
            <div class="menu-header">
                <img src="{{ asset('assets/logoti.png') }}" alt="MindCare">
                <button class="close-menu" id="closeMenu"><i data-lucide="x"></i></button>
            </div>
            <ul class="menu-links">
                <li><a href="{{ route('home') }}"><i data-lucide="home"></i> Início</a></li>
                <li><a href="{{ url('/sobre') }}"><i data-lucide="info"></i> Sobre nós</a></li>
                <li><a href="{{ url('/servicos') }}"><i data-lucide="heart-pulse"></i> Serviços</a></li>
                <li><a href="{{ url('/planos') }}"><i data-lucide="layout-grid"></i> Planos</a></li>
                <li><a href="{{ url('/faq') }}"><i data-lucide="help-circle"></i> FAQ</a></li>
            </ul>
            <div class="menu-footer">
                <a href="{{ route('login') }}" class="btn-sidebar">Agendar Consulta</a>
                <div class="menu-auth-links">
                    @guest
                        <a href="{{ route('login') }}"><i data-lucide="log-in"></i> Iniciar Sessão</a>
                        <a href="{{ route('register') }}"><i data-lucide="user-plus"></i> Criar Conta</a>
                    @endguest
                    @auth
                        <a href="{{ route('dashboard') }}"><i data-lucide="layout-dashboard"></i> Meu Painel</a>
                        <form method="POST" action="{{ route('logout') }}" style="display:inline">
                            @csrf
                            <button type="submit" style="background:none;border:none;cursor:pointer;font-family:inherit;font-size:inherit;display:flex;align-items:center;gap:0.5rem;padding:0;color:#ef4444;width:100%">
                                <i data-lucide="log-out"></i> Terminar Sessão
                            </button>
                        </form>
                    @endauth
                </div>
                <div class="menu-contact">
                    <p><i data-lucide="phone"></i> +244 932 380 303</p>
                    <p><i data-lucide="mail"></i> geral@mindcareangola.ao</p>
                </div>
            </div>
        </nav>
        <div class="overlay" id="overlay"></div>
    </header>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-column brand-col">
                <img src="{{ asset('assets/logoti.png') }}" alt="MindCare Logo" class="footer-logo-img">
                <p class="brand-description">
                    Cuidando da sua saúde mental com excelência e humanização. Referência em psicologia clínica,
                    organizacional e terapias especializadas.
                </p>
                <div class="social-links">
                    <a href="https://facebook.com" target="_blank" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://instagram.com" target="_blank" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="footer-column">
                <h3 class="footer-title">Navegação</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Início</a></li>
                    <li><a href="{{ url('/sobre') }}">Sobre Nós</a></li>
                    <li><a href="{{ url('/servicos') }}">Serviços</a></li>
                    <li><a href="{{ url('/planos') }}">Planos</a></li>
                    <li><a href="{{ url('/faq') }}">FAQ</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3 class="footer-title">Nossos Serviços</h3>
                <ul class="footer-links">
                    <li><a href="{{ url('/servicos') }}">Psicoterapia</a></li>
                    <li><a href="{{ url('/servicos') }}">Neuropsicologia</a></li>
                    <li><a href="{{ url('/servicos') }}">Psicologia Infantil</a></li>
                    <li><a href="{{ url('/servicos') }}">Consultoria Empresas</a></li>
                    <li><a href="{{ url('/servicos') }}">Terapia ABA</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3 class="footer-title">Contacto</h3>
                <ul class="contact-info">
                    <li>
                        <i data-lucide="map-pin"></i>
                        <span>Centralidade do Kilamba, L24, <br>Porta 1, Luanda</span>
                    </li>
                    <li>
                        <i data-lucide="phone"></i>
                        <span>+244 932 380 303</span>
                    </li>
                    <li>
                        <i data-lucide="mail"></i>
                        <span>geral@mindcareangola.ao</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p>&copy; 2024 Mind Care, Psicologia e Serviços, Lda. Todos os direitos reservados.</p>
                <div class="footer-legal">
                    <a href="#">Privacidade</a>
                    <a href="#">Termos</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Chat Widget Component -->
    <x-chat-widget />

</body>
</html>
