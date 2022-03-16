@props(['division' => $division])

<tr class="odd:bg-white even:bg-slate-100">
    <!-- Division ID -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $division->id }}</td>

    <!-- Division Abbreviation -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $division->abbreviation }}</td>

    <!-- Division Description -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap truncate">{{ $division->description }}</td>

    <!-- Action Icons -->
    <td class="p-3 flex">
        <!-- Edit Icon -->
        <form action="{{ route('admin.division.show', $division) }}" method="GET">
            @csrf
            <x-enabled-edit-icon />
        </form>
        <!-- Delete Icon -->
        <form action="{{ route('admin.division.destroy', $division) }}" method="POST">
            @csrf
            @method('DELETE')
            <x-enabled-delete-icon />
        </form>
    </td>
</tr>
