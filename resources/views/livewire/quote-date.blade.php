<div>
    <!-- Quote date texts -->
    <h2 class="text-2xl font-medium">Date</h2>
    <p class="text-gray-600 mb-3">
        @if (!$isManual)
            The date must be today or a future date.
        @else
            Pick a date for the quote.
        @endif
    </p>

    <div>
        <!-- Date -->
        <label for="date" class="sr-only">Date</label>
        <input required
            class="shadow border rounded p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
            @error('date') border-red-500 @enderror"
            type="date" name="date" wire:model="savedDate">

        @error('date')
            <div class="text-red-500 mt-1 text-xs">
                {{ $message }}
            </div>
        @enderror


    </div>
</div>
