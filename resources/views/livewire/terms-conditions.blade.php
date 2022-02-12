<form action="">
    @csrf
    <!-- Quote number div -->
    <div>
            <!-- Quote number texts -->
        <h2 class="text-2xl font-medium">Quote Number</h2>
        <p class="text-gray-600 mb-3">
            Number that will be used to identify the quote.
        </p>

        <!-- Quote number input -->
        <div class="grid grid-cols-5 gap-2 mb-4">
            <!-- Year -->
            <label for="numberYear" class="sr-only">Year</label>
            <input
            class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            name="numberYear" id="numberYear" placeholder="Year"
            value="{{ now()->year }}">

            <!-- Division -->
            <label for="numberDivision" class="sr-only">Division</label>
            <input
            class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            name="numberDivision"
            id="numberDivision"
            placeholder="Division"
            value="{{ old('numberDivision') }}">

            <!-- Sales -->
            <label for="numberSales" class="sr-only">Sales</label>
            <input
            class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            name="numberSales"
            id="numberSales"
            placeholder="Sales"
            value="{{ old('numberSales') }}">

            <!-- Month -->
            <label for="numberMonth" class="sr-only">Month</label>
            <input
            class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            name="numberMonth"
            id="numberMonth"
            placeholder="Month"
            value="{{ now()->month }}">

            <!-- Number -->
            <label for="numberNumber" class="sr-only">Number</label>
            <input
            class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            name="numberNumber"
            id="numberNumber"
            placeholder="Number"
            value="{{ old('numberNumber') }}">
        </div>
    </div>

    <!-- Date div -->
    <div>
        <!-- Quote date texts -->
        <h2 class="text-2xl font-medium">Date</h2>
        <p class="text-gray-600 mb-3">
        Select the date from the calendar or leave it to use today's date.
        </p>
    </div>

    <!-- Sender and receiver div -->
    <div>
        <!-- Quote sender and receiver texts -->
        <h2 class="text-2xl font-medium">Sender and Receiver Details</h2>
        <p class="text-gray-600 mb-3">
            Your details as the sender, and the client details as the receiver.
        </p>

        <!-- Sender and receiver inputs -->
        <div class="grid grid-cols-2 gap-2 mb-1">
            <h2 class="text-xl font-bold">Quote From</h2>
            <h2 class="text-xl font-bold">Quote To</h2>
        </div>
        <div class="grid grid-cols-2 gap-2 mb-4">
            <!-- Sender input -->
            <label for="sender" class="sr-only">Sender</label>
            <select
                class="shadow border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="sender"
                id="sender">
                <option value="">-- Select a sender --</option>
                @foreach ($senders as $sender)
                    <option value="{{ $sender->id }}">ID:{{ $sender->id}} - {{ $sender->name }}</option>
                @endforeach
            </select>

            <!-- Receiver input -->
            <label for="receiver" class="sr-only">Quote To</label>
            <select
                class="shadow border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                name="receiver"
                id="receiver">
                <option value="">-- Select a client --</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}">ID:{{ $client->id}} - {{ $client->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Quote items div -->
    <div>
        <!-- Items texts -->
        <h2 class="text-2xl font-medium">Items, Tax, and Total Price</h2>
        <p class="text-gray-600 mb-3">
            Add items, tax, and total price.
        </p>
    </div>

    <!-- Terms & conditions div -->
    <div>
        <!-- Terms & Conditions texts -->
        <h2 class="text-2xl font-medium">Terms & Conditions</h2>
        <p class="text-gray-600 mb-3">
            Press the "Add Line" button to add a line, and the trash icon on each line to remove the line.
        </p>

        <!-- Terms & conditions input -->
        <div class="overflow-auto rounded-lg shadow mb-4">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-300">
                    <tr>
                        <th class="w-10"></th>
                        <th class="pt-1">Add your input below</th>
                        <th class="w-9"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($termsConditions as $index => $termCondition)
                        <tr>
                            <td class="text-4xl align-middle text-center">
                                •
                            </td>
                            <td>
                                <div class="flex flex-wrap">
                                    <!-- Terms & conditions input -->
                                    <div class="w-full">
                                        <label for="terms" class="sr-only">Terms & Conditions</label>
                                        <input
                                            class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
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

            <!-- Add line button -->
            <div class="flex flex-wrap">
                <button
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 m-2 rounded focus:outline-none focus:shadow-outline"
                    wire:click.prevent="addTermsCondition"
                    type="button">
                    + Add Line
                </button>
            </div>
        </div>
    </div>

    <!-- Submit button -->
    <div>
        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-4 py-3 rounded
        font-medium w-full">Create Quotation</button>
    </div>
</form>
