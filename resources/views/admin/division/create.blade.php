@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <!-- Header -->
            <div class="p-6 text-gray-700">
                <h1 class="text-4xl font-semibold mb-1">Add a Division</h1>
                <p>Store a new division to the database</p>
            </div>

            <div class=" bg-indigo-600/10 p-6 rounded-lg mb-3">
                <!-- Division details header -->
                <h2 class="text-2xl font-medium mb-5">Division Details</h2>

                <!-- Division details form -->
                <form action="{{ route('admin.division.create') }}" method="POST">
                    @csrf
                    <!-- Abbreviation -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="abbreviation">
                                Division Abbreviation
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('abbreviation') border-red-500 @enderror"
                                name="abbreviation"
                                type="text"
                                placeholder="ONL"
                                value="{{ old('abbreviation') }}">

                                @error('abbreviation')
                                    <div class="text-red-500 mt-2 text-sm">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>
                    </div>

                    <!-- Client address -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="description">
                                Description
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('description') border-red-500 @enderror"
                                name="description"
                                type="text"
                                placeholder="Online"
                                value="{{ old('description') }}">

                                @error('description')
                                    <div class="text-red-500 mt-2 text-sm">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end">
                        <!-- Cancel button -->
                        <a href="{{ route('admin') }}"
                            class="mr-2 bg-red-500 hover:bg-red-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cancel
                        </a>
                        <!-- Add Division button -->
                        <button
                            class="bg-indigo-500 hover:bg-indigo-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                            Add Division
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
