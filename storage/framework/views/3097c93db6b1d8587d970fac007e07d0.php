<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['activeRoute' => 'dashboard']));

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

foreach (array_filter((['activeRoute' => 'dashboard']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $p = Auth::user()->paciente;
    $unreadMsgs = $p
        ? $p->conversas()->with('mensagens')->get()->flatMap(fn ($c) => $c->mensagens)->where('remetente_id', '!=', Auth::id())->where('lida', false)->count()
        : 0;
    $newDocs = $p ? $p->documentos()->where('novo', true)->count() : 0;
    $planoNome = $p?->subscricaoActiva?->plano?->nome ?? null;

    $nav = [
        ['route' => 'dashboard',   'icon' => 'dashboard',          'label' => 'Dashboard'],
        ['route' => 'consultas',   'icon' => 'calendar_month',     'label' => 'Consultas'],
        ['route' => 'mensagens',   'icon' => 'chat',               'label' => 'Mensagens', 'badge' => $unreadMsgs],
        ['route' => 'plano',       'icon' => 'medical_services',   'label' => 'Planos'],
        ['route' => 'ficha',       'icon' => 'description',        'label' => 'Ficha Clínica'],
        ['route' => 'documentos',  'icon' => 'assessment',         'label' => 'Relatórios', 'badge' => $newDocs],
        ['route' => 'perfil',      'icon' => 'person',             'label' => 'Perfil'],
    ];

    $isActive = fn($r) => request()->routeIs($r);
?>

<aside class="hidden md:flex fixed left-0 top-0 h-full w-[280px] bg-surface border-r border-outline-variant flex-col py-stack-lg z-50">
    <div class="px-gutter mb-10 flex justify-between items-start">
        <div>
            <h1 class="font-headline-md text-headline-md font-bold text-primary">MindCare</h1>
            <p class="font-body-sm text-body-sm text-on-surface-variant">Portal do Paciente</p>
            <?php if($planoNome): ?>
                <p class="font-label-md text-[10px] text-primary/80 mt-1 uppercase tracking-wider"><?php echo e($planoNome); ?></p>
            <?php endif; ?>
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
    </div>
    
    <footer class="mt-auto px-6">
        <form method="POST" action="<?php echo e(route('logout')); ?>" id="logout-form" class="m-0">
            <?php echo csrf_field(); ?>
            <button type="submit" class="flex items-center gap-3 py-2 text-error hover:opacity-80 transition-colors w-full text-left cursor-pointer bg-transparent border-none p-0 outline-none">
                <span class="material-symbols-outlined">logout</span>
                <span class="font-body-md text-body-md font-medium">Sair</span>
            </button>
        </form>
    </footer>
</aside>
<?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/components/portal-sidebar.blade.php ENDPATH**/ ?>