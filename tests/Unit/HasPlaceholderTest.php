<?php

use Athphane\FilamentEditorjs\Forms\Components\EditorjsTextField;
use Filament\Support\Concerns\HasPlaceholder;

it('can set placeholder for editorjs field', function () {
    $field = new class('test') extends EditorjsTextField
    {
        use HasPlaceholder;

        public function setPlaceholderPublic(string $placeholder): static
        {
            return $this->placeholder($placeholder);
        }

        public function getPlaceholderPublic(): string
        {
            return $this->getPlaceholder();
        }
    };

    $field->setPlaceholderPublic('Start writing...');

    expect($field->getPlaceholderPublic())->toBe('Start writing...');
});

it('can set empty placeholder', function () {
    $field = new class('test') extends EditorjsTextField
    {
        use HasPlaceholder;

        public function setPlaceholderPublic(?string $placeholder): static
        {
            return $this->placeholder($placeholder);
        }

        public function getPlaceholderPublic(): ?string
        {
            return $this->getPlaceholder();
        }
    };

    $field->setPlaceholderPublic(null);

    expect($field->getPlaceholderPublic())->toBeNull();
});

it('has no placeholder by default', function () {
    $field = new class('test') extends EditorjsTextField
    {
        use HasPlaceholder;

        public function getPlaceholderPublic(): ?string
        {
            return $this->getPlaceholder();
        }
    };

    expect($field->getPlaceholderPublic())->toBeNull();
});

it('can set placeholder through EditorjsTextField::make', function () {
    $field = EditorjsTextField::make('content')
        ->placeholder('Start writing...');

    expect($field->getPlaceholder())->toBe('Start writing...');
});

it('can set empty placeholder through EditorjsTextField::make', function () {
    $field = EditorjsTextField::make('content')
        ->placeholder('');

    expect($field->getPlaceholder())->toBe('');
});
