<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    @if(is_null($recordExists()))
        <div class="editorjs-wrapper w-full text-center text-gray-400 dark:text-gray-500">
            Save the record to start writing content.
        </div>
    @else
        <div class="filament-editorjs">
            <div
                wire:ignore
                id="editorjs-{{ str_replace('.', '-', $getStatePath()) }}"
                {{
                  $attributes
                    ->merge($getExtraAttributes())
                    ->class([
                        'editorjs-wrapper'
                    ])
                }}
                x-data="editorjs({
                    state: $wire.entangle('{{ $getStatePath() }}'),
                    statePath: '{{ $getStatePath() }}',
                    placeholder: '{{ $getPlaceholder() }}',
                    readOnly: {{ $isDisabled() ? 'true' : 'false' }},
                    tools: @js($getTools()),
                    minHeight: @js($getMinHeight()),
                    uploadByFileUsing: function(file) {
                        // File type validation
                        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                        if (!allowedTypes.includes(file.type)) {
                            console.warn('File type not allowed:', file.type);
                            return Promise.resolve({ success: 0 });
                        }

                        // File size validation (5MB limit)
                        const maxSize = 5 * 1024 * 1024;
                        if (file.size > maxSize) {
                            console.warn('File too large:', file.size);
                            return Promise.resolve({ success: 0 });
                        }

                        return new Promise((resolve) => {
                            $wire.upload(
                                'componentFileAttachments.{{ $getStatePath() }}',
                                file,
                                (uploadedFilename) => {
                                    $wire.getFormComponentFileAttachmentUrl('{{ $getStatePath() }}', uploadedFilename)
                                        .then((url) => {
                                            resolve({
                                                success: 1,
                                                file: {
                                                    url: url,
                                                    name: file.name,
                                                    size: file.size
                                                }
                                            });
                                        })
                                        .catch((error) => {
                                            console.error('URL fetch error:', error);
                                            resolve({ success: 0 });
                                        });
                                },
                                (error) => {
                                    console.error('Upload Error:', error);
                                    resolve({ success: 0 });
                                }
                            );
                        });
                    }
                })"
            >
            </div>
        </div>
    @endif
</x-dynamic-component>
