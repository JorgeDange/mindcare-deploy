<div id="loadingOverlay" class="loading-overlay" aria-hidden="true" role="status" aria-label="A carregar">
    <div class="loading-spinner">
        <div class="loading-ring"></div>
        <p class="loading-text">A processar...</p>
    </div>
</div>

@once
<style>
.loading-overlay {
    position: fixed;
    inset: 0;
    z-index: 100000;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.25s ease, visibility 0.25s ease;
}
.loading-overlay.active {
    opacity: 1;
    visibility: visible;
}
.loading-spinner {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
}
.loading-ring {
    width: 44px;
    height: 44px;
    border: 4px solid #e2e8f0;
    border-top-color: #005f5f;
    border-radius: 50%;
    animation: loading-spin 0.8s linear infinite;
}
.loading-text {
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 500;
    margin: 0;
}
@keyframes loading-spin {
    to { transform: rotate(360deg); }
}

/* Button loading state */
.btn-loading {
    position: relative;
    pointer-events: none;
    color: transparent !important;
}
.btn-loading::after {
    content: '';
    position: absolute;
    inset: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2.5px solid rgba(255,255,255,0.3);
    border-top-color: #fff;
    border-radius: 50%;
    animation: loading-spin 0.8s linear infinite;
}
.btn-loading.sm-btn-cancel::after {
    border-color: rgba(0,0,0,0.1);
    border-top-color: #64748b;
}
</style>
<script>
window.showLoading = function (text) {
    var overlay = document.getElementById('loadingOverlay');
    if (!overlay) return;
    var label = overlay.querySelector('.loading-text');
    if (label && text) label.textContent = text;
    else if (label) label.textContent = 'A processar...';
    overlay.classList.add('active');
    document.body.style.pointerEvents = 'none';
};
window.hideLoading = function () {
    var overlay = document.getElementById('loadingOverlay');
    if (!overlay) return;
    overlay.classList.remove('active');
    document.body.style.pointerEvents = '';
};
document.addEventListener('DOMContentLoaded', function () {
    var overlay = document.getElementById('loadingOverlay');
    if (!overlay) return;
    if (overlay.classList.contains('active')) {
        overlay.classList.remove('active');
        document.body.style.pointerEvents = '';
    }
});
</script>
@endonce