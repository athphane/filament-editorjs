@php
    $content = $content ?? [];
    $config = $config ?? [];
@endphp

<div class="my-6 overflow-x-auto">
    <table class="min-w-full border-collapse border border-gray-300">
        @foreach($content as $rowIndex => $row)
            <tr>
                @foreach($row as $cellIndex => $cell)
                    @if($rowIndex === 0)
                        <th class="border border-gray-300 px-4 py-2 bg-gray-100 font-semibold text-left">{{ $cell }}</th>
                    @else
                        <td class="border border-gray-300 px-4 py-2">{{ $cell }}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </table>
</div>