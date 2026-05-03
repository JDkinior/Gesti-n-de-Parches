<x-guest-layout>
    <div class="mb-6 pb-6 border-b border-gray-300 dark:border-gray-600">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Establecer Nueva Contraseña</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Ingresa tu nueva contraseña para recuperar acceso</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="form-group mb-4">
            <x-input-label for="email" value="Correo Electrónico" />
            <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="tu@email.com" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="form-group mb-4">
            <x-input-label for="password" value="Nueva Contraseña" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" />
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">Mínimo 8 caracteres</p>
        </div>

        <!-- Confirm Password -->
        <div class="form-group mb-6">
            <x-input-label for="password_confirmation" value="Confirmar Contraseña" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <x-primary-button>
            <i class="fas fa-lock mr-2"></i>{{ __('Restablecer Contraseña') }}
        </x-primary-button>
    </form>
</x-guest-layout>
