<div>
    <!-- Terms & Conditions texts -->
    <h2 class="text-2xl font-medium">Terms & Conditions</h2>
    <p class="text-gray-600 mb-3">
        Press the "Add Line" button to add a line, and the trash icon on each line to remove the line.
    </p>

    <!-- Terms & conditions input -->
    <div class="overflow-auto rounded-lg shadow mb-4">
        <table class="w-full">
            <thead class="bg-gray-50 border-b-1 border-gray-400">
                <tr>
                    <th class="w-10">No.</th>
                    <th class="pt-1">Terms & Conditions</th>
                    <th class="w-9">Del.</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($termsConditions as $index => $termCondition)
                    <tr>
                        <td class="align-middle text-center">
                            {{ $index + 1 }}
                        </td>
                        <td>
                            <div class="flex flex-wrap">
                                <!-- Terms & conditions input -->
                                <div class="w-full">
                                    <label for="terms" class="sr-only">Terms & Conditions</label>
                                    <input
                                        class="shadow appearance-none border rounded w-full p-1 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                                        name="termsConditions[{{ $index }}]"
                                        placeholder="Terms & Conditions"
                                        wire:model="termsConditions.{{ $index }}">
                                </div>
                            </div>
                        </td>

                        <!-- Delete button -->
                        <td>
                            <a href="" class="mt-2" wire:click.prevent="removeTermsCondition({{ $index }})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-500 text-center" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @error('termsConditions')
            <div class="text-red-500 mt-1 text-sm ml-2">
                {{ $message }}
            </div>
        @enderror

        <!-- Add line button -->
        <div class="flex flex-wrap">
            <button
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 m-2 rounded focus:outline-none focus:shadow-outline"
                wire:click.prevent="addTermsCondition"
                type="button">
                + Add Row
            </button>
        </div>
    </div>
</div>
