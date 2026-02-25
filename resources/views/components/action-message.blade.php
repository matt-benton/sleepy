@props([
    'on',
])

@teleport('body')
    <div
        x-data="{ shown: false, timeout: null }"
        x-init="@this.on('{{ $on }}', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 3000); })"
        x-show="shown"
        x-transition:enter="transition ease duration-300"
        x-transition:enter-start="transform translate-y-[150px]"
        x-transition:enter-end="transform translate-y-0"
        x-transition:leave="transition ease duration-500"
        x-transition:leave-end="transform translate-y-[150px]"
        style="display: none"
        {{ $attributes->merge(['class' => 'text-sm fixed bottom-0 inset-x-0 bg-green-400 dark:bg-green-600 rounded-lg px-6 py-4 mx-auto mb-6 max-w-md']) }}
    >
        {{ $slot->isEmpty() ? __('Saved.') : $slot }}
    </div>
@endteleport
