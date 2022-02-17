@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-3/12 bg-gray-100 p-6 rounded-lg mt-10 shadow-lg">
            <!-- Login title -->
            <h1 class="text-4xl font-medium text-center mb-5">Login</h1>

            <!-- For showing error status message (like invalid login details) -->
            @if (session('status'))
                <div class="bg-red-500 p-3 rounded-lg mb-4 text-white text-center">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Form for Email box, password box, remember me checkbox, login button -->
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <!-- Email textbox -->
                <div class="mb-4">
                    <label for="email" class="mx-2">Email</label>
                    <input type="email" name="email" placeholder="Your email"
                    class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                    value="{{ old('email') }}">

                    <!-- Display error messagPe if there is an error -->
                    @error('email')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password textbox -->
                <div class="mb-4">
                    <label for="password" class="mx-2">Password</label>
                    <input type="password" name="password" placeholder="Enter your password"
                    class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
                    value="">

                    <!-- Display error message if there is an error -->
                    @error('password')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Remember me checkbox -->
                <div class="mb-4">
                    <div class="flex items-center justify-center">
                        <input type="checkbox" name="remember" id="remember" class="mr-2">
                        <label for="remember">Remember me</label>
                    </div>
                </div>

                <!-- Login button -->
                <div class="flex justify-center">
                    <button type="submit" class="shadow bg-green-500 hover:bg-green-700 text-white px-4 py-3 rounded
                    font-medium w-2/3"> Sign in </button>
                </div>
            </form>
        </div>
    </div>
@endsection
