@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-4/12 bg-white p-6 rounded-lg">
            <!-- Login title -->
            <h1 class="text-4xl font-medium text-center mb-5">Login</h1>

            <!-- For showing error status message (like invalid login details) -->
            @if (session('status'))
                <div class="bg-red-500 p-3 rounded-lg mb-4 text-white text-center">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Form for username box, password box, remember me checkbox, login button -->
            <form action="{{ route('login') }}" method="post">
                @csrf
                <!-- Username textbox -->
                <div class="mb-4">
                    <label for="username" class="sr-only">Username</label>
                    <input type="text" name="username" id="username" placeholder="Your username"
                    class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('username') border-red-500 @enderror" value="{{ old('username') }}">

                    <!-- Display error message if there is an error -->
                    @error('username')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password textbox -->
                <div class="mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password"
                    class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('password') border-red-500 @enderror" value="">

                    <!-- Display error message if there is an error -->
                    @error('password')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Remember me checkbox -->
                <div class="mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="mr-2">
                        <label for="remember">Remember me</label>
                    </div>
                </div>

                <!-- Submit button -->
                <div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-3 rounded
                    font-medium w-full">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection
