<style>
    .mindcare-loader {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: #ffffff;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 999999;
        transition: opacity 0.6s ease;
    }

    .mindcare-loader.hidden {
        opacity: 0;
        pointer-events: none;
    }

    .loader-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    .loader-content img {
        width: 140px;
        animation: pulse-loader 1.5s infinite ease-in-out alternate;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid rgba(34, 79, 82, 0.2);
        border-top-color: #224F52;
        border-radius: 50%;
        animation: spin-loader 1s linear infinite;
    }

    @keyframes pulse-loader {
        0% { transform: scale(0.95); opacity: 0.8; }
        100% { transform: scale(1.05); opacity: 1; }
    }

    @keyframes spin-loader {
        to { transform: rotate(360deg); }
    }

</style>
<div id="mindcare-loader" class="mindcare-loader">
    <div class="loader-content">
        <img src="<?php echo e(asset('assets/logot.png')); ?>" alt="A carregar">
        <div class="spinner"></div>
    </div>
</div>
<script>
    window.addEventListener('load', function () {
        var loader = document.getElementById('mindcare-loader');
        if (loader) {
            loader.classList.add('hidden');
            setTimeout(function () { loader.style.display = 'none'; }, 600);
        }
    });

    if (document.readyState === 'complete') {
        var loader = document.getElementById('mindcare-loader');
        if (loader) {
            loader.classList.add('hidden');
            setTimeout(function () { loader.style.display = 'none'; }, 600);
        }
    }
</script>
<?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/components/loader.blade.php ENDPATH**/ ?>