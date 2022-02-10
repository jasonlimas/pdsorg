@props(['client' => $client])

<tr class="bg-white">
    <!-- Client ID -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $client->id }}</td>

    <!-- Client Name -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $client->name }}</td>

    <!-- Client Email -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $client->email }}</td>

    <!-- Edit Icon (TODO) -->
    <td class="p-3">
        <form action="{{ route('profiles.client.edit', $client) }}" method="GET">
            @csrf
            @can('edit', $client)
                <button type="submit" class="mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </button>
            @elsecannot('edit', $client)
                <button disabled class="mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </button>
            @endcan

        </form>
    </td>

    <!-- Delete Icon -->
    <td class="p-3">
        <!-- Make sure that only authorized users can delete clients (either admin or client creator) -->
        <form action="{{ route('profiles.client.destroy', $client) }}" method="POST">
            @csrf
            @method('DELETE')
            @can('delete', $client) <!-- If authenticated user can delete the client, show the delete icon with red color-->
                <button type="submit" class="mt-1" onclick="return confirm('Are you sure?')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            @elsecannot('delete', $client)  <!-- If user can't delete the client, show the delete icon with gray color -->
                <button class="mt-1" disabled>  <!-- Disabled button -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            @endcan
        </form>
    </td>
</tr>
