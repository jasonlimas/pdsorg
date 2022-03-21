<div class="overflow-auto w-full rounded-lg shadow mb-4 bg-gray-100">
    <table class="w-full">
        <thead class="bg-gray-50 border-b-1 border-gray-400">
            <tr>
                <th class="w-24 py-1">Bank Name</th>
                <th class="w-36 py-1">Account Name</th>
                <th class="w-36 py-1">Account Number</th>
                <th class="w-10 py-1">Del.</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($banks as $index => $bank)
                <tr>
                    <!-- Banking Name -->
                    <td>
                        <div class="flex flex-wrap">
                            <div class="w-full">
                                <label for="banks[{{ $index }}][institution]" class="sr-only">Banking Institution</label>
                                <input
                                    required
                                    class="shadow appearance-none border rounded w-full p-2 mx-1 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                                    name="banks[{{ $index }}][institution]"
                                    placeholder="Institution"
                                    wire:model="banks.{{ $index }}.institution">
                            </div>
                        </div>
                    </td>

                    <!-- Banking Account Name -->
                    <td>
                        <div class="flex flex-wrap">
                            <div class="w-full">
                                <label for="banks[{{ $index }}][accountName]" class="sr-only">Banking Account Name</label>
                                <input
                                    required
                                    class="shadow appearance-none border rounded w-full p-2 mx-1 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                                    name="banks[{{ $index }}][accountName]"
                                    placeholder="Account Name"
                                    wire:model="banks.{{ $index }}.accountName">
                            </div>
                        </div>
                    </td>

                    <!-- Banking Account Number -->
                    <td>
                        <div class="flex flex-wrap">
                            <div class="w-full">
                                <label for="banks[{{ $index }}][accountNumber]" class="sr-only">Banking Account Number</label>
                                <input
                                    required
                                    class="shadow appearance-none border rounded w-full p-2 mx-1 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                                    name="banks[{{ $index }}][accountNumber]"
                                    placeholder="Account Number"
                                    wire:model="banks.{{ $index }}.accountNumber">
                            </div>
                        </div>
                    </td>

                    <!-- Delete button -->
                    <td class="text-center">
                        <form>
                            @csrf
                            <button type="button" class="hover:bg-gray-300 p-2 rounded" wire:click.prevent="removeBank({{ $index }})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @error('banksError')
        <div class="text-red-500 mt-1 text-sm ml-2">
            {{ $message }}
        </div>
    @enderror

    <!-- Add line button -->
    <div class="flex flex-wrap justify-center">
        <button
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 m-2 rounded focus:outline-none focus:shadow-outline w-full"
            wire:click.prevent="addBank"
            type="button">
            + Add Row
        </button>
    </div>
</div>
