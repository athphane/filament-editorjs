<?php

use Athphane\FilamentEditorjs\Forms\Components\EditorjsTextField;
use Athphane\FilamentEditorjs\Forms\Concerns\HasTools;

it('can set default tools from config', function () {
    $field = new class('test') extends EditorjsTextField
    {
        use HasTools;

        public function setDefaultToolsPublic(): static
        {
            return $this->setDefaultTools();
        }

        public function getToolsPublic(): array
        {
            return $this->getTools();
        }
    };

    $field->setDefaultToolsPublic();

    // Default tools from config
    expect($field->getToolsPublic())->toBeArray();
});

it('can set tools by profile name', function () {
    $field = new class('test') extends EditorjsTextField
    {
        use HasTools;

        public function toolsPublic(string $tool_profile): static
        {
            return $this->tools($tool_profile);
        }

        public function getToolsPublic(): array
        {
            return $this->getTools();
        }
    };

    $field->toolsPublic('default');

    expect($field->getToolsPublic())->toBeArray();
});
