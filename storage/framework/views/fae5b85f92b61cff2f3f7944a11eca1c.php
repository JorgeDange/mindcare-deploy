<?php
    $flashTypes = [
        'success' => ['color' => '#10b981', 'bg' => '#ecfdf5', 'text' => '#065f46', 'icon' => 'fa-circle-check'],
        'error'   => ['color' => '#ef4444', 'bg' => '#fef2f2', 'text' => '#991b1b', 'icon' => 'fa-circle-exclamation'],
        'warning' => ['color' => '#f59e0b', 'bg' => '#fffbeb', 'text' => '#92400e', 'icon' => 'fa-triangle-exclamation'],
        'info'    => ['color' => '#3b82f6', 'bg' => '#eff6ff', 'text' => '#1e40af', 'icon' => 'fa-circle-info'],
    ];
?>

<?php $__currentLoopData = $flashTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cfg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(session($key)): ?>
        <div class="flash-message flash-<?php echo e($key); ?>" style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding: 14px 18px; border-radius: 12px; border-left: 4px solid <?php echo e($cfg['color']); ?>; background: <?php echo e($cfg['bg']); ?>; color: <?php echo e($cfg['text']); ?>; font-size: 0.9rem;">
            <i class="fa-solid <?php echo e($cfg['icon']); ?>" style="font-size: 1.1rem; flex-shrink: 0;"></i>
            <span style="flex: 1;"><?php echo e(session($key)); ?></span>
            <button onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; color: inherit; opacity: 0.5; font-size: 1.1rem; padding: 0; line-height: 1;">&times;</button>
        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php if($errors->any()): ?>
    <div class="flash-message flash-error" style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding: 14px 18px; border-radius: 12px; border-left: 4px solid #f59e0b; background: #fffbeb; color: #92400e; font-size: 0.9rem;">
        <i class="fa-solid fa-triangle-exclamation" style="font-size: 1.1rem; flex-shrink: 0;"></i>
        <span style="flex: 1;"><?php echo e($errors->first()); ?></span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; cursor: pointer; color: inherit; opacity: 0.5; font-size: 1.1rem; padding: 0; line-height: 1;">&times;</button>
    </div>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.flash-message').forEach(function(el) {
            setTimeout(function() {
                if (el.parentElement) {
                    el.style.transition = 'opacity 0.3s';
                    el.style.opacity = '0';
                    setTimeout(function() { if (el.parentElement) el.remove(); }, 300);
                }
            }, 5000);
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/components/flash-messages.blade.php ENDPATH**/ ?>