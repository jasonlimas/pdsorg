@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-11/12">
            <!-- Main Header -->
            <div class="p-6 text-gray-700">
                <h1 class="text-4xl font-semibold mb-1">Edit Copied Quote Details</h1>
                <!-- If user is logged in, show name -->
                @auth
                    <p>
                        You are currently editing a copied quote: {{ $quote->number }}<br>
                        You can edit everything except for the Quote To/Recipient section.
                    </p>
                @endauth
            </div>

            <!-- Create Quote Form. Only logged in user can see the form -->
            <div class="bg-gray-100 p-6 rounded-lg mb-3 shadow-lg">
                @auth
                    <form action="{{ route('quotes.duplicate', $quote) }}" method="POST">
                        @csrf
                        <!-- Quote number component -->
                        @livewire('quote-number', ['quote' => $quote, 'isCopied' => true])

                        <!-- DIVIDER -->
                        <div class="flex justify-center"><div class="w-4/5 my-9 border-b-2 border-slate-300-50"></div></div>

                        <!-- Quote date component -->
                        @livewire('quote-date', ['quote' => $quote])

                        <!-- DIVIDER -->
                        <div class="flex justify-center"><div class="w-4/5 my-9 border-b-2 border-slate-300-50"></div></div>

                        <!-- Sender and receiver component -->
                        @livewire('quote-sender-receiver', ['quote' => $quote, 'isCopied' => true])

                        <!-- DIVIDER -->
                        <div class="flex justify-center"><div class="w-4/5 my-9 border-b-2 border-slate-300-50"></div></div>

                        <!-- Quote items component -->
                        @livewire('quote-items', ['quote' => $quote])

                        <!-- DIVIDER -->
                        <div class="flex justify-center"><div class="w-4/5 my-9 border-b-2 border-slate-300-50"></div></div>

                        <!-- Terms and conditions component -->
                        @livewire('quote-terms-conditions', ['quote' => $quote])

                        <!-- DIVIDER -->
                        <div class="flex justify-center"><div class="w-4/5 my-9 border-b-2 border-slate-300-50"></div></div>

                        <!-- Add attachment component -->
                        @livewire('quote-attachment')

                        <!-- DIVIDER -->
                        <div class="flex justify-center"><div class="w-4/5 my-9"></div></div>

                        <!-- Submit button -->
                        <div class="flex justify-center">
                            <button
                                onclick="return confirm('Save quote?')"
                                type="submit"
                                class="bg-blue-500 hover:bg-blue-700 transition-colors duration-200 text-white px-4 py-3 rounded font-medium w-2/4">
                                Save Copied Quote</button>
                        </div>
                    </form>
                @endauth
            </div>
        </div>
    </div>
@endsection
