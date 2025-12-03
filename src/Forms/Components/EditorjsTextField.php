<?php

namespace Athphane\FilamentEditorjs\Forms\Components;

use Athphane\FilamentEditorjs\Forms\Concerns\HasHeight;
use Athphane\FilamentEditorjs\Forms\Concerns\HasTools;
use Athphane\FilamentEditorjs\Traits\ModelHasEditorJsComponent;
use Filament\Forms\Components\Concerns\HasFileAttachments;
use Filament\Forms\Components\Field;
use Filament\Support\Components\Attributes\ExposedLivewireMethod;
use Filament\Support\Concerns\HasPlaceholder;
use Livewire\Attributes\Renderless;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EditorjsTextField extends Field
{
    use HasFileAttachments;
    use HasHeight;
    use HasPlaceholder;
    use HasTools;

    protected string $view = 'filament-editorjs::components.editorjs-text-field';

    protected ?int $mediaId = null;

    public static function make(string $name = null): static
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
    public function handleFileAttachmentUpload(TemporaryUploadedFile $file): mixed
    {
        /** @var ModelHasEditorJsComponent $record */
        $record = $this->getRecord();

        $media = $record->editJsSaveImageFromTempFile($file);

        return $media->uuid;
    }

    #[ExposedLivewireMethod]
    #[Renderless]
    public function handleUploadedAttachmentUrlRetrieval(mixed $file): ?string
    {
        $media = Media::where('uuid', $file)->first();

        if (!$media) {
            // Try to find media by ID if $file is an ID instead of UUID
            $media = Media::find($file);
        }

        if (!$media) {
            return null;
        }

        try {
            // Try to get the preview URL, fallback to original URL if conversion doesn't exist
            $url = $media->hasGeneratedConversion('preview')
                ? $media->getUrl('preview')
                : $media->getUrl();
        } catch (\Exception $e) {
            // If there's an issue with the conversion, return the original URL
            $url = $media->getUrl();
        }

        // Return a JSON string with both URL and ID
        return json_encode([
            'url' => $url,
            'id'  => $media->id,
        ]);
    }

    #[ExposedLivewireMethod]
    public function processUploadedFileAndGetUrl(string $tempFileIdentifier): ?string
    {
        try {
            // Convert the temporary file identifier string to a TemporaryUploadedFile object
            // In Livewire, we can get the TemporaryUploadedFile using createFromLivewire
            $tempFile = TemporaryUploadedFile::createFromLivewire($tempFileIdentifier);

            if (!$tempFile instanceof TemporaryUploadedFile) {
                return null;
            }

            // Process the temporary file to get UUID using existing method
            $uuid = $this->handleFileAttachmentUpload($tempFile);

            if (!$uuid) {
                return null;
            }

            // Now retrieve the media data using the UUID
            return $this->handleUploadedAttachmentUrlRetrieval($uuid);
        } catch (\Exception $e) {
            \Log::error('Error processing uploaded file: ' . $e->getMessage());
            return null;
        }
    }

    public function someMethod()
    {
        return 'something';
    }
}
