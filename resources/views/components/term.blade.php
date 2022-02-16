@props(['term' => $term])

<tr class="bg-white">
    <!-- Term ID -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $term->id }}</td>

    <!-- Term Name -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $term->name }}</td>

    <!-- Edit Icon -->
    <td class="p-3">
        <form action="{{ route('profiles.terms.show', $term) }}" method="GET">
            @csrf
            <button type="submit" class="mt-1 hover:bg-gray-300 p-2 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </button>
        </form>
    </td>

    <!-- Delete Icon -->
    <td class="p-3">
        <form action="{{ route('profiles.terms.destroy', $term) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="mt-1 hover:bg-gray-300 p-2 rounded" onclick="return confirm('Are you sure?')">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </form>
    </td>
</tr>
