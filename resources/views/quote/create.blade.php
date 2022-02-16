@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <!-- Main Header -->
            <div class="p-6 text-gray-700">
                <h1 class="text-4xl font-semibold mb-1">Create a Quote</h1>
                <!-- If user is not logged in, tell the user -->
                @guest
                    <p>
                        Not logged in. <br>
                        You must be logged in to create a quote.
                    </p>
                @endguest

                <!-- If user is logged in, show name -->
                @auth
                    <p>
                        Logged in as <b>{{ auth()->user()->name }}</b>. <br>
                        You can create a quote below.
                    </p>
                @endauth
            </div>

            <!-- Session Messages -->
            @if (session('status'))
                <div class="bg-green-500 p-4 rounded-lg mb-3 text-white text-center">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Create Quote Form. Only logged in user can see the form -->
            <div class="bg-gray-100 p-6 rounded-lg mb-3 shadow-lg">
                <!-- If user is not logged in, tell the user -->
                @guest
                    <h2 class="text-xl font-medium text-center">Please <a class="text-blue-500 underline" href="{{ route('login') }}">login</a> to access the form.</h2>
                @endguest

                <!-- Show the form for logged in user -->
                @auth
                    <form action="{{ route('quotes.create') }}" method="POST">
                        @csrf
                        <!-- Quote number div -->
                        <div>
                                <!-- Quote number texts -->
                            <h2 class="text-2xl font-medium">Quote Number</h2>
                            <p class="text-gray-600 mb-3">
                                Number that will be used to identify the quote.
                            </p>

                            <!-- Quote number input -->
                            <div class="grid grid-cols-5 gap-2 mb-4">
                                <!-- Year -->
                                <div>
                                    <label for="numberYear" class="sr-only">Year</label>
                                    <input
                                    class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                    @error('numberYear') border-red-500 @enderror"
                                    type="number"
                                    name="numberYear"
                                    id="numberYear"
                                    placeholder="Year"
                                    value="{{ now()->year }}">

                                    <div class="text-red-500 mt-1 text-xs">
                                        @error('numberYear')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>

                                <!-- Division -->
                                <div>
                                    <label for="numberDivision" class="sr-only">Division</label>
                                    <input
                                    class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                    @error('numberDivision') border-red-500 @enderror"
                                    type="text"
                                    name="numberDivision"
                                    id="numberDivision"
                                    placeholder="Division"
                                    value="{{ old('numberDivision') }}">

                                    <div class="text-red-500 mt-1 text-xs">
                                        @error('numberDivision')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>

                                <!-- Sales -->
                                <div>
                                    <label for="numberSales" class="sr-only">Sales</label>
                                    <input
                                    class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                    @error('numberSales') border-red-500 @enderror"
                                    type="text"
                                    name="numberSales"
                                    id="numberSales"
                                    placeholder="Sales"
                                    value="{{ old('numberSales') }}">

                                    <div class="text-red-500 mt-1 text-xs">
                                        @error('numberSales')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>

                                <!-- Month -->
                                <div>
                                    <label for="numberMonth" class="sr-only">Month</label>
                                    <input
                                    class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                    @error('numberMonth') border-red-500 @enderror"
                                    type="number"
                                    name="numberMonth"
                                    id="numberMonth"
                                    placeholder="Month"
                                    value="{{ now()->month }}">

                                    <div class="text-red-500 mt-1 text-xs">
                                        @error('numberMonth')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>

                                <!-- Number -->
                                <div>
                                    <label for="numberNumber" class="sr-only">Number</label>
                                    <input
                                    min="1"
                                    class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                    @error('numberNumber') border-red-500 @enderror"
                                    type="number"
                                    name="numberNumber"
                                    id="numberNumber"
                                    placeholder="Number"
                                    value="{{ old('numberNumber') }}">

                                    <div class="text-red-500 mt-1 text-xs">
                                        @error('numberNumber')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Date div -->
                        <div>
                            <!-- Quote date texts -->
                            <h2 class="text-2xl font-medium">Date</h2>
                            <p class="text-gray-600 mb-3">
                                Select the date from the calendar.
                            </p>

                            <!-- Quote date input -->
                            <div class="mb-4">
                                <!-- Date -->
                                <label for="date" class="sr-only">Date</label>
                                <input
                                class="shadow appearance-none border rounded p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('date') border-red-500 @enderror"
                                type="date"
                                name="date"
                                id="date"
                                value="{{ old('date') }}">

                                @error('date')
                                    <div class="text-red-500 mt-1 text-xs">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Sender and receiver component -->
                        @livewire('quote-sender-receiver')

                        <!-- Quote items component -->
                        @livewire('quote-items')

                        <!-- Terms and conditions component -->
                        @livewire('quote-terms-conditions')

                        <!-- Submit button -->
                        <div>
                            <button
                                onclick="return confirm('Create quote?')"
                                type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-3 rounded
                            font-medium w-full">Create Quotation</button>
                        </div>
                    </form>
                @endauth
            </div>
        </div>
    </div>
@endsection
