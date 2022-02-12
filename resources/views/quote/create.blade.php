@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <!-- Main Header -->
            <div class="p-6 text-gray-200">
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

            <!-- Create Quote Form. Only logged in user can see the form -->
            <div class="bg-gray-100 p-6 rounded-lg mb-3">
                <!-- If user is not logged in, tell the user -->
                @guest
                    <h2 class="text-xl font-medium text-center">Please <a class="text-blue-500 underline" href="{{ route('login') }}">login</a> to access the form.</h2>
                @endguest

                <!-- Show the form for logged in user -->
                @auth
                    <form action="">
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
                                <label for="numberYear" class="sr-only">Year</label>
                                <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                type="text"
                                name="numberYear" id="numberYear" placeholder="Year"
                                value="{{ now()->year }}">

                                <!-- Division -->
                                <label for="numberDivision" class="sr-only">Division</label>
                                <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                type="text"
                                name="numberDivision"
                                id="numberDivision"
                                placeholder="Division"
                                value="{{ old('numberDivision') }}">

                                <!-- Sales -->
                                <label for="numberSales" class="sr-only">Sales</label>
                                <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                type="text"
                                name="numberSales"
                                id="numberSales"
                                placeholder="Sales"
                                value="{{ old('numberSales') }}">

                                <!-- Month -->
                                <label for="numberMonth" class="sr-only">Month</label>
                                <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                type="text"
                                name="numberMonth"
                                id="numberMonth"
                                placeholder="Month"
                                value="{{ now()->month }}">

                                <!-- Number -->
                                <label for="numberNumber" class="sr-only">Number</label>
                                <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                type="text"
                                name="numberNumber"
                                id="numberNumber"
                                placeholder="Number"
                                value="{{ old('numberNumber') }}">
                            </div>
                        </div>

                        <!-- Date div -->
                        <div>
                            <!-- Quote date texts -->
                            <h2 class="text-2xl font-medium">Date</h2>
                            <p class="text-gray-600 mb-3">
                            Select the date from the calendar or leave it to use today's date.
                            </p>
                        </div>

                        <!-- Sender and receiver div -->
                        @livewire('quote-sender-receiver')

                        <!-- Quote items div -->
                        <div>
                            <!-- Items texts -->
                            <h2 class="text-2xl font-medium">Items, Tax, and Total Price</h2>
                            <p class="text-gray-600 mb-3">
                                Add items, tax, and total price.
                            </p>

                            <!-- Items input -->

                        </div>

                        <!-- Terms and conditions div -->
                        @livewire('quote-terms-conditions')

                        <!-- Submit button -->
                        <div>
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-4 py-3 rounded
                            font-medium w-full">Create Quotation</button>
                        </div>
                    </form>
                @endauth

            </div>

        </div>
    </div>

    {{-- <div class="flex justify-center">
        <!-- Create a quote form div -->
        <div class=" bg-white p-4 rounded-lg">
            <form action="" method="POST">
                @csrf
                <!-- Quote number -->
                <h2 class="text-xl font-semibold mb-2">Quote Number</h2>
                <div class="grid grid-cols-5 gap-2 mb-4">
                    <!-- Year -->
                    <label for="numberYear" class="sr-only">Year</label>
                    <input type="text" name="numberYear" id="numberYear" placeholder="Year"
                    class="bg-gray-100 border-2 w-full p-3 rounded-lg" value="{{ now()->year }}">

                    <!-- Division -->
                    <label for="numberDivision" class="sr-only">Division</label>
                    <input type="text" name="numberDivision" id="numberDivision" placeholder="Division"
                    class="bg-gray-100 border-2 w-full p-3 rounded-lg" value="{{ old('numberDivision') }}">

                    <!-- Sales -->
                    <label for="numberSales" class="sr-only">Sales</label>
                    <input type="text" name="numberSales" id="numberSales" placeholder="Sales"
                    class="bg-gray-100 border-2 w-full p-3 rounded-lg" value="{{ old('numberSales') }}">

                    <!-- Month -->
                    <label for="numberMonth" class="sr-only">Month</label>
                    <input type="text" name="numberMonth" id="numberMonth" placeholder="Month"
                    class="bg-gray-100 border-2 w-full p-3 rounded-lg" value="{{ now()->month }}">

                    <!-- Number -->
                    <label for="numberNumber" class="sr-only">Number</label>
                    <input type="text" name="numberNumber" id="numberNumber" placeholder="Number"
                    class="bg-gray-100 border-2 w-full p-3 rounded-lg" value="{{ old('numberNumber') }}">
                </div>

                <!-- Date -->
                <h2 class="text-xl font-semibold mb-2">Date</h2>
                <div class="mb-4">
                    <script src="https://unpkg.com/@themesberg/flowbite@1.3.0/dist/datepicker.bundle.js"></script>
                    <div class="relative">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input datepicker readonly type="text" name="date" id="date" class="bg-gray-100 border-2 rounded-lg block w-full pl-10 p-3" placeholder="Select date">
                    </div>
                </div>

                <!-- Quote To -->


                <!-- Terms and conditions -->


                <!-- Submit button -->
                <div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-3 rounded
                    font-medium w-full">Create Quotation</button>
                </div>
            </form>
        </div>
    </div> --}}
@endsection
