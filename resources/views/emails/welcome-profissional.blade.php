<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo à MindCare</title>
    <style>
        body { font-family: 'Inter', Arial, sans-serif; background: #f2f4f3; margin: 0; padding: 0; }
        .container { max-width: 560px; margin: 40px auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
        .header { background: #224F52; padding: 32px; text-align: center; }
        .header img { height: 48px; }
        .body { padding: 32px; }
        h1 { font-size: 22px; font-weight: 700; color: #1f2937; margin: 0 0 8px; }
        p { font-size: 15px; color: #4b5563; line-height: 1.6; margin: 0 0 16px; }
        .details { background: #f9fafb; border-radius: 12px; padding: 20px; margin: 20px 0; }
        .details dt { font-size: 12px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; }
        .details dd { font-size: 15px; font-weight: 600; color: #1f2937; margin: 2px 0 12px; }
        .details dd:last-child { margin-bottom: 0; }
        .btn { display: inline-block; background: #224F52; color: white; padding: 12px 32px; border-radius: 50px; text-decoration: none; font-size: 15px; font-weight: 600; }
        .footer { text-align: center; padding: 24px 32px; border-top: 1px solid #f3f4f6; font-size: 13px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/logoti.png') }}" alt="MindCare" loading="lazy" decoding="async">
        </div>
        <div class="body">
            <h1>Bem-vindo(a), {{ $user->name }}!</h1>
            <p>A sua conta de profissional foi criada na plataforma <strong>MindCare</strong>. Já pode aceder ao sistema e começar a acompanhar os seus pacientes.</p>

            <div class="details">
                <dl>
                    <dt>Email</dt>
                    <dd>{{ $user->email }}</dd>
                </dl>
            </div>

            <p>Recomendamos que altere a sua password após o primeiro login.</p>

            <p style="text-align: center; margin-top: 28px;">
                <a href="{{ url('/profissional/login') }}" class="btn">Aceder à Plataforma</a>
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} MindCare. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>