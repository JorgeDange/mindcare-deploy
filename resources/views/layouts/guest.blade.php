<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MindCare') }} - 2FA</title>
        <link rel="shortcut icon" href="{{ asset('assets/logoti.png') }}" type="image/x-icon">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

        <!-- Tailwind CDN with Config -->
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <script>
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        colors: {
                            "primary": "#005f5f",
                            "on-primary": "#ffffff",
                            "primary-container": "#007a7a",
                            "on-primary-container": "#acfffe",
                            "secondary": "#0060ac",
                            "surface": "#f3faff",
                            "on-surface": "#071e27",
                            "on-surface-variant": "#3e4948",
                            "surface-container-low": "#e6f6ff",
                            "surface-container": "#dbf1fe",
                            "outline": "#6e7979",
                            "outline-variant": "#bdc9c8",
                            "error": "#ba1a1a"
                        },
                        fontFamily: {
                            "headline-lg": ["Inter", "sans-serif"],
                            "title-lg": ["Inter", "sans-serif"],
                            "body-md": ["Inter", "sans-serif"],
                            "body-sm": ["Inter", "sans-serif"],
                            "label-md": ["Inter", "sans-serif"]
                        },
                        spacing: {
                            "stack-lg": "24px"
                        }
                    }
                }
            }
        </script>
        <style>
            body { font-family: 'Inter', sans-serif; background-color: #f3faff; }
            .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        </style>
    </head>
    <body class="text-on-surface antialiased bg-surface">
        {{ $slot }}
    </body>
</html>
