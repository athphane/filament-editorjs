@php
    $content = $content ?? '';
    $caption = $caption ?? '';
    $alignment = $alignment ?? 'left';
    $config = $config ?? [];

    $alignmentClasses = [
        'center' => 'text-center border-l-0 border-r-0 justify-center',
        'right' => 'text-right border-l-0 border-r-4 justify-end',
    ][$alignment] ?? 'text-left border-l-4 border-r-0'; // Default to left

    $containerClasses = "my-6 p-4 italic bg-gray-50 border-t border-b border-gray-200 {$alignmentClasses}";
@endphp

<div class="{{ $containerClasses }}">
    <blockquote class="text-gray-700">
        "{{ $content }}"
    </blockquote>

    @if($caption)
        <cite class="block mt-2 text-sm text-gray-500 not-italic">— {{ $caption }}</cite>
    @endif
</div>