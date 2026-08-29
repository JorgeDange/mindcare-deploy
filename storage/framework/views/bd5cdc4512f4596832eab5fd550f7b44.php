<div id="<?php echo e($id ?? 'sideModalOverlay'); ?>" class="side-modal-overlay" onclick="closeSideModal(event, '<?php echo e($id ?? 'sideModalOverlay'); ?>')">
    <div class="side-modal-panel <?php echo e($panelClass ?? ''); ?>" onclick="event.stopPropagation()">
        
        <!-- Header Principal -->
        <div class="sm-header">
            <div class="sm-header-info">
                <div class="sm-avatar">
                    <?php if(isset($avatar)): ?>
                        <?php echo $avatar; ?>

                    <?php else: ?>
                        <div class="sm-avatar-placeholder">MC</div>
                    <?php endif; ?>
                </div>
                <div class="sm-header-text">
                    <?php if(isset($headerContext)): ?>
                        <span class="sm-label"><?php echo e($headerContext); ?></span>
                    <?php endif; ?>
                    <h3><?php echo e($title ?? 'Perfil'); ?></h3>
                    <p><?php echo e($subtitle ?? ''); ?></p>
                </div>
            </div>
            
            <div class="sm-top-actions">
                <button class="sm-btn-icon" aria-label="Editar">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <button class="sm-btn-icon close-btn" aria-label="Fechar" onclick="closeSideModal(null, '<?php echo e($id ?? 'sideModalOverlay'); ?>')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>

        <!-- Abas (Tabs) opcionais -->
        <?php if(isset($tabs)): ?>
            <div class="sm-tabs">
                <?php echo e($tabs); ?>

            </div>
        <?php endif; ?>

        <!-- Corpo do Modal (Formulário) -->
        <div class="sm-body">
            <?php echo e($slot); ?>

        </div>

        <!-- Rodapé do Modal (Botões) -->
        <div class="sm-footer">
            <button type="button" class="sm-btn-cancel" onclick="closeSideModal(null, '<?php echo e($id ?? 'sideModalOverlay'); ?>')">Cancelar</button>
            <button type="submit" class="sm-btn-save" form="<?php echo e($formId ?? 'sideModalForm'); ?>">Guardar Alterações</button>
        </div>

    </div>
</div>

<?php if (! $__env->hasRenderedOnce('5a3484a8-9f47-4e9d-86a0-b6da20d6be76')): $__env->markAsRenderedOnce('5a3484a8-9f47-4e9d-86a0-b6da20d6be76'); ?>
<style>
@media (max-width: 768px) {
    .side-modal-overlay .side-modal-panel {
        border-radius: 0;
    }
}
</style>
<script>
    function openSideModal(id = 'sideModalOverlay') {
        const el = document.getElementById(id);
        if (el) {
            const panel = el.querySelector('.side-modal-panel');
            if (panel && window.innerWidth <= 768) {
                panel.classList.add('bottom-sheet');
            } else if (panel) {
                panel.classList.remove('bottom-sheet');
            }
            el.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeSideModal(e, id = 'sideModalOverlay') {
        if (e && e.target && e.target.id !== id && !e.target.closest('.close-btn') && !e.target.closest('.sm-btn-cancel')) {
            return;
        }
        const el = document.getElementById(id);
        if (el) el.classList.remove('active');
        
        if (!document.querySelector('.side-modal-overlay.active')) {
            document.body.style.overflow = '';
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const overlays = document.querySelectorAll('.side-modal-overlay.active');
            overlays.forEach(el => el.classList.remove('active'));
            if (overlays.length > 0) {
                document.body.style.overflow = '';
            }
        }
    });
</script>
<?php endif; ?>
<?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/components/side-modal.blade.php ENDPATH**/ ?>