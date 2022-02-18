@props(['client' => $client])

<tr class="odd:bg-white even:bg-slate-100">
    <!-- Client ID -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $client->id }}</td>

    <!-- Client Name -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $client->name }}</td>

    <!-- Client Email -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $client->email }}</td>

    <!-- Client Phone -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $client->phone }}</td>

    <!-- Edit Icon -->
    <td class="p-3">
        <form action="{{ route('profiles.client.show', $client) }}" method="GET">
            @csrf
            @can('edit', $client)
                <x-enabled-edit-icon />
            @elsecannot('edit', $client)
                <x-disabled-edit-icon />
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
                <x-enabled-delete-icon />
            @elsecannot('delete', $client)  <!-- If user can't delete the client, show the delete icon with gray color -->
                <x-disabled-delete-icon />
            @endcan
        </form>
    </td>
</tr>
