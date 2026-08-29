<?php $__env->startSection('title', 'Consultas — MindCare'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $proxConsulta = $paciente->consultas->where('estado', 'Agendada')->first();
?>

<!-- Page Header -->
<div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4 mb-stack-lg">
    <div>
        <h2 class="font-headline-lg text-headline-lg text-primary">Agenda de Consultas</h2>
        <p class="text-body-md text-on-surface-variant">Faça a gestão dos seus horários e acompanhe o seu histórico clínico.</p>
    </div>
    <div class="flex w-full md:w-auto gap-stack-sm">
        <button class="w-full md:w-auto px-6 py-3 md:py-2 rounded-lg bg-primary text-on-primary font-semibold shadow-sm hover:opacity-90 active:scale-95 transition-all flex items-center justify-center gap-2" onclick="openNovaConsultaModal()">
            <span class="material-symbols-outlined text-[20px]">add</span>
            <span>Novo Agendamento</span>
        </button>
    </div>
</div>

<!-- Bento Grid Layout -->
<div class="grid grid-cols-12 gap-stack-lg">
    <!-- Calendar Section (Left Side - Bento Big Block) -->
    <div class="col-span-12 lg:col-span-8 space-y-stack-lg">
        <div class="bg-white p-6 rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/20">
            <div class="flex flex-col md:flex-row gap-4 justify-between items-start md:items-center mb-6 w-full overflow-hidden">
                <div class="flex items-center gap-4 w-full md:w-auto justify-between md:justify-start">
                    <h3 class="font-title-lg text-title-lg text-on-surface truncate">
                        <?php echo e($startOfWeek->format('d M')); ?> – <?php echo e($endOfWeek->format('d M, Y')); ?>

                    </h3>
                    <div class="flex gap-2 shrink-0">
                        <a href="<?php echo e(route('consultas', ['week' => $previousWeek->toDateString()])); ?>" class="w-8 h-8 bg-surface-container hover:bg-surface-variant rounded-full flex items-center justify-center transition-colors">
                            <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        </a>
                        <a href="<?php echo e(route('consultas', ['week' => $nextWeek->toDateString()])); ?>" class="w-8 h-8 bg-surface-container hover:bg-surface-variant rounded-full flex items-center justify-center transition-colors">
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </a>
                    </div>
                </div>
                
                <!-- Filtros por Estado -->
                <div class="flex w-full md:w-auto bg-surface-container-low rounded-lg p-1 text-xs font-semibold gap-1 overflow-x-auto custom-scrollbar scroll-smooth whitespace-nowrap">
                    <a href="<?php echo e(route('consultas', array_filter(request()->except('estado', 'page')))); ?>"
                       class="px-3 py-1.5 rounded-md transition-colors <?php echo e(!$estadoFilter ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant hover:bg-white/50'); ?>">Todas</a>
                    <a href="<?php echo e(route('consultas', array_merge(request()->except('estado', 'page'), ['estado' => 'Agendada']))); ?>"
                       class="px-3 py-1.5 rounded-md transition-colors <?php echo e($estadoFilter === 'Agendada' ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant hover:bg-white/50'); ?>">Agendadas</a>
                    <a href="<?php echo e(route('consultas', array_merge(request()->except('estado', 'page'), ['estado' => 'Realizada']))); ?>"
                       class="px-3 py-1.5 rounded-md transition-colors <?php echo e($estadoFilter === 'Realizada' ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant hover:bg-white/50'); ?>">Realizadas</a>
                    <a href="<?php echo e(route('consultas', array_merge(request()->except('estado', 'page'), ['estado' => 'Cancelada']))); ?>"
                       class="px-3 py-1.5 rounded-md transition-colors <?php echo e($estadoFilter === 'Cancelada' ? 'bg-white shadow-sm text-primary font-bold' : 'text-on-surface-variant hover:bg-white/50'); ?>">Canceladas</a>
                </div>
            </div>

            <!-- Sessões do Plano -->
            <?php if($sub): ?>
                <?php
                    $usadas = $sub->sessoes_usadas;
                    $total = $sub->plano->sessoes_total ?? 0;
                    $disp = $sub->sessoesDisponivel();
                    $pct = $total > 0 ? round(($usadas / $total) * 100) : 0;
                ?>
                <div class="px-4 py-3 mb-6 bg-surface-container-low rounded-xl border border-outline-variant/20">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-label-md text-on-surface-variant"><?php echo e($usadas); ?> de <?php echo e($total); ?> sessões utilizadas</span>
                        <span class="text-label-md font-semibold <?php echo e($disp === 0 ? 'text-error' : ($disp === 1 ? 'text-amber-500' : 'text-primary')); ?>"><?php echo e($disp); ?> restante<?php echo e($disp !== 1 ? 's' : ''); ?></span>
                    </div>
                    <div class="w-full bg-surface-variant rounded-full h-2">
                        <div class="h-2 rounded-full <?php echo e($disp === 0 ? 'bg-error' : ($disp === 1 ? 'bg-amber-400' : 'bg-primary')); ?>" style="width: <?php echo e($pct); ?>%"></div>
                    </div>
                    <?php if($disp === 0): ?>
                        <div class="mt-2 text-label-md text-error bg-error-container/30 rounded-lg px-3 py-2 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">error</span>
                            <span>As sessões do seu plano estão esgotadas. <a href="<?php echo e(route('plano')); ?>" class="font-semibold underline">Adquira mais sessões aqui</a>.</span>
                        </div>
                    <?php elseif($disp === 1): ?>
                        <div class="mt-2 text-label-md text-amber-700 bg-amber-50 rounded-lg px-3 py-2 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">warning</span>
                            <span>Última sessão disponível.</span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Calendário Principal -->
            <div class="calendar-body border border-outline-variant/30 rounded-xl overflow-x-auto custom-scrollbar">
                <div class="min-w-[700px]">
                    <!-- Cabeçalho (Dias da Semana) -->
                    <div class="grid grid-cols-8 bg-surface-container-low border-b border-outline-variant/30 text-center py-3 text-label-md font-bold text-on-surface-variant">
                        <div class="border-r border-outline-variant/20"></div>
                        <?php for($i = 0; $i < 7; $i++): ?>
                            <?php
                                $currentDay = $startOfWeek->copy()->addDays($i);
                                $isToday = $currentDay->isToday();
                            ?>
                            <div class="flex flex-col items-center justify-center border-r border-outline-variant/20 last:border-r-0 py-1 <?php echo e($isToday ? 'bg-primary-container/10 text-primary rounded-md font-bold' : ''); ?>">
                                <span class="text-[10px] uppercase"><?php echo e(substr($currentDay->translatedFormat('l'), 0, 3)); ?></span>
                                <span class="text-body-md mt-0.5"><?php echo e($currentDay->format('d')); ?></span>
                            </div>
                        <?php endfor; ?>
                    </div>

                    <!-- Grelha (Horas) -->
                    <div class="relative grid grid-cols-8 h-[660px] bg-white overflow-y-auto custom-scrollbar">
                        <!-- Eixo do Tempo (08:00 - 18:00) -->
                        <div class="col-span-1 border-r border-outline-variant/20 divide-y divide-outline-variant/10 text-[10px] text-on-surface-variant text-center font-semibold">
                            <?php for($hour = 8; $hour <= 18; $hour++): ?>
                                <div class="h-[60px] flex items-center justify-center"><?php echo e(str_pad($hour, 2, '0', STR_PAD_LEFT)); ?>:00</div>
                            <?php endfor; ?>
                        </div>

                        <!-- Colunas de Dias -->
                        <?php for($day = 0; $day < 7; $day++): ?>
                            <div class="col-span-1 border-r border-outline-variant/20 last:border-r-0 relative divide-y divide-outline-variant/10">
                                <?php for($hour = 8; $hour <= 18; $hour++): ?>
                                    <div class="h-[60px]"></div>
                                <?php endfor; ?>

                                <!-- Eventos do Dia -->
                                <?php $__currentLoopData = $consultasFiltradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consulta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $dateStr = \Carbon\Carbon::parse($consulta->data)->format('Y-m-d');
                                        $consultaDate = \Carbon\Carbon::parse($dateStr . ' ' . $consulta->hora);
                                        $consultaDayOfWeek = $consultaDate->dayOfWeekIso - 1;
                                    ?>
                                    
                                    <?php if($consultaDayOfWeek == $day): ?>
                                        <?php
                                            $hour = $consultaDate->hour;
                                            $minute = $consultaDate->minute;
                                            
                                            if ($hour >= 8 && $hour <= 18) {
                                                $topPosition = (($hour - 8) * 60) + $minute; 
                                                
                                                $eventClass = 'bg-primary-container/20 text-on-primary-fixed-variant border-primary';
                                                if ($consulta->estado == 'Realizada') $eventClass = 'bg-green-50 text-green-700 border-green-500';
                                                if ($consulta->estado == 'Cancelada') $eventClass = 'bg-error-container/20 text-error border-error';
                                            }
                                        ?>
                                        
                                        <?php if(isset($topPosition)): ?>
                                            <div class="absolute left-1 right-1 p-2 rounded-lg border-l-4 <?php echo e($eventClass); ?> text-[10px] shadow-sm hover:scale-[1.02] cursor-pointer transition-transform z-10" 
                                                 style="top: <?php echo e($topPosition); ?>px; height: 52px; overflow: hidden;"
                                                 data-id="<?php echo e($consulta->id); ?>"
                                                 data-profissional="<?php echo e($consulta->profissional->user->name ?? 'Clínica'); ?>"
                                                 data-data="<?php echo e($consultaDate->translatedFormat('l, d \d\e F \d\e Y')); ?>"
                                                 data-hora="<?php echo e($consultaDate->format('H:i')); ?>"
                                                 data-estado="<?php echo e($consulta->estado); ?>"
                                                 data-confirmavel="<?php echo e($consulta->estado === 'Agendada' && !$consulta->confirmada ? '1' : '0'); ?>"
                                                 onclick="abrirDetalheConsulta(this)">
                                                <div class="font-bold truncate"><?php echo e($consulta->tipo); ?></div>
                                                <div class="opacity-80 truncate"><?php echo e($consulta->profissional->user->name); ?></div>
                                                <div class="opacity-70 truncate"><?php echo e($consultaDate->format('H:i')); ?> · <?php echo e(ucfirst($consulta->modalidade)); ?></div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Upcoming & Past -->
    <div class="col-span-12 lg:col-span-4 space-y-stack-lg">
        <!-- Próximos Agendamentos -->
        <div class="bg-white p-6 rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/20 flex flex-col h-[400px]">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-title-lg text-title-lg text-on-surface">Próximos Agendamentos</h3>
                <?php $pendentesCount = $paciente->consultas->where('estado', 'Agendada')->count(); ?>
                <span class="px-2.5 py-0.5 bg-primary-container text-white text-label-md rounded-full font-bold"><?php echo e($pendentesCount); ?> agendada(s)</span>
            </div>
            
            <div class="flex-1 overflow-y-auto custom-scrollbar space-y-3 pr-1">
                <?php $__empty_1 = true; $__currentLoopData = $paciente->consultas->where('estado', 'Agendada'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consulta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-4 rounded-xl border border-outline-variant/30 hover:border-primary transition-all cursor-pointer bg-surface-container-lowest group"
                         data-id="<?php echo e($consulta->id); ?>"
                         data-profissional="<?php echo e($consulta->profissional->user->name ?? 'Clínica'); ?>"
                         data-data="<?php echo e(\Carbon\Carbon::parse($consulta->data)->translatedFormat('l, d \d\e F \d\e Y')); ?>"
                         data-hora="<?php echo e(\Carbon\Carbon::parse($consulta->hora)->format('H:i')); ?>"
                         data-estado="<?php echo e($consulta->estado); ?>"
                         data-confirmavel="<?php echo e(!$consulta->confirmada ? '1' : '0'); ?>"
                         onclick="abrirDetalheConsulta(this)">
                        <div class="flex justify-between items-start">
                            <div class="flex gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-full bg-primary-container/20 text-primary flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-lg">psychology</span>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-body-md font-bold text-on-surface truncate"><?php echo e($consulta->tipo); ?></p>
                                    <p class="text-body-sm text-on-surface-variant truncate"><?php echo e($consulta->profissional->user->name); ?></p>
                                </div>
                            </div>
                            <span class="text-label-md font-bold text-primary flex-shrink-0">
                                <?php if(\Carbon\Carbon::parse($consulta->data)->isToday()): ?> HOJE <?php else: ?> <?php echo e(\Carbon\Carbon::parse($consulta->data)->format('d M')); ?> <?php endif; ?>
                            </span>
                        </div>
                        <div class="mt-4 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-1.5 text-on-surface-variant">
                                <span class="material-symbols-outlined text-[16px]">schedule</span>
                                <span><?php echo e(\Carbon\Carbon::parse($consulta->hora)->format('H:i')); ?> · <?php echo e(ucfirst($consulta->modalidade)); ?></span>
                            </div>
                            <?php if($consulta->confirmada): ?>
                                <span class="text-primary font-bold flex items-center gap-0.5"><span class="material-symbols-outlined text-[14px]">check_circle</span> Confirmada</span>
                            <?php else: ?>
                                <span class="text-amber-500 font-bold">Pendente</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="py-12 text-center text-on-surface-variant text-xs flex flex-col items-center justify-center h-full">
                        <span class="material-symbols-outlined text-4xl opacity-20 mb-2">event_busy</span>
                        <p>Sem consultas agendadas no momento.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Histórico Recente -->
        <div class="glass-card p-6 rounded-xl shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/20">
            <h3 class="font-title-lg text-title-lg text-on-surface mb-4">Histórico Recente</h3>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $paciente->consultas->where('estado', '!=', 'Agendada')->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consulta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full <?php echo e($consulta->estado == 'Realizada' ? 'bg-green-500' : 'bg-error'); ?>"></div>
                            <div>
                                <p class="text-body-sm font-semibold text-on-surface"><?php echo e($consulta->tipo); ?></p>
                                <p class="text-label-md text-on-surface-variant"><?php echo e(\Carbon\Carbon::parse($consulta->data)->format('d \d\e F')); ?></p>
                            </div>
                        </div>
                        <span class="font-bold <?php echo e($consulta->estado == 'Realizada' ? 'text-primary' : 'text-error'); ?>"><?php echo e(ucfirst($consulta->estado)); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="py-4 text-center text-on-surface-variant text-xs">
                        <p>Nenhuma consulta finalizada encontrada.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- NOVO MODAL OVERLAY -->
<div id="modal-nova-consulta" class="fixed inset-0 z-[10000] flex items-end md:items-center justify-center bg-on-background/40 backdrop-blur-sm hidden" onclick="if(event.target===this)closeNovaConsultaModal()">
    <!-- MODAL CONTAINER -->
    <div class="bg-surface-container-lowest w-full max-w-[1000px] h-full md:h-auto md:max-h-[90vh] md:min-h-[500px] rounded-none md:rounded-[24px] shadow-2xl flex flex-col overflow-hidden animate-in fade-in duration-300">
        <form action="<?php echo e(route('portal.consultas.store')); ?>" method="POST" class="w-full flex flex-col md:flex-row flex-1 overflow-hidden">
            <?php echo csrf_field(); ?>
            
            <!-- MAIN CONTENT AREA (Left side) -->
            <div class="flex-1 flex flex-col overflow-hidden border-b md:border-b-0 md:border-r border-outline-variant/20">
                <!-- Header -->
                <div class="px-stack-lg px-4 md:px-stack-lg py-4 md:py-6 flex items-center justify-between flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-surface">Novo Agendamento</h3>
                    </div>
                    <button type="button" onclick="closeNovaConsultaModal()" class="w-10 h-10 rounded-full hover:bg-surface-variant flex items-center justify-center transition-colors flex-shrink-0">
                        <span class="material-symbols-outlined text-on-surface-variant">close</span>
                    </button>
                </div>

                <!-- Workflow Steps -->
                <div class="flex-1 overflow-y-auto px-4 md:px-stack-lg pb-stack-lg space-y-stack-lg">
                    
                    <!-- Step 1: Tipo de Consulta -->
                    <section class="space-y-4">
                        <label class="font-label-md text-label-md text-primary uppercase tracking-wider block">Passo 1: Tipo de Consulta</label>
                        <div class="relative">
                            <select name="tipo" class="w-full h-12 px-4 rounded-lg border border-outline-variant bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-secondary focus:border-secondary outline-none appearance-none font-body-md cursor-pointer transition-all bg-none" required>
                                <option disabled selected value="">Seleccione o tipo de consulta</option>
                                <?php $__currentLoopData = ['Individual', 'Casal', 'Familiar', 'Avaliação Inicial', 'Grupo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tipo); ?>" <?php if(old('tipo', 'Individual') === $tipo): echo 'selected'; endif; ?>><?php echo e($tipo); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="absolute right-4 inset-y-0 flex items-center pointer-events-none transition-transform duration-200 select-arrow">
                                <span class="material-symbols-outlined text-on-surface-variant text-[20px] leading-none">expand_more</span>
                            </div>
                        </div>
                    </section>

                    <!-- Step 2: Profissional -->
                    <section class="space-y-4">
                        <div class="flex justify-between items-end">
                            <label class="font-label-md text-label-md text-primary uppercase tracking-wider block">Passo 2: Escolha o Profissional</label>
                            <span class="text-body-sm font-body-sm text-on-surface-variant"><?php echo e(count($profissionais)); ?> especialistas disponíveis</span>
                        </div>
                        
                        <div class="flex gap-4 overflow-x-auto pb-2 scroll-smooth">
                            <?php $__currentLoopData = $profissionais; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profissional): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="cursor-pointer flex-shrink-0 w-60 p-4 rounded-xl border border-outline-variant hover:border-primary/50 hover:bg-surface-variant transition-all text-left relative">
                                <input type="radio" name="profissional_id" value="<?php echo e($profissional->id); ?>" <?php if(old('profissional_id') == $profissional->id): echo 'checked'; endif; ?> class="absolute opacity-0 w-0 h-0 peer" required>
                                <div class="peer-checked:border-primary peer-checked:border-2 peer-checked:bg-surface-container-high border-2 border-transparent absolute inset-0 rounded-xl pointer-events-none transition-all"></div>
                                
                                <div class="flex items-center gap-3 mb-3 relative z-10">
                                    <div class="w-12 h-12 rounded-full bg-primary-container/20 text-primary flex items-center justify-center font-bold text-lg uppercase">
                                        <?php echo e(substr($profissional->user->name, 0, 2)); ?>

                                    </div>
                                    <div>
                                        <h4 class="font-title-lg text-body-md font-bold text-on-surface leading-tight"><?php echo e($profissional->user->name); ?></h4>
                                        <p class="text-body-sm font-body-sm text-primary"><?php echo e($profissional->especialidade); ?></p>
                                    </div>
                                </div>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </section>

                    <!-- Step 3 & 4: Date & Time Grid -->
                    <section class="grid grid-cols-1 lg:grid-cols-2 gap-stack-lg">
                        <!-- Date -->
                        <div class="space-y-4">
                            <label class="font-label-md text-label-md text-primary uppercase tracking-wider block">Passo 3: Data</label>
                            <input type="date" name="data" class="w-full h-12 px-4 rounded-lg border border-outline-variant bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md" required min="<?php echo e(date('Y-m-d')); ?>" value="<?php echo e(old('data')); ?>">
                        </div>

                        <!-- Time Slots -->
                        <div class="space-y-4">
                            <label class="font-label-md text-label-md text-primary uppercase tracking-wider block">Passo 4: Horário</label>
                            <input type="time" name="hora" class="w-full h-12 px-4 rounded-lg border border-outline-variant bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md" required value="<?php echo e(old('hora', '10:00')); ?>">
                        </div>
                    </section>
                    
                    <!-- Step 5: Modalidade & Observações -->
                    <section class="space-y-4 mt-6 border-t border-outline-variant/30 pt-6">
                        <label class="font-label-md text-label-md text-primary uppercase tracking-wider block">Passo 5: Modalidade e Detalhes</label>
                        
                        <div class="flex gap-3 md:gap-6 mb-4">
                            <label class="flex items-center gap-2 cursor-pointer p-3 border border-outline-variant rounded-lg hover:bg-surface-variant transition-colors flex-1">
                                <input type="radio" name="modalidade" value="online" <?php if(old('modalidade', 'online') === 'online'): echo 'checked'; endif; ?> class="accent-primary w-4 h-4"> 
                                <span class="font-body-md font-medium text-on-surface">Online (Vídeo)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer p-3 border border-outline-variant rounded-lg hover:bg-surface-variant transition-colors flex-1">
                                <input type="radio" name="modalidade" value="presencial" <?php if(old('modalidade') === 'presencial'): echo 'checked'; endif; ?> class="accent-primary w-4 h-4"> 
                                <span class="font-body-md font-medium text-on-surface">Presencial</span>
                            </label>
                        </div>
                        
                        <textarea name="observacoes" class="w-full h-24 p-4 rounded-lg border border-outline-variant bg-surface-container-lowest text-on-surface focus:ring-2 focus:ring-secondary focus:border-secondary outline-none transition-all font-body-md resize-none" placeholder="Preferências ou notas para a equipa clínica (opcional)"><?php echo e(old('observacoes')); ?></textarea>
                    </section>
                    
                </div>
            </div>

            <!-- SUMMARY SIDEBAR (Right side) -->
            <aside class="w-full md:w-[320px] bg-surface-container flex flex-col md:h-full border-t md:border-t-0 md:border-l border-outline-variant/20 shrink-0">
                <!-- Cabeçalho expansível no mobile -->
                <button type="button" onclick="this.parentElement.classList.toggle('summary-open')" class="flex md:hidden items-center justify-between px-4 py-3 bg-surface-container-high/50 active:bg-surface-container-high transition-colors" aria-label="Mostrar resumo">
                    <span class="font-body-md font-bold text-on-surface text-sm">Resumo do Agendamento</span>
                    <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-200">expand_less</span>
                </button>
                
                <div class="hidden md:flex flex-col flex-1 p-stack-lg summary-mobile-content">
                    <h4 class="font-title-lg text-title-lg text-on-surface mb-stack-lg">Resumo do Agendamento</h4>
                    <div class="flex-1 space-y-6">
                        <!-- Selected Info -->
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-primary mt-1">person</span>
                                <div>
                                    <p class="text-body-sm font-label-md text-on-surface-variant">Especialista</p>
                                    <p class="font-body-md font-bold">Seleccione ao lado</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-primary mt-1">event</span>
                                <div>
                                    <p class="text-body-sm font-label-md text-on-surface-variant">Data e Hora</p>
                                    <p class="font-body-md font-bold">A definir</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-primary mt-1">payments</span>
                                <div>
                                    <p class="text-body-sm font-label-md text-on-surface-variant">Plano</p>
                                    <p class="font-body-md font-bold"><?php echo e($sub->plano->nome ?? 'Sem plano ativo'); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Divider -->
                        <div class="h-px bg-outline-variant/30"></div>
                        
                        <!-- Policy Note -->
                        <div class="bg-surface-container-high p-4 rounded-xl">
                            <p class="text-body-sm text-on-surface-variant leading-relaxed">
                                <span class="material-symbols-outlined text-[16px] align-middle mr-1">info</span>
                                Cancelamentos gratuitos até 24h antes do início da consulta.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Action Button - always visible -->
                <div class="p-4 md:p-stack-lg border-t md:border-t-0 border-outline-variant/20">
                    <button type="submit" class="w-full h-12 bg-primary text-on-primary font-bold rounded-full shadow-lg hover:bg-primary-container active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                        Confirmar Agendamento
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
            </aside>
        </form>
    </div>
</div>

<!-- Modal Lateral de Detalhe da Consulta -->
<?php if (isset($component)) { $__componentOriginal06466d70a5df71623dc2a561e77c49ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal06466d70a5df71623dc2a561e77c49ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.side-modal','data' => ['id' => 'modal-detalhe-consulta']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('side-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-detalhe-consulta']); ?>
     <?php $__env->slot('avatar', null, []); ?> 
        <div class="sm-avatar-placeholder" style="background: #EAF8F8; color: #005f5f; display: flex; align-items: center; justify-content: center;">
            <span class="material-symbols-outlined text-2xl">event_available</span>
        </div>
     <?php $__env->endSlot(); ?>
     <?php $__env->slot('title', null, []); ?> Detalhe da Consulta <?php $__env->endSlot(); ?>
     <?php $__env->slot('subtitle', null, []); ?> Visualize ou altere o estado da marcação. <?php $__env->endSlot(); ?>

    <div class="mb-6 mt-4">
        <div class="space-y-4">
            <div class="flex justify-between border-b border-outline-variant/30 pb-2 text-xs">
                <span class="text-on-surface-variant font-medium">Profissional:</span>
                <span class="text-on-surface font-bold" id="detalhe-prof"></span>
            </div>
            <div class="flex justify-between border-b border-outline-variant/30 pb-2 text-xs">
                <span class="text-on-surface-variant font-medium">Data:</span>
                <span class="text-on-surface font-bold" id="detalhe-data"></span>
            </div>
            <div class="flex justify-between border-b border-outline-variant/30 pb-2 text-xs">
                <span class="text-on-surface-variant font-medium">Hora:</span>
                <span class="text-on-surface font-bold" id="detalhe-hora"></span>
            </div>
            <div class="flex justify-between border-b border-outline-variant/30 pb-2 text-xs">
                <span class="text-on-surface-variant font-medium">Estado Atual:</span>
                <span class="text-primary font-bold" id="detalhe-estado"></span>
            </div>
        </div>
    </div>

    <form id="form-confirmar" method="POST" class="mb-3 hidden">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <button type="submit" class="w-full bg-primary text-on-primary py-3 rounded-lg font-bold hover:opacity-90 transition-all">Confirmar Presença</button>
    </form>

    <form id="form-cancelar" method="POST" class="hidden">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <button type="submit" class="w-full border border-error text-error py-3 rounded-lg font-bold hover:bg-error/5 transition-all">Cancelar Consulta</button>
    </form>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal06466d70a5df71623dc2a561e77c49ee)): ?>
<?php $attributes = $__attributesOriginal06466d70a5df71623dc2a561e77c49ee; ?>
<?php unset($__attributesOriginal06466d70a5df71623dc2a561e77c49ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal06466d70a5df71623dc2a561e77c49ee)): ?>
<?php $component = $__componentOriginal06466d70a5df71623dc2a561e77c49ee; ?>
<?php unset($__componentOriginal06466d70a5df71623dc2a561e77c49ee); ?>
<?php endif; ?>

