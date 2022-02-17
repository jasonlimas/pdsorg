@props(['sender' => $sender])

<tr class="bg-white">
    <!-- Sender ID -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $sender->id }}</td>

    <!-- Sender Name -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $sender->name }}</td>

    <!-- Edit Icon -->
    <td class="p-3">
        <form action="{{ route('profiles.sender.show', $sender) }}" method="GET">
            @csrf
            <x-enabled-edit-icon />
        </form>
    </td>

    <!-- Delete Icon -->
    <td class="p-3">
        <form action="{{ route('profiles.sender.destroy', $sender) }}" method="POST">
            @csrf
            @method('DELETE')
            <x-enabled-delete-icon />
        </form>
    </td>
</tr>
