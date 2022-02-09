@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-10/12">
            <div class="p-4 bg-white rounded-md mb-4">
                <!-- Create a quote title -->
                <h1 class="text-2xl font-semibold mb-1">Create a Quote</h1>

                <!-- If user is not logged in, tell the user -->
                @guest
                    <p class="text-gray-600">
                        Not logged in. <br>
                        You must be logged in to create a quote.
                    </p>
                @endguest

                <!-- If user is logged in, show name -->
                @auth
                    <p class="text-gray-600">
                        Logged in as {{ auth()->user()->name }}. <br>
                        You can create a quote below.
                    </p>
                @endauth
            </div>

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
        </div>
    </div>
@endsection
