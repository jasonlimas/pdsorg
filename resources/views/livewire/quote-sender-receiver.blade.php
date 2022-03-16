<div>
    <!-- Quote sender and receiver texts -->
    <h2 class="text-2xl font-medium">Sender and Receiver Details</h2>
    <p class="text-gray-600 mb-3">
        Your details as the sender, and the client details as the receiver.<br>
        @if ($isCopied)
            <a class="text-red-400">This is a copied quote. You cannot change the "Quote To" section on copied
                quote.</a>
        @elseif ($isManual)
            Freely pick the "Quote From" and "Quote To" details.
        @else
            The "Quote From" details are tied to your account's organization details. Check
            <a class="text-blue-500 hover:underline" href="{{ route('profiles') }}"> profiles page</a> for more
            details.
        @endif
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
            <select @if ($isCopied) disabled @endif required
                class="shadow border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                @error('sender') border-red-500 @enderror"
                name="sender" wire:model="selectedSender">
                @if ($isManual)
                    <option value="">-- Select a sender --</option>
                    @foreach ($senders as $sender)
                        <option value="{{ $sender->id }}">ID:{{ $sender->id }} - {{ $sender->name }}</option>
                    @endforeach
                @else
                    <option value="{{ $senders->id }}">{{ $senders->name }}</option>
                @endif
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
            <select @if ($isCopied) disabled @endif required
                class="shadow border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                @error('receiver') border-red-500 @enderror"
                name="receiver" wire:model="selectedClient">
                <option value="">-- Select a client --</option>
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}">ID:{{ $client->id }} - {{ $client->name }}</option>
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
    <div class="grid grid-cols-2 gap-2">
        <!-- Sender details -->
        <textarea disabled style="resize: none"
            class="shadow border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            cols="30" rows="5"
            @if ($isManual) wire:model="senderDetails" @else wire:model="senderAddress" @endif></textarea>

        <!-- Receiver details -->
        <textarea disabled style="resize: none"
            class="shadow border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            cols="30" rows="5" wire:model="clientDetails"></textarea>
    </div>
</div>
