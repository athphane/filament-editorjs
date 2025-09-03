<?php

use Athphane\FilamentEditorjs\Forms\Components\EditorjsTextField;
use Athphane\FilamentEditorjs\Forms\Concerns\HasHeight;

it('can set and get min height', function () {
    $field = new class('test') extends EditorjsTextField
    {
        use HasHeight;

        public function minHeightPublic(int $minHeight): static
        {
            return $this->minHeight($minHeight);
        }

        public function getMinHeightPublic(): int
        {
            return $this->getMinHeight();
        }
    };

    $field->minHeightPublic(150);

    expect($field->getMinHeightPublic())->toBe(150);
});

it('has default min height', function () {
    $field = new class('test') extends EditorjsTextField
    {
        use HasHeight;

        public function getMinHeightPublic(): int
        {
            return $this->getMinHeight();
        }
    };

    // Default should be 20
    expect($field->getMinHeightPublic())->toBe(20);
});
