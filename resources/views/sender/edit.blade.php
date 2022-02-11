@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <!-- Header -->
            <div class="p-6 text-gray-200">
                <h1 class="text-4xl font-semibold mb-1">Edit a Sender Organization Details</h1>
                <p>Change details for organisation: <b>{{ $sender->name }}</p>
            </div>

            <!-- Session Messages -->
            @if (session('status'))
                <div class="bg-green-500 p-4 rounded-lg mb-3 text-white text-center">
                    {{ session('status') }}
                </div>
            @endif

            <div class=" bg-gray-100 p-6 rounded-lg mb-3">
                <!-- Sender Organization Details header -->
                <h2 class="text-2xl font-medium mb-5">Sender Organization Details</h2>

                <!-- Sender Organization Details form -->
                <form action="{{ route('profiles.sender.update', $sender) }}" method="POST">
                    @csrf
                    <!-- Name -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="name">
                                Organization Name
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                                @error('name') border-red-500 @enderror"
                                name="name"
                                id="name"
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
                                id="address"
                                placeholder="Organization Address">{{ $sender->address }}</textarea>

                            @error('address')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end">
                        <!-- Cancel button -->
                        <a href="{{ route('profiles') }}"
                            class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cancel
                        </a>
                        <!-- Update button -->
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                            Update Details
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection