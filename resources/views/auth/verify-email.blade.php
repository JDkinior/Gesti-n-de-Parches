<x-guest-layout>
    <div class="mb-6 pb-6 border-b border-gray-300 dark:border-gray-600">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Verificar Correo</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">Confirma tu dirección de correo electrónico</p>
    </div>

    <div class="mb-6 p-4 rounded-lg bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-700 text-sm text-amber-700 dark:text-amber-300">
        <i class="fas fa-exclamation-triangle mr-2"></i>
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-3 rounded-lg bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-sm text-green-700 dark:text-green-300">
            <i class="fas fa-check-circle mr-2"></i>
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="space-y-3">
        <form method="POST" action="{{ route('verification.send') }}" class="m-0">
            @csrf
            <x-primary-button>
                <i class="fas fa-envelope mr-2"></i>{{ __('Resend Verification Email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                <i class="fas fa-sign-out-alt mr-2"></i>{{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
