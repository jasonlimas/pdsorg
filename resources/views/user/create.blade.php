@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <!-- Header -->
            <div class="p-6 text-gray-700">
                <h1 class="text-4xl font-semibold mb-1">Add New User</h1>
                <p>Create and configure a new account for a new user</p>
            </div>

            <!-- Form section -->
            <div class="bg-indigo-600/10 p-6 rounded-lg mb-3 shadow-lg">
                <form
                    @admin action="{{ route('admin.user.create') }}" @endadmin
                    @teamleader action="{{ route('leader.user.create') }}" @endteamleader
                    method="POST">
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
                                value="{{ old('name') }}">

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
                                Name Initial
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
                                value="{{ old('name_abbreviation') }}">

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
                                value="{{ old('email') }}">

                            @error('name')
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
                                value="{{ old('phone') }}">

                            @error('phone')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- DIVIDER -->
                    <div class="flex justify-center"><div class="w-4/5 my-6 border-b-2 border-slate-300-50"></div></div>

                    <!-- Password -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="password">
                                Password
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                required
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('password') border-red-500 @enderror"
                                name="password"
                                type="password"
                                placeholder="Password">

                            @error('password')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Confirm password -->
                    <div class="flex flex-wrap">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="password_confirmation">
                                Confirm Password
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                required
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('password_confirmation') border-red-500 @enderror"
                                name="password_confirmation"
                                type="password"
                                placeholder="Confirm password">

                            @error('password_confirmation')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    @admin
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
                                    <option value="">-- Select a role --</option>
                                    @foreach ($roles as $role)
                                        <option {{ $role->id == old('role') ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
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
                                    <option value="">-- Select an organization --</option>
                                    @foreach ($organizations as $organization)
                                        <option {{ $organization->id == old('organization') ? 'selected' : '' }} value="{{ $organization->id }}">ID:{{ $organization->id}} - {{ $organization->name }}</option>
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
                                    <option value="">-- Select a division --</option>
                                    @foreach ($divisions as $division)
                                        <option {{ $division->id == old('division') ? 'selected' : '' }} value="{{ $division->id }}">ID:{{ $division->id}} - {{ $division->abbreviation }} ({{ $division->description }})</option>
                                    @endforeach
                                </select>

                                @error('division_id')
                                    <div class="text-red-500 mt-2 text-sm">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    @endadmin

                    <!-- DIVIDER -->
                    <div class="flex justify-center"><div class="w-4/5 my-6"></div></div>

                    <!-- Buttons -->
                    <div class="flex justify-end">
                        <!-- Cancel button -->
                        <a
                            @admin href="{{ route('admin') }}" @endadmin
                            @teamleader href="{{ route('leader') }}" @endteamleader
                            class="mr-2 bg-red-500 hover:bg-red-700 transition-colors duration-200 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline text-center">
                            Cancel
                        </a>
                        <!-- Create User button -->
                        <button
                            class="bg-indigo-500 hover:bg-indigo-700 transition-colors duration-200 text-white font-bold py-3 px-4 w-1/6 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                            Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
