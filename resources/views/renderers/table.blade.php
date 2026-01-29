@php
    $content = $content ?? [];
@endphp

<div class="overflow-x-auto my-6">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800 border border-gray-200 dark:border-gray-800">
        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
            @foreach($content as $row)
                <tr>
                    @foreach($row as $cell)
                        <td class="px-3 py-2 text-gray-700 dark:text-gray-300 border-x border-gray-100 dark:border-gray-800">
                            {!! $cell !!}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>