@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-11/12">
            <!-- Main Header -->
            <div class="p-6 text-gray-700">
                <h1 class="text-4xl font-semibold mb-1">Create a Quote Manually</h1>
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
                @auth
                    <form action="{{ route('admin.quote.create') }}" method="POST">
                        @csrf
                        <!-- Quote number component -->
                        @livewire('quote-number', ['isManual' => true])

                        <!-- DIVIDER -->
                        <div class=" flex justify-center">
                            <div class="w-4/5 my-9 border-b-2 border-slate-300-50"></div>
                        </div>

                        <!-- Quote date component -->
                        @livewire('quote-date', ['isManual' => true])

                        <!-- DIVIDER -->
                        <div class="flex justify-center">
                            <div class="w-4/5 my-9 border-b-2 border-slate-300-50"></div>
                        </div>

                        <!-- Sender and receiver component -->
                        @livewire('quote-sender-receiver', ['isManual' => true])

                        <!-- DIVIDER -->
                        <div class="flex justify-center">
                            <div class="w-4/5 my-9 border-b-2 border-slate-300-50"></div>
                        </div>

                        <!-- Quote items component -->
                        @livewire('quote-items')

                        <!-- DIVIDER -->
                        <div class="flex justify-center">
                            <div class="w-4/5 my-9 border-b-2 border-slate-300-50"></div>
                        </div>

                        <!-- Terms and conditions component -->
                        @livewire('quote-terms-conditions')

                        <!-- DIVIDER -->
                        <div class="flex justify-center">
                            <div class="w-4/5 my-9 border-b-2 border-slate-300-50"></div>
                        </div>

                        <!-- Add attachment component -->
                        @livewire('quote-attachment')

                        <!-- DIVIDER -->
                        <div class="flex justify-center"><div class="w-4/5 my-9"></div></div>

                        <!-- Submit button -->
                        <div class="flex justify-center">
                            <button onclick="return confirm('Create quote?')" type="submit"
                                class="bg-blue-500 hover:bg-blue-700 transition-colors duration-200 text-white px-4 py-3 rounded font-medium w-2/4">
                                Create Quotation</button>
                        </div>
                    </form>
                @endauth
            </div>
        </div>
    </div>
@endsection
