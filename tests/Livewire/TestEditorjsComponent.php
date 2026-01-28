<?php

namespace Athphane\FilamentEditorjs\Tests\Livewire;

use Athphane\FilamentEditorjs\Forms\Components\EditorjsTextField;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Attributes\Rule;
use Livewire\Component;

class TestEditorjsComponent extends Component implements HasForms
{
    use InteractsWithForms;

    #[Rule('nullable|array')]
    public $content = null;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                EditorjsTextField::make('content'),
            ]);
    }

    public function submit()
    {
        $this->form->getState();
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            {{ $this->form }}
        </div>
        HTML;
    }
}
