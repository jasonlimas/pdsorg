@extends('layouts.app')

@section('content')
<div class="flex justify-center">
    <div class="w-8/12">
        <!-- Header -->
        <div class="p-6 text-gray-700">
            <h1 class="text-4xl font-semibold mb-1">Add a Terms & Conditions preset</h1>
            <p>Store a new terms and conditions preset to the database</p>
        </div>

        <!-- Session Messages -->
        @if (session('status'))
            <div class="bg-green-500 p-4 rounded-lg mb-3 text-white text-center">
                {{ session('status') }}
            </div>
        @endif

        <div class=" bg-gray-100 p-6 rounded-lg mb-3">
            <!-- Preset header -->
            <h2 class="text-2xl font-medium mb-5">Preset Details</h2>

            <!-- Preset form -->
            <form action="{{ route('profiles.terms.create') }}" method="POST">
                @csrf
                <!-- Name -->
                <div class="flex flex-wrap mb-4">
                    <div class="w-1/3 align-middle">
                        <label class="text-md p-3 inline-block align-middle" for="name">
                            Preset Name
                        </label>
                    </div>
                    <div class="w-2/3">
                        <input
                            required
                            class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                            @error('name') border-red-500 @enderror"
                            name="name"
                            id="name"
                            type="text"
                            placeholder="Preset Name"
                            value="{{ old('name') }}">

                            @error('name')
                            <div class="text-red-500 mt-2 text-sm">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="flex flex-wrap mb-4">
                    <div class="w-1/3 align-middle">
                        <label class="text-md p-3 inline-block align-middle" for="address">
                            Terms & Conditions Details
                        </label>
                    </div>

                    <!-- Input component -->
                    @livewire('profile-terms-conditions')
                </div>

                <!-- Add preset button -->
                <div class="flex justify-end">
                    <!-- Cancel button -->
                    <a href="{{ route('profiles') }}"
                        class="mr-2 bg-red-500 hover:bg-red-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancel
                    </a>
                    <button
                        class="bg-blue-500 hover:bg-blue-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Add Preset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
