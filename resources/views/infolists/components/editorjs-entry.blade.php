<x-filament-infolists::entry-wrapper :entry="$entry">
    {!! \Athphane\FilamentEditorjs\FilamentEditorjs::renderContent($getState(), $entry->getRenderConfig()) !!}
</x-filament-infolists::entry-wrapper>
