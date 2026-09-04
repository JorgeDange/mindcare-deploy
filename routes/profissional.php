<?php

use App\Http\Controllers\ProfissionalController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:profissional', '2fa'])->prefix('profissional')->name('profissional.')->group(function () {
    Route::get('/dashboard', [ProfissionalController::class, 'dashboard'])->name('dashboard');

    Route::get('/agenda', [ProfissionalController::class, 'agenda'])->name('agenda');
    Route::post('/consultas', [ProfissionalController::class, 'storeConsulta'])->name('consultas.store');
    Route::put('/consultas/{consulta}/estado', [ProfissionalController::class, 'updateEstado'])->name('consultas.estado');

    Route::get('/pacientes', [ProfissionalController::class, 'pacientes'])->name('pacientes.index');
    Route::get('/pacientes/{paciente}', [ProfissionalController::class, 'showPaciente'])->name('pacientes.show');
    Route::get('/pacientes/{paciente}/ficha', [ProfissionalController::class, 'fichaPaciente'])->name('pacientes.ficha');
    Route::put('/pacientes/{paciente}/ficha', [ProfissionalController::class, 'updateFichaPaciente'])->name('pacientes.ficha.update');

    Route::get('/documentos', [ProfissionalController::class, 'documentos'])->name('documentos.index');
    Route::post('/documentos', [ProfissionalController::class, 'storeDocumento'])->name('documentos.store');
    Route::get('/documentos/{documento}/download', [ProfissionalController::class, 'downloadDocumento'])->name('documentos.download');

    Route::get('/mensagens', [ProfissionalController::class, 'mensagens'])->name('mensagens.index');
    Route::get('/mensagens/nova', [ProfissionalController::class, 'novaConversa'])->name('mensagens.nova');
    Route::post('/mensagens/nova', [ProfissionalController::class, 'storeConversa'])->name('mensagens.nova.store');
    Route::post('/mensagens', [ProfissionalController::class, 'storeMensagem'])->name('mensagens.store')->middleware('throttle:mensagens');
    Route::get('/mensagens/{conversa}/novas', [ProfissionalController::class, 'novasMensagens'])->name('mensagens.novas');
    Route::get('/mensagens/nao-lidas', [ProfissionalController::class, 'mensagensNaoLidas'])->name('mensagens.nao-lidas');

    Route::get('/perfil', [ProfissionalController::class, 'perfil'])->name('perfil');

    Route::put('/perfil', function () {
        return view('em-construcao');
    })->name('perfil.update');

    Route::get('/relatorios', function () {
        return view('em-construcao');
    })->name('relatorios.index');
});
