<x-guest-layout>
    <div class="mb-6 pb-6 border-b border-gray-300 dark:border-gray-600">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Confirmar Contraseña</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Por seguridad, confirma tu contraseña</p>
    </div>

    <div class="mb-6 p-4 rounded-lg bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 text-sm text-blue-700 dark:text-blue-300">
        <i class="fas fa-shield-alt mr-2"></i>
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="form-group mb-6">
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <x-primary-button>
            <i class="fas fa-check mr-2"></i>{{ __('Confirm') }}
        </x-primary-button>
    </form>
</x-guest-layout>
