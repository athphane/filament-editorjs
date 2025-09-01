<?php

namespace Athphane\FilamentEditorjs\Traits;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait ModelHasEditorJsComponent
{
    /**
     * Do things when the model is booted
     */
    public static function bootModelHasEditorJsComponent(): void
    {
        static::updating(function ($model) {
            // Find removed media from the content and delete it from the media collection
            $model->findAndDeleteRemovedEditorJsMedia();
        });
    }

    /**
     * The name of the media collection for the editorjs media collection
     */
    public function editorjsMediaCollectionName(): string
    {
        return 'content_images';
    }

    /**
     * The name of the field that contains the content for the editorjs field
     */
    public function editorJsContentFieldName(): string
    {
        return 'content';
    }

    /**
     * Method to save the TemporaryUploadedFile to the media collection for the editorjs images
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function editJsSaveImageFromTempFile(TemporaryUploadedFile $file)
    {
        return $this
            ->addMedia($file->getRealPath())
            ->usingFileName($file->getClientOriginalName())
            ->toMediaCollection($this->editorjsMediaCollectionName());
    }

    /**
     * Helper method to register the media collections for the editorjs media collection
     * Use this in your model's own registerMediaCollections method.
     *
     * This function allows for you to pass in an array of mime types to accept.
     * By default, the package will use its own config for the image mime types.
     */
    public function registerEditorJsMediaCollections(?array $mime_types = null, bool $generate_responsive_images = true): void
    {
        if (! $mime_types) {
            $mime_types = config('filament-editorjs.image_mime_types');
        }

        $this->addMediaCollection($this->editorjsMediaCollectionName())
            ->acceptsMimeTypes($mime_types)
            ->withResponsiveImagesIf($generate_responsive_images);
    }

    /**
     * Helper method to register the media conversions for the editorjs media collection
     * Use this in your model's own registerMediaConversions method.
     *
     * This function allows for the Media object to be passed in just like the addMediaConversion
     * from Spatie
     */
    public function registerEditorJsMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->performOnCollections($this->editorjsMediaCollectionName())
            ->fit(Fit::Contain, 1024, 768)
            ->nonQueued();
    }

    /**
     * Method to find and delete all the media in the collection that is not currently used in the content
     */
    public function findAndDeleteRemovedEditorJsMedia(): void
    {
        $content = $this->{$this->editorJsContentFieldName()};

        $media_currently_used_in_content = [];

        // Go through all the content blocks and find the media IDs
        foreach ($content['blocks'] as $content) {
            if (data_get($content, 'type') === 'image') {
                $media_currently_used_in_content[] = data_get($content, 'data.file.media_id');
            }
        }

        // Delete all the media in the collection that is not currently used in the content
        $this->media()
            ->where('collection_name', $this->editorjsMediaCollectionName())
            ->whereNotIn('id', $media_currently_used_in_content)->delete();
    }
}
