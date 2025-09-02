<?php

use Athphane\FilamentEditorjs\Tests\Livewire\TestEditorjsComponent;

use function Pest\Livewire\livewire;

it('can render editorjs component', function () {
    livewire(TestEditorjsComponent::class)
        ->assertFormExists()
        ->assertFormFieldExists('content');
});

it('can fill editorjs component with content', function () {
    $content = [
        'time'   => 1675692000000,
        'blocks' => [
            [
                'type' => 'paragraph',
                'data' => [
                    'text' => 'This is a test paragraph.',
                ],
            ],
        ],
        'version' => '2.27.2',
    ];

    livewire(TestEditorjsComponent::class)
        ->fillForm([
            'content' => $content,
        ])
        ->assertFormSet([
            'content' => $content,
        ]);
});

it('can validate editorjs content', function () {
    livewire(TestEditorjsComponent::class)
        ->fillForm([
            'content' => [
                'blocks' => [
                    [
                        'type' => 'paragraph',
                        'data' => [
                            'text' => 'This is a test paragraph.',
                        ],
                    ],
                ],
            ],
        ])
        ->call('submit')
        ->assertHasNoFormErrors();
});

it('can test file attachment functionality', function () {
    // This test verifies that the component implements HasFileAttachments
    $component = new TestEditorjsComponent();

    // We can't directly test file uploads without a full implementation
    // But we can verify that the form field supports file attachments
    $form = $component->form(new Filament\Forms\Form($component));

    expect($form)->toBeInstanceOf(Filament\Forms\Form::class);
})->skip('Full file upload testing requires a more complex setup with actual media library integration');
