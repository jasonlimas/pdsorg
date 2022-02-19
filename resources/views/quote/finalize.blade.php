@extends('layouts.app')

@section('content')
<div class="flex justify-center">
    <div class="w-8/12">
        <!-- Header -->
        <div class="p-6 text-gray-700 text-center">
            <h1 class="text-4xl font-semibold mb-1">Quote Created</h1>
            <p>Your quote has been saved. Pick an action below:</p>
        </div>

        <!-- Buttons -->
        <div class="flex justify-center mt-5 mb-5 space-x-2 text-center">
            <form action="{{ route('quotes') }}" method="GET">
                @csrf
                <button
                    class="bg-indigo-500 hover:bg-indigo-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded-lg"
                    type="submit">
                    View All Quotes
                </button>
            </form>

            <form action="{{ route('quotes.create') }}" method="GET">
                @csrf
                <button
                    class="bg-indigo-500 hover:bg-indigo-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded-lg"
                    type="submit">
                    Create New Quote
                </button>
            </form>

            <form action="{{ route('quotes.create.download', $quote) }}" method="GET">
                @csrf
                <button
                    class="bg-indigo-500 hover:bg-indigo-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded-lg"
                    type="submit">
                    Download Created Quote
                </button>
            </form>

            <form action="#" method="">
                @csrf
                <button
                    disabled
                    class="bg-gray-500 hover:bg-gray-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded-lg"
                    type="submit">
                    Email to Client (not yet available)
                </button>
            </form>
        </div>

        <!-- Quote Details -->
        <div class="p-6 text-gray-700">
            <!-- Header -->
            <h1 class="text-3xl font-semibold mb-5 text-center">Quote Details</h1>

            <!-- Quote number -->
            <div class="flex flex-wrap mb-2">
                <div class="w-1/3 align-middle">
                    <label class="text-md p-3 inline-block align-middle" for="number">
                        Quote Number
                    </label>
                </div>

                <!-- Text box -->
                <div class="w-2/3">
                    <input
                        readonly
                        class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                        name="number"
                        type="text"
                        value="{{ substr($quote->quote_date, 0, 4) . '/' . $quote->div . '/' . $quote->sales_person . '/' . substr($quote->quote_date, 5, 2) . '/' . $quote->number }}">
                </div>
            </div>

            <!-- Quote date -->
            <div class="flex flex-wrap mb-2">
                <div class="w-1/3 align-middle">
                    <label class="text-md p-3 inline-block align-middle" for="date">
                        Quote Date
                    </label>
                </div>

                <!-- Text box -->
                <div class="w-2/3">
                    <input
                        readonly
                        class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                        name="date"
                        type="text"
                        value="{{ $quote->quote_date }}">
                </div>
            </div>

            <!-- Quote from -->
            <div class="flex flex-wrap mb-2">
                <div class="w-1/3 align-middle">
                    <label class="text-md p-3 inline-block align-middle" for="sender">
                        Quote From
                    </label>
                </div>

                <!-- Text box -->
                <div class="w-2/3">
                    <input
                        readonly
                        class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                        name="sender"
                        type="text"
                        value="{{ $sender }}">
                </div>
            </div>

            <!-- Quote to -->
            <div class="flex flex-wrap mb-2">
                <div class="w-1/3 align-middle">
                    <label class="text-md p-3 inline-block align-middle" for="receiver">
                        Quote To
                    </label>
                </div>

                <!-- Text box -->
                <div class="w-2/3">
                    <input
                        readonly
                        class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                        name="receiver"
                        type="text"
                        value="{{ $client }}">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
