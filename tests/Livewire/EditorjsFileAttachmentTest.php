<?php

use Athphane\FilamentEditorjs\Forms\Components\EditorjsTextField;
use Athphane\FilamentEditorjs\Tests\Livewire\TestEditorjsComponent;

use function Pest\Livewire\livewire;

it('verifies editorjs text field implements file attachments', function () {
    $field = EditorjsTextField::make('content');

    // Check that the field implements the HasFileAttachments contract
    expect($field)->toBeInstanceOf(\Filament\Forms\Components\Concerns\HasFileAttachments::class);

    // Check that the field uses the HasFileAttachments trait
    expect(method_exists($field, 'handleFileAttachmentUpload'))->toBeTrue();
    expect(method_exists($field, 'handleUploadedAttachmentUrlRetrieval'))->toBeTrue();
});

it('can test file attachment upload method', function () {
    // This would require a more complex setup with a real model that implements HasMedia
    // For now, we'll just verify the method exists
    $field = EditorjsTextField::make('content');

    expect(method_exists($field, 'handleFileAttachmentUpload'))->toBeTrue();
})->skip('Testing file attachment upload requires a model with HasMedia implementation');

it('can test file attachment url retrieval method', function () {
    // This would require setting up media in the database
    // For now, we'll just verify the method exists
    $field = EditorjsTextField::make('content');

    expect(method_exists($field, 'handleUploadedAttachmentUrlRetrieval'))->toBeTrue();
})->skip('Testing file attachment URL retrieval requires media in database');

it('can render editorjs component in livewire', function () {
    livewire(TestEditorjsComponent::class)
        ->assertFormExists()
        ->assertFormFieldExists('content')
        ->assertSuccessful();
});

it('verifies editorjs component has correct configuration', function () {
    livewire(TestEditorjsComponent::class)
        ->assertFormFieldExists('content', function (EditorjsTextField $field): bool {
            // Check that the field has the correct view
            return $field->getView() === 'filament-editorjs::components.editorjs-text-field';
        });
});
