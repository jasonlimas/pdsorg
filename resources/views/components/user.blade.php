@props(['user' => $user])

<tr class="odd:bg-white even:bg-slate-100">
    <!-- User ID -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $user->id }}</td>

    <!-- User Name -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $user->name }}</td>

    <!-- User Email -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $user->email }}</td>

    <!-- User Phone -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $user->phone }}</td>

    <!-- Edit Icon -->
    <td class="p-3">
        <form action="{{ route('admin.user.show', $user) }}" method="GET">
            @csrf
            <x-enabled-edit-icon />
        </form>
    </td>

    <!-- Delete Icon -->
    <td class="p-3">
        <!-- Make sure that only authorized users can delete clients (either admin or client creator) -->
        <form action="{{ route('admin.user.destroy', $user) }}" method="POST">
            @csrf
            @method('DELETE')
            <x-enabled-delete-icon />
        </form>
    </td>
</tr>
