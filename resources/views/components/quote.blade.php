@props(['quote' => $quote])

<tr class="odd:bg-white even:bg-slate-100 text-gray-700">
    <td class="p-3 whitespace-nowrap border-r">{{ $quote->id }}</td>
    <td class="p-3 whitespace-nowrap border-r">{{ $quote->quote_date }}</td>
    <td class="p-3 whitespace-nowrap border-r">{{ $quote->client }}</td>
    <td class="p-3 whitespace-nowrap border-r">{{ $quote->amount }}</td>
    <td class="p-3 whitespace-nowrap border-r">{{ $quote->createdBy }}</td>
    <td class="p-3 whitespace-nowrap border-r"></td>

    <!-- Action icons -->
    <td class="p-3 flex text-center">
        <!-- Download the quote -->
        <form action="{{ route('quotes.download', $quote) }}" method="POST">
            @csrf
            <x-enabled-download-icon />
        </form>

        <!-- Make sure that only authorized users can edit quotes -->
        <form action="{{ route('quotes.show', $quote) }}" method="GET">
            @csrf
            @can('edit', $quote)
                <x-enabled-edit-icon />
            @elsecannot('edit', $quote)
                <x-disabled-edit-icon />
            @endcan
        </form>

        <!-- Make sure that only authorized users can delete quotes -->
        <form action="{{ route('quotes.destroy', $quote) }}" method="POST">
            @csrf
            @method('DELETE')
            @can('delete', $quote)
                <x-enabled-delete-icon />
            @elsecannot('delete', $quote)
                <x-disabled-delete-icon />
            @endcan
        </form>

        <!-- Duplicate Quote -->
        <form action="{{ route('quotes.duplicate', $quote) }}" method="GET">
            @csrf
            <x-enabled-duplicate-icon />
        </form>
    </td>
</tr>
