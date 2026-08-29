<?php $__env->startSection('title', 'Alterar Palavra-passe — MindCare'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[1000px] mx-auto">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 mb-stack-lg text-on-surface-variant">
        <a href="<?php echo e(route('perfil')); ?>" class="font-body-sm text-body-sm hover:text-primary cursor-pointer transition-colors">Perfil</a>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <a href="<?php echo e(route('perfil')); ?>#seguranca" class="font-body-sm text-body-sm hover:text-primary cursor-pointer transition-colors">Segurança</a>
        <span class="material-symbols-outlined text-sm">chevron_right</span>
        <span class="font-body-sm text-body-sm text-on-surface font-semibold">Alterar Palavra-passe</span>
    </nav>
    
    <header class="mb-stack-lg">
        <h2 class="font-headline-lg text-headline-lg text-on-surface">Segurança da Conta</h2>
        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Atualize a sua palavra-passe regularmente para manter os seus dados de saúde protegidos.</p>
    </header>

    <?php if(session('status') === 'password-updated'): ?>
    <div class="mb-6 bg-[#224F52] text-white px-6 py-4 rounded-xl shadow-md flex items-center gap-3">
        <span class="material-symbols-outlined text-[20px] text-primary-fixed">check_circle</span>
        <span class="font-body-md text-sm font-semibold">Palavra-passe atualizada com sucesso!</span>
    </div>
    <?php endif; ?>

    <div class="flex flex-col lg:flex-row gap-gutter">
        <!-- Main Form Card -->
        <section class="flex-[2] bg-white rounded-xl p-stack-lg shadow-[0px_4px_12px_rgba(0,0,0,0.05)] border border-outline-variant/10">
            <div class="mb-stack-lg flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">lock_reset</span>
                </div>
                <h3 class="font-title-lg text-title-lg text-on-surface">Redefinir Palavra-passe</h3>
            </div>
            
            <form method="post" action="<?php echo e(route('password.update')); ?>" class="space-y-stack-lg">
                <?php echo csrf_field(); ?>
                <?php echo method_field('put'); ?>

                <div class="space-y-stack-sm">
                    <label class="font-body-sm text-body-sm font-bold text-on-surface-variant ml-1" for="current_password">Palavra-passe Atual</label>
                    <div class="relative">
                        <input id="current_password" name="current_password" type="password" required autocomplete="current-password"
                               class="w-full h-12 px-4 rounded-lg border border-outline-variant focus:border-secondary focus:ring-2 focus:ring-secondary/20 transition-all outline-none" placeholder="••••••••" />
                        <button class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline-variant hover:text-on-surface toggle-password" type="button">visibility</button>
                    </div>
                    <?php if($errors->updatePassword->has('current_password')): ?>
                        <p class="text-error text-xs font-bold mt-1 ml-1 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">warning</span> <?php echo e($errors->updatePassword->first('current_password')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="space-y-stack-sm">
                    <label class="font-body-sm text-body-sm font-bold text-on-surface-variant ml-1" for="new-password">Nova Palavra-passe</label>
                    <div class="relative">
                        <input id="new-password" name="password" type="password" required autocomplete="new-password"
                               class="w-full h-12 px-4 rounded-lg border border-outline-variant focus:border-secondary focus:ring-2 focus:ring-secondary/20 transition-all outline-none" placeholder="••••••••" />
                        <button class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline-variant hover:text-on-surface toggle-password" type="button">visibility</button>
                    </div>
                    <?php if($errors->updatePassword->has('password')): ?>
                        <p class="text-error text-xs font-bold mt-1 ml-1 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">warning</span> <?php echo e($errors->updatePassword->first('password')); ?></p>
                    <?php endif; ?>
                    
                    <!-- Password Strength Checklist -->
                    <div class="bg-surface-container-low rounded-lg p-4 mt-2">
                        <p class="font-label-md text-label-md text-on-surface-variant mb-3">Requisitos de Segurança:</p>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <li class="flex items-center gap-2 text-label-md font-label-md text-error transition-colors" id="req-length">
                                <span class="material-symbols-outlined text-[16px]">cancel</span>
                                Pelo menos 8 caracteres
                            </li>
                            <li class="flex items-center gap-2 text-label-md font-label-md text-error transition-colors" id="req-number">
                                <span class="material-symbols-outlined text-[16px]">cancel</span>
                                Um número ou símbolo
                            </li>
                            <li class="flex items-center gap-2 text-label-md font-label-md text-error transition-colors" id="req-upper">
                                <span class="material-symbols-outlined text-[16px]">cancel</span>
                                Uma letra maiúscula
                            </li>
                            <li class="flex items-center gap-2 text-label-md font-label-md text-error transition-colors" id="req-lower">
                                <span class="material-symbols-outlined text-[16px]">cancel</span>
                                Uma letra minúscula
                            </li>
                        </ul>
                        <div class="mt-4 h-1.5 w-full bg-outline-variant/30 rounded-full overflow-hidden">
                            <div class="h-full w-0 bg-error transition-all duration-500" id="strength-bar"></div>
                        </div>
                    </div>
                </div>

                <div class="space-y-stack-sm">
                    <label class="font-body-sm text-body-sm font-bold text-on-surface-variant ml-1" for="password_confirmation">Confirmar Nova Palavra-passe</label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                               class="w-full h-12 px-4 rounded-lg border border-outline-variant focus:border-secondary focus:ring-2 focus:ring-secondary/20 transition-all outline-none" placeholder="••••••••" />
                        <button class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline-variant hover:text-on-surface toggle-password" type="button">visibility</button>
                    </div>
                    <?php if($errors->updatePassword->has('password_confirmation')): ?>
                        <p class="text-error text-xs font-bold mt-1 ml-1 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">warning</span> <?php echo e($errors->updatePassword->first('password_confirmation')); ?></p>
                    <?php endif; ?>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-outline-variant/20">
                    <a href="<?php echo e(route('perfil')); ?>" class="px-6 h-12 flex items-center rounded-lg border border-primary text-primary font-body-md hover:bg-primary/5 transition-colors">Cancelar</a>
                    <button class="px-8 h-12 flex items-center rounded-lg bg-primary text-on-primary font-body-md font-semibold hover:bg-primary-container transition-all active:scale-95 shadow-md" type="submit">Guardar Alterações</button>
                </div>
            </form>
        </section>

        <!-- Sidebar / Info Box -->
        <aside class="flex-1 space-y-gutter">
            <div class="bg-surface-container-high rounded-xl p-stack-lg border border-surface-variant">
                <div class="flex items-center gap-2 mb-4 text-primary">
                    <span class="material-symbols-outlined">verified_user</span>
                    <h4 class="font-title-lg text-title-lg">Dicas de Segurança</h4>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant mb-6 leading-relaxed">
                    A proteção dos seus registos terapêuticos e dados pessoais é a nossa prioridade. Siga estas recomendações:
                </p>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <span class="material-symbols-outlined text-primary text-xl">history</span>
                        <div>
                            <p class="font-body-sm text-body-sm font-bold text-on-surface">Mude semestralmente</p>
                            <p class="font-label-md text-label-md text-on-surface-variant">Evite usar a mesma palavra-passe por mais de 6 meses.</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="material-symbols-outlined text-primary text-xl">devices</span>
                        <div>
                            <p class="font-body-sm text-body-sm font-bold text-on-surface">Encerre sessões</p>
                            <p class="font-label-md text-label-md text-on-surface-variant">Sempre faça 'Sair' ao usar computadores públicos.</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="material-symbols-outlined text-primary text-xl">phishing</span>
                        <div>
                            <p class="font-body-sm text-body-sm font-bold text-on-surface">Cuidado com Phishing</p>
                            <p class="font-label-md text-label-md text-on-surface-variant">O MindCare nunca solicitará a sua palavra-passe por e-mail.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 rounded-lg overflow-hidden border border-primary/20">
                    <!-- Subtle generic security pattern representation -->
                    <div class="w-full h-24 bg-gradient-to-r from-primary/10 to-secondary/10 flex items-center justify-center opacity-80">
                        <span class="material-symbols-outlined text-primary/40" style="font-size: 64px;">fingerprint</span>
                    </div>
                </div>
            </div>

            <div class="bg-primary/5 rounded-xl p-stack-lg border border-primary/10">
                <h4 class="font-body-md text-body-md font-bold mb-2 text-on-surface">Precisa de Ajuda?</h4>
                <p class="font-label-md text-label-md text-on-surface-variant mb-4">Se suspeita que a sua conta foi comprometida, entre em contacto imediatamente.</p>
                <a class="text-primary font-body-sm font-bold flex items-center gap-1 hover:underline" href="#">
                    Falar com Suporte <span class="material-symbols-outlined text-sm">open_in_new</span>
                </a>
            </div>
        </aside>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Simple micro-interaction for password strength simulation
        const passwordInput = document.getElementById('new-password');
        const strengthBar = document.getElementById('strength-bar');
        const reqs = {
            length: document.getElementById('req-length'),
            number: document.getElementById('req-number'),
            upper: document.getElementById('req-upper'),
            lower: document.getElementById('req-lower')
        };

        if(passwordInput && strengthBar) {
            passwordInput.addEventListener('input', (e) => {
                const val = e.target.value;
                let strength = 0;

                const checks = {
                    length: val.length >= 8,
                    number: /[0-9!@#$%^&*]/.test(val),
                    upper: /[A-Z]/.test(val),
                    lower: /[a-z]/.test(val)
                };

                Object.keys(checks).forEach(key => {
                    const el = reqs[key];
                    if(!el) return;
                    const icon = el.querySelector('.material-symbols-outlined');
                    if (checks[key]) {
                        el.classList.replace('text-error', 'text-primary');
                        icon.textContent = 'check_circle';
                        strength += 25;
                    } else {
                        el.classList.replace('text-primary', 'text-error');
                        icon.textContent = 'cancel';
                    }
                });

                strengthBar.style.width = strength + '%';
                if (strength <= 25) strengthBar.className = 'h-full bg-error transition-all duration-500';
                else if (strength <= 75) strengthBar.className = 'h-full bg-secondary transition-all duration-500';
                else strengthBar.className = 'h-full bg-primary transition-all duration-500';
            });
        }

        // Toggle visibility simulation
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = btn.previousElementSibling;
                const isPass = input.type === 'password';
                input.type = isPass ? 'text' : 'password';
                btn.textContent = isPass ? 'visibility_off' : 'visibility';
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.portal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/vol16_2/infinityfree.com/if0_42474986/htdocs/resources/views/profile/edit.blade.php ENDPATH**/ ?>