<?php

namespace Athphane\FilamentEditorjs\Forms\Components;

use Athphane\FilamentEditorjs\Forms\Concerns\HasHeight;
use Athphane\FilamentEditorjs\Forms\Concerns\HasTools;
use Athphane\FilamentEditorjs\Traits\ModelHasEditorJsComponent;
use Filament\Forms\Components\Concerns\HasFileAttachments;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasPlaceholder;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EditorjsTextField extends Field implements \Filament\Forms\Components\Contracts\HasFileAttachments
{
    use HasFileAttachments;
    use HasHeight;
    use HasPlaceholder;
    use HasTools;

    protected string $view = 'filament-editorjs::components.editorjs-text-field';

    protected ?int $mediaId = null;

    public static function make(string $name): static
    {
        $instance = parent::make($name);

        // Setup Default Tools from Config
        $instance = $instance->setDefaultTools();

        return $instance;
    }

    public function recordExists(): bool
    {
        return $this->getRecord() !== null;
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    protected function handleFileAttachmentUpload(TemporaryUploadedFile $file): mixed
    {
        /** @var ModelHasEditorJsComponent $record */
        $record = $this->getRecord();

        $media = $record->editJsSaveImageFromTempFile($file);

        return $media->uuid;
    }

    protected function handleUploadedAttachmentUrlRetrieval(mixed $file): ?string
    {
        $media = Media::where('uuid', $file)->first();

        if ( ! $media) {
            return null;
        }

        // Return a JSON string with both URL and ID
        return json_encode([
            'url' => $media->getUrl('preview'),
            'id'  => $media->id,
        ]);
    }
}
