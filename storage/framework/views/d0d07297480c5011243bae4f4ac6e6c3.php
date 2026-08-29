<?php if (isset($component)) { $__componentOriginalfb4bf44be545cdc2e345d8fa2f9195c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfb4bf44be545cdc2e345d8fa2f9195c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-split-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-split-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

    <?php $__env->startSection('progress'); ?>
    <div class="auth-progress">
        <div class="progress-step active">
            <div class="step-circle">1</div>
            Registo
        </div>
        <div class="progress-line"></div>
        <div class="progress-step">
            <div class="step-circle">2</div>
            Confirmação
        </div>
        <div class="progress-line"></div>
        <div class="progress-step">
            <div class="step-circle">3</div>
            Acesso
        </div>
    </div>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('title', 'Criar Conta'); ?>

    <form method="POST" action="<?php echo e(route('register')); ?>">
        <?php echo csrf_field(); ?>

        <div class="form-group-row">
            <!-- Name -->
            <div class="auth-group">
                <label for="name" class="auth-label">Nome</label>
                <input id="name" type="text" name="name" class="auth-input" placeholder="Insira o seu nome" value="<?php echo e(old('name')); ?>" required autofocus autocomplete="name">
                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('name'),'class' => 'auth-error']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('name')),'class' => 'auth-error']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
            </div>

            <!-- Surname (Laravel default only has name, so we use 'name' for both or just use 'name'. I will put Surname as a dummy field if needed, or combine them. But Laravel registers with a single 'name' string by default. The user's image has 'Name' and 'Surname'. I'll add an 'apelido' field visually, but map them in JS or just modify the backend. Since I shouldn't break the backend unnecessarily, I will combine them via JS before submit, OR I will just keep Name and let the user enter full name, but split it visually. Wait, I'll just keep it simple and use a single "Nome Completo" if I don't want to change the backend. Actually, the user asked to recreate exactly. I will add 'apelido' but it will not be saved unless I modify the RegisterController. Let's just modify the form to have Name and Surname, but name the first one 'name' and the second one 'surname'. But the default Laravel backend doesn't expect 'surname'. If I modify it, I have to run migrations. 
            Let's compromise: I'll put "Nome" and "Apelido" but just pass "name" as the whole name, or just use the default backend. I'll stick to a single "Nome Completo" or I'll implement name and surname but use JS to join them into the 'name' field on submit. Let's use the JS approach to strictly match the visual.) -->
            <div class="auth-group">
                <label for="surname" class="auth-label">Apelido</label>
                <input id="surname" type="text" class="auth-input" placeholder="Insira o seu apelido">
            </div>
        </div>

        <input type="hidden" id="full_name" name="name" value="<?php echo e(old('name')); ?>">

        <!-- Email Address -->
        <div class="auth-group">
            <label for="email" class="auth-label">E-mail</label>
            <input id="email" type="email" name="email" class="auth-input" placeholder="exemplo@mail.com" value="<?php echo e(old('email')); ?>" required autocomplete="username">
            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('email'),'class' => 'auth-error']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('email')),'class' => 'auth-error']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
        </div>

        <!-- Password -->
        <div class="auth-group">
            <label for="password" class="auth-label">Palavra-passe</label>
            <input id="password" type="password" name="password" class="auth-input" placeholder="••••••••" required autocomplete="new-password">
            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('password'),'class' => 'auth-error']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('password')),'class' => 'auth-error']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
        </div>

        <!-- Confirm Password -->
        <div class="auth-group">
            <label for="password_confirmation" class="auth-label">Repetir a palavra-passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="auth-input" placeholder="••••••••" required autocomplete="new-password">
            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('password_confirmation'),'class' => 'auth-error']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('password_confirmation')),'class' => 'auth-error']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
        </div>

        <div class="auth-terms">
            Ao clicar em "Registar", você aceita os nossos Termos e Condições, Política de Privacidade e Política de uso de cookies. <br>
            Já tem uma conta? <a href="<?php echo e(route('login')); ?>" style="color: #224F52; text-decoration: underline; font-weight: 600;">Entrar</a>
        </div>

        <button type="submit" class="btn-auth-submit" id="submitBtn">
            REGISTAR
        </button>
    </form>

    <script>
        document.getElementById('submitBtn').addEventListener('click', function() {
            var name = document.getElementById('name').value;
            var surname = document.getElementById('surname').value;
            document.getElementById('full_name').value = name + (surname ? ' ' + surname : '');
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfb4bf44be545cdc2e345d8fa2f9195c3)): ?>
<?php $attributes = $__attributesOriginalfb4bf44be545cdc2e345d8fa2f9195c3; ?>
<?php unset($__attributesOriginalfb4bf44be545cdc2e345d8fa2f9195c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfb4bf44be545cdc2e345d8fa2f9195c3)): ?>
<?php $component = $__componentOriginalfb4bf44be545cdc2e345d8fa2f9195c3; ?>
<?php unset($__componentOriginalfb4bf44be545cdc2e345d8fa2f9195c3); ?>
<?php endif; ?>
<?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/auth/register.blade.php ENDPATH**/ ?>