<?php

namespace Athphane\FilamentEditorjs\Tests\Livewire;

use Athphane\FilamentEditorjs\Forms\Components\EditorjsTextField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class TestEditorjsComponent extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [
        'content' => null,
    ];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                EditorjsTextField::make('content')
                    ->placeholder('Start writing...')
                    ->minHeight(200),
            ])
            ->statePath('data');
    }

    public function submit()
    {
        // This method would handle form submission
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <form wire:submit="submit">
                {{ $this->form }}
                
                <button type="submit">
                    Submit
                </button>
            </form>
            
            <div>
                Submitted content: {{ json_encode($this->data['content']) }}
            </div>
        </div>
        HTML;
    }
}
