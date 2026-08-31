<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContatoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $nome,
        public string $telefone,
        public string $email,
        public ?string $assunto,
        public string $mensagem,
    ) {}

    public function envelope(): Envelope
    {
        $assunto = $this->assunto ?: 'Novo contacto via site';

        return new Envelope(
            subject: "MindCare - {$assunto}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
        );
    }
}
