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
                <form action="" method="">
                    @livewire('emails-to-send')
                </form>
            </div>
        </div>
    </div>
@endsection
