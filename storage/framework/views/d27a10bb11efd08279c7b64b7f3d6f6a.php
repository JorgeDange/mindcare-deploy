<?php $__env->startSection('title', $paciente->user?->name ?? 'Paciente'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto">
    <!-- Profile Header -->
    <div class="bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30 p-6 mb-6">
        <div class="flex items-center gap-5">
            <?php if($paciente->user?->foto_perfil): ?>
                <img src="<?php echo e(asset('storage/' . $paciente->user->foto_perfil)); ?>" alt="Foto"
                     class="w-16 h-16 rounded-full object-cover">
            <?php else: ?>
                <div class="w-16 h-16 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center text-lg font-bold">
                    <?php echo e($paciente->user?->iniciais ?? '?'); ?>

                </div>
            <?php endif; ?>
            <div class="flex-1">
                <h2 class="font-title-lg text-title-lg text-on-surface"><?php echo e($paciente->user?->name); ?></h2>
                <p class="text-body-sm text-on-surface-variant"><?php echo e($paciente->user?->email); ?></p>
                <div class="flex items-center gap-3 mt-2">
                    <?php if($paciente->subscricaoActiva?->plano): ?>
                        <span class="font-label-md font-semibold px-2.5 py-1 rounded-full bg-primary-fixed text-on-primary-fixed text-[11px]">
                            <?php echo e($paciente->subscricaoActiva->plano->nome); ?>

                        </span>
                    <?php endif; ?>
                    <span class="text-xs text-on-surface-variant flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                        Desde <?php echo e($paciente->data_inicio?->format('d/m/Y') ?? '—'); ?>

                    </span>
                </div>
            </div>
            <a href="<?php echo e(route('profissional.pacientes.ficha', $paciente)); ?>"
               class="px-4 py-2 text-sm font-semibold text-on-primary bg-primary rounded-full hover:opacity-90 transition-all flex items-center gap-1">
                <span class="material-symbols-outlined text-[18px]">edit_note</span> Editar Ficha
            </a>
        </div>
    </div>

    <!-- Tabs -->
    <?php
        $tab = request('tab', 'info');
    ?>
    <div class="portal-tabs mb-6">
        <a href="<?php echo e(route('profissional.pacientes.show', ['paciente' => $paciente, 'tab' => 'info'])); ?>"
           class="portal-tab <?php echo e($tab === 'info' ? 'active' : ''); ?> flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">info</span> Informações
        </a>
        <a href="<?php echo e(route('profissional.pacientes.show', ['paciente' => $paciente, 'tab' => 'consultas'])); ?>"
           class="portal-tab <?php echo e($tab === 'consultas' ? 'active' : ''); ?> flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">calendar_month</span> Consultas
        </a>
        <a href="<?php echo e(route('profissional.pacientes.show', ['paciente' => $paciente, 'tab' => 'plano'])); ?>"
           class="portal-tab <?php echo e($tab === 'plano' ? 'active' : ''); ?> flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">assignment</span> Plano
        </a>
    </div>

    <!-- Tab Content -->
    <?php if($tab === 'info'): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
            <div class="bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30 p-6">
                <h3 class="font-title-lg text-title-lg text-on-surface mb-4">Dados Pessoais</h3>
                <dl class="space-y-3 text-body-sm">
                    <div class="flex justify-between">
                        <dt class="text-on-surface-variant">Nome</dt>
                        <dd class="text-on-surface font-medium"><?php echo e($paciente->user?->name ?? '—'); ?></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-on-surface-variant">Email</dt>
                        <dd class="text-on-surface font-medium"><?php echo e($paciente->user?->email ?? '—'); ?></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-on-surface-variant">Telefone</dt>
                        <dd class="text-on-surface font-medium"><?php echo e($paciente->user?->telefone ?? '—'); ?></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-on-surface-variant">Data de Início</dt>
                        <dd class="text-on-surface font-medium"><?php echo e($paciente->data_inicio?->format('d/m/Y') ?? '—'); ?></dd>
                    </div>
                </dl>
            </div>
            <div class="bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30 p-6">
                <h3 class="font-title-lg text-title-lg text-on-surface mb-4">Dados Clínicos</h3>
                <dl class="space-y-3 text-body-sm">
                    <div>
                        <dt class="text-on-surface-variant mb-1">Motivo da Consulta</dt>
                        <dd class="text-on-surface"><?php echo e($paciente->motivo_consulta ?? '—'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-on-surface-variant mb-1">Condições</dt>
                        <dd class="text-on-surface"><?php echo e($paciente->condicoes ?? '—'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-on-surface-variant mb-1">Medicação</dt>
                        <dd class="text-on-surface"><?php echo e($paciente->medicacao ?? '—'); ?></dd>
                    </div>
                </dl>
            </div>
        </div>

    <?php elseif($tab === 'consultas'): ?>
        <div class="bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30 overflow-hidden">
            <div class="px-6 py-4 border-b border-outline-variant/30">
                <h3 class="font-title-lg text-title-lg text-on-surface">Últimas Consultas</h3>
            </div>
            <?php if($paciente->consultas->isNotEmpty()): ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-body-sm">
                        <thead>
                            <tr class="bg-surface-container-low text-left font-label-md text-on-surface-variant uppercase tracking-wider">
                                <th class="py-3 px-4">Data</th>
                                <th class="py-3 px-4">Hora</th>
                                <th class="py-3 px-4">Tipo</th>
                                <th class="py-3 px-4">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $paciente->consultas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consulta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $badgeClasses = [
                                        'Agendada' => 'bg-secondary-container text-on-secondary-container',
                                        'Realizada' => 'bg-primary-fixed text-on-primary-fixed',
                                        'Faltou' => 'bg-amber-50 text-amber-800',
                                        'Cancelada' => 'bg-error-container text-on-error-container',
                                    ];
                                ?>
                                <tr class="border-b border-outline-variant/20">
                                    <td class="py-3 px-4 text-on-surface"><?php echo e($consulta->data->format('d/m/Y')); ?></td>
                                    <td class="py-3 px-4 text-on-surface"><?php echo e(\Carbon\Carbon::parse($consulta->hora)->format('H:i')); ?></td>
                                    <td class="py-3 px-4 text-on-surface"><?php echo e($consulta->tipo); ?></td>
                                    <td class="py-3 px-4">
                                        <span class="font-label-md font-semibold px-2.5 py-1 rounded-full text-[11px] <?php echo e($badgeClasses[$consulta->estado] ?? 'bg-surface-variant text-on-surface-variant'); ?>">
                                            <?php echo e($consulta->estado); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="p-8 text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-3xl mb-3 block opacity-30">calendar_month</span>
                    <p class="text-body-sm">Nenhuma consulta registada.</p>
                </div>
            <?php endif; ?>
        </div>

    <?php elseif($tab === 'plano'): ?>
        <div class="bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30 p-6">
            <?php if($paciente->subscricaoActiva?->plano): ?>
                <?php
                    $sub = $paciente->subscricaoActiva;
                    $plano = $sub->plano;
                    $restantes = $plano->sessoes_total - $sub->sessoes_usadas;
                    $progresso = $plano->sessoes_total > 0 ? round(($sub->sessoes_usadas / $plano->sessoes_total) * 100) : 0;
                ?>
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="font-title-lg text-title-lg text-on-surface"><?php echo e($plano->nome); ?></h3>
                        <p class="text-body-sm text-on-surface-variant mt-0.5"><?php echo e($plano->descricao); ?></p>
                    </div>
                    <span class="font-label-md font-semibold px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed">Activo</span>
                </div>
                <div class="mb-4">
                    <div class="flex justify-between text-body-sm mb-1">
                        <span class="text-on-surface-variant">Progresso</span>
                        <span class="text-on-surface font-medium"><?php echo e($sub->sessoes_usadas); ?>/<?php echo e($plano->sessoes_total); ?> sessões</span>
                    </div>
                    <div class="w-full bg-surface-variant rounded-full h-2">
                        <div class="bg-primary h-2 rounded-full transition-all" style="width: <?php echo e($progresso); ?>%"></div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-body-sm">
                    <div class="bg-surface-container-low rounded-lg p-3">
                        <p class="text-on-surface-variant">Sessões Restantes</p>
                        <p class="text-lg font-bold text-on-surface"><?php echo e(max(0, $restantes)); ?></p>
                    </div>
                    <div class="bg-surface-container-low rounded-lg p-3">
                        <p class="text-on-surface-variant">Validade</p>
                        <p class="text-lg font-bold text-on-surface"><?php echo e($sub->data_validade?->format('d/m/Y') ?? '—'); ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-8 text-on-surface-variant">
                    <span class="material-symbols-outlined text-3xl mb-3 block opacity-30">assignment</span>
                    <p class="text-body-sm">Paciente sem plano activo.</p>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.profissional', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/profissional/pacientes/show.blade.php ENDPATH**/ ?>