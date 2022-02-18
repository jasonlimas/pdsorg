<div>
    <!-- Terms & Conditions texts -->
    <h2 class="text-2xl font-medium">Terms & Conditions</h2>
    <p class="text-gray-600 mb-1">
        Select from a saved preset, or write them from scratch here.
    </p>

    <div class="flex justify-end">
        <label for="preset" class="sr-only">Preset</label>
        <select
            class="shadow border rounded w-1/4 px-2 my-2 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
            name="preset"
            wire:model="selectedPreset">
            <option value="">-- Select a preset --</option>
            @foreach ($savedPresets as $preset)
                <option value="{{ $preset->id }}">ID:{{ $preset->id}} - {{ $preset->name }}</option>
            @endforeach
        </select>

        <div class="flex">
            <button
                class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 m-2 rounded"
                wire:click.prevent="applyPreset"
                type="button">
                Apply Preset
            </button>
        </div>
    </div>

    <!-- Terms & conditions input -->
    <div class="overflow-auto rounded-lg shadow mb-4">
        <table class="w-full">
            <thead class="bg-gray-50 border-b-1 border-gray-400">
                <tr>
                    <th class="w-1/12">No.</th>
                    <th class="w-10/12 pt-1">Description</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($termsConditions as $index => $termCondition)
                    <tr>
                        <td class="align-middle text-center">
                            <p class="font-semibold">{{ $index + 1 }}</p>
                        </td>
                        <td>
                            <div class="flex flex-wrap">
                                <!-- Terms & conditions input -->
                                <div class="w-full">
                                    <label for="terms" class="sr-only">Terms & Conditions</label>
                                    <input
                                        required
                                        class="shadow appearance-none border rounded w-full p-2 mx-1 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                                        name="termsConditions[{{ $index }}]"
                                        placeholder="Terms & Conditions"
                                        wire:model="termsConditions.{{ $index }}">
                                </div>
                            </div>
                        </td>

                        <!-- Delete button -->
                        <td class="text-center">
                            <form>
                                @csrf
                                <button type="button" class="hover:bg-gray-300 p-2 rounded" wire:click.prevent="removeTermsCondition({{ $index }})">
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
