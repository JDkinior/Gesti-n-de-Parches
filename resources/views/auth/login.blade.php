<x-guest-layout>
    <div class="mb-6 pb-6 border-b border-gray-600 dark:border-gray-600">
        <h2 class="text-2xl font-bold text-white dark:text-white mb-2">Acceso</h2>
        <p class="text-sm text-gray-400 dark:text-gray-400">Inicia sesión en tu cuenta</p>
    </div>

    @if(session('status'))
        <div class="auth-session-status mb-4" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-900/30 dark:bg-red-900/30 border border-red-700 dark:border-red-700 text-sm text-red-300 dark:text-red-300">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <strong>Se encontraron errores:</strong>
            <ul class="list-disc list-inside mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <!-- Email -->
        <div class="form-group mb-4">
            <x-input-label for="email" value="Correo Electrónico" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="tu@email.com" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="form-group mb-4">
            <x-input-label for="password" value="Contraseña" />
            <div class="relative flex">
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    class="flex-1 px-3 py-2 border border-gray-600 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 rounded-l-lg text-gray-100 placeholder-gray-500 transition-colors duration-200 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                    required 
                    autocomplete="current-password"
                    placeholder="••••••••"
                >
                <button 
                    type="button" 
                    id="togglePassword" 
                    class="px-3 py-2 border border-l-0 border-gray-600 dark:border-gray-600 dark:bg-gray-800 rounded-r-lg bg-gray-800 text-gray-400 dark:text-gray-400 hover:bg-gray-700 dark:hover:bg-gray-700 transition-colors"
                    title="Mostrar / ocultar contraseña"
                >
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Remember & Forgot Password -->
        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center gap-2">
                <input 
                    type="checkbox" 
                    name="remember" 
                    id="remember_me" 
                    class="w-4 h-4 rounded cursor-pointer accent-blue-500"
                    {{ old('remember') ? 'checked' : '' }}
                >
                <span class="text-sm text-gray-400 dark:text-gray-400">Recuerda mi sesión</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-400 hover:text-blue-300 dark:text-blue-400 font-medium">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <x-primary-button>
            <i class="fas fa-sign-in-alt mr-2"></i>Iniciar Sesión
        </x-primary-button>
    </form>

    <div class="relative my-4">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-600 dark:border-gray-600"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-gray-800 dark:bg-gray-800 text-gray-500 dark:text-gray-500">o</span>
        </div>
    </div>

    <p class="text-center text-sm text-gray-400 dark:text-gray-400">
        ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 dark:text-blue-400 font-semibold">Regístrate aquí</a>
    </p>

    @push('scripts')
    <script>
        document.getElementById('togglePassword')?.addEventListener('click', function(){
            const pw = document.getElementById('password');
            if (!pw) return;
            if (pw.type === 'password') { 
                pw.type = 'text'; 
                this.innerHTML = '<i class="fas fa-eye-slash"></i>'; 
            } else { 
                pw.type = 'password'; 
                this.innerHTML = '<i class="fas fa-eye"></i>'; 
            }
        });
    </script>
    @endpush
</x-guest-layout>
