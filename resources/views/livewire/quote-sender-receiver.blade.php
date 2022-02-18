<div>
    <!-- Quote sender and receiver texts -->
    <h2 class="text-2xl font-medium">Sender and Receiver Details</h2>
    <p class="text-gray-600 mb-3">
        Your details as the sender, and the client details as the receiver.<br>
        The "Quote From" details are tied to your account's organization details. Check <a href="{{ route('profiles') }}" class="text-blue-600 no-underline hover:underline">profiles page</a> for more details.
    </p>

    <!-- Sender and receiver inputs header -->
    <div class="grid grid-cols-2 gap-2 mb-1">
        <h2 class="text-xl font-bold bg-gray-200 rounded px-2 py-1">Quote From</h2>
        <h2 class="text-xl font-bold bg-gray-200 rounded px-2 py-1">Quote To</h2>
    </div>
    <!-- Input combo boxes -->
    <div class="grid grid-cols-2 gap-2">
        <!-- Sender input -->
        <div>
            <label for="sender" class="sr-only">Sender</label>
            <select
                class="shadow border rounded w-full p-3 text-black leading-tight focus:outline-none focus:shadow-outline
                @error('sender') border-red-500 @enderror"
                name="sender">
                <option value="{{ $sender->id }}">{{ $sender->name }}</option>
            </select>

            <div class="text-red-500 mt-1 text-xs">
                @error('sender')
                    {{ $message }}
                @enderror
            </div>
        </div>

        <!-- Receiver input -->
        <div>
            <label for="receiver" class="sr-only">Quote To</label>
            <select
                class="shadow border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                @error('receiver') border-red-500 @enderror"
                name="receiver"
                id="receiver"
                wire:model="selectedClient">
                <option value="">-- Select a client --</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}">ID:{{ $client->id}} - {{ $client->name }}</option>
                @endforeach
            </select>

            <div class="text-red-500 mt-1 text-xs">
                @error('receiver')
                    {{ $message }}
                @enderror
            </div>
        </div>
    </div>

    <!-- Quote sender and receiver details -->
    <div class="grid grid-cols-2 gap-2 mb-4">
        <!-- Sender details -->
        <textarea
            disabled
            style="resize: none"
            class="shadow border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            cols="30"
            rows="5">{{ $sender->address }}</textarea>

        <!-- Receiver details -->
        <textarea
            disabled
            style="resize: none"
            class="shadow border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            cols="30"
            rows="5"
            wire:model="clientDetails" ></textarea>
    </div>
</div>
