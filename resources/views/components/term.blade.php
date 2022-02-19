@props(['term' => $term])

<tr class="odd:bg-white even:bg-slate-100">
    <!-- Term ID -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $term->id }}</td>

    <!-- Term Name -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $term->name }}</td>

    <!-- Edit Icon -->
    <td class="p-3">
        <form action="{{ route('profiles.terms.show', $term) }}" method="GET">
            @csrf
            <x-enabled-edit-icon />
        </form>
    </td>

    <!-- Delete Icon -->
    <td class="p-3">
        <form action="{{ route('profiles.terms.destroy', $term) }}" method="POST">
            @csrf
            @method('DELETE')
            <x-enabled-delete-icon />
        </form>
    </td>
</tr>
