<?php

namespace App\Http\Controllers;

use App\Mail\ContatoMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'assunto' => 'nullable|string|max:255',
            'mensagem' => 'required|string|max:2000',
        ]);

        Mail::to('geral@mindcare.ao')->send(new ContatoMail($validated));

        return redirect(route('home') . '#contacto')
            ->with('success', 'Mensagem enviada com sucesso! Entraremos em contacto brevemente.');
    }
}
