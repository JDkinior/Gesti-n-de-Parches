<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --primary-color: #0ea5e9;
                --primary-hover: #0284c7;
                --bg-primary: #0f172a;
                --bg-secondary: #1e293b;
                --text-primary: #e2e8f0;
                --text-secondary: #cbd5e1;
                --border-color: #334155;
                --success-color: #10b981;
                --error-color: #ef4444;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            html, body {
                height: 100%;
            }

            body {
                font-family: 'Figtree', ui-sans-serif, system-ui, sans-serif;
                background-color: var(--bg-primary);
                color: var(--text-primary);
                line-height: 1.6;
            }

            .auth-wrapper {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                padding: 1.5rem;
                background-color: var(--bg-primary);
            }

            .auth-container {
                width: 100%;
                max-width: 440px;
            }

            .auth-header {
                text-align: center;
                margin-bottom: 2rem;
            }

            .auth-logo {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 50px;
                height: 50px;
                background-color: var(--primary-color);
                border-radius: 12px;
                color: white;
                font-size: 1.75rem;
                margin-bottom: 1.5rem;
                transition: all 0.2s ease;
            }

            .auth-logo:hover {
                background-color: var(--primary-hover);
                transform: translateY(-2px);
            }

            .auth-card {
                background: #1e293b;
                border-radius: 12px;
                border: 1px solid var(--border-color);
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px 2px rgba(0, 0, 0, 0.2);
                overflow: hidden;
            }

            .auth-card-body {
                padding: 2rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-group:last-of-type {
                margin-bottom: 0;
            }

            label {
                display: block;
                font-size: 0.9375rem;
                font-weight: 600;
                color: var(--text-primary);
                margin-bottom: 0.5rem;
                letter-spacing: -0.01em;
            }

            input[type="text"],
            input[type="email"],
            input[type="password"],
            textarea,
            select {
                width: 100%;
                padding: 0.75rem 1rem;
                font-size: 1rem;
                border: 1px solid var(--border-color);
                border-radius: 8px;
                background-color: #0f172a;
                color: var(--text-primary);
                transition: all 0.2s ease;
                font-family: inherit;
            }

            input::placeholder,
            textarea::placeholder {
                color: var(--text-secondary);
            }

            input:hover,
            textarea:hover,
            select:hover {
                border-color: #475569;
            }

            input:focus,
            textarea:focus,
            select:focus {
                outline: none;
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
            }

            .btn {
                padding: 0.75rem 1.5rem;
                font-size: 0.95rem;
                font-weight: 600;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                transition: all 0.2s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                letter-spacing: -0.01em;
                width: 100%;
                margin-top: 0.5rem;
            }

            .btn-primary {
                background-color: var(--primary-color);
                color: white;
            }

            .btn-primary:hover {
                background-color: var(--primary-hover);
                box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
            }

            .btn-primary:active {
                transform: translateY(1px);
            }

            .btn-secondary {
                background-color: transparent;
                color: var(--primary-color);
                border: 1px solid var(--border-color);
            }

            .btn-secondary:hover {
                background-color: var(--bg-secondary);
                border-color: var(--primary-color);
            }

            .link {
                color: var(--primary-color);
                text-decoration: none;
                font-weight: 500;
                transition: all 0.2s ease;
            }

            .link:hover {
                color: var(--primary-hover);
                text-decoration: underline;
            }

            .text-center {
                text-align: center;
            }

            .text-muted {
                color: var(--text-secondary);
                font-size: 0.9rem;
            }

            .text-sm {
                font-size: 0.875rem;
            }

            .mb-4 {
                margin-bottom: 1rem;
            }

            .mt-4 {
                margin-top: 1rem;
            }

            .mt-2 {
                margin-top: 0.5rem;
            }

            .ms-4 {
                margin-left: 1rem;
            }

            .flex {
                display: flex;
            }

            .flex-col {
                flex-direction: column;
            }

            .items-center {
                align-items: center;
            }

            .justify-between {
                justify-content: space-between;
            }

            .justify-end {
                justify-content: flex-end;
            }

            .gap-2 {
                gap: 0.5rem;
            }

            .gap-4 {
                gap: 1rem;
            }

            .block {
                display: block;
            }

            .w-full {
                width: 100%;
            }

            .underline {
                text-decoration: underline;
            }

            .rounded-lg {
                border-radius: 0.5rem;
            }

            .hidden {
                display: none;
            }

            /* Input Error Styles */
            .error-message {
                color: var(--error-color);
                font-size: 0.875rem;
                margin-top: 0.375rem;
            }

            /* Auth Session Status */
            .auth-session-status {
                background-color: #d1fae5;
                border: 1px solid #10b981;
                color: #065f46;
                padding: 1rem;
                border-radius: 8px;
                margin-bottom: 1.5rem;
                font-size: 0.9rem;
            }

            .divider {
                display: flex;
                align-items: center;
                margin: 1.5rem 0;
                gap: 1rem;
            }

            .divider::before,
            .divider::after {
                content: '';
                flex: 1;
                height: 1px;
                background-color: var(--border-color);
            }

            .divider-text {
                font-size: 0.85rem;
                color: var(--text-secondary);
                font-weight: 500;
            }

            .buttons-group {
                display: flex;
                gap: 1rem;
                margin-top: 2rem;
            }

            .buttons-group .btn {
                flex: 1;
                margin: 0;
            }

            /* Modo oscuro */
            @media (prefers-color-scheme: dark) {
                :root {
                    --bg-primary: #0f172a;
                    --bg-secondary: #1e293b;
                    --text-primary: #f1f5f9;
                    --text-secondary: #cbd5e1;
                    --border-color: #334155;
                }

                body {
                    background-color: var(--bg-primary);
                }

                .auth-card {
                    background: #1e293b;
                    border-color: var(--border-color);
                }

                input[type="text"],
                input[type="email"],
                input[type="password"],
                textarea,
                select {
                    background-color: #0f172a;
                    border-color: var(--border-color);
                    color: var(--text-primary);
                }

                input:hover,
                textarea:hover,
                select:hover {
                    border-color: #475569;
                }

                input:focus,
                textarea:focus,
                select:focus {
                    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
                }

                .btn-secondary {
                    border-color: var(--border-color);
                }

                .btn-secondary:hover {
                    background-color: var(--bg-secondary);
                }

                .auth-session-status {
                    background-color: rgba(16, 185, 129, 0.2);
                    border-color: #10b981;
                    color: #86efac;
                }

                .error-message {
                    color: #fca5a5;
                }
            }

            @media (max-width: 640px) {
                .auth-container {
                    max-width: 100%;
                }

                .auth-card-body {
                    padding: 1.5rem;
                }

                .buttons-group {
                    flex-direction: column;
                }

                .buttons-group .btn {
                    margin: 0.5rem 0 0 0;
                }
            }
        </style>
    </head>
    <body>
        <div class="auth-wrapper">
            <div class="auth-container">
                <div class="auth-header">
                    <a href="/" class="auth-logo">
                        <i class="fas fa-lock"></i>
                    </a>
                    <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">{{ config('app.name', 'Laravel') }}</h1>
                </div>

                <div class="auth-card">
                    <div class="auth-card-body">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
