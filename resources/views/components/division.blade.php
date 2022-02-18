@props(['division' => $division])

<tr class="odd:bg-white even:bg-slate-100">
    <!-- Division ID -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $division->id }}</td>

    <!-- Division Abbreviation -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $division->abbreviation }}</td>

    <!-- Division Description -->
    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{ $division->description }}</td>

    <!-- Edit Icon -->
    <td class="p-3">
        <form action="#" method="GET">
            @csrf
            <x-enabled-edit-icon />
        </form>
    </td>

    <!-- Delete Icon -->
    <td class="p-3">
        <form action="#" method="POST">
            @csrf
            @method('DELETE')
            <x-enabled-delete-icon />
        </form>
    </td>
</tr>