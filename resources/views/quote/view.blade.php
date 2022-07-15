@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <!-- Header -->
            <div class="p-6 text-gray-700">
                <h1 class="text-4xl font-semibold mb-1">Quote Info:
                    {{ substr($quote->quote_date, 0, 4) . '/' . $quote->div . '/' . $quote->sales_person . '/' . substr($quote->quote_date, 5, 2) . '/' . $quote->number }}
                </h1>
                <p>Quote details</p>
            </div>

            <!-- Body -->
            <div class="bg-gray-100 p-6 rounded-lg mb-3 shadow-lg">
                <h2 class="text-2xl font-medium">General details</h2>
                <!-- Name -->
                <div class="flex flex-wrap mb-2">
                    <div class="w-1/3 align-middle">
                        <label class="text-md p-3 inline-block align-middle" for="number">
                            Quote#
                        </label>
                    </div>
                    <div class="w-2/3">
                        <input readonly
                            class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                            name="number" type="text"
                            value="{{ substr($quote->quote_date, 0, 4) . '/' . $quote->div . '/' . $quote->sales_person . '/' . substr($quote->quote_date, 5, 2) . '/' . $quote->number }}">
                    </div>
                </div>

                <!-- Date -->
                <div class="flex flex-wrap mb-2">
                    <div class="w-1/3 align-middle">
                        <label class="text-md p-3 inline-block align-middle" for="number">
                            Date
                        </label>
                    </div>
                    <div class="w-2/3">
                        <input readonly
                            class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                            name="number" type="text" value="{{ $quote->formatted_date }}">
                    </div>
                </div>

                <!-- Quoted by -->
                <div class="flex flex-wrap mb-2">
                    <div class="w-1/3 align-middle">
                        <label class="text-md p-3 inline-block align-middle" for="by">
                            Quoted by
                        </label>
                    </div>
                    <div class="w-2/3">
                        <input readonly
                            class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                            name="by" type="text" value="{{ $quote->sales_person }}">
                    </div>
                </div>

                <!-- Quoted to -->
                <div class="flex flex-wrap mb-2">
                    <div class="w-1/3 align-middle">
                        <label class="text-md p-3 inline-block align-middle" for="client">
                            Quoted to
                        </label>
                    </div>
                    <div class="w-2/3">
                        <input readonly
                            class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                            name="client" type="text"
                            value="{{ $quote->client->name }} (PIC: {{ $quote->client->pic }})">
                    </div>
                </div>

                <!-- Status -->
                <div class="flex flex-wrap mb-2">
                    <div class="w-1/3 align-middle">
                        <label class="text-md p-3 inline-block align-middle" for="number">
                            Status
                        </label>
                    </div>
                    <div class="w-2/3">
                        <input readonly
                            class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                            name="status" type="text" value="{{ $quote->status_text }}">
                    </div>
                </div>

                <!-- Amount -->
                <div class="flex flex-wrap mb-5">
                    <div class="w-1/3 align-middle">
                        <label class="text-md p-3 inline-block align-middle" for="amount">
                            Amount (incl. tax)
                        </label>
                    </div>
                    <div class="w-2/3">
                        <input readonly
                            class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline"
                            name="amount" type="text" value="{{ 'Rp ' . number_format($quote->amount, 2) }}">
                    </div>
                </div>

                <!-- Items -->
                <div class="flex flex-wrap mb-5">
                    <h2 class="text-2xl font-medium">Items</h2>
                    <!-- Table -->
                    <div class="overflow-auto rounded-lg shadow">
                        <table class="w-full">
                            <!-- Table Headers -->
                            <thead class="bg-gray-200 border-b-2 border-gray-300">
                                <tr>
                                    <th class="w-40 p-3 text-sm tracking-wide text-left">Item name</th>
                                    <th class="w-14 p-3 text-sm tracking-wide text-left">Qty</th>
                                    <th class="w-24 p-3 text-sm tracking-wide text-left">Unit price</th>
                                    <th class="w-24 p-3 text-sm tracking-wide text-left">Total price</th>
                                </tr>
                            </thead>
                            <!-- Table Body -->
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($quote->items as $item)
                                    <tr>
                                        <td class="p-3 text-sm tracking-wide text-left">{{ $item['name'] }}</td>
                                        <td class="p-3 text-sm tracking-wide text-left">{{ $item['quantity'] . ' ' . $item['quantityUnit'] }}</td>
                                        <td class="p-3 text-sm tracking-wide text-left">
                                            {{ 'Rp ' . number_format($item['price'], 2) }}</td>
                                        <td class="p-3 text-sm tracking-wide text-left">
                                            {{ 'Rp ' . number_format($item['price'] * $item['quantity'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Terms and conditions -->
                <div class="mb-2">
                    <h2 class="text-2xl font-medium">Terms and Conditions</h2>
                    <ul class="list-disc mx-5">
                        @foreach ($quote->terms_conditions as $term)
                            <li>{{ $term }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- Go back button -->
                <div class="flex justify-end">
                    <a href="{{ route('quotes') }}"
                        class="bg-blue-500 hover:bg-blue-700 transition-colors text-white font-bold py-2 px-4 rounded">
                        Go back
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
