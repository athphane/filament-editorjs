@php
    $content = $content ?? [];
@endphp

<div class="max-w-3xl mx-auto px-6">
    <div class="overflow-x-auto my-[1.25rem]">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
            <tbody class="divide-y divide-gray-200">
            @foreach($content as $row)
                <tr>
                    @foreach($row as $cell)
                        <td class="px-3 py-2 text-gray-700 border-x border-gray-100">
                            {!! $cell !!}
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
