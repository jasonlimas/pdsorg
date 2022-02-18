<div>
    <!-- Quote number texts -->
    <h2 class="text-2xl font-medium">Quote Number</h2>
    <p class="text-gray-600 mb-3">
        Number that will be used to identify the quote.
    </p>

    <!-- Quote number input -->
    <div class="grid grid-cols-5 gap-2 mb-4">
        <!-- Year -->
        <div>
            <label for="numberYear" class="text-sm">Year</label>
            <input
                disabled
                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                @error('numberYear') border-red-500 @enderror"
                type="number"
                name="numberYear"
                placeholder="Year"
                value="{{ now()->year }}">

            <div class="text-red-500 mt-1 text-xs">
                @error('numberYear')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <!-- Division -->
        <div>
            <label for="numberDivision" class="text-sm">Your division</label>
            <input
                disabled
                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                @error('numberDivision') border-red-500 @enderror"
                type="text"
                name="numberDivision"
                value="{{ $divisionAbbreviation }}">

            <div class="text-red-500 mt-1 text-xs">
                @error('numberDivision')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <!-- User's name abbreviation -->
        <div>
            <label for="numberSales" class="text-sm">Your name</label>
            <input
                disabled
                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                @error('numberSales') border-red-500 @enderror"
                type="text"
                name="numberSales"
                placeholder="Sales"
                value="{{ $userAbbreviation }}">

            <div class="text-red-500 mt-1 text-xs">
                @error('numberSales')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <!-- Month -->
        <div>
            <label for="numberMonth" class="text-sm">Month</label>
            <input
                disabled
                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                @error('numberMonth') border-red-500 @enderror"
                type="number"
                name="numberMonth"
                placeholder="Month"
                value="{{ now()->month }}">

            <div class="text-red-500 mt-1 text-xs">
                @error('numberMonth')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <!-- Number -->
        <div>
            <label for="numberNumber" class="text-sm">Number</label>
            <input
                min="1"
                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                @error('numberNumber') border-red-500 @enderror"
                type="number"
                name="numberNumber"
                placeholder="Number"
                value="{{ old('numberNumber') }}">

            <div class="text-red-500 mt-1 text-xs">
                @error('numberNumber')
                    {{ $message }}
                @enderror
            </div>
        </div>
    </div>
</div>

<div>
    <!-- Quote date texts -->
    <h2 class="text-2xl font-medium">Date</h2>
    <p class="text-gray-600 mb-3">
        Select the date from the calendar.
    </p>

    <!-- Quote date input -->
    <div class="mb-4">
        <!-- Date -->
        <label for="date" class="sr-only">Date</label>
        <input
        class="shadow appearance-none border rounded p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
        @error('date') border-red-500 @enderror"
        type="date"
        name="date"
        id="date"
        value="{{ old('date') }}">

        @error('date')
            <div class="text-red-500 mt-1 text-xs">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
