<?php $__env->startSection('title', 'Pacientes — Profissional'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <header class="mb-stack-lg">
        <h2 class="font-headline-lg text-headline-lg text-on-surface">Meus Pacientes</h2>
        <p class="font-body-md text-body-md text-on-surface-variant"><?php echo e($pacientes->count()); ?> paciente(s) atribuído(s) a si.</p>
    </header>

    <!-- Search -->
    <div class="mb-6">
        <div class="relative max-w-md">
            <span class="material-symbols-outlined absolute left-4 inset-y-0 my-auto flex items-center text-on-surface-variant">search</span>
            <input type="text" id="search-pacientes" placeholder="Pesquisar por nome..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-outline-variant/30 bg-white text-body-sm focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none shadow-sm">
        </div>
    </div>

    <!-- Pacientes Grid -->
    <div id="pacientes-grid" class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
        <?php $__empty_1 = true; $__currentLoopData = $pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paciente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $user = $paciente->user;
                $plano = $paciente->subscricaoActiva?->plano;
                $sessoesRestantes = $paciente->sessoes_restantes;
                $sessoesClasse = $sessoesRestantes > 2
                    ? 'bg-primary-fixed text-on-primary-fixed'
                    : ($sessoesRestantes > 0 ? 'bg-amber-50 text-amber-800' : 'bg-error-container text-on-error-container');
            ?>
            <div class="bg-white rounded-xl p-5 shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30 flex items-center gap-4 hover:shadow-md transition-shadow"
                 data-nome="<?php echo e(strtolower($user?->name ?? '')); ?>">
                <?php if($user?->foto_perfil): ?>
                    <img src="<?php echo e(asset('storage/' . $user->foto_perfil)); ?>" alt="Foto"
                         class="w-12 h-12 rounded-full object-cover flex-shrink-0">
                <?php else: ?>
                    <div class="w-12 h-12 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center text-sm font-bold flex-shrink-0">
                        <?php echo e($user?->iniciais ?? '?'); ?>

                    </div>
                <?php endif; ?>
                <div class="flex-1 min-w-0">
                    <p class="text-body-md font-bold text-on-surface truncate"><?php echo e($user?->name ?? 'Paciente'); ?></p>
                    <div class="flex items-center gap-2 mt-1 flex-wrap">
                        <?php if($plano): ?>
                            <span class="font-label-md font-semibold px-2.5 py-0.5 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px]">
                                <?php echo e($plano->nome); ?>

                            </span>
                            <span class="font-label-md font-semibold px-2.5 py-0.5 rounded-full <?php echo e($sessoesClasse); ?> text-[11px]">
                                <?php echo e($sessoesRestantes); ?> <?php echo e($sessoesRestantes === 1 ? 'sessão' : 'sessões'); ?>

                            </span>
                        <?php else: ?>
                            <span class="font-label-md font-semibold px-2.5 py-0.5 rounded-full bg-surface-variant text-on-surface-variant text-[11px]">
                                Sem plano
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <a href="<?php echo e(route('profissional.pacientes.show', $paciente)); ?>"
                   class="text-label-md font-medium text-primary hover:underline whitespace-nowrap flex-shrink-0 flex items-center gap-1">
                    Ver perfil <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-16 text-on-surface-variant">
                <span class="material-symbols-outlined text-4xl opacity-30 mb-4 block">groups</span>
                <p class="text-body-sm">Nenhum paciente atribuído.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.getElementById('search-pacientes')?.addEventListener('input', function() {
        const term = this.value.toLowerCase().trim();
        document.querySelectorAll('#pacientes-grid > div').forEach(el => {
            const nome = el.dataset.nome || '';
            el.style.display = nome.includes(term) ? '' : 'none';
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.profissional', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/profissional/pacientes/index.blade.php ENDPATH**/ ?>