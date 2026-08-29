<?php $__env->startSection('title', 'Relatórios — MindCare'); ?>

<?php $__env->startSection('content'); ?>
<?php
    // Extrair último clínico e outros clínicos
    $ultimoClinico = $documentos->first(fn($doc) => 
        strtolower($doc->categoria ?? '') === 'clínico' || 
        strtolower($doc->categoria ?? '') === 'clinico' || 
        strtolower($doc->tipo ?? '') === 'clinico' || 
        strtolower($doc->tipo ?? '') === 'clínico'
    );
    
    $outrosClinicos = $documentos->filter(fn($doc) => 
        (strtolower($doc->categoria ?? '') === 'clínico' || 
         strtolower($doc->categoria ?? '') === 'clinico' || 
         strtolower($doc->tipo ?? '') === 'clinico' || 
         strtolower($doc->tipo ?? '') === 'clínico') 
        && (!$ultimoClinico || $doc->id !== $ultimoClinico->id)
    )->take(1);

    // Extrair financeiros
    $financeiros = $documentos->filter(fn($doc) => 
        strtolower($doc->categoria ?? '') === 'financeiro' || 
        strtolower($doc->tipo ?? '') === 'financeiro'
    )->take(2);
?>

<div class="space-y-stack-lg">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
        <div>
            <h2 class="font-headline-lg text-headline-lg text-primary">Central de Relatórios</h2>
            <p class="text-body-lg text-on-surface-variant mt-2">Acompanhe seu progresso e acesse documentos clínicos e financeiros.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <!-- Search & Filters -->
            <div class="relative w-full sm:w-64">
                <span class="material-symbols-outlined absolute left-3 inset-y-0 my-auto flex items-center text-on-surface-variant opacity-60">search</span>
                <input id="search-input" class="w-full pl-10 pr-4 py-2 bg-white border border-outline-variant/30 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-sm outline-none" placeholder="Pesquisar relatórios..." type="text"/>
            </div>
            <select id="filter-category" class="bg-white border border-outline-variant/30 rounded-xl py-2 pl-4 pr-10 text-body-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none cursor-pointer">
                <option value="">Todas as categorias</option>
                <option value="Clínico">Clínico</option>
                <option value="Financeiro">Financeiro</option>
            </select>
        </div>
    </div>

    <!-- Bento Grid Categories -->
    <section class="grid grid-cols-12 gap-stack-md">
        <!-- Clinical Reports Card (Large) -->
        <div class="col-span-12 lg:col-span-8 bg-white rounded-xl p-stack-lg shadow-sm border border-surface-variant/50 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-8 opacity-[0.03] group-hover:opacity-10 group-hover:scale-110 transition-all duration-700 pointer-events-none">
                <span class="material-symbols-outlined text-[120px] text-primary">monitor_heart</span>
            </div>
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-stack-md">
                        <span class="w-10 h-10 bg-primary-fixed text-on-primary-fixed rounded-lg flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined">clinical_notes</span></span>
                        <h3 class="font-title-lg text-title-lg">Relatórios Clínicos</h3>
                    </div>
                    <p class="text-body-sm text-on-surface-variant max-w-xl mb-stack-lg">Histórico de evoluções, diagnósticos, planos de tratamento e resultados de avaliações psicológicas mensais.</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-stack-sm mt-4">
                    <?php if($ultimoClinico): ?>
                        <div onclick="abrirDocumento(<?php echo e($ultimoClinico->id); ?>, '<?php echo e(addslashes($ultimoClinico->nome)); ?>', '<?php echo e(addslashes($ultimoClinico->partilhadoPor->name ?? 'Clínica')); ?>', '<?php echo e($ultimoClinico->created_at->format('d/m/Y')); ?>')" class="bg-surface p-4 rounded-lg border border-surface-variant hover:border-primary transition-all cursor-pointer">
                            <p class="text-[10px] font-bold text-primary mb-1 uppercase tracking-wider">Último</p>
                            <p class="font-bold text-on-surface text-body-sm truncate" title="<?php echo e($ultimoClinico->nome); ?>"><?php echo e($ultimoClinico->nome); ?></p>
                            <p class="text-[11px] text-on-surface-variant mt-1"><?php echo e($ultimoClinico->created_at->diffForHumans()); ?></p>
                        </div>
                    <?php else: ?>
                        <div class="bg-surface p-4 rounded-lg border border-surface-variant opacity-60">
                            <p class="text-[10px] font-bold text-primary mb-1 uppercase tracking-wider">Último</p>
                            <p class="font-bold text-on-surface text-body-sm truncate">Sem relatórios</p>
                            <p class="text-[11px] text-on-surface-variant mt-1">-</p>
                        </div>
                    <?php endif; ?>

                    <?php $__currentLoopData = $outrosClinicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cDoc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div onclick="abrirDocumento(<?php echo e($cDoc->id); ?>, '<?php echo e(addslashes($cDoc->nome)); ?>', '<?php echo e(addslashes($cDoc->partilhadoPor->name ?? 'Clínica')); ?>', '<?php echo e($cDoc->created_at->format('d/m/Y')); ?>')" class="bg-surface p-4 rounded-lg border border-surface-variant hover:border-primary transition-all cursor-pointer">
                            <p class="text-[10px] font-bold text-primary mb-1 uppercase tracking-wider">Clínico</p>
                            <p class="font-bold text-on-surface text-body-sm truncate" title="<?php echo e($cDoc->nome); ?>"><?php echo e($cDoc->nome); ?></p>
                            <p class="text-[11px] text-on-surface-variant mt-1"><?php echo e($cDoc->created_at->format('d/m/Y')); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div onclick="document.getElementById('filter-category').value = 'Clínico'; document.getElementById('filter-category').dispatchEvent(new Event('change'));" class="flex items-center justify-center border-2 border-dashed border-surface-variant hover:border-primary rounded-lg hover:bg-surface transition-all cursor-pointer text-on-surface-variant p-4">
                        <span class="font-label-md text-label-md text-primary font-bold">Ver todos clínicos</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Reports Card -->
        <div class="col-span-12 lg:col-span-4 bg-white rounded-xl p-stack-lg shadow-sm border border-surface-variant/50 relative overflow-hidden group">
            <div class="absolute -bottom-4 -right-4 opacity-[0.02] group-hover:opacity-5 group-hover:rotate-12 transition-all duration-500 pointer-events-none">
                <span class="material-symbols-outlined text-[160px] text-secondary">account_balance_wallet</span>
            </div>
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-stack-md">
                        <span class="w-10 h-10 bg-secondary-fixed text-on-secondary-fixed rounded-lg flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined">receipt_long</span></span>
                        <h3 class="font-title-lg text-title-lg">Financeiros</h3>
                    </div>
                    <p class="text-body-sm text-on-surface-variant mb-auto">Recibos para convênio, notas fiscais e histórico de faturamento detalhado por período.</p>
                </div>
                <div class="mt-stack-lg space-y-stack-sm">
                    <?php $__empty_1 = true; $__currentLoopData = $financeiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fDoc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-3 bg-surface rounded-lg border border-surface-variant/40">
                            <div class="flex items-center gap-2 overflow-hidden">
                                <span class="material-symbols-outlined text-secondary flex-shrink-0">picture_as_pdf</span>
                                <span class="text-body-sm font-bold text-on-surface truncate" title="<?php echo e($fDoc->nome); ?>"><?php echo e($fDoc->nome); ?></span>
                            </div>
                            <a href="<?php echo e(route('portal.documento.download', $fDoc->id)); ?>" class="material-symbols-outlined text-on-surface-variant cursor-pointer hover:text-primary transition-colors flex-shrink-0" title="Descarregar">download</a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-4 bg-surface rounded-lg text-body-sm text-on-surface-variant border border-dashed border-outline-variant/30">
                            Sem recibos recentes
                        </div>
                    <?php endif; ?>

                    <button onclick="document.getElementById('filter-category').value = 'Financeiro'; document.getElementById('filter-category').dispatchEvent(new Event('change'));" class="w-full py-2 text-primary font-bold text-body-sm hover:underline flex items-center justify-center gap-2 mt-2">
                        Ver todos financeiros
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Detailed Table Section -->
    <section class="bg-white rounded-xl shadow-sm border border-surface-variant/50 overflow-hidden">
        <div class="px-stack-lg py-stack-md border-b border-surface-variant flex justify-between items-center bg-surface/10">
            <h3 class="font-title-lg text-title-lg">Documentos Recentes</h3>
            <div class="flex items-center gap-4">
                <span class="text-body-sm text-on-surface-variant font-medium">
                    Exibindo <?php echo e($documentos->firstItem() ?? 0); ?> - <?php echo e($documentos->lastItem() ?? 0); ?> de <?php echo e($documentos->total() ?? 0); ?> documentos
                </span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface/50 text-on-surface-variant border-b border-surface-variant">
                        <th class="px-stack-lg py-4 font-label-md text-label-md uppercase tracking-wider">Nome do Documento</th>
                        <th class="px-stack-lg py-4 font-label-md text-label-md uppercase tracking-wider">Categoria</th>
                        <th class="px-stack-lg py-4 font-label-md text-label-md uppercase tracking-wider">Data de Emissão</th>
                        <th class="px-stack-lg py-4 font-label-md text-label-md uppercase tracking-wider">Tamanho</th>
                        <th class="px-stack-lg py-4 font-label-md text-label-md uppercase tracking-wider">Status</th>
                        <th class="px-stack-lg py-4 font-label-md text-label-md uppercase tracking-wider text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-variant" id="documents-table-body">
                    <?php $__empty_1 = true; $__currentLoopData = $documentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-surface/40 transition-colors cursor-pointer document-row" 
                        data-nome="<?php echo e($doc->nome); ?>" 
                        data-categoria="<?php echo e($doc->categoria ?? 'Clínico'); ?>"
                        onclick="abrirDocumento(<?php echo e($doc->id); ?>, '<?php echo e(addslashes($doc->nome)); ?>', '<?php echo e(addslashes($doc->partilhadoPor->name ?? 'Clínica')); ?>', '<?php echo e($doc->created_at->format('d/m/Y')); ?>')">
                        <td class="px-stack-lg py-4">
                            <div class="flex items-center gap-3">
                                <?php if(strtolower($doc->categoria ?? '') === 'financeiro' || strtolower($doc->tipo ?? '') === 'financeiro'): ?>
                                    <span class="material-symbols-outlined text-secondary flex-shrink-0">receipt</span>
                                <?php else: ?>
                                    <span class="material-symbols-outlined text-primary flex-shrink-0">description</span>
                                <?php endif; ?>
                                <span class="font-body-md font-bold text-on-surface truncate max-w-xs sm:max-w-sm md:max-w-md" title="<?php echo e($doc->nome); ?>"><?php echo e($doc->nome); ?></span>
                            </div>
                        </td>
                        <td class="px-stack-lg py-4">
                            <?php if(strtolower($doc->categoria ?? '') === 'financeiro' || strtolower($doc->tipo ?? '') === 'financeiro'): ?>
                                <span class="px-2.5 py-1 bg-secondary-container/20 text-on-secondary-container rounded-full text-[11px] font-bold">Financeiro</span>
                            <?php else: ?>
                                <span class="px-2.5 py-1 bg-primary-container/20 text-on-primary-fixed-variant rounded-full text-[11px] font-bold">Clínico</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-stack-lg py-4 text-body-sm text-on-surface-variant"><?php echo e($doc->created_at->format('d/m/Y')); ?></td>
                        <td class="px-stack-lg py-4 text-body-sm text-on-surface-variant">
                            <?php echo e($doc->tamanho > 1048576 ? number_format($doc->tamanho / 1048576, 1) . ' MB' : ($doc->tamanho > 1024 ? number_format($doc->tamanho / 1024, 0) . ' KB' : $doc->tamanho . ' B')); ?>

                        </td>
                        <td class="px-stack-lg py-4">
                            <?php if($doc->novo): ?>
                                <span class="px-2.5 py-1 bg-yellow-100 text-yellow-800 rounded-full text-[11px] font-bold">Novo</span>
                            <?php else: ?>
                                <span class="px-2.5 py-1 bg-green-100 text-green-800 rounded-full text-[11px] font-bold">Lido</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-stack-lg py-4 text-right" onclick="event.stopPropagation();">
                            <div class="flex justify-end gap-1">
                                <button onclick="abrirDocumento(<?php echo e($doc->id); ?>, '<?php echo e(addslashes($doc->nome)); ?>', '<?php echo e(addslashes($doc->partilhadoPor->name ?? 'Clínica')); ?>', '<?php echo e($doc->created_at->format('d/m/Y')); ?>')" class="w-9 h-9 text-on-surface-variant hover:text-primary hover:bg-surface rounded-lg flex items-center justify-center transition-all" title="Visualizar">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </button>
                                <a href="<?php echo e(route('portal.documento.download', $doc->id)); ?>" class="w-9 h-9 text-on-surface-variant hover:text-primary hover:bg-surface rounded-lg flex items-center justify-center transition-all" title="Descarregar">
                                    <span class="material-symbols-outlined text-[18px]">download</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <!-- Empty State -->
                    <tr id="empty-state-row">
                        <td colspan="6" class="p-0 border-none">
                            <div class="flex flex-col items-center justify-center py-16 text-center">
                                <div class="w-16 h-16 bg-surface-container-low text-on-surface-variant/40 rounded-full flex items-center justify-center mb-4 border border-outline-variant/20">
                                    <span class="material-symbols-outlined text-3xl">file_medical</span>
                                </div>
                                <h3 class="font-title-lg text-title-lg text-on-surface">Sem relatórios disponíveis</h3>
                                <p class="text-body-sm text-on-surface-variant max-w-sm mt-2 px-4">Os seus relatórios clínicos e prescrições aparecerão aqui após as suas consultas com os profissionais.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                    
                    <!-- Client-side Search No Results Row -->
                    <tr id="no-results-row" style="display: none;">
                        <td colspan="6" class="p-0 border-none">
                            <div class="flex flex-col items-center justify-center py-16 text-center">
                                <div class="w-16 h-16 bg-surface-container-low text-on-surface-variant/40 rounded-full flex items-center justify-center mb-4 border border-outline-variant/20">
                                    <span class="material-symbols-outlined text-3xl">search_off</span>
                                </div>
                                <h3 class="font-title-lg text-title-lg text-on-surface">Nenhum resultado encontrado</h3>
                                <p class="text-body-sm text-on-surface-variant max-w-sm mt-2 px-4">Tente ajustar a sua pesquisa ou os filtros seleccionados.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="px-stack-lg py-4 bg-surface/30 border-t border-surface-variant">
            <?php echo e($documentos->appends(request()->query())->links()); ?>

        </div>
    </section>
    <!-- Sessões Realizadas -->
    <section class="bg-white rounded-xl shadow-sm border border-surface-variant/50 overflow-hidden">
        <div class="px-stack-lg py-stack-md border-b border-surface-variant flex justify-between items-center bg-surface/10">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">check_circle</span>
                <h3 class="font-title-lg text-title-lg">Sessões Realizadas</h3>
            </div>
            <a href="<?php echo e(route('consultas')); ?>" class="text-primary font-bold text-body-sm hover:underline flex items-center gap-1">
                Ver todas <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        </div>
        <div class="divide-y divide-outline-variant/20">
            <?php $__empty_1 = true; $__currentLoopData = $sessoesRealizadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sessao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between px-stack-lg py-4 hover:bg-surface-container-low transition-colors gap-4">
                    <div class="flex items-center gap-4 min-w-0">
                        <div class="w-10 h-10 rounded-full bg-primary-container/20 text-primary flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-[18px]">psychology</span>
                        </div>
                        <div class="min-w-0">
                            <p class="font-body-md font-bold text-on-surface truncate"><?php echo e($sessao->tipo); ?></p>
                            <p class="text-body-sm text-on-surface-variant truncate"><?php echo e($sessao->profissional?->user?->name); ?> · <?php echo e(ucfirst($sessao->modalidade)); ?></p>
                        </div>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="font-body-sm font-bold text-on-surface"><?php echo e(\Carbon\Carbon::parse($sessao->data)->format('d/m/Y')); ?></p>
                        <p class="text-label-md text-on-surface-variant"><?php echo e($sessao->hora); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-stack-lg py-8 text-center text-on-surface-variant text-body-sm">
                    <span class="material-symbols-outlined text-3xl opacity-30 mb-2">event_busy</span>
                    <p>Nenhuma sessão realizada ainda. As suas consultas concluídas aparecerão aqui.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<!-- Modal Lateral para Ver Documento -->
