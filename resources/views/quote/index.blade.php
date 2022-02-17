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
            @if (session('status'))
                <div class="bg-green-500 p-4 rounded-lg mb-3 text-white text-center">
                    {{ session('status') }}
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
                                <th class="w-1/12 p-1"></th>
                                <th class="w-1/12 p-1"></th>
                                <th class="w-1/12"></th>
                            </thead>

                            <tbody class="divide-y divide-gray-100">
                                @foreach($quotes as $quote)
                                    <tr class="bg-white text-gray-700 text-lg">
                                        <td class="p-3 whitespace-nowrap border-r">{{ $quote->id }}</td>
                                        <td class="p-3 whitespace-nowrap border-r">{{ $quote->quote_date }}</td>
                                        <td class="p-3 whitespace-nowrap border-r">{{ $quote->client }}</td>
                                        <td class="p-3 whitespace-nowrap border-r">{{ $quote->amount }}</td>

                                        <!-- Download button -->
                                        <td class="p-3 text-center">
                                            <!-- Make sure that only authorized users can delete clients (either admin or client creator) -->
                                            <form action="{{ route('quotes.download', $quote) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="mt-1 hover:bg-gray-300 p-2 rounded">
                                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 512 512"><!--! Font Awesome Pro 6.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                        <path d="M480 352h-133.5l-45.25 45.25C289.2 409.3 273.1 416 256 416s-33.16-6.656-45.25-18.75L165.5 352H32c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h448c17.67 0 32-14.33 32-32v-96C512 366.3 497.7 352 480 352zM432 456c-13.2 0-24-10.8-24-24c0-13.2 10.8-24 24-24s24 10.8 24 24C456 445.2 445.2 456 432 456zM233.4 374.6C239.6 380.9 247.8 384 256 384s16.38-3.125 22.62-9.375l128-128c12.49-12.5 12.49-32.75 0-45.25c-12.5-12.5-32.76-12.5-45.25 0L288 274.8V32c0-17.67-14.33-32-32-32C238.3 0 224 14.33 224 32v242.8L150.6 201.4c-12.49-12.5-32.75-12.5-45.25 0c-12.49 12.5-12.49 32.75 0 45.25L233.4 374.6z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>

                                        <!-- Edit button -->
                                        <td class="p-3 text-center">
                                            <!-- Make sure that only authorized users can delete clients (either admin or client creator) -->
                                            <form action="#" method="">
                                                @csrf
                                                @can('edit', $quote)
                                                    <x-enabled-edit-icon />
                                                @elsecannot('edit', $quote)
                                                    <x-disabled-edit-icon />
                                                @endcan
                                            </form>
                                        </td>

                                        <!-- Delete button -->
                                        <td class="p-3 text-center">
                                            <!-- Make sure that only authorized users can delete clients (either admin or client creator) -->
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
