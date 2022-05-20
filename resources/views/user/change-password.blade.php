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
                        <div class="w-2/3" x-data="{ show: true }">
                            <div class="relative">
                            
                              <input
                                  class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                  @error('oldPassword') border-red-500 @enderror"
                                  name="oldPassword"
                                  :type="show ? 'password' : 'text'"
                                  placeholder="Old Password">

                              <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">

                                <svg class="h-6 text-gray-700" fill="none" @click="show = !show"
                                  :class="{'hidden': !show, 'block':show }" xmlns="http://www.w3.org/2000/svg"
                                  viewbox="0 0 576 512">
                                  <path fill="currentColor"
                                    d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                  </path>
                                </svg>

                                <svg class="h-6 text-gray-700" fill="none" @click="show = !show"
                                  :class="{'block': !show, 'hidden':show }" xmlns="http://www.w3.org/2000/svg"
                                  viewbox="0 0 640 512">
                                  <path fill="currentColor"
                                    d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                                  </path>
                                </svg>

                              </div>
                              @error('oldPassword')
                                  <div class="text-red-500 mt-2 text-sm">
                                      {{ $message }}
                                  </div>
                              @enderror
                            </div>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="flex flex-wrap mb-2">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="newPassword">
                                New Password
                            </label>
                        </div>
                        <div class="w-2/3" x-data="{ show: true }">
                            <div class="relative">
                            
                              <input
                                  class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                  @error('newPassword') border-red-500 @enderror"
                                  name="newPassword"
                                  :type="show ? 'password' : 'text'"
                                  placeholder="New Password">

                              <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">

                                <svg class="h-6 text-gray-700" fill="none" @click="show = !show"
                                  :class="{'hidden': !show, 'block':show }" xmlns="http://www.w3.org/2000/svg"
                                  viewbox="0 0 576 512">
                                  <path fill="currentColor"
                                    d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                  </path>
                                </svg>

                                <svg class="h-6 text-gray-700" fill="none" @click="show = !show"
                                  :class="{'block': !show, 'hidden':show }" xmlns="http://www.w3.org/2000/svg"
                                  viewbox="0 0 640 512">
                                  <path fill="currentColor"
                                    d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                                  </path>
                                </svg>

                              </div>
                              @error('newPassword')
                                  <div class="text-red-500 mt-2 text-sm">
                                      {{ $message }}
                                  </div>
                              @enderror
                            </div>
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
