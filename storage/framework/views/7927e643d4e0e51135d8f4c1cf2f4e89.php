<?php $__env->startSection('title', 'Dashboard — Profissional'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $totalConsultas = $consultasMes->sum() ?? 0;
    $totalRealizadas = $consultasMes['Realizada'] ?? 0;
    $pctRealizadas = $totalConsultas > 0 ? round(($totalRealizadas / $totalConsultas) * 100) : 0;
?>

<!-- Welcome Header -->
<header class="mb-stack-lg">
    <h2 class="font-headline-lg text-headline-lg text-on-surface">Olá, <?php echo e(explode(' ', Auth::user()->name)[0]); ?>. Pronto para mais um dia?</h2>
    <p class="font-body-md text-body-md text-on-surface-variant">Aqui está o resumo da sua prática clínica.</p>
</header>

<!-- Bento Grid Layout -->
<div class="grid grid-cols-12 gap-stack-lg">
    <!-- Metrics Row (Asymmetric Large Block) -->
    <section class="col-span-12 lg:col-span-8 grid grid-cols-2 md:grid-cols-3 gap-stack-md">
        <div class="col-span-2 md:col-span-3 bg-primary-container text-on-primary-container p-stack-lg rounded-xl flex flex-col md:flex-row md:items-center justify-between shadow-sm relative overflow-hidden group">
            <div class="z-10">
                <p class="font-label-md text-label-md uppercase tracking-wider opacity-80">Resumo do Mês</p>
                <h3 class="font-headline-md text-headline-md font-bold mt-1">
                    <?php echo e($totalConsultas > 0 ? 'Você realizou '.$totalRealizadas.' de '.$totalConsultas.' consultas' : 'A sua agenda está vazia este mês'); ?>

                </h3>
                <p class="font-body-sm text-body-sm mt-2 max-w-md">Acompanhe o progresso dos seus atendimentos e mantenha-se organizado.</p>
            </div>
            <div class="z-10 mt-4 md:mt-0 flex gap-2">
                <a href="<?php echo e(route('profissional.agenda')); ?>" class="bg-surface-container-lowest text-primary px-4 py-2 rounded-lg font-bold text-label-md hover:scale-105 transition-transform shadow-sm">Ver Agenda</a>
            </div>
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
        </div>

        <!-- Mini Stat Cards -->
        <div class="bg-white p-stack-md rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] flex flex-col justify-between border border-outline-variant/30">
            <div class="flex justify-between items-start">
                <span class="w-10 h-10 bg-secondary-container text-on-secondary-container rounded-lg flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined">groups</span></span>
                <span class="text-primary font-bold text-label-md flex items-center gap-1"><?php echo e($totalPacientes); ?> total</span>
            </div>
            <div class="mt-4">
                <p class="font-body-sm text-body-sm text-on-surface-variant">Pacientes</p>
                <p class="font-headline-md text-headline-md font-bold text-on-surface"><?php echo e($totalPacientes); ?></p>
            </div>
        </div>

        <div class="bg-white p-stack-md rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] flex flex-col justify-between border border-outline-variant/30">
            <div class="flex justify-between items-start">
                <span class="w-10 h-10 bg-primary-fixed text-on-primary-fixed rounded-lg flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined">calendar_today</span></span>
                <span class="text-primary font-bold text-label-md flex items-center gap-1"><?php echo e($consultasHoje); ?> hoje</span>
            </div>
            <div class="mt-4">
                <p class="font-body-sm text-body-sm text-on-surface-variant">Consultas Hoje</p>
                <p class="font-headline-md text-headline-md font-bold text-on-surface"><?php echo e($consultasHoje); ?></p>
            </div>
        </div>

        <div class="bg-white p-stack-md rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] flex flex-col justify-between border border-outline-variant/30">
            <div class="flex justify-between items-start">
                <span class="w-10 h-10 bg-surface-variant text-on-surface-variant rounded-lg flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined">upcoming</span></span>
                <span class="text-primary font-bold text-label-md"><?php echo e($proximasConsultas->count()); ?> agendadas</span>
            </div>
            <div class="mt-4">
                <p class="font-body-sm text-body-sm text-on-surface-variant">Próximas</p>
                <p class="font-headline-md text-headline-md font-bold text-on-surface"><?php echo e($proximasConsultas->count()); ?></p>
            </div>
        </div>
    </section>

    <!-- Progression Card (Tall Block) -->
    <section class="col-span-12 lg:col-span-4 bg-secondary text-white rounded-xl p-stack-lg flex flex-col items-center justify-center text-center shadow-md relative overflow-hidden">
        <div class="relative z-10 w-full">
            <p class="font-label-md text-label-md uppercase tracking-widest opacity-80 mb-4">Taxa de Realização</p>
            <div class="relative w-32 h-32 mb-6 mx-auto">
                <svg class="w-full h-full" viewbox="0 0 36 36">
                    <path class="text-white/20" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="100, 100" stroke-width="3"></path>
                    <path class="text-white" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="<?php echo e($pctRealizadas); ?>, 100" stroke-linecap="round" stroke-width="3"></path>
                    <text class="fill-white font-bold text-[8px]" text-anchor="middle" x="18" y="20.35"><?php echo e($pctRealizadas); ?>%</text>
                </svg>
            </div>
            <h3 class="font-title-lg text-title-lg font-bold mb-2"><?php echo e($pctRealizadas >= 70 ? 'Excelente desempenho!' : 'Espaço para melhorar'); ?></h3>
            <p class="font-body-sm text-body-sm opacity-90 mb-6"><?php echo e($totalRealizadas); ?> de <?php echo e($totalConsultas); ?> consultas realizadas este mês.</p>
            <a href="<?php echo e(route('profissional.agenda')); ?>" class="block w-full bg-white text-secondary py-3 rounded-xl font-bold hover:bg-secondary-fixed transition-colors active:scale-95 shadow-sm text-center">Gerir Agenda</a>
        </div>
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-white rounded-full"></div>
            <div class="absolute bottom-0 right-0 w-60 h-60 bg-white rounded-full"></div>
        </div>
    </section>

    <!-- Próximas Consultas -->
    <section class="col-span-12 lg:col-span-8 bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30">
        <div class="p-stack-md border-b border-outline-variant/30 flex justify-between items-center">
            <h3 class="font-title-lg text-title-lg text-on-surface">Próximas Consultas</h3>
            <a class="text-primary font-bold text-label-md hover:underline" href="<?php echo e(route('profissional.agenda')); ?>">Ver agenda</a>
        </div>
        <?php if($proximasConsultas->isNotEmpty()): ?>
        <div class="divide-y divide-outline-variant/20">
            <?php $__currentLoopData = $proximasConsultas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consulta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $paciente = $consulta->paciente;
                    $user = $paciente?->user;
                ?>
                <div class="flex items-center justify-between px-5 py-4 hover:bg-surface-container-low transition-colors gap-3">
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        <?php if($user?->foto_perfil): ?>
                            <img src="<?php echo e(asset('storage/' . $user->foto_perfil)); ?>" alt="Foto" class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                        <?php else: ?>
                            <div class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center text-xs font-bold flex-shrink-0">
                                <?php echo e($user?->iniciais ?? '?'); ?>

                            </div>
                        <?php endif; ?>
                        <div class="min-w-0">
                            <p class="text-body-md font-bold text-on-surface truncate"><?php echo e($user?->name ?? 'Paciente'); ?></p>
                            <p class="text-body-sm text-on-surface-variant"><?php echo e(\Carbon\Carbon::parse($consulta->data)->format('d M Y')); ?> · <?php echo e(\Carbon\Carbon::parse($consulta->hora)->format('H:i')); ?> · <?php echo e($consulta->tipo); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <span class="font-label-md font-semibold px-3 py-1 rounded-full
                            <?php echo e($consulta->estado == 'Agendada' ? 'bg-secondary-container text-on-secondary-container' : ''); ?>

                            <?php echo e($consulta->estado == 'Realizada' ? 'bg-primary-fixed text-on-primary-fixed' : ''); ?>

                            <?php echo e($consulta->estado == 'Cancelada' ? 'bg-error-container text-on-error-container' : ''); ?>

                            <?php echo e($consulta->estado == 'Faltou' ? 'bg-amber-50 text-amber-800' : ''); ?>">
                            <?php echo e($consulta->estado); ?>

                        </span>
                        <?php if($consulta->estado === 'Agendada'): ?>
                            <?php if(!$consulta->confirmada): ?>
                                <form method="POST" action="<?php echo e(route('profissional.consultas.estado', $consulta)); ?>" class="inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                    <input type="hidden" name="estado" value="confirmada">
                                    <button type="submit" class="w-8 h-8 text-green-600 hover:bg-green-50 rounded-full flex items-center justify-center transition-colors" title="Confirmar">
                                        <span class="material-symbols-outlined text-[18px]">check</span>
                                    </button>
                                </form>
                            <?php endif; ?>
                            <form method="POST" action="<?php echo e(route('profissional.consultas.estado', $consulta)); ?>" class="inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="estado" value="cancelada">
                                <button type="submit" class="w-8 h-8 text-error hover:bg-error-container/20 rounded-full flex items-center justify-center transition-colors" title="Cancelar">
                                    <span class="material-symbols-outlined text-[18px]">close</span>
                                </button>
                            </form>
                        <?php endif; ?>
                        <?php if($consulta->estado === 'Agendada' && $consulta->confirmada): ?>
                            <form method="POST" action="<?php echo e(route('profissional.consultas.estado', $consulta)); ?>" class="inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="estado" value="realizada">
                                <button type="submit" class="w-8 h-8 text-green-600 hover:bg-green-50 rounded-full flex items-center justify-center transition-colors" title="Realizar">
                                    <span class="material-symbols-outlined text-[18px]">task_alt</span>
                                </button>
                            </form>
                            <form method="POST" action="<?php echo e(route('profissional.consultas.estado', $consulta)); ?>" class="inline">
                                <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="estado" value="falta">
                                <button type="submit" class="w-8 h-8 text-amber-600 hover:bg-amber-50 rounded-full flex items-center justify-center transition-colors" title="Faltou">
                                    <span class="material-symbols-outlined text-[18px]">block</span>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <div class="p-stack-md text-center text-on-surface-variant text-body-sm py-8">
            <span class="material-symbols-outlined text-3xl opacity-30 mb-2">event_busy</span>
            <p class="font-semibold text-on-surface mb-1">Nenhuma consulta agendada</p>
            <p class="mb-4">Agende uma nova consulta para começar.</p>
            <button onclick="window.location.href='<?php echo e(route('profissional.agenda')); ?>'" class="inline-block bg-primary text-on-primary px-4 py-2 rounded-lg text-label-md font-bold hover:opacity-90 transition-all">Agendar</button>
        </div>
        <?php endif; ?>
    </section>

    <!-- Resumo do Mês -->
    <section class="col-span-12 lg:col-span-4 bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30">
        <div class="p-stack-md border-b border-outline-variant/30">
            <h3 class="font-title-lg text-title-lg text-on-surface">Resumo do Mês</h3>
            <p class="text-body-sm text-on-surface-variant mt-0.5"><?php echo e(now()->translatedFormat('F Y')); ?></p>
        </div>
        <div class="p-stack-md space-y-3">
            <?php if($consultasMes->isNotEmpty()): ?>
                <?php $__currentLoopData = ['Agendada' => 'secondary-container', 'Realizada' => 'primary-fixed', 'Faltou' => 'amber-100', 'Cancelada' => 'error-container']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado => $cor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(isset($consultasMes[$estado])): ?>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-<?php echo e(str_replace('-', '-', explode('-', $cor)[0])); ?>-400"></span>
                            <span class="text-body-sm text-on-surface-variant"><?php echo e($estado); ?></span>
                        </div>
                        <span class="text-body-sm font-bold text-on-surface"><?php echo e($consultasMes[$estado]); ?></span>
                    </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <hr class="border-outline-variant/20 my-1">
                <div class="flex items-center justify-between">
                    <span class="text-body-sm font-medium text-on-surface">Total</span>
                    <span class="text-body-sm font-bold text-primary"><?php echo e($consultasMes->sum()); ?></span>
                </div>
            <?php else: ?>
                <div class="text-center text-on-surface-variant py-4">
                    <span class="material-symbols-outlined text-3xl opacity-30 mb-2 block">bar_chart</span>
                    <p class="text-body-sm">Nenhuma consulta este mês.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Mensagens Não Lidas + Atalhos -->
    <section class="col-span-12 lg:col-span-4 bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30">
        <div class="p-stack-md border-b border-outline-variant/30">
            <h3 class="font-title-lg text-title-lg text-on-surface">Atalhos Rápidos</h3>
        </div>
        <div class="p-stack-md space-y-3">
            <a href="<?php echo e(route('profissional.mensagens.index')); ?>" class="flex items-center gap-4 p-3 rounded-xl hover:bg-surface-container-low transition-colors group">
                <div class="w-12 h-12 rounded-xl bg-secondary-container text-on-secondary-container flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined">chat</span>
                </div>
                <div>
                    <p class="font-body-md font-bold text-on-surface">Mensagens</p>
                    <p class="text-body-sm text-on-surface-variant"><?php echo e($mensagensNaoLidas); ?> não lida(s)</p>
                </div>
            </a>
            <a href="<?php echo e(route('profissional.pacientes.index')); ?>" class="flex items-center gap-4 p-3 rounded-xl hover:bg-surface-container-low transition-colors group">
                <div class="w-12 h-12 rounded-xl bg-primary-fixed text-on-primary-fixed flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined">groups</span>
                </div>
                <div>
                    <p class="font-body-md font-bold text-on-surface">Pacientes</p>
                    <p class="text-body-sm text-on-surface-variant"><?php echo e($totalPacientes); ?> no total</p>
                </div>
            </a>
            <a href="<?php echo e(route('profissional.documentos.index')); ?>" class="flex items-center gap-4 p-3 rounded-xl hover:bg-surface-container-low transition-colors group">
                <div class="w-12 h-12 rounded-xl bg-surface-variant text-on-surface-variant flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined">description</span>
                </div>
                <div>
                    <p class="font-body-md font-bold text-on-surface">Documentos</p>
                    <p class="text-body-sm text-on-surface-variant">Gerir ficheiros clínicos</p>
                </div>
            </a>
        </div>
    </section>

    <!-- Últimos Pacientes -->
    <section class="col-span-12 lg:col-span-8 bg-white rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/30">
        <div class="p-stack-md border-b border-outline-variant/30 flex justify-between items-center">
            <h3 class="font-title-lg text-title-lg text-on-surface">Atividade Recente</h3>
            <a href="<?php echo e(route('profissional.agenda')); ?>" class="text-primary font-bold text-label-md hover:underline">Ver tudo</a>
        </div>
        <div class="p-stack-md text-center text-on-surface-variant text-body-sm py-6">
            <span class="material-symbols-outlined text-3xl opacity-30 mb-2 block">timeline</span>
            <p>Continue acompanhando a sua agenda para ver as atividades mais recentes.</p>
            <a href="<?php echo e(route('profissional.agenda')); ?>" class="inline-block mt-4 bg-primary text-on-primary px-4 py-2 rounded-lg text-label-md font-bold hover:opacity-90 transition-all">Ir para Agenda</a>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.profissional', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/profissional/dashboard.blade.php ENDPATH**/ ?>