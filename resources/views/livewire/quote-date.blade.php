<div>
    <!-- Quote date texts -->
    <h2 class="text-2xl font-medium">Date</h2>
    <p class="text-gray-600 mb-3">
        The date must be today or a future date.
    </p>

    <div>
        <!-- Date -->
        <label for="date" class="sr-only">Date</label>
        <input
            class="shadow border rounded p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
            @error('date') border-red-500 @enderror"
            type="date"
            name="date">

        @error('date')
            <div class="text-red-500 mt-1 text-xs">
                {{ $message }}
            </div>
        @enderror


    </div>
</div>
