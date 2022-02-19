@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <!-- Header -->
            <div class="p-6 text-gray-700">
                <h1 class="text-4xl font-semibold mb-1">Edit User</h1>
                <p>Edit details for user: <a class="font-semibold">{{ $user->name }}</a></p>
            </div>

            <!-- Form section -->
            <div class="bg-indigo-600/10 p-6 rounded-lg mb-3 shadow-lg">
                <form action="{{ route('admin.user.show', $user) }}" method="POST">
                    @csrf
                    <!-- Full name -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="name">
                                Full Name
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                required
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('name') border-red-500 @enderror"
                                name="name"
                                type="text"
                                placeholder="John Doe"
                                value="{{ $user->name }}">

                            @error('name')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Name abbreviation -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="name_abbreviation">
                                Name Abbreviation/Initials
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                required
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('name_abbreviation') border-red-500 @enderror"
                                name="name_abbreviation"
                                type="text"
                                placeholder="JD"
                                value="{{ $user->name_abbreviation }}">

                            @error('name_abbreviation')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="email">
                                Email
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                required
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('email') border-red-500 @enderror"
                                name="email"
                                type="email"
                                placeholder="email@xdc-indonesia.com"
                                value="{{ $user->email }}">

                            @error('email')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex flex-wrap">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="phone">
                                Phone
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                required
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('phone') border-red-500 @enderror"
                                name="phone"
                                type="text"
                                placeholder="08XXXXXXXXX"
                                value="{{ $user->phone }}">

                            @error('phone')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- DIVIDER -->
                    <div class="flex justify-center"><div class="w-4/5 my-6 border-b-2 border-slate-300-50"></div></div>

                    <!-- Password warning message -->
                    <p class="text-red-700 font-semibold mb-4 bg-red-100 rounded text-center py-2">
                        WARNING: Only fill these password input boxes if you wish to change the password. Otherwise, leave them blank.
                    </p>

                    <!-- New Password -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="new_password">
                                New Password
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('new_password') border-red-500 @enderror"
                                name="new_password"
                                type="password"
                                placeholder="Password">

                            @error('new_password')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Confirm password -->
                    <div class="flex flex-wrap">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="new_password_confirmation">
                                Confirm New Password
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('new_password_confirmation') border-red-500 @enderror"
                                name="new_password_confirmation"
                                type="password"
                                placeholder="Confirm password">

                            @error('new_password_confirmation')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- DIVIDER -->
                    <div class="flex justify-center"><div class="w-4/5 my-6 border-b-2 border-slate-300-50"></div></div>

                    <!-- Role -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="role_id">
                                Role
                            </label>
                        </div>
                        <div class="w-2/3">
                            <select
                                class="shadow border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                                @error('role_id') border-red-500 @enderror"
                                name="role_id">
                                @foreach ($roles as $role)
                                    <option {{ $role->id == $user->role_id ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>

                            @error('role_id')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Organization -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="organization_id">
                                Organization
                            </label>
                        </div>
                        <div class="w-2/3">
                            <select
                                class="shadow border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                                @error('organization_id') border-red-500 @enderror"
                                name="organization_id">
                                @foreach ($organizations as $organization)
                                    <option {{ $organization->id == $user->sender_id ? 'selected' : '' }} value="{{ $organization->id }}">ID:{{ $organization->id}} - {{ $organization->name }}</option>
                                @endforeach
                            </select>

                            @error('organization_id')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Division -->
                    <div class="flex flex-wrap">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="division_id">
                                Division
                            </label>
                        </div>
                        <div class="w-2/3">
                            <select
                                class="shadow border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline
                                @error('division_id') border-red-500 @enderror"
                                name="division_id">
                                @foreach ($divisions as $division)
                                    <option {{ $division->id == $user->division_id ? 'selected' : '' }} value="{{ $division->id }}">ID:{{ $division->id}} - {{ $division->abbreviation }} ({{ $division->description }})</option>
                                @endforeach
                            </select>

                            @error('division_id')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- DIVIDER -->
                    <div class="flex justify-center"><div class="w-4/5 my-6"></div></div>

                    <!-- Buttons -->
                    <div class="flex justify-end">
                        <!-- Cancel button -->
                        <a
                            href="{{ route('admin') }}"
                            class="mr-2 bg-red-500 hover:bg-red-700 transition-colors duration-200 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline text-center">
                            Cancel
                        </a>
                        <!-- Update User button -->
                        <button
                            class="bg-indigo-500 hover:bg-indigo-700 transition-colors duration-200 text-white font-bold py-3 px-4 w-1/6 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
