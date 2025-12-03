@php
    $key = $getKey();
    $statePath = $getStatePath();
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div class="filament-editorjs">
        <div
            wire:ignore
            id="editorjs-{{ str_replace('.', '-', $statePath) }}"
            {{ $attributes->merge($getExtraAttributes())->class(['editorjs-wrapper']) }}
            x-data="editorjs({
                state: $wire.entangle('{{ $statePath }}'),
                statePath: '{{ $statePath }}',
                placeholder: '{{ $getPlaceholder() }}',
                readOnly: @js($isDisabled()),
                tools: @js($getTools()),
                minHeight: @js($getMinHeight()),
                wire: $wire,
                componentKey: @js($key),
                imageMimeTypes: @js(config('filament-editorjs.image_mime_types')),
                maxSize: 5242880,
                canUpload: @js($recordExists()),
                pluginUrls: @js($getPluginUrls()) {{-- Pass the URLs here --}}
            })"
        >
        </div>
    </div>
</x-dynamic-component>
