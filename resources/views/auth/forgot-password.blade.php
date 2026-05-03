<x-guest-layout>
    <div class="mb-6 pb-6 border-b border-gray-300 dark:border-gray-600">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Recuperar Contraseña</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">¿Olvidaste tu contraseña? Aquí puedes recuperarla</p>
    </div>

    <div class="mb-6 p-4 rounded-lg bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 text-sm text-blue-700 dark:text-blue-300">
        <i class="fas fa-info-circle mr-2"></i>
        {{ __('No worries! Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group mb-6">
            <x-input-label for="email" value="Correo Electrónico" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="tu@email.com" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="space-y-3">
            <x-primary-button>
                <i class="fas fa-envelope mr-2"></i>{{ __('Enviar Enlace de Recuperación') }}
            </x-primary-button>

            <a href="{{ route('login') }}" class="flex items-center justify-center w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Volver al Acceso
            </a>
        </div>
    </form>
</x-guest-layout>
