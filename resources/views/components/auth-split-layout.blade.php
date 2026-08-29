<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MindCare') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/logoti.png') }}" type="image/x-icon">

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="{{ asset('css/auth-custom.css') }}">
</head>
<body>

    <div class="auth-split-layout">
        <!-- Esquerda: Imagem -->
        <div class="auth-left">
            <a href="/" class="auth-left-logo">
                <img src="{{ asset('assets/logot.png') }}" alt="MindCare Logo">
                
            </a>
            
            <div class="glass-box">
                <p>Agende a sua primeira consulta online ou presencial connosco hoje mesmo.</p>
                <a href="{{ url('/planos') }}">Conhecer Planos</a>
            </div>
        </div>

        <!-- Direita: Formulário -->
        <div class="auth-right">
            <div class="auth-form-container">
                
                @hasSection('progress')
                    @yield('progress')
                @endif

                <h2 class="auth-title">@yield('title')</h2>

                {{ $slot }}
                
            </div>
        </div>
    </div>

</body>
</html>
