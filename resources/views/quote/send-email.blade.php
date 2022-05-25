@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="p-6 text-gray-700 text-center">
        <h1 class="text-4xl font-semibold mb-1">Send Email</h1>
        <p>Sending quote:
            {{ substr($quote->quote_date, 0, 4) . '/' . $quote->div . '/' . $quote->sales_person . '/' . substr($quote->quote_date, 5, 2) . '/' . $quote->number }}
        </p>
    </div>

    <div class="flex justify-center">
        <div class="w-8/12">
            <div class="bg-gray-100 p-6 rounded-lg">
                <!-- List of recipients -->
                <form action="" method="">
                    @livewire('emails-to-send')
                </form>

                <!-- Send email button -->
                <div class="flex justify-center space-x-2 text-center">
                    <form action="{{ route('quotes.email', $quote) }}" method="POST">
                        @csrf
                        <button
                            class="bg-indigo-500 hover:bg-indigo-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded-lg"
                            type="submit">
                            Send Email
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
