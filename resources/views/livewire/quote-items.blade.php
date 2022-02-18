<div>
    <!-- Items texts -->
    <h2 class="text-2xl font-medium">Items, Tax, and Total Price</h2>
    <p class="text-gray-600 mb-3">
        Add items, tax, and total price.
    </p>

    <!-- Items input -->
    <div class="overflow-auto rounded-lg shadow mb-1">
        <!-- Table -->
        <div class="rounded-lg @error('items')border border-red-500 @enderror">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-1 border-gray-400">
                    <tr>
                        <th class="w-1/12">No.</th>
                        <th class="w-5/12">Item Name</th>
                        <th class="w-1/12">Qty</th>
                        <th class="w-2/12">Unit Price</th>
                        <th class="w-2/12">Total Price</th>
                        <th class="w-1/12"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $index => $item)
                        <tr>
                            <!-- Number -->
                            <td class="text-center align-middle">
                                <p class="font-semibold">{{ $index + 1 }}</p>
                            </td>

                            <!-- Item name -->
                            <td>
                                <div class="flex flex-wrap">
                                    <div class="w-full">
                                        <textarea
                                            rows="2"
                                            class="shadow appearance-none border rounded w-full p-1 leading-tight text-gray-700 focus:outline-none focus:shadow-outline align-middle"
                                            name="items[{{ $index }}][name]"
                                            placeholder="Item name"
                                            wire:model="items.{{ $index }}.name"></textarea>
                                    </div>
                                </div>
                            </td>

                            <!-- Quantity -->
                            <td>
                                <div class="flex flex-wrap">
                                    <div class="w-full">
                                        <input
                                            type="number"
                                            min="1"
                                            class="text-center shadow appearance-none border rounded w-full px-1 py-2 leading-none text-gray-700 focus:outline-none focus:shadow-outline"
                                            name="items[{{ $index }}][quantity]"
                                            placeholder="Qty"
                                            wire:model="items.{{ $index }}.quantity">
                                    </div>
                                </div>
                            </td>

                            <!-- Unit price -->
                            <td>
                                <div class="flex flex-wrap">
                                    <div class="w-full">
                                        <input
                                            type="number"
                                            min="0"
                                            class="shadow appearance-none border rounded w-full px-1 py-2 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                                            name="items[{{ $index }}][unitPrice]"
                                            placeholder="Unit price"
                                            wire:model="items.{{ $index }}.unitPrice">
                                    </div>
                                </div>
                            </td>

                            <!-- Total price -->
                            <td>
                                <div class="flex flex-wrap">
                                    <div class="w-full">
                                        <input
                                            disabled
                                            class="shadow appearance-none border rounded w-full px-1 py-2 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                                            name="totalPrice"
                                            placeholder="Total price"
                                            wire:model="itemTotalPrice">
                                    </div>
                                </div>
                            </td>

                            <!-- Delete button -->
                            <td class="text-center">
                                <form>
                                    @csrf
                                    <button type="submit" class="mt-1 hover:bg-gray-300 p-2 rounded" wire:click.prevent="removeItem({{ $index }})">
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
        </div>

        @error('items')
            <div class="text-red-500 mt-1 text-sm ml-2">
                {{ $message }}
            </div>
        @enderror

        <!-- Add line button -->
        <div class="flex flex-wrap">
            <button
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 m-2 rounded focus:outline-none focus:shadow-outline"
                wire:click.prevent="addItem"
                type="button">
                + Add Row
            </button>
        </div>
    </div>

    <!-- Sub-total -->
    <div class="flex justify-end items-center mb-0.5">
        <!-- Sub-total -->
        <label class="sr-only" for="subTotal">
            Sub-total
        </label>
        <p class="px-2 text-bold">SUB-TOTAL</p>
        <input
            disabled
            class="shadow appearance-none border rounded p-1 text-gray-700 leading-none focus:outline-none focus:shadow-outline text-right"
            id="subTotal"
            name="subTotal"
            placeholder="Sub-total"
            wire:model="subTotal">
    </div>

    <!-- Tax -->
    <div class="flex justify-end items-center mb-0.5">
        <label class="sr-only" for="tax">
            Tax
        </label>
        <p class="px-2 text-bold">TAX (%)</p>
        <div>
            <input
            min="1"
            type="number"
            class="shadow appearance-none border rounded p-1 text-gray-700 leading-none focus:outline-none focus:shadow-outline text-right
            @error('tax') border-red-500 @enderror"
            id="tax"
            name="tax"
            placeholder="Tax"
            value="11"
            wire:model.lazy="tax">

            @error('tax')
                <div class="text-red-500 mt-1 text-xs text-right">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <!-- Grand total -->
    <div class="flex justify-end items-center">
        <label class="sr-only" for="grandTotal">
            Grand total
        </label>
        <p class="px-2 text-bold">GRAND TOTAL</p>
        <input
            disabled
            class="shadow appearance-none border rounded p-1 text-gray-700 leading-none focus:outline-none focus:shadow-outline text-right"
            id="grandTotal"
            name="grandTotal"
            placeholder="Grand total"
            wire:model="grandTotal">
    </div>
</div>
