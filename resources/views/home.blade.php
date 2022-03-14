@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <!-- Main header -->
            <div class="p-6 text-gray-700 ">
                <h1 class="text-4xl font-semibold mb-1">Home</h1>
                <p>Welcome to paradisestore.org!</p>
            </div>

            <div class="bg-gray-100 p-6 rounded-lg mb-3 shadow-md">
                @guest
                    <h2 class="text-center text-xl">You are not logged in. Please <a href="{{ route('login') }}"
                            class="text-blue-500 hover:underline">log in</a> to continue.</h2>
                @endguest

                @auth
                    <h2 class="text-center text-xl">You are logged in. Welcome back!</h2>

                    <!-- Buttons -->
                    <div class="justify-center mt-5 mb-5 space-y-1 text-center">
                        <form action="{{ route('quotes') }}" method="GET">
                            @csrf
                            <button
                                class="bg-indigo-500 hover:bg-indigo-700 w-48 transition-colors duration-200 text-white font-bold py-2 px-4 rounded-lg"
                                type="submit">
                                View All Quotes
                            </button>
                        </form>

                        <form action="{{ route('quotes.create') }}" method="GET">
                            @csrf
                            <button
                                class="bg-indigo-500 hover:bg-indigo-700 w-48 transition-colors duration-200 text-white font-bold py-2 px-4 rounded-lg"
                                type="submit">
                                Create New Quote
                            </button>
                        </form>

                        <form action="{{ route('profiles') }}" method="GET">
                            @csrf
                            <button
                                class="bg-indigo-500 hover:bg-indigo-700 w-48 transition-colors duration-200 text-white font-bold py-2 px-4 rounded-lg"
                                type="submit">
                                Profiles
                            </button>
                        </form>

                        @admin
                        <form action="{{ route('admin') }}" method="GET">
                            @csrf
                            <button
                                class="bg-rose-500 hover:bg-rose-700 w-48 transition-colors duration-200 text-white font-bold py-2 px-4 rounded-lg"
                                type="submit">
                                Admin Panel
                            </button>
                        </form>
                        @endadmin
                    </div>
                @endauth
            </div>
        </div>
    </div>
@endsection
