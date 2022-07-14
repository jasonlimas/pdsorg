@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <!-- Header -->
            <div class="p-6 text-gray-700">
                <h1 class="text-4xl font-semibold mb-1">Add a New Client</h1>
                <p>Store a new client to the database</p>
            </div>

            <!-- Session Messages -->
            @if (session('status'))
                <div class="bg-green-500 p-4 rounded-lg mb-3 text-white text-center">
                    {{ session('status') }}
                </div>
            @endif

            <div class=" bg-gray-100 p-6 rounded-lg mb-3">
                <!-- Client details header -->
                <h2 class="text-2xl font-medium mb-5">Client Details</h2>

                <!-- Client details form -->
                <form action="{{ route('profiles.client.create') }}" method="POST">
                    @csrf
                    <!-- Name -->
                    <div class="flex flex-wrap mb-2">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="name">
                                Client Company Name
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                            @error('name') border-red-500 @enderror"
                                name="name" id="name" type="text" placeholder="PT. Some Company"
                                value="{{ old('name') }}">

                            @error('name')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- PIC -->
                    <div class="flex flex-wrap mb-2">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="pic">
                                Person In Charge
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                            @error('pic') border-red-500 @enderror"
                                name="pic" id="pic" type="text" placeholder="John Doe" value="{{ old('pic') }}">

                            @error('pic')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Client email -->
                    <div class="flex flex-wrap mb-2">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="email">
                                Client Email
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                            @error('email') border-red-500 @enderror"
                                name="email" id="email" type="text" placeholder="johndoe@company.com"
                                value="{{ old('email') }}">

                            @error('email')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Client phone -->
                    <div class="flex flex-wrap mb-2">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="phone">
                                Client Phone
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                            @error('phone') border-red-500 @enderror"
                                name="phone" id="phone" type="text" placeholder="08919582739" value="{{ old('phone') }}">

                            @error('phone')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Client address -->
                    <div class="flex flex-wrap mb-2">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="address">
                                Client Address (max 200 chars)
                            </label>
                        </div>
                        <div class="w-2/3">
                            <textarea maxlength=200 cols=30 rows=4 class="shadow appearance-none border rounded w-full p-3 text-gray-700 focus:outline-none focus:shadow-outline
                            @error('address') border-red-500 @enderror"
                                name="address" id="address"
                                placeholder="Client Address">{{ old('address') }}</textarea>

                            @error('address')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Add client button -->
                    <div class="flex justify-end">
                        <!-- Cancel button -->
                        <a href="{{ route('profiles') }}"
                            class="w-20 mr-2 bg-red-500 hover:bg-red-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cancel
                        </a>
                        <button
                            class="w-40 bg-blue-500 hover:bg-blue-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                            Add Client
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
