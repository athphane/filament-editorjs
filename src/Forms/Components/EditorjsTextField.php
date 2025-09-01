<?php

namespace Athphane\FilamentEditorjs\Forms\Components;

use Athphane\FilamentEditorjs\Forms\Concerns\HasHeight;
use Athphane\FilamentEditorjs\Forms\Concerns\HasTools;
use Athphane\FilamentEditorjs\Traits\ModelHasEditorJsComponent;
use Filament\Forms\Components\Concerns\HasFileAttachments;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasPlaceholder;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class EditorjsTextField extends Field implements \Filament\Forms\Components\Contracts\HasFileAttachments
{
    use HasFileAttachments;
    use HasHeight;
    use HasPlaceholder;
    use HasTools;

    protected string $view = 'filament-editorjs::components.editorjs-text-field';

    public static function make(string $name): static
    {
        $instance = parent::make($name);

        // Setup Default Tools from Config
        $instance = $instance->setDefaultTools();

        return $instance;
    }

    public function recordExists(): true
    {
        return $this->getRecord() !== null;
    }

    protected function handleFileAttachmentUpload(TemporaryUploadedFile $file): mixed
    {
        /** @var ModelHasEditorJsComponent $record */
        $record = $this->getRecord();
        $image = $record->editJsSaveImageFromTempFile($file);
        $storeMethod = $this->getFileAttachmentsVisibility() === 'public' ? 'storePublicly' : 'store';

        return $file->{$storeMethod}($this->getFileAttachmentsDirectory(), $this->getFileAttachmentsDiskName());
    }
}
