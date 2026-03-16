@php
    $key = $getKey();
    $statePath = $getStatePath();
    $languages = \Athphane\FilamentEditorjs\Support\LanguageRegistry::class;
    $languageRegistry = app($languages);
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>

        <div
            wire:ignore
            id="editorjs-{{ str_replace('.', '-', $statePath) }}"
            {{ $attributes->merge($getExtraAttributes())->class(['editorjs-wrapper']) }}
            x-data="editorjs({
                state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
                statePath: '{{ $statePath }}',
                placeholder: @js($getPlaceholder()),
                readOnly: @js($isDisabled()),
                tools: @js($getTools()),
                minHeight: @js($getMinHeight()),
                wire: $wire,
                componentKey: @js($key),
                imageMimeTypes: @js(config('filament-editorjs.image_mime_types')),
                maxSize: 5242880,
                canUpload: @js($recordExists()),
                availableLanguages: @js($languageRegistry->getLanguages())
            })"
        >
        </div>
</x-dynamic-component>
