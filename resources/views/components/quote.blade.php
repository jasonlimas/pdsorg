@props(['quote' => $quote])

<tr class="odd:bg-white even:bg-slate-100 text-gray-700">
    <td class="p-3 whitespace-nowrap">
        <a href="{{ route('quotes.view', $quote) }}" class="p-3 whitespace-nowrap text-blue-600 hover:underline">
            {{ $quote->id }}
        </a>
    </td>
    <td class="p-3 whitespace-nowrap">{{ $quote->quote_date }}</td>
    <td class="p-3 whitespace-nowrap">{{ $quote->client }}</td>
    <td class="p-3 whitespace-nowrap">{{ $quote->amount }}</td>
    <td class="p-3 whitespace-nowrap">{{ $quote->createdBy }}</td>

    <!-- Status -->
    <td class="p-3 whitespace-nowrap">
        @if ($quote->status_id == 1)
            <span
                class="p-1.5 text-xs font-medium uppercase tracking-wider text-yellow-800 bg-yellow-200 bg-opacity-50 rounded-lg">{{ $quote->status }}</span>
        @elseif ($quote->status_id == 2)
            <span
                class="p-1.5 text-xs font-medium uppercase tracking-wider text-green-800 bg-green-200 bg-opacity-50 rounded-lg">{{ $quote->status }}</span>
        @elseif ($quote->status_id == 3)
            <span
                class="p-1.5 text-xs font-medium uppercase tracking-wider text-red-800 bg-red-200 bg-opacity-50 rounded-lg">{{ $quote->status }}</span>
        @endif
    </td>

    <!-- Action icons -->
    <td class="p-3 whitespace-nowrap flex text-center">
        <!-- Download the quote -->
        <form action="{{ route('quotes.download', $quote) }}" method="POST" target="_blank">
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

        <!-- Email Quote -->
        <form action="{{ route('quotes.prepare-email', $quote) }}" method="GET">
            @csrf
            <x-enabled-email-icon />
        </form>
    </td>
</tr>