<?php if (isset($component)) { $__componentOriginal06466d70a5df71623dc2a561e77c49ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal06466d70a5df71623dc2a561e77c49ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.side-modal','data' => ['id' => 'modal-ver-documento','title' => 'Detalhes do Relatório','subtitle' => 'Visualize as informações e anotações do relatório.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('side-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal-ver-documento','title' => 'Detalhes do Relatório','subtitle' => 'Visualize as informações e anotações do relatório.']); ?>
     <?php $__env->slot('avatar', null, []); ?> 
        <div class="sm-avatar-placeholder" style="background: #EAF8F8; color: #005f5f; display: flex; align-items: center; justify-content: center;">
            <span class="material-symbols-outlined text-2xl">description</span>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="space-y-6 mt-4">
        <!-- Document Info Card -->
        <div class="bg-surface p-4 rounded-xl border border-surface-variant/50 space-y-3">
            <h4 id="preview-doc-nome" class="font-bold text-base text-primary leading-tight"></h4>
            
            <div class="grid grid-cols-2 gap-4 pt-2.5 text-[11px] border-t border-outline-variant/30">
                <div>
                    <span class="text-on-surface-variant block mb-0.5">Partilhado por:</span>
                    <span id="preview-doc-autor" class="font-bold text-on-surface"></span>
                </div>
                <div>
                    <span class="text-on-surface-variant block mb-0.5">Data:</span>
                    <span id="preview-doc-data" class="font-bold text-on-surface"></span>
                </div>
            </div>
        </div>

        <!-- Document Notes -->
        <div class="space-y-2">
            <span class="text-xs font-bold text-on-surface-variant uppercase tracking-wider block">Observações / Conteúdo</span>
            <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/20 min-h-[160px] max-h-[300px] overflow-y-auto">
                <p id="preview-doc-descricao" class="text-body-sm text-on-surface leading-relaxed whitespace-pre-line">A carregar detalhes...</p>
            </div>
        </div>
        
        <!-- Actions inside modal body -->
        <div class="pt-4 flex flex-col sm:flex-row gap-3">
            <a id="preview-doc-download-btn" href="#" class="flex-1 bg-primary text-on-primary font-bold py-3 px-4 rounded-xl shadow-md hover:opacity-90 active:scale-95 transition-all text-center flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[20px]">download</span>
                Descarregar
            </a>
            <button type="button" onclick="closeSideModal(null, 'modal-ver-documento')" class="flex-1 border border-outline text-on-surface font-bold py-3 px-4 rounded-xl hover:bg-surface-variant transition-all">
                Fechar
            </button>
        </div>
    </div>
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

