@extends('layouts.app')

@section('content')
    <div class="flex justify-center"  x-data="{ quoteInfo: null, quoteItems: null, quoteTerms: null }">
        <div class="w-11/12">
            <!-- Main Header -->
            <div class="p-6 text-gray-700">
                @admin
                <h1 class="text-4xl font-semibold mb-1">All Created Quotes</h1>
                @endadmin
                @teamleader
                <h1 class="text-4xl font-semibold mb-1">All Quotes From Your Division</h1>
                @endteamleader
                @salesperson
                <h1 class="text-4xl font-semibold mb-1">Your Quotes</h1>
                @endsalesperson

                <!-- If user is logged in, show name -->
                @auth
                    <p>
                        Logged in as <b>{{ auth()->user()->name }}</b>. <br>
                        Access created quotes below.
                    </p>
                @endauth
            </div>

            <!-- Session Messages -->
            @if (session('success'))
                <div class="bg-green-500 p-4 rounded-lg mb-3 text-white text-center">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Sorting/Filtering -->
            @auth
                <div>
                    <h2 class="mx-2 font-bold">Filter Settings</h2>
                    <form action="{{ url('quotes/filter') }}" method="POST">
                        @csrf
                        @if ($filter)
                            <div class="bg-gray-100 rounded-lg mb-2 shadow-lg flex justify-start space-x-2">
                                <p class="px-5 py-2">
                                    Showing quotes with filter settings:<br>
                                    From <b>{{ $startDate }}</b> to <b>{{ $endDate }}</b><br>
                                    Quoted to <b>{{ $client }}</b><br>
                                </p>
                            </div>
                        @else
                            <div class="bg-gray-100 rounded-lg mb-2 shadow-lg flex justify-start space-x-2">
                                <!-- Date -->
                                <div class="w-1/3 pl-5 pt-2">
                                    <label for="startDate">Start date</label>
                                    <input
                                        class="p-1 rounded shadow focus:outline-none text-gray-700 border w-full
                                        @error('startDate') border-red-500 @enderror"
                                        type="date" name="startDate" value="{{ old('startDate') }}">

                                    @error('startDate')
                                        <div class="text-red-500 mt-1 text-xs">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="w-1/3 pt-2">
                                    <label for="endDate">End date</label>
                                    <input
                                        class="p-1 rounded shadow focus:outline-none text-gray-700 border w-full
                                        @error('endDate') border-red-500 @enderror"
                                        type="date" name="endDate" value="{{ old('endDate') }}">

                                    @error('endDate')
                                        <div class="text-red-500 mt-1 text-xs">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="w-1/3 pr-2 py-2">
                                    <label for="client" class="">Quote to</label>
                                    <select
                                        class="shadow border rounded w-full p-1 text-gray-700 focus:outline-none focus:shadow-outline"
                                        name="client">
                                        <option value="">-- Select client --</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">ID:{{ $client->id }} - {{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <!-- Buttons -->
                        <div class="rounded-lg mb-3 space-x-2 flex justify-end">
                            @admin
                            <a href="{{ route('admin.quote.create') }}"
                                class="bg-red-600 hover:bg-red-800 transition-colors duration-200 w-1/6 px-4 py-2 rounded text-white text-center">
                                Create (Manual)
                            </a>
                            @endadmin
                            <a href="{{ route('quotes.create') }}"
                                class="bg-blue-500 hover:bg-blue-700 transition-colors duration-200 w-1/6 px-4 py-2 rounded text-white text-center">
                                Create Quote
                            </a>
                            @if ($filter)
                                <a href="{{ route('quotes') }}"
                                    class="bg-orange-600 hover:bg-orange-800 transition-colors duration-200 w-1/6 px-4 py-2 rounded text-white text-center">
                                    Clear Filter
                                </a>
                            @else
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 transition-colors duration-200 w-1/6 px-4 py-2 rounded text-white text-center"
                                    type="submit">
                                    Apply Filter
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            @endauth

            <div class="bg-gray-100 rounded-lg mb-3 shadow-md">
                <!-- If user is not logged in, tell the user -->
                @guest
                    <h2 class="text-xl font-medium text-center">Please <a class="text-blue-500 underline"
                            href="{{ route('login') }}">login</a> to view quotes.</h2>
                @endguest

                <!-- If the user is logged in -->
                @auth
                    <!-- Table -->
                    <div class="overflow-auto rounded-lg shadow mb-4">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b-2 border-gray-300">
                                <tr>
                                    <th class="w-32 px-4 py-2 text-left">Quote#</th>
                                    <th class="w-20 px-4 py-2 text-left">Date</th>
                                    <th class="w-56 px-4 py-2 text-left">Quoted To</th>
                                    <th class="w-32 px-4 py-2 text-left">Amount</th>
                                    <th class="w-20 px-4 py-2 text-left">Sender</th>
                                    <th class="w-20 px-4 py-2 text-left">Status</th>
                                    <th class="w-36 px-4 py-2 text-left"></th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @foreach ($quotes as $quote)
                                    <x-quote :quote="$quote" />
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination links -->
                        <div class="p-2 bg-gray-50 border-t-2 border-gray-100">
                            {{ $quotes->links() }}
                        </div>
                    </div>
                @endauth
            </div>

            <p class="text-sm mb-2">
                Note on quote status:
            </p>
            <ul class="text-sm">
                <li class="mb-4">
                    <span class="p-1.5 text-xs font-medium uppercase tracking-wider text-yellow-800 bg-yellow-200 bg-opacity-50 rounded-lg">Not Sent</span> - Quote has not been sent to the client.
                </li>
                <li class="mb-4">
                    <span class="p-1.5 text-xs font-medium uppercase tracking-wider text-green-800 bg-green-200 bg-opacity-50 rounded-lg">Sent</span> - Quote sent to the client.
                </li>
                <li class="mb-4">
                    <span class="p-1.5 text-xs font-medium uppercase tracking-wider text-red-800 bg-red-200 bg-opacity-50 rounded-lg">Expired</span> - Quote is 30 days old or older.
                </li>
            </ul>
        </div>

        <!-- MODAL!! -->
        <div
            class="fixed inset-0 z-50 flex flex-col items-center justify-end px-5 overflow-y-auto bg-gray-600 bg-opacity-50 sm:justify-start sm:px-0"
            x-show="modal"
            x-on:modal-overlay.window="if ($event.detail.id == 'view-quote-modal') modal=true"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-500"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak>
            <div
                class="w-full mb-5 transition-all transform sm:mt-20 sm:mb-0 sm:max-w-2xl"
                x-show="modal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-4 sm:translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-4 sm:translate-y-4"
                x-on:click.away="modal=false, bsd(false)">
                <div class="p-10 bg-white rounded-sm shadow-sm">
                    <h1 class="text-center font-bold text-3xl mb-5">QUOTE INFO</h1>

                    <!-- General info -->
                    <template x-for="attr in quoteInfo">
                        <p class="" x-text="attr"></p>
                    </template>

                    <!-- Items -->
                    <h2 class="mt-3 text-xl text-left font-semibold">Items</h2>
                    <table>
                        <thead class="bg-gray-200 border-2 border-gray-300">
                            <tr>
                                <th class="w-24">Name</th>
                                <th class="w-10">Qty</th>
                                <th class="w-14">Unit Price</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-50 border-2 border-gray-300">
                            <template x-for="item in quoteItems">
                                <tr class="border-2 border-gray-300">
                                    <td class="overflow-y-auto" x-text="item.name"></td>
                                    <td class="truncate text-center" x-text="item.quantity"></td>
                                    <td class="truncate text-center">Rp. <span x-text="item.price"></span></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <!-- Terms and conditions -->
                    <h2 class="mt-3 text-xl text-left font-semibold">Terms & Conditions</h2>
                    <ul class="mx-5 list-disc">
                        <template x-for="term in quoteTerms">
                            <li class="text-sm" x-text="term"></li>
                        </template>
                    </ul>

                    <!-- Button -->
                    <div class="mt-5 flex justify-center">
                        <button
                            class="w-full bg-blue-500 hover:bg-blue-700 transition-colors text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            x-on:click="modal=false, bsd(false)">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
