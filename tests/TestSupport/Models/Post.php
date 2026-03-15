<?php

namespace Athphane\FilamentEditorjs\Tests\TestSupport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['content'];

    public function editorjsMediaCollectionName(): string
    {
        return 'content_images';
    }

    public function editorJsContentFieldName(): string
    {
        return 'content';
    }

    public function registerEditorJsMediaCollections(?array $mime_types = null, bool $generate_responsive_images = true): void
    {
        if ( ! $mime_types) {
            $mime_types = config('filament-editorjs.image_mime_types');
        }

        $this->addMediaCollection($this->editorjsMediaCollectionName())
            ->acceptsMimeTypes($mime_types)
            ->withResponsiveImagesIf($generate_responsive_images);
    }

    public function registerEditorJsMediaConversions(?Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->performOnCollections($this->editorjsMediaCollectionName())
            ->fit(Spatie\Image\Enums\Fit::Contain, 1024, 768)
            ->nonQueued();
    }

    public function findAndDeleteRemovedEditorJsMedia(): void
    {
        $content = $this->{$this->editorJsContentFieldName()};

        $media_currently_used_in_content = [];

        if (is_array($content) && isset($content['blocks'])) {
            foreach ($content['blocks'] as $contentBlock) {
                if (data_get($contentBlock, 'type') === 'image') {
                    $media_currently_used_in_content[] = data_get($contentBlock, 'data.file.media_id');
                }
            }
        }

        $this->media()
            ->where('collection_name', $this->editorjsMediaCollectionName())
            ->whereNotIn('id', $media_currently_used_in_content)
            ->delete();
    }

    public function editJsSaveImageFromTempFile($file)
    {
        return $this
            ->addMedia($file->getRealPath())
            ->usingFileName($file->getClientOriginalName())
            ->toMediaCollection($this->editorjsMediaCollectionName());
    }
}