<style>
/* Nova consulta modal mobile: summary toggle */
@media (max-width: 767px) {
    #modal-nova-consulta .summary-mobile-content {
        display: none;
    }
    #modal-nova-consulta .summary-open .summary-mobile-content {
        display: flex !important;
    }
    #modal-nova-consulta .summary-open > button span.material-symbols-outlined {
        transform: rotate(180deg);
    }
}
/* Select arrow rotation on focus */
#modal-nova-consulta select:focus ~ .select-arrow {
    transform: rotate(180deg);
}
</style>

<script>
function openNovaConsultaModal() {
    const el = document.getElementById('modal-nova-consulta');
    if (el) {
        el.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}
function closeNovaConsultaModal() {
    const el = document.getElementById('modal-nova-consulta');
    if (el) {
        el.classList.add('hidden');
        document.body.style.overflow = '';
    }
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeNovaConsultaModal();
    }
});

function abrirDetalheConsulta(el) {
    const id = el.getAttribute('data-id');
    const prof = el.getAttribute('data-profissional');
    const dataStr = el.getAttribute('data-data');
    const hora = el.getAttribute('data-hora');
    const estado = el.getAttribute('data-estado');
    const confirmavel = el.getAttribute('data-confirmavel');

    document.getElementById('detalhe-prof').innerText = prof;
    document.getElementById('detalhe-data').innerText = dataStr;
    document.getElementById('detalhe-hora').innerText = hora;
    document.getElementById('detalhe-estado').innerText = estado;

    const formConfirmar = document.getElementById('form-confirmar');
    const formCancelar = document.getElementById('form-cancelar');
    
    const urlBase = "<?php echo e(url('portal/consultas')); ?>";
    formConfirmar.action = urlBase + '/' + id + '/confirmar';
    formCancelar.action = urlBase + '/' + id + '/cancelar';

    if (estado === 'Agendada') {
        formCancelar.style.display = 'block';
        formConfirmar.style.display = confirmavel === '1' ? 'block' : 'none';
    } else {
        formConfirmar.style.display = 'none';
        formCancelar.style.display = 'none';
    }

    openSideModal('modal-detalhe-consulta');
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.portal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/portal/consultas.blade.php ENDPATH**/ ?>