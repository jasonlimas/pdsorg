@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <!-- Main Header -->
            <div class="p-6 text-gray-700">
                <h1 class="text-4xl font-semibold mb-1">Quotes</h1>
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

            @auth
                <!-- Sorting -->
                <div class="bg-gray-100 p-6 rounded-lg mb-1 shadow-lg">
                    <div class="flex justify-end">
                        <div>
                            <a href="{{ route('quotes.create') }}" class="bg-blue-500 hover:bg-blue-700 p-2 rounded-lg text-white text-center">Create Quote</a>
                        </div>
                    </div>
                </div>
            @endauth

            <div class="bg-gray-100 p-6 rounded-lg mb-3 shadow-md">
                <!-- If user is not logged in, tell the user -->
                @guest
                    <h2 class="text-xl font-medium text-center">Please <a class="text-blue-500 underline" href="{{ route('login') }}">login</a> to view quotes.</h2>
                @endguest

                <!-- If the user is logged in -->
                @auth
                    <!-- Table -->
                    <div class="overflow-auto rounded-lg shadow mb-4">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b-2 border-gray-300">
                                <th class="w-1/12 border-r p-1">No.</th>
                                <th class="w-2/12 border-r p-1">Date</th>
                                <th class="w-4/12 border-r p-1">Quoted To</th>
                                <th class="w-2/12 border-r p-1">Amount</th>
                                <th class="w-2/12 p-1"></th>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @foreach($quotes as $quote)
                                    <tr class="bg-white text-gray-700 text-lg">
                                        <td class="p-3 whitespace-nowrap border-r">{{ $quote->id }}</td>
                                        <td class="p-3 whitespace-nowrap border-r">{{ $quote->quote_date }}</td>
                                        <td class="p-3 whitespace-nowrap border-r">{{ $quote->client }}</td>
                                        <td class="p-3 whitespace-nowrap border-r">{{ $quote->amount }}</td>

                                        <!-- Action icons -->
                                        <td class="p-3 flex text-center">
                                            <!-- Download the quote -->
                                            <form action="{{ route('quotes.download', $quote) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="hover:bg-gray-300 p-2 rounded">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>

                                            <!-- Make sure that only authorized users can edit quotes -->
                                            <form action="{{ route('quotes.show', $quote) }}" method="GET">
                                                @csrf
                                                @can('edit', $quote)
                                                    <x-enabled-edit-icon />
                                                @elsecannot('edit', $quote)
                                                    <x-disabled-edit-icon />
                                                @endcan
                                            </form>

                                            <!-- Make sure that only authorized users can delete quotes -->
                                            <form action="{{ route('quotes.destroy', $quote) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                @can('delete', $quote)
                                                    <x-enabled-delete-icon />
                                                @elsecannot('delete', $quote)
                                                    <x-disabled-delete-icon />
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>
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
