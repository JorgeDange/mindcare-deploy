<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['unreadNotifications' => 0, 'recentNotifications' => collect()]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['unreadNotifications' => 0, 'recentNotifications' => collect()]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $u = Auth::user();
    $p = $u->paciente;
    $planoNome = $p?->subscricaoActiva?->plano?->nome ?? 'Paciente';
?>

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
            <!-- Dropdown Notificações -->
            <div class="relative" id="notif-dropdown-toggle" onclick="toggleDropdown('notif-dropdown')" style="cursor: pointer;">
                <button class="relative w-10 h-10 text-on-surface-variant hover:bg-surface-variant rounded-full flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                    <?php if($unreadNotifications > 0): ?>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-error rounded-full"></span>
                    <?php endif; ?>
                </button>
                
                <div id="notif-dropdown" class="fixed top-[72px] left-1/2 -translate-x-1/2 w-[calc(100vw-32px)] md:absolute md:top-full md:left-auto md:-translate-x-0 md:right-0 md:mt-2 md:w-80 bg-white rounded-xl shadow-lg border border-outline-variant/30 py-2 hidden z-50 origin-top">
                    <div class="px-4 py-2 border-b border-outline-variant/20 flex justify-between items-center">
                        <span class="font-bold text-on-surface text-sm">Notificações</span>
                        <?php if($unreadNotifications > 0): ?>
                            <span class="bg-error text-on-error text-[10px] font-bold px-1.5 py-0.5 rounded-full"><?php echo e($unreadNotifications); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if($recentNotifications->isEmpty()): ?>
                        <div class="px-4 py-6 text-center text-on-surface-variant text-xs">
                            <span class="material-symbols-outlined text-3xl opacity-30 mb-2">notifications_off</span>
                            <p>De momento, não tens novas notificações.</p>
                        </div>
                    <?php else: ?>
                        <div class="max-h-60 overflow-y-auto">
                            <?php $__currentLoopData = $recentNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
        
        <!-- Dropdown Utilizador -->
        <div class="relative" id="user-dropdown-toggle" onclick="toggleDropdown('user-dropdown')" style="cursor: pointer;">
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="font-label-md text-label-md font-bold text-on-surface"><?php echo e(explode(' ', trim($u->name))[0]); ?></p>
                    <p class="font-label-md text-[10px] text-on-surface-variant"><?php echo e($planoNome); ?></p>
                </div>
                
                <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                    <?php if($u->foto_perfil): ?>
                        <img src="<?php echo e($u->foto_url); ?>" alt="Foto de Perfil" class="w-full h-full object-cover rounded-full">
                    <?php else: ?>
                        <div class="w-full h-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-sm">
                            <?php echo e($u->iniciais ?? strtoupper(substr($u->name, 0, 2))); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div id="user-dropdown" class="user-dropdown-menu hidden">
                <div class="user-dropdown-header">
                    <span class="user-dropdown-name"><?php echo e($u->name); ?></span>
                    <span class="user-dropdown-plan"><?php echo e($planoNome); ?></span>
                </div>
                <div class="user-dropdown-divider"></div>
                <a href="<?php echo e(route('perfil')); ?>" class="user-dropdown-item">
                    <span class="material-symbols-outlined user-dropdown-icon">person</span>
                    <span>O Meu Perfil</span>
                </a>
                <a href="<?php echo e(route('ficha')); ?>" class="user-dropdown-item">
                    <span class="material-symbols-outlined user-dropdown-icon">description</span>
                    <span>Minha Ficha</span>
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
<?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/components/portal-topbar.blade.php ENDPATH**/ ?>