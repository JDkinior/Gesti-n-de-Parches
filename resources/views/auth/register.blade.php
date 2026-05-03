<x-guest-layout>
    <div class="mb-6 pb-6 border-b border-gray-300 dark:border-gray-600">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Crear cuenta</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Registrate para acceder a la plataforma</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group mb-4">
            <x-input-label for="name" value="Nombre Completo" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Tu nombre completo" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <!-- Email Address -->
        <div class="form-group mb-4">
            <x-input-label for="email" value="Correo Electrónico" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="tu@email.com" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="form-group mb-4">
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" />
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">Mínimo 8 caracteres, incluye números y símbolos</p>
        </div>

        <!-- Confirm Password -->
        <div class="form-group mb-6">
            <x-input-label for="password_confirmation" value="Confirmar Contraseña" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="space-y-3">
            <x-primary-button>
                <i class="fas fa-user-plus mr-2"></i>{{ __('Registrarse') }}
            </x-primary-button>

            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">o</span>
                </div>
            </div>

            <a href="{{ route('login') }}" class="flex items-center justify-center w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                <i class="fas fa-sign-in-alt mr-2"></i>Acceder con tu cuenta
            </a>
        </div>

        <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-4">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600 dark:text-blue-400 font-semibold">Inicia sesión</a>
        </p>
    </form>
</x-guest-layout>
