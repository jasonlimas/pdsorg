@props(['user' => $user])

<tr class="odd:bg-white even:bg-slate-100">
    <!-- User ID -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $user->id }}</td>

    <!-- User Name -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap truncate">{{ $user->name }}</td>

    <!-- User Email -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap truncate">{{ $user->email }}</td>

    <!-- User Phone -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap truncate">{{ $user->phone }}</td>

    <!-- Action Icons -->
    <td class="p-3 flex">
        <!-- Edit Icon -->
        <form action="{{ route('admin.user.show', $user) }}" method="GET">
            @csrf
            <x-enabled-edit-icon />
        </form>
        <!-- Delete Icon -->
        <form
            @admin action="{{ route('admin.user.destroy', $user) }}" @endadmin
            @teamleader action="{{ route('leader.user.destroy', $user) }}" @endteamleader
            method="POST">
            @csrf
            @method('DELETE')
            <x-enabled-delete-icon />
        </form>
    </td>
</tr>
