<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'MindCare')); ?></title>
    <link rel="shortcut icon" href="<?php echo e(asset('assets/logoti.png')); ?>" type="image/x-icon">

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="<?php echo e(asset('css/auth-custom.css')); ?>">
</head>
<body>

    <div class="auth-split-layout">
        <!-- Esquerda: Imagem -->
        <div class="auth-left">
            <a href="/" class="auth-left-logo">
                <img src="<?php echo e(asset('assets/logot.png')); ?>" alt="MindCare Logo">
                
            </a>
            
            <div class="glass-box">
                <p>Agende a sua primeira consulta online ou presencial connosco hoje mesmo.</p>
                <a href="<?php echo e(url('/planos')); ?>">Conhecer Planos</a>
            </div>
        </div>

        <!-- Direita: Formulário -->
        <div class="auth-right">
            <div class="auth-form-container">
                
                <?php if (! empty(trim($__env->yieldContent('progress')))): ?>
                    <?php echo $__env->yieldContent('progress'); ?>
                <?php endif; ?>

                <h2 class="auth-title"><?php echo $__env->yieldContent('title'); ?></h2>

                <?php echo e($slot); ?>

                
            </div>
        </div>
    </div>

</body>
</html>
<?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/components/auth-split-layout.blade.php ENDPATH**/ ?>