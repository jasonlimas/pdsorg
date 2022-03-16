@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
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

                <!-- If user is not logged in, tell the user -->
                @guest
                    <p>
                        Not logged in. <br>
                        You must be logged in to view this page.
                    </p>
                @endguest

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

            <!-- Sorting -->
            @auth
                <form action="{{ route('quotes.filter', $quotes) }}" method="POST">
                    @csrf
                    <div class="bg-gray-100 rounded-lg mb-2 shadow-lg flex justify-start space-x-2">
                        <!-- Date -->
                        <div class="w-1/3 pl-5 pt-2">
                            <label for="startDate">Start date</label>
                            <input
                                class="p-1 rounded shadow focus:outline-none text-gray-700 border w-full
                                @error('startDate') border-red-500 @enderror"
                                type="date" name="startDate" value="{{ old('startDate') }}">
                       </div>

                        <div class="w-1/3 pt-2">
                            <label for="endDate">End date</label>
                            <input
                                class="p-1 rounded shadow focus:outline-none text-gray-700 border w-full
                                @error('startDate') border-red-500 @enderror"
                                type="date" name="endDate" value="{{ old('endDate') }}">
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
                        <button
                            class="bg-blue-500 hover:bg-blue-700 transition-colors duration-200 w-1/6 px-4 py-2 rounded text-white text-center"
                            type="submit">
                            Filter
                        </button>
                    </div>
                </form>
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
                                <th class="w-1/12 border-r p-1">No.</th>
                                <th class="w-2/12 border-r p-1">Date</th>
                                <th class="w-2/12 border-r p-1">Quoted To</th>
                                <th class="w-2/12 border-r p-1">Amount</th>
                                <th class="w-1/12 border-r p-1">Created by</th>
                                <th class="w-1/12 border-r p-1">Status</th>
                                <th class="w-2/12 p-1">Action</th>
                            </thead>

                            <tbody>
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
        </div>
    </div>
@endsection
