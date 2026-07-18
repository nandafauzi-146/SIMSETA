@props(['title' => null, 'description' => null, 'footer' => null])

<div {{ $attributes->merge(['class' => 'rounded-[2rem] border border-[var(--primary)]/15 bg-white p-6 shadow-lg sm:p-8']) }}>
    @if ($title || $description)
        <div class="mb-6 border-b border-slate-100 pb-4">
            @if ($title)
                <h2 class="text-xl font-semibold text-[var(--text)]">{{ $title }}</h2>
            @endif
            @if ($description)
                <p class="mt-2 text-sm text-[var(--text-muted)]">{{ $description }}</p>
            @endif
        </div>
    @endif

    {{ $slot }}

    @if ($footer)
        <div class="mt-6 border-t border-slate-100 pt-4">{{ $footer }}</div>
    @endif
</div>