<?php $__env->startPush('styles'); ?>
<style>
    /* Ocultar o rodapé padrão do side-modal para visualização */
    #modal-ver-documento .sm-footer {
        display: none !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function abrirDocumento(id, nome, autor, data) {
    document.getElementById('preview-doc-nome').textContent = nome;
    document.getElementById('preview-doc-autor').textContent = autor;
    document.getElementById('preview-doc-data').textContent = data;
    document.getElementById('preview-doc-descricao').textContent = 'A carregar detalhes...';
    document.getElementById('preview-doc-download-btn').href = `/portal/documentos/${id}/download`;
    
    fetch(`/portal/documentos/${id}/preview`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('preview-doc-descricao').textContent = data.descricao || 'Sem descrição adicional.';
        })
        .catch(error => {
            console.error('Erro ao obter detalhes do documento:', error);
            document.getElementById('preview-doc-descricao').textContent = 'Erro ao carregar os detalhes do documento.';
        });

    openSideModal('modal-ver-documento');
}

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input');
    const categoryFilter = document.getElementById('filter-category');
    const tableRows = document.querySelectorAll('.document-row');
    const emptyStateRow = document.getElementById('empty-state-row');
    const noResultsRow = document.getElementById('no-results-row');

    function filterTable() {
        const query = searchInput.value.toLowerCase().trim();
        const category = categoryFilter.value;
        let visibleCount = 0;

        tableRows.forEach(row => {
            const name = row.getAttribute('data-nome').toLowerCase();
            const rowCategory = row.getAttribute('data-categoria');
            
            const matchesSearch = name.includes(query);
            const matchesCategory = !category || rowCategory === category;

            if (matchesSearch && matchesCategory) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Se a tabela estiver vazia de origem (sem registros no banco), manter o emptyStateRow original
        if (emptyStateRow && tableRows.length === 0) {
            emptyStateRow.style.display = '';
            noResultsRow.style.display = 'none';
        } else {
            if (emptyStateRow) emptyStateRow.style.display = 'none';
            if (noResultsRow) {
                noResultsRow.style.display = visibleCount === 0 ? '' : 'none';
            }
        }
    }

    if (searchInput) searchInput.addEventListener('input', filterTable);
    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterTable);
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.portal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/portal/documentos.blade.php ENDPATH**/ ?>