<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full px-4 py-2.5 bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 active:transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
