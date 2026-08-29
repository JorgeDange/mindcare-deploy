<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Profissional — MindCare'); ?></title>
    <link rel="shortcut icon" href="<?php echo e(asset('assets/logoti.png')); ?>" type="image/x-icon">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/side-modal.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/table-layout.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/form-tabs.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/chat-layout.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>

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
    <?php if (isset($component)) { $__componentOriginald5d051f243b37508d39f8ce3d92a5684 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald5d051f243b37508d39f8ce3d92a5684 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.loader','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('loader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald5d051f243b37508d39f8ce3d92a5684)): ?>
<?php $attributes = $__attributesOriginald5d051f243b37508d39f8ce3d92a5684; ?>
<?php unset($__attributesOriginald5d051f243b37508d39f8ce3d92a5684); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald5d051f243b37508d39f8ce3d92a5684)): ?>
<?php $component = $__componentOriginald5d051f243b37508d39f8ce3d92a5684; ?>
<?php unset($__componentOriginald5d051f243b37508d39f8ce3d92a5684); ?>
<?php endif; ?>

    <?php
        $profissional = Auth::user()->loadMissing('profissional')->profissional;
        $especialidade = $profissional->especialidade ?? '';
        $unreadMsgs = $profissional
            ? \App\Models\Conversa::where('profissional_id', $profissional->id)
                ->withCount(['mensagens as nao_lidas' => fn ($q) => $q->where('remetente_id', '!=', Auth::id())->where('lida', false)])
                ->get()
                ->sum('nao_lidas')
            : 0;
        $layoutUnreadNotifications = Auth::user()->unreadNotifications->count();
        $layoutRecentNotifications = Auth::user()->notifications()->orderByDesc('created_at')->take(5)->get();

        $nav = [
            ['route' => 'profissional.dashboard',   'icon' => 'dashboard',          'label' => 'Dashboard'],
            ['route' => 'profissional.agenda',      'icon' => 'calendar_month',     'label' => 'Agenda'],
            ['route' => 'profissional.pacientes.index', 'icon' => 'groups',         'label' => 'Pacientes'],
            ['route' => 'profissional.mensagens.index', 'icon' => 'chat',           'label' => 'Mensagens', 'badge' => $unreadMsgs],
            ['route' => 'profissional.documentos.index', 'icon' => 'description',   'label' => 'Documentos'],
            ['route' => 'profissional.perfil',      'icon' => 'person',             'label' => 'Perfil'],
        ];

        $isActive = fn($r) => request()->routeIs($r);
    ?>

    <!-- Sidebar -->
    <aside class="hidden md:flex fixed left-0 top-0 h-full w-[280px] bg-surface border-r border-outline-variant flex-col py-stack-lg z-50">
        <div class="px-gutter mb-10 flex justify-between items-start">
            <div>
                <h1 class="font-headline-md text-headline-md font-bold text-primary">MindCare</h1>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Painel do Profissional</p>
                <p class="font-label-md text-[10px] text-primary/80 mt-1 uppercase tracking-wider"><?php echo e($especialidade ?: 'Profissional'); ?></p>
            </div>
            <button class="md:hidden w-10 h-10 text-on-surface-variant hover:bg-surface-variant rounded-full flex items-center justify-center transition-colors" onclick="document.querySelector('aside').classList.add('hidden')"><span class="material-symbols-outlined">close</span></button>
        </div>

        <nav class="flex-grow space-y-1">
            <?php $__currentLoopData = $nav; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="flex items-center gap-3 px-6 py-3 transition-all duration-200
                          <?php echo e($isActive($item['route'])
                              ? 'border-l-4 border-primary bg-surface-container-high text-on-surface font-bold'
                              : 'text-on-surface-variant hover:bg-surface-variant'); ?>"
                   href="<?php echo e(route($item['route'])); ?>">
                    <span class="material-symbols-outlined"><?php echo e($item['icon']); ?></span>
                    <span class="font-body-md text-body-md"><?php echo e($item['label']); ?></span>
                    <?php if(isset($item['badge']) && $item['badge'] > 0): ?>
                        <span class="ml-auto bg-error text-on-error font-bold text-[10px] min-w-[18px] h-[18px] rounded-full flex items-center justify-center px-1">
                            <?php echo e($item['badge']); ?>

                        </span>
                    <?php endif; ?>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>

        <div class="px-6 mt-6">
            <a href="<?php echo e(route('profissional.agenda')); ?>" class="w-full bg-primary text-on-primary py-3 px-4 rounded-xl font-bold flex items-center justify-center gap-2 hover:opacity-90 active:scale-95 transition-all shadow-md">
                <span class="material-symbols-outlined">add</span>
                <span>Nova Consulta</span>
            </a>
        </div>

        <footer class="mt-auto px-6 space-y-1">
            <a class="flex items-center gap-3 py-2 text-on-surface-variant hover:text-primary transition-colors" href="<?php echo e(route('profissional.perfil')); ?>">
                <span class="material-symbols-outlined">settings</span>
                <span class="font-body-md text-body-md">Definições</span>
            </a>
            <form method="POST" action="<?php echo e(route('logout')); ?>" id="logout-form" class="m-0">
                <?php echo csrf_field(); ?>
                <button type="submit" class="flex items-center gap-3 py-2 text-error hover:opacity-80 transition-colors w-full text-left cursor-pointer bg-transparent border-none p-0 outline-none">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="font-body-md text-body-md font-medium">Sair</span>
                </button>
            </form>
        </footer>
    </aside>

    <!-- TopBar -->
    <header class="fixed top-0 left-0 right-0 md:left-[280px] h-16 bg-surface shadow-sm md:bg-background md:shadow-none flex justify-between items-center px-margin-mobile md:px-gutter z-40">
        <div class="flex items-center gap-4 md:hidden">
            <button class="w-10 h-10 text-primary hover:bg-surface-container-high rounded-full flex items-center justify-center active:scale-95 duration-100 transition-colors" onclick="document.querySelector('aside').classList.toggle('hidden')"><span class="material-symbols-outlined">menu</span></button>
            <h1 class="font-headline-md text-headline-md font-bold text-primary">MindCare</h1>
        </div>

        <div class="relative w-96 hidden md:block">
            <span class="material-symbols-outlined absolute left-3 inset-y-0 my-auto flex items-center text-on-surface-variant">search</span>
            <input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-4 text-body-sm focus:ring-2 focus:ring-primary/20 transition-all outline-none" placeholder="Pesquisar..." type="text"/>
        </div>

        <div class="flex items-center gap-stack-lg">
            <div class="flex items-center gap-4">
                <!-- Notifications Dropdown -->
                <div class="relative" id="notif-dropdown-toggle" onclick="toggleDropdown('notif-dropdown')" style="cursor: pointer;">
                    <button class="relative w-10 h-10 text-on-surface-variant hover:bg-surface-variant rounded-full flex items-center justify-center transition-colors">
                        <span class="material-symbols-outlined">notifications</span>
                        <?php if($layoutUnreadNotifications > 0): ?>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-error rounded-full"></span>
                        <?php endif; ?>
                    </button>

                    <div id="notif-dropdown" class="fixed top-[72px] left-1/2 -translate-x-1/2 w-[calc(100vw-32px)] md:absolute md:top-full md:left-auto md:-translate-x-0 md:right-0 md:mt-2 md:w-80 bg-white rounded-xl shadow-lg border border-outline-variant/30 py-2 hidden z-50 origin-top">
                        <div class="px-4 py-2 border-b border-outline-variant/20 flex justify-between items-center">
                            <span class="font-bold text-on-surface text-sm">Notificações</span>
                            <?php if($layoutUnreadNotifications > 0): ?>
                                <span class="bg-error text-on-error text-[10px] font-bold px-1.5 py-0.5 rounded-full"><?php echo e($layoutUnreadNotifications); ?></span>
                            <?php endif; ?>
                        </div>

                        <?php if($layoutRecentNotifications->isEmpty()): ?>
                            <div class="px-4 py-6 text-center text-on-surface-variant text-xs">
                                <span class="material-symbols-outlined text-3xl opacity-30 mb-2">notifications_off</span>
                                <p>De momento, não tem novas notificações.</p>
                            </div>
                        <?php else: ?>
                            <div class="max-h-60 overflow-y-auto">
                                <?php $__currentLoopData = $layoutRecentNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $data = $notif->data;
                                        $isUnread = is_null($notif->read_at);
                                    ?>
                                    <a href="<?php echo e(data_get($data, 'url', '#')); ?>" class="flex items-start gap-3 px-4 py-3 hover:bg-surface-container-low transition-colors <?php echo e($isUnread ? 'bg-surface-container-lowest font-medium' : ''); ?>">
                                        <div class="p-1.5 rounded-lg <?php echo e($isUnread ? 'bg-primary-container text-on-primary-container' : 'bg-surface-variant text-on-surface-variant'); ?>">
                                            <span class="material-symbols-outlined text-[18px]"><?php echo e(data_get($data, 'icone', 'notifications')); ?></span>
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            <p class="text-xs text-on-surface truncate"><?php echo e(data_get($data, 'titulo', 'Notificação')); ?></p>
                                            <p class="text-[10px] text-on-surface-variant truncate"><?php echo e(data_get($data, 'mensagem', '')); ?></p>
                                            <p class="text-[9px] text-on-surface-variant/70 mt-1"><?php echo e($notif->created_at->diffForHumans()); ?></p>
                                        </div>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="px-4 py-2 border-t border-outline-variant/20 text-center">
                                <a href="<?php echo e(route('notificacoes')); ?>" class="text-xs text-primary font-bold hover:underline">Ver todas</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <button class="w-10 h-10 text-on-surface-variant hover:bg-surface-variant rounded-full flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined">help</span>
                </button>
            </div>

            <div class="h-8 w-[1px] bg-outline-variant"></div>

            <!-- User Dropdown -->
            <div class="relative" id="user-dropdown-toggle" onclick="toggleDropdown('user-dropdown')" style="cursor: pointer;">
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="font-label-md text-label-md font-bold text-on-surface"><?php echo e(explode(' ', trim(Auth::user()->name))[0]); ?></p>
                        <p class="font-label-md text-[10px] text-on-surface-variant"><?php echo e($especialidade ?: 'Profissional'); ?></p>
                    </div>

                    <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                        <?php if(Auth::user()->foto_perfil): ?>
                            <img src="<?php echo e(Auth::user()->foto_url); ?>" alt="Foto de Perfil" class="w-full h-full object-cover rounded-full">
                        <?php else: ?>
                            <div class="w-full h-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-sm">
                                <?php echo e(Auth::user()->iniciais ?? strtoupper(substr(Auth::user()->name, 0, 2))); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div id="user-dropdown" class="user-dropdown-menu hidden">
                    <div class="user-dropdown-header">
                        <span class="user-dropdown-name"><?php echo e(Auth::user()->name); ?></span>
                        <span class="user-dropdown-plan"><?php echo e($especialidade ?: 'Profissional'); ?></span>
                    </div>
                    <div class="user-dropdown-divider"></div>
                    <a href="<?php echo e(route('profissional.perfil')); ?>" class="user-dropdown-item">
                        <span class="material-symbols-outlined user-dropdown-icon">person</span>
                        <span>O Meu Perfil</span>
                    </a>
                    <div class="user-dropdown-divider"></div>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="m-0">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="user-dropdown-item user-dropdown-danger">
                            <span class="material-symbols-outlined user-dropdown-icon">logout</span>
                            <span>Terminar Sessão</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Canvas -->
    <main class="md:ml-[280px] pt-[80px] md:pt-[96px] pb-24 md:pb-8 px-margin-mobile md:px-margin-desktop min-h-screen">
        <div class="max-w-container-max mx-auto">
            <?php if (isset($component)) { $__componentOriginal5b09c79149dfb771c232996af5f9dae4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b09c79149dfb771c232996af5f9dae4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.flash-messages','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flash-messages'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b09c79149dfb771c232996af5f9dae4)): ?>
<?php $attributes = $__attributesOriginal5b09c79149dfb771c232996af5f9dae4; ?>
<?php unset($__attributesOriginal5b09c79149dfb771c232996af5f9dae4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b09c79149dfb771c232996af5f9dae4)): ?>
<?php $component = $__componentOriginal5b09c79149dfb771c232996af5f9dae4; ?>
<?php unset($__componentOriginal5b09c79149dfb771c232996af5f9dae4); ?>
<?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <!-- Interactive Atmospheric Element -->
    <div class="fixed inset-0 pointer-events-none z-[-1] overflow-hidden" id="particles"></div>

    <script>
        // Background atmosphere
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

        // Dropdown toggle
        function toggleDropdown(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.toggle('hidden');
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

        // Notification polling
        setInterval(() => {
            fetch('<?php echo e(route('notificacoes.nao-lidas')); ?>', {
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
    <?php if (isset($component)) { $__componentOriginal115e82920da0ed7c897ee494af74b9d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal115e82920da0ed7c897ee494af74b9d8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.loading-overlay','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('loading-overlay'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal115e82920da0ed7c897ee494af74b9d8)): ?>
<?php $attributes = $__attributesOriginal115e82920da0ed7c897ee494af74b9d8; ?>
<?php unset($__attributesOriginal115e82920da0ed7c897ee494af74b9d8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal115e82920da0ed7c897ee494af74b9d8)): ?>
<?php $component = $__componentOriginal115e82920da0ed7c897ee494af74b9d8; ?>
<?php unset($__componentOriginal115e82920da0ed7c897ee494af74b9d8); ?>
<?php endif; ?>

    <!-- BottomNav (Mobile) -->
    <nav class="md:hidden fixed bottom-0 left-0 w-full bg-surface-container-lowest border-t border-outline-variant/20 shadow-[0_-4px_12px_rgba(0,0,0,0.05)] h-20 px-2 pb-safe flex justify-around items-center z-50 rounded-t-xl">
        <a class="flex flex-col items-center justify-center <?php echo e(Request::routeIs('profissional.dashboard') ? 'bg-primary-container text-on-primary-container rounded-2xl px-5 py-1' : 'text-on-surface-variant px-5 py-1'); ?> active:scale-90 transition-transform duration-150" href="<?php echo e(route('profissional.dashboard')); ?>">
            <span class="material-symbols-outlined" style="<?php echo e(Request::routeIs('profissional.dashboard') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">dashboard</span>
            <span class="font-label-md text-label-md">Home</span>
        </a>
        <a class="flex flex-col items-center justify-center <?php echo e(Request::routeIs('profissional.agenda') ? 'bg-primary-container text-on-primary-container rounded-2xl px-5 py-1' : 'text-on-surface-variant px-5 py-1'); ?> active:scale-90 transition-transform duration-150" href="<?php echo e(route('profissional.agenda')); ?>">
            <span class="material-symbols-outlined" style="<?php echo e(Request::routeIs('profissional.agenda') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">event</span>
            <span class="font-label-md text-label-md">Agenda</span>
        </a>
        <a class="flex flex-col items-center justify-center <?php echo e(Request::routeIs('profissional.mensagens.*') ? 'bg-primary-container text-on-primary-container rounded-2xl px-5 py-1' : 'text-on-surface-variant px-5 py-1'); ?> active:scale-90 transition-transform duration-150" href="<?php echo e(route('profissional.mensagens.index')); ?>">
            <span class="material-symbols-outlined" style="<?php echo e(Request::routeIs('profissional.mensagens.*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">mail</span>
            <span class="font-label-md text-label-md">Mensagens</span>
        </a>
        <a class="flex flex-col items-center justify-center <?php echo e(Request::routeIs('profissional.pacientes.*') ? 'bg-primary-container text-on-primary-container rounded-2xl px-5 py-1' : 'text-on-surface-variant px-5 py-1'); ?> active:scale-90 transition-transform duration-150" href="<?php echo e(route('profissional.pacientes.index')); ?>">
            <span class="material-symbols-outlined" style="<?php echo e(Request::routeIs('profissional.pacientes.*') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">groups</span>
            <span class="font-label-md text-label-md">Pacientes</span>
        </a>
        <a class="flex flex-col items-center justify-center <?php echo e(Request::routeIs('profissional.perfil') ? 'bg-primary-container text-on-primary-container rounded-2xl px-5 py-1' : 'text-on-surface-variant px-5 py-1'); ?> active:scale-90 transition-transform duration-150" href="<?php echo e(route('profissional.perfil')); ?>">
            <span class="material-symbols-outlined" style="<?php echo e(Request::routeIs('profissional.perfil') ? "font-variation-settings: 'FILL' 1;" : ''); ?>">person_outline</span>
            <span class="font-label-md text-label-md">Perfil</span>
        </a>
    </nav>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/layouts/profissional.blade.php ENDPATH**/ ?>