<div>
    <!-- Quote number texts -->
    <h2 class="text-2xl font-medium">Quote Number</h2>
    <p class="text-gray-600">
        Quote identification.
    </p>
    @if (!$isManual)
        <p class="text-gray-600 mb-3">
            Number is automatically generated. You don't have to enter it.<br>
            Sender person's division and name fields are filled based on your information. If they are wrong, please contact your administrator.
        </p>
    @endif



    <!-- Quote number input -->
    @if ($isManual) <div class="columns-3 gap-2"> @else <div class="columns-2 gap-2"> @endif
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
        @if ($isManual)
            <div>
                <label for="numberNumber" class="text-sm">Quote number</label>
                <input min="1" required
                    class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                    @error('numberNumber') border-red-500 @enderror"
                    type="number" name="numberNumber" placeholder="Number" value="{{ old('numberNumber') }}">

                <div class="text-red-500 mt-1 text-xs">
                    @error('numberNumber')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        @endif
    </div>

    <p class="text-red-600 text-sm mb-3">
        Note: creating a quote manually doesn't count towards the auto increasing quote number.
    </p>
</div>
