@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <!-- Header -->
            <div class="p-6 text-gray-700">
                <h1 class="text-4xl font-semibold mb-1">Edit a Sender Organization Details</h1>
            <p>Change details for organisation: <a class="font-semibold">{{ $sender->name }}</a></p>
            </div>

            <!-- Session Messages -->
            @if (session('status'))
                <div class="bg-green-500 p-4 rounded-lg mb-3 text-white text-center">
                    {{ session('status') }}
                </div>
            @endif

            <div class=" bg-indigo-600/10 p-6 rounded-lg mb-3 shadow-lg">
                <!-- Sender Organization Details form -->
                <form action="{{ route('admin.sender.show', $sender) }}" method="POST">
                    @csrf
                    <!-- Sender Organization Name & Address header -->
                    <h2 class="text-2xl font-medium mb-5">Sender Name and Address</h2>

                    <!-- Name -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="name">
                                Organization Name
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('name') border-red-500 @enderror"
                                name="name"
                                type="text"
                                placeholder="Organization Name"
                                value="{{ $sender->name }}">

                                @error('name')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="address">
                                Organization Address
                            </label>
                        </div>
                        <div class="w-2/3">
                            <textarea
                                cols=30
                                rows=4
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 focus:outline-none focus:shadow-outline
                                @error('address') border-red-500 @enderror"
                                name="address"
                                placeholder="Organization Address">{{ $sender->address }}</textarea>

                            @error('address')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sender Organization Bank Details header -->
                    <h2 class="text-2xl font-medium mb-5">Bank Account Details</h2>

                    <!-- Input component -->
                    @livewire('sender-bank-details')

                    {{-- <!-- Banking Institution -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="name">
                                Banking Institution
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('bankInstitution') border-red-500 @enderror"
                                name="bankInstitution"
                                type="text"
                                placeholder="Institution Name"
                                value="{{ $sender->bank_institution }}">

                                @error('bankInstitution')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Banking Account Name -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="name">
                                Banking Account Name
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('bankAccountName') border-red-500 @enderror"
                                name="bankAccountName"
                                type="text"
                                placeholder="Account Name"
                                value="{{ $sender->bank_account_name }}">

                                @error('bankAccountName')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Banking Account Number -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="name">
                                Banking Account Number
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('bankAccountNumber') border-red-500 @enderror"
                                name="bankAccountNumber"
                                type="text"
                                placeholder="Account Number"
                                value="{{ $sender->bank_account_number }}">

                                @error('bankAccountNumber')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div> --}}

                    <!-- Buttons -->
                    <div class="flex justify-end">
                        <!-- Cancel button -->
                        <a href="{{ route('admin') }}"
                            class="mr-2 bg-red-500 hover:bg-red-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cancel
                        </a>
                        <!-- Update button -->
                        <button
                            class="bg-indigo-500 hover:bg-indigo-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                            Update Details
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
