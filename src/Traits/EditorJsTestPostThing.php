<?php

namespace Athphane\FilamentEditorjs\Traits;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

final class EditorJsTestPostThing extends Model implements HasMedia
{
    use InteractsWithMedia;
    use ModelHasEditorJsComponent;
}
