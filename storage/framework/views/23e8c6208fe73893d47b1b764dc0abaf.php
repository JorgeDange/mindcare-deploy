<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['consulta']));

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

foreach (array_filter((['consulta']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $paciente = $consulta->paciente;
    $user = $paciente?->user;
    $estados = [
        'Agendada' => 'bg-blue-100 text-blue-700',
        'Realizada' => 'bg-gray-100 text-gray-600',
        'Cancelada' => 'bg-red-100 text-red-700',
        'Faltou' => 'bg-amber-100 text-amber-700',
    ];
    $badgeClasse = $estados[$consulta->estado] ?? 'bg-gray-100 text-gray-600';
?>

<tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
    <td class="py-3 px-4">
        <div class="flex items-center gap-3">
            <?php if($user?->foto_perfil): ?>
                <img src="<?php echo e(asset('storage/' . $user->foto_perfil)); ?>" alt="Foto"
                     class="w-9 h-9 rounded-full object-cover">
            <?php else: ?>
                <div class="w-9 h-9 rounded-full bg-mc text-white flex items-center justify-center text-xs font-bold">
                    <?php echo e($user?->iniciais ?? '?'); ?>

                </div>
            <?php endif; ?>
            <div>
                <p class="text-sm font-medium text-gray-900"><?php echo e($user?->name ?? 'Paciente'); ?></p>
                <p class="text-xs text-gray-500"><?php echo e($paciente?->motivo_consulta ?? ''); ?></p>
            </div>
        </div>
    </td>
    <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap">
        <?php echo e(\Carbon\Carbon::parse($consulta->data)->format('d/m/Y')); ?>

    </td>
    <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap">
        <?php echo e(\Carbon\Carbon::parse($consulta->hora)->format('H:i')); ?>

    </td>
    <td class="py-3 px-4">
        <span class="inline-block text-xs font-medium px-3 py-1 rounded-full <?php echo e($badgeClasse); ?>">
            <?php echo e($consulta->estado); ?>

        </span>
    </td>
    <td class="py-3 px-4">
        <div class="flex items-center gap-2">
            <?php if($consulta->estado === 'Agendada'): ?>
                <?php if(!$consulta->confirmada): ?>
                    <form method="POST" action="<?php echo e(route('profissional.consultas.estado', $consulta)); ?>" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" name="estado" value="confirmada">
                        <button type="submit" class="text-xs text-green-600 hover:text-green-800 font-medium">Confirmar</button>
                    </form>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('profissional.consultas.estado', $consulta)); ?>" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" name="estado" value="realizada">
                        <button type="submit" class="text-xs text-green-600 hover:text-green-800 font-medium">Realizar</button>
                    </form>
                    <form method="POST" action="<?php echo e(route('profissional.consultas.estado', $consulta)); ?>" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" name="estado" value="falta">
                        <button type="submit" class="text-xs text-amber-600 hover:text-amber-800 font-medium">Faltou</button>
                    </form>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('profissional.consultas.estado', $consulta)); ?>" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="estado" value="cancelada">
                    <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium">Cancelar</button>
                </form>
            <?php endif; ?>
            <a href="<?php echo e(route('profissional.pacientes.show', $paciente)); ?>" class="text-xs text-mc hover:text-mcLight font-medium">
                <i class="fa-solid fa-eye"></i>
            </a>
        </div>
    </td>
</tr>
<?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/components/profissional/consulta-row.blade.php ENDPATH**/ ?>