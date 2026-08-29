<?php

use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Portal\NotificacaoController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\TwoFactorController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/sobre', [PublicController::class, 'sobre'])->name('sobre');
Route::get('/servicos', [PublicController::class, 'servicos'])->name('servicos');
Route::get('/planos', [PublicController::class, 'planos'])->name('planos');
Route::get('/planos/particular', [PublicController::class, 'particular'])->name('planos.particular');
Route::get('/planos/familiar', [PublicController::class, 'familiar'])->name('planos.familiar');
Route::get('/planos/corporativo', [PublicController::class, 'corporativo'])->name('planos.corporativo');
Route::get('/faq', [PublicController::class, 'faq'])->name('faq');
Route::post('/chatbot/enviar', [ChatbotController::class, 'send'])->middleware('throttle:10,1');

// Portal Routes
Route::middleware(['auth', 'verified', 'role:paciente', '2fa'])->prefix('portal')->group(function () {
    Route::get('/dashboard', [PortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/perfil', [PortalController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [PortalController::class, 'updatePerfil'])->name('portal.perfil.update');
    Route::get('/consultas', [PortalController::class, 'consultas'])->name('consultas');
    Route::post('/consultas', [PortalController::class, 'storeConsulta'])->name('portal.consultas.store')->middleware('throttle:uploads');
    Route::put('/consultas/{consulta}/confirmar', [PortalController::class, 'confirmarConsulta'])->name('portal.consultas.confirmar');
    Route::put('/consultas/{consulta}/cancelar', [PortalController::class, 'cancelarConsulta'])->name('portal.consultas.cancelar');
    Route::put('/consultas/{consulta}/reagendar', [PortalController::class, 'reagendarConsulta'])->name('portal.consultas.reagendar');
    Route::get('/documentos', [PortalController::class, 'documentos'])->name('documentos');
    Route::get('/documentos/{documento}/download', [PortalController::class, 'downloadDocumento'])->name('portal.documento.download');
    Route::get('/documentos/{documento}/preview', [PortalController::class, 'previewDocumento'])->name('portal.documento.preview');
    Route::get('/mensagens', [PortalController::class, 'mensagens'])->name('mensagens');
    Route::post('/mensagens', [PortalController::class, 'storeMensagem'])->name('portal.mensagens.store')->middleware('throttle:mensagens');
    Route::get('/mensagens/{conversa}/novas', [PortalController::class, 'novasMensagens'])->name('portal.mensagens.novas');
    Route::get('/plano', [PortalController::class, 'plano'])->name('plano');
    Route::post('/plano/aderir', [PortalController::class, 'aderirPlano'])->name('portal.plano.aderir')->middleware('throttle:uploads');
    Route::post('/plano/trocar', [PortalController::class, 'trocarPlano'])->name('portal.plano.trocar')->middleware('throttle:uploads');
    Route::get('/ficha', [PortalController::class, 'ficha'])->name('ficha');
    Route::put('/ficha', [PortalController::class, 'updateFicha'])->name('portal.ficha.update');

    // Notificações
    Route::get('/notificacoes', [NotificacaoController::class, 'index'])->name('notificacoes');
    Route::get('/notificacoes/nao-lidas', [NotificacaoController::class, 'naoLidas'])->name('notificacoes.nao-lidas');
    Route::post('/notificacoes/{notification}/ler', [NotificacaoController::class, 'ler'])->name('portal.notificacoes.ler');
    Route::post('/notificacoes/ler-todas', [NotificacaoController::class, 'lerTodas'])->name('portal.notificacoes.ler-todas');
});

// Default Profile Routes from Breeze (optional, maybe adapt later)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 2FA Routes
Route::middleware('auth')->group(function () {
    Route::get('/2fa/ativar', [TwoFactorController::class, 'ativar'])->name('2fa.ativar');
    Route::post('/2fa/ativar', [TwoFactorController::class, 'confirmarAtivacao'])->name('2fa.ativar.confirmar');
    Route::get('/2fa/verificar', [TwoFactorController::class, 'verificar'])->name('2fa.verificar');
    Route::post('/2fa/verificar', [TwoFactorController::class, 'validarCodigo'])->name('2fa.verificar.codigo');
    Route::delete('/2fa/desativar', [TwoFactorController::class, 'desativar'])->name('2fa.desativar');
});

require __DIR__.'/auth.php';
