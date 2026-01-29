@php
    $blocks = $blocks ?? [];
@endphp

<div>
    @foreach($blocks as $block)
        {!! $block !!}
    @endforeach
</div>