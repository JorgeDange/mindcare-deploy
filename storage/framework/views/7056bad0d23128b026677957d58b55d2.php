<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['titulo', 'valor', 'icone', 'cor' => 'blue', 'descricao' => '']));

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

foreach (array_filter((['titulo', 'valor', 'icone', 'cor' => 'blue', 'descricao' => '']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $cores = [
        'blue' => 'bg-blue-50 text-blue-600',
        'green' => 'bg-green-50 text-green-600',
        'amber' => 'bg-amber-50 text-amber-600',
        'rose' => 'bg-rose-50 text-rose-600',
        'purple' => 'bg-purple-50 text-purple-600',
        'teal' => 'bg-teal-50 text-teal-600',
    ];
    $corClasse = $cores[$cor] ?? $cores['blue'];
?>

<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
    <div class="w-12 h-12 rounded-lg <?php echo e($corClasse); ?> flex items-center justify-center flex-shrink-0">
        <i class="fa-solid <?php echo e($icone); ?> text-lg"></i>
    </div>
    <div class="min-w-0">
        <p class="text-2xl font-bold text-gray-900"><?php echo e($valor); ?></p>
        <p class="text-sm text-gray-500 truncate"><?php echo e($titulo); ?></p>
        <?php if($descricao): ?>
            <p class="text-xs text-gray-400 mt-0.5"><?php echo e($descricao); ?></p>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/components/profissional/stat-card.blade.php ENDPATH**/ ?>