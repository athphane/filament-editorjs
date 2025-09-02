<?php

namespace Athphane\FilamentEditorjs\Tests\Models;

use Athphane\FilamentEditorjs\Traits\ModelHasEditorJsComponent;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia;
    use ModelHasEditorJsComponent;

    protected $table = 'posts';

    protected $guarded = [];

    protected $casts = [
        'content' => 'array',
    ];

    public function registerMediaCollections(): void
    {
        $this->registerEditorJsMediaCollections();
    }

    public function registerMediaConversions(?\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->registerEditorJsMediaConversions($media);
    }
}
