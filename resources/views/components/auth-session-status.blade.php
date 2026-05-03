@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'mb-4 p-3 rounded-lg bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-sm text-green-700 dark:text-green-300 font-medium']) }}>
        <i class="fas fa-check-circle mr-2"></i>{{ $status }}
    </div>
@endif
