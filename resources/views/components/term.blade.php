@props(['term' => $term])

<tr class="odd:bg-white even:bg-slate-100">
    <!-- Term ID -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $term->id }}</td>

    <!-- Term Name -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap truncate">{{ $term->name }}</td>

    <!-- Term Content -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap truncate">{{ count($term->terms_conditions) }}</td>

    <!-- Actions Icon -->
    <td class="p-3 flex">
        <form action="{{ route('profiles.terms.show', $term) }}" method="GET">
            @csrf
            <x-enabled-edit-icon />
        </form>
        <form action="{{ route('profiles.terms.destroy', $term) }}" method="POST">
            @csrf
            @method('DELETE')
            <x-enabled-delete-icon />
        </form>
    </td>
</tr>
