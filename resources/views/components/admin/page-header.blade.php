@props(['title', 'description' => null])

<div {{ $attributes->merge(['class' => 'mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between']) }}>
    <div>
        <h1 class="text-3xl font-semibold text-[var(--text)]">{{ $title }}</h1>
        @if ($description)
            <p class="mt-2 text-sm text-[var(--text-muted)]">{{ $description }}</p>
        @endif
    </div>

    @if ($slot->isNotEmpty())
        <div class="flex flex-wrap items-center gap-3">{{ $slot }}</div>
    @endif
</div>
