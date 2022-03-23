@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <!-- Main header -->
            <div class="p-6 text-gray-700 ">
                <h1 class="text-4xl font-semibold mb-1">Change Password</h1>
                <p>Change your password for logging in next time</p>
            </div>
            <!-- Session Messages -->
            @if (session('status'))
                <div class="bg-green-500 p-4 rounded-lg mb-3 text-white text-center">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Form -->
            <div class="bg-gray-100 p-6 rounded-lg mb-3 shadow-lg">
                <h2 class="text-2xl font-medium">Your Password</h2>
                <p class="text-gray-600 mb-5">
                    Your need to enter your old password to change your password. <br>
                    Contact an admin if you forgot your password.
                </p>

                <!-- The form -->
                <form action="{{ route('profiles.change-password') }}" method="POST">
                    @csrf
                    <!-- Old Password -->
                    <div class="flex flex-wrap mb-2">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="oldPassword">
                                Old Password
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('oldPassword') border-red-500 @enderror"
                                name="oldPassword"
                                type="password"
                                placeholder="Old Password">

                            @error('oldPassword')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="flex flex-wrap mb-2">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="newPassword">
                                New Password
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('newPassword') border-red-500 @enderror"
                                name="newPassword"
                                type="password"
                                placeholder="New Password">

                            @error('newPassword')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="newPassword_confirmation">
                                Confirm New Password
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('newPassword_confirmation') border-red-500 @enderror"
                                name="newPassword_confirmation"
                                type="password"
                                placeholder="Confirm Password">

                            @error('newPassword_confirmation')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end">
                        <!-- Cancel button -->
                        <a
                            href="{{ route('profiles') }}"
                            class="w-20 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 mr-2 rounded focus:outline-none focus:shadow-outline text-center transition-colors duration-200">
                            Cancel
                        </a>
                        <!-- Update User button -->
                        <button
                            class="w-40 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center transition-colors duration-200"
                            type="submit">
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
