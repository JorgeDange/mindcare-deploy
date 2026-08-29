<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Portal — MindCare')</title>
    <link rel="shortcut icon" href="{{ asset('assets/logoti.png') }}" type="image/x-icon">
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Scripts and Styles -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
              "secondary-fixed-dim": "#a4c9ff",
              "on-background": "#071e27",
              "on-primary-container": "#acfffe",
              "inverse-on-surface": "#dff4ff",
              "error": "#ba1a1a",
              "primary": "#005f5f",
              "surface-container-lowest": "#ffffff",
              "secondary": "#0060ac",
              "error-container": "#ffdad6",
              "surface-variant": "#cfe6f2",
              "on-tertiary": "#ffffff",
              "on-error": "#ffffff",
              "secondary-container": "#68abff",
              "surface-container": "#dbf1fe",
              "on-primary-fixed-variant": "#004f4f",
              "on-primary-fixed": "#002020",
              "surface": "#f3faff",
              "on-tertiary-fixed": "#181c1d",
              "on-primary": "#ffffff",
              "background": "#f3faff",
              "primary-fixed": "#97f2f1",
              "tertiary": "#525656",
              "on-surface-variant": "#3e4948",
              "on-surface": "#071e27",
              "on-secondary-fixed": "#001c39",
              "surface-container-highest": "#cfe6f2",
              "tertiary-container": "#6a6e6e",
              "surface-tint": "#006a6a",
              "surface-dim": "#c7dde9",
              "secondary-fixed": "#d4e3ff",
              "primary-container": "#007a7a",
              "on-secondary-fixed-variant": "#004883",
              "surface-bright": "#f3faff",
              "on-error-container": "#93000a",
              "inverse-surface": "#1e333c",
              "outline-variant": "#bdc9c8",
              "on-secondary-container": "#003e73",
              "primary-fixed-dim": "#7ad5d5",
              "on-tertiary-fixed-variant": "#434748",
              "on-secondary": "#ffffff",
              "on-tertiary-container": "#eef1f1",
              "tertiary-fixed-dim": "#c4c7c7",
              "surface-container-high": "#d5ecf8",
              "outline": "#6e7979",
              "surface-container-low": "#e6f6ff",
              "inverse-primary": "#7ad5d5",
              "tertiary-fixed": "#e0e3e3"
            },
            "borderRadius": {
              "DEFAULT": "0.25rem",
              "lg": "0.5rem",
              "xl": "0.75rem",
              "full": "9999px"
            },
            "spacing": {
              "stack-md": "16px",
              "stack-lg": "24px",
              "unit": "8px",
              "gutter": "24px",
              "stack-sm": "8px",
              "margin-mobile": "16px",
              "margin-desktop": "32px",
              "container-max": "1280px"
            },
            "fontFamily": {
              "label-md": ["Inter"],
              "body-md": ["Inter"],
              "display-lg": ["Inter"],
              "body-sm": ["Inter"],
              "headline-md": ["Inter"],
              "headline-lg": ["Inter"],
              "title-lg": ["Inter"],
              "body-lg": ["Inter"],
              "headline-lg-mobile": ["Inter"]
            },
            "fontSize": {
              "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
              "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
              "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
              "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
              "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
              "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
              "title-lg": ["20px", {"lineHeight": "28px", "fontWeight": "600"}],
              "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
              "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "600"}]
            }
          },
        },
      }
    </script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/side-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/calendar-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form-tabs.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pricing-cards.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chat-layout.css') }}">
    @stack('styles')
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3faff;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .user-dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            width: 220px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            border: 1px solid rgba(189, 201, 200, 0.3);
            padding: 8px 0;
            z-index: 50;
        }

        .user-dropdown-menu:not(.hidden) {
            display: block;
            animation: dropdownIn 0.2s ease;
        }

        @keyframes dropdownIn {
            from { opacity: 0; transform: translateY(-4px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .user-dropdown-header {
            padding: 12px 16px 8px;
        }

        .user-dropdown-name {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #071e27;
        }

        .user-dropdown-plan {
            display: block;
            font-size: 0.7rem;
            color: #6e7979;
            margin-top: 2px;
        }

        .user-dropdown-divider {
            height: 1px;
            background: rgba(189, 201, 200, 0.2);
            margin: 4px 0;
        }

        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            font-size: 0.82rem;
            color: #071e27;
            text-decoration: none;
            transition: background 0.15s;
            cursor: pointer;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            font-family: inherit;
        }

        .user-dropdown-item:hover {
            background: #e6f6ff;
        }

        .user-dropdown-item:active {
            background: #cfe6f2;
        }

        .user-dropdown-danger {
            color: #ba1a1a;
        }

        .user-dropdown-danger:hover {
            background: rgba(186, 26, 26, 0.08);
        }

        .user-dropdown-icon {
            font-size: 18px;
            color: #6e7979;
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20;
        }

        .user-dropdown-danger .user-dropdown-icon {
            color: #ba1a1a;
        }
    </style>
</head>
<body class="bg-surface text-on-surface">
    <x-loader />

    @php
        $layoutUnreadNotifications = Auth::user()->unreadNotifications->count();
        $layoutRecentNotifications = Auth::user()->notifications()->orderByDesc('created_at')->take(5)->get();
    @endphp

    <!-- SideNavBar -->
    <x-portal-sidebar />

    <!-- TopNavBar -->
    <x-portal-topbar
        :unread-notifications="$layoutUnreadNotifications"
        :recent-notifications="$layoutRecentNotifications"
    />

    <!-- Main Content Canvas -->
    <main class="md:ml-[280px] @if(!Request::routeIs('mensagens')) pt-[80px] md:pt-[96px] pb-24 md:pb-8 px-margin-mobile md:px-margin-desktop min-h-screen @else pt-16 pb-20 md:pb-0 h-[calc(100vh-4rem)] overflow-hidden @endif">
        <div class="@if(!Request::routeIs('mensagens')) max-w-container-max mx-auto @else h-full @endif">
            <x-flash-messages />
            @yield('content')
        </div>
    </main>

    <!-- Interactive Atmospheric Element (Subtle floating particles) -->
    <div class="fixed inset-0 pointer-events-none z-[-1] overflow-hidden" id="particles"></div>

    <script>
        // Background atmosphere: subtle moving glow
        const particlesContainer = document.getElementById('particles');
        if (particlesContainer) {
            for (let i = 0; i < 5; i++) {
                const blob = document.createElement('div');
                blob.className = 'absolute bg-primary-fixed/20 blur-[120px] rounded-full transition-all duration-[10000ms] ease-in-out';
                const size = Math.random() * 400 + 200;
                blob.style.width = `${size}px`;
                blob.style.height = `${size}px`;
                blob.style.left = `${Math.random() * 100}%`;
                blob.style.top = `${Math.random() * 100}%`;
                particlesContainer.appendChild(blob);
                
                setInterval(() => {
                    blob.style.left = `${Math.random() * 100}%`;
                    blob.style.top = `${Math.random() * 100}%`;
                }, 10000);
            }
        }

        // Dropdown Utilizador e Notificações
        function toggleDropdown(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.toggle('hidden');
            // close the other
            const otherId = id === 'user-dropdown' ? 'notif-dropdown' : 'user-dropdown';
            const other = document.getElementById(otherId);
            if (other) other.classList.add('hidden');
        }

        document.addEventListener('click', (e) => {
            ['user-dropdown', 'notif-dropdown'].forEach(id => {
                const toggleId = id === 'user-dropdown' ? 'user-dropdown-toggle' : 'notif-dropdown-toggle';
                if (!e.target.closest('#' + toggleId)) {
                    const el = document.getElementById(id);
                    if (el) el.classList.add('hidden');
                }
            });
        });

        // Polling de notificações a cada 15s (substituto do WebSocket)
        setInterval(() => {
            fetch('{{ route('notificacoes.nao-lidas') }}', {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                const badge = document.querySelector('#notif-dropdown-toggle .bg-error');
                if (badge) {
                    badge.style.display = data.total > 0 ? 'flex' : 'none';
                }
                const text = document.querySelector('#notif-dropdown-toggle .rounded-full span');
                if (text) text.textContent = data.total;
            })
            .catch(() => {});
        }, 15000);
    </script>
    <x-loading-overlay />

    <!-- BottomNavBar (Mobile Only) -->
    <nav class="md:hidden fixed bottom-0 left-0 w-full bg-surface-container-lowest border-t border-outline-variant/20 shadow-[0_-4px_12px_rgba(0,0,0,0.05)] h-20 px-2 pb-safe flex justify-around items-center z-50 rounded-t-xl">
        <a class="flex flex-col items-center justify-center {{ Request::routeIs('dashboard') ? 'bg-primary-container text-on-primary-container rounded-2xl px-5 py-1' : 'text-on-surface-variant px-5 py-1' }} active:scale-90 transition-transform duration-150" href="{{ route('dashboard') }}">
            <span class="material-symbols-outlined" style="{{ Request::routeIs('dashboard') ? "font-variation-settings: 'FILL' 1;" : '' }}">home</span>
            <span class="font-label-md text-label-md">Home</span>
        </a>
        <a class="flex flex-col items-center justify-center {{ Request::routeIs('consultas') ? 'bg-primary-container text-on-primary-container rounded-2xl px-5 py-1' : 'text-on-surface-variant px-5 py-1' }} active:scale-90 transition-transform duration-150" href="{{ route('consultas') }}">
            <span class="material-symbols-outlined" style="{{ Request::routeIs('consultas') ? "font-variation-settings: 'FILL' 1;" : '' }}">event</span>
            <span class="font-label-md text-label-md">Consultas</span>
        </a>
        <a class="flex flex-col items-center justify-center {{ Request::routeIs('mensagens') ? 'bg-primary-container text-on-primary-container rounded-2xl px-5 py-1' : 'text-on-surface-variant px-5 py-1' }} active:scale-90 transition-transform duration-150" href="{{ route('mensagens') }}">
            <span class="material-symbols-outlined" style="{{ Request::routeIs('mensagens') ? "font-variation-settings: 'FILL' 1;" : '' }}">mail</span>
            <span class="font-label-md text-label-md">Mensagens</span>
        </a>
        <a class="flex flex-col items-center justify-center {{ Request::routeIs('perfil') ? 'bg-primary-container text-on-primary-container rounded-2xl px-5 py-1' : 'text-on-surface-variant px-5 py-1' }} active:scale-90 transition-transform duration-150" href="{{ route('perfil') }}">
            <span class="material-symbols-outlined" style="{{ Request::routeIs('perfil') ? "font-variation-settings: 'FILL' 1;" : '' }}">person_outline</span>
            <span class="font-label-md text-label-md">Perfil</span>
        </a>
    </nav>

    @stack('scripts')
</body>
</html>
