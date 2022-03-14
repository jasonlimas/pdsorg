<div>
    <!-- Quote number texts -->
    <h2 class="text-2xl font-medium">Quote Number</h2>
    <p class="text-gray-600 mb-3">
        Number that will be used to identify the quote.
    </p>

    <!-- Quote number input -->
    <div class="columns-3 gap-2">
        <!-- User's division -->
        <div>
            <label for="numberDivision" class="text-sm">Sender person's division</label>
            <input @if (!$isManual) disabled @endif required
                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                @error('numberDivision') border-red-500 @enderror"
                type="text" name="numberDivision" placeholder="Division"
                @if ($isManual) value="{{ old('numberDivision') }}"
                @else value="{{ $divisionAbbreviation }}" @endif>

            <div class="text-red-500 mt-1 text-xs">
                @error('numberDivision')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <!-- User's name abbreviation -->
        <div>
            <label for="numberSales" class="text-sm">Sender person's name</label>
            <input @if (!$isManual) disabled @endif required
                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                @error('numberSales') border-red-500 @enderror"
                type="text" name="numberSales" placeholder="Sales Person"
                @if ($isManual) value="{{ old('numberSales') }}"
                @else value="{{ $userAbbreviation }}" @endif>

            <div class="text-red-500 mt-1 text-xs">
                @error('numberSales')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <!-- Number -->
        <div>
            <label for="numberNumber" class="text-sm">Quote number</label>
            <input @if ($isCopied) disabled @endif min="1" required
                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                @error('numberNumber') border-red-500 @enderror"
                type="number" name="numberNumber" placeholder="Number" value="{{ old('numberNumber') }}">

            <div class="text-red-500 mt-1 text-xs">
                @error('numberNumber')
                    {{ $message }}
                @enderror
            </div>
        </div>
    </div>
</div>
