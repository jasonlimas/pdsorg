<div>
    <!-- Quote sender and receiver texts -->
    <h2 class="text-2xl font-medium">Sender and Receiver Details</h2>
    <p class="text-gray-600 mb-3">
        Your details as the sender, and the client details as the receiver.
    </p>

    <!-- Sender and receiver inputs header -->
    <div class="grid grid-cols-2 gap-2 mb-1">
        <h2 class="text-xl font-bold bg-gray-200 rounded px-2 py-1">Quote From</h2>
        <h2 class="text-xl font-bold bg-gray-200 rounded px-2 py-1">Quote To</h2>
    </div>
    <!-- Input combo boxes -->
    <div class="grid grid-cols-2 gap-2 mb-1">
        <!-- Sender input -->
        <label for="sender" class="sr-only">Sender</label>
        <select
            class="shadow border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            name="sender"
            id="sender"
            wire:model="selectedSender">
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
            id="receiver"
            wire:model="selectedClient">
            <option value="">-- Select a client --</option>
            @foreach ($clients as $client)
                <option value="{{ $client->id }}">ID:{{ $client->id}} - {{ $client->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Quote sender and receiver details -->
    <div class="grid grid-cols-2 gap-2 mb-4">
        <!-- Sender details -->
        <textarea
            disabled
            style="resize: none"
            class="shadow border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            cols="30"
            rows="5"
            wire:model="senderAddress" ></textarea>

        <!-- Receiver details -->
        <textarea
            disabled
            style="resize: none"
            class="shadow border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            cols="30"
            rows="5"
            wire:model="clientAddress" ></textarea>
    </div>
</div>
