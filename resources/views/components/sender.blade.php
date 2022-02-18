@props(['sender' => $sender])

<tr class="odd:bg-white even:bg-slate-100">
    <!-- Sender ID -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $sender->id }}</td>

    <!-- Sender Name -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $sender->name }}</td>

    <!-- Edit Icon -->
    <td class="p-3">
        <form action="{{ route('admin.sender.show', $sender) }}" method="GET">
            @csrf
            <x-enabled-edit-icon />
        </form>
    </td>

    <!-- Delete Icon -->
    <td class="p-3">
        <form action="{{ route('admin.sender.destroy', $sender) }}" method="POST">
            @csrf
            @method('DELETE')
            <x-enabled-delete-icon />
        </form>
    </td>
</tr>
