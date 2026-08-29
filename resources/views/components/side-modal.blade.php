<div id="{{ $id ?? 'sideModalOverlay' }}" class="side-modal-overlay" onclick="closeSideModal(event, '{{ $id ?? 'sideModalOverlay' }}')">
    <div class="side-modal-panel {{ $panelClass ?? '' }}" onclick="event.stopPropagation()">
        
        <!-- Header Principal -->
        <div class="sm-header">
            <div class="sm-header-info">
                <div class="sm-avatar">
                    @if(isset($avatar))
                        {!! $avatar !!}
                    @else
                        <div class="sm-avatar-placeholder">MC</div>
                    @endif
                </div>
                <div class="sm-header-text">
                    @if(isset($headerContext))
                        <span class="sm-label">{{ $headerContext }}</span>
                    @endif
                    <h3>{{ $title ?? 'Perfil' }}</h3>
                    <p>{{ $subtitle ?? '' }}</p>
                </div>
            </div>
            
            <div class="sm-top-actions">
                <button class="sm-btn-icon" aria-label="Editar">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <button class="sm-btn-icon close-btn" aria-label="Fechar" onclick="closeSideModal(null, '{{ $id ?? 'sideModalOverlay' }}')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>

        <!-- Abas (Tabs) opcionais -->
        @if(isset($tabs))
            <div class="sm-tabs">
                {{ $tabs }}
            </div>
        @endif

        <!-- Corpo do Modal (Formulário) -->
        <div class="sm-body">
            {{ $slot }}
        </div>

        <!-- Rodapé do Modal (Botões) -->
        <div class="sm-footer">
            <button type="button" class="sm-btn-cancel" onclick="closeSideModal(null, '{{ $id ?? 'sideModalOverlay' }}')">Cancelar</button>
            <button type="submit" class="sm-btn-save" form="{{ $formId ?? 'sideModalForm' }}">Guardar Alterações</button>
        </div>

    </div>
</div>

@once
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
@endonce
