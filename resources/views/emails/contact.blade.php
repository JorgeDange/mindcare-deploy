<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Contacto - MindCare</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7fa;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7fa;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background:linear-gradient(135deg,#005f5f 0%,#007a7a 100%);padding:30px 40px;text-align:center;">
                            <h1 style="color:#ffffff;margin:0;font-size:24px;font-weight:600;">MindCare</h1>
                            <p style="color:#acfffe;margin:8px 0 0;font-size:13px;letter-spacing:0.5px;">NOVO CONTACTO VIA SITE</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:35px 40px;">
                            <p style="color:#3e4948;font-size:15px;line-height:1.6;margin:0 0 20px;">
                                Recebemos uma nova mensagem através do formulário de contacto do site.
                            </p>

                            <!-- Dados -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3faff;border-radius:8px;border:1px solid #bdc9c8;">
                                <tr>
                                    <td style="padding:20px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding:8px 0;color:#6e7979;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;width:120px;vertical-align:top;">Nome</td>
                                                <td style="padding:8px 0;color:#071e27;font-size:15px;">{{ $data['nome'] }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:8px 0;color:#6e7979;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;vertical-align:top;">Telefone</td>
                                                <td style="padding:8px 0;color:#071e27;font-size:15px;">{{ $data['telefone'] }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:8px 0;color:#6e7979;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;vertical-align:top;">Email</td>
                                                <td style="padding:8px 0;color:#005f5f;font-size:15px;">{{ $data['email'] }}</td>
                                            </tr>
                                            @if(!empty($data['assunto']))
                                            <tr>
                                                <td style="padding:8px 0;color:#6e7979;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;vertical-align:top;">Assunto</td>
                                                <td style="padding:8px 0;color:#071e27;font-size:15px;">{{ $data['assunto'] }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td style="padding:8px 0;color:#6e7979;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px;vertical-align:top;">Mensagem</td>
                                                <td style="padding:8px 0;color:#071e27;font-size:15px;line-height:1.6;">{!! nl2br(e($data['mensagem'])) !!}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Responder -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:25px;">
                                <tr>
                                    <td align="center">
                                        <a href="mailto:{{ $data['email'] }}" style="display:inline-block;background-color:#005f5f;color:#ffffff;padding:12px 30px;border-radius:8px;text-decoration:none;font-size:14px;font-weight:600;">
                                            Responder por Email
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f3faff;padding:20px 40px;border-top:1px solid #bdc9c8;text-align:center;">
                            <p style="color:#6e7979;font-size:12px;margin:0;">
                                Este email foi enviado automaticamente pelo sistema MindCare.
                            </p>
                            <p style="color:#6e7979;font-size:12px;margin:5px 0 0;">
                                © {{ date('Y') }} MindCare — Todos os direitos reservados
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
