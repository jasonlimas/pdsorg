@props(['client' => $client])

<tr class="odd:bg-white even:bg-slate-100">
    <!-- Client ID -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $client->id }}</td>

    <!-- Client Name -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap truncate">{{ $client->name }}</td>

    <!-- Client Email -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap truncate">{{ $client->email }}</td>

    <!-- Client Phone -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap truncate">{{ $client->phone }}</td>

    <!-- Action Icons -->
    <td class="p-3 flex">
        <form action="{{ route('profiles.client.show', $client) }}" method="GET">
            @csrf
            @can('edit', $client)
                <x-enabled-edit-icon />
            @elsecannot('edit', $client)
                <x-disabled-edit-icon />
            @endcan
        </form>
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
