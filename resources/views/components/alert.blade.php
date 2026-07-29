@props(['type' => 'info', 'dismissible' => true])

@php
    $types = [
        'success' => [
            'bg' => 'bg-[#66BB6A]/10',
            'border' => 'border-[#66BB6A]/30',
            'text' => 'text-[#1F2937]',
            'icon' => 'fas fa-check-circle text-[#2E7D32]'
        ],
        'error' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-200',
            'text' => 'text-red-800',
            'icon' => 'fas fa-exclamation-circle text-red-600'
        ],
        'info' => [
            'bg' => 'bg-blue-50',
            'border' => 'border-blue-200',
            'text' => 'text-blue-800',
            'icon' => 'fas fa-info-circle text-blue-600'
        ],
        'warning' => [
            'bg' => 'bg-[#E8C17A]/10',
            'border' => 'border-[#C89B53]/30',
            'text' => 'text-[#1F2937]',
            'icon' => 'fas fa-exclamation-triangle text-[#C89B53]'
        ],
    ];

    $meta = $types[$type] ?? $types['info'];
@endphp

<div x-data="{ show: true }" x-show="show" x-init="setTimeout(()=> show = false, 5000)"
    x-transition:enter="transform transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1"
    x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transform transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1"
    class="mb-4 rounded-3xl border px-5 py-4 shadow-sm flex items-start gap-3 {{ $meta['bg'] }} {{ $meta['border'] }} {{ $meta['text'] }}">
    <div class="shrink-0 mt-0.5">
        <i class="{{ $meta['icon'] }}"></i>
    </div>
    <div class="min-w-0 flex-1 text-sm">
        {{ $slot }}
    </div>

    @if($dismissible)
        <button @click="show = false" class="ml-3 shrink-0 rounded-full p-1.5 text-[var(--text-muted)] hover:bg-black/5">
            <i class="fas fa-times"></i>
        </button>
    @endif
</div>