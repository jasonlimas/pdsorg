@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <!-- Main header -->
            <div class="p-6 text-gray-700">
                <h1 class="text-4xl font-semibold mb-1">Admin Panel</h1>
                <p>Manage users, organisation details and define divisions here</p>
            </div>
            <!-- Success Messages -->
            @if (session('success'))
                <div class="bg-green-500 p-4 rounded-lg mb-3 text-white text-center">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Users Section -->
            <div class=" bg-indigo-600/10 p-6 rounded-lg mb-3 shadow-lg">
                <!-- Users header -->
                <h2 class="text-2xl font-medium">Registered Users</h2>
                <p class="text-gray-600 mb-5">
                    Manage registered users here. Click the <a class="font-semibold">Add User</a> button to register a new
                    user
                </p>

                <!-- Table -->
                <div class="overflow-auto rounded-lg shadow mb-4">
                    <table>
                        <!-- Table Headers -->
                        <thead class="bg-gray-200 border-b-2 border-gray-300">
                            <tr>
                                <th class="w-10 p-3 text-sm tracking-wide text-left">ID</th>
                                <th class="w-40 p-3 text-sm tracking-wide text-left">Name</th>
                                <th class="w-52 p-3 text-sm tracking-wide text-left">Email</th>
                                <th class="w-24 p-3 text-sm tracking-wide text-left">Phone</th>
                                <th class="w-20 p-3 text-sm tracking-wide text-left">Action</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="divide-y divide-gray-200">
                            <!-- Add a new row for every user stored in the database -->
                            @foreach ($users as $user)
                                <x-user :user="$user" />
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination links -->
                    <div class="p-2 bg-gray-50 border-t-2 border-gray-100">
                        {{ $users->appends(['senders' => $senders->currentPage(), 'divisions' => $divisions->currentPage()])->links() }}
                    </div>
                </div>

                <!-- Add new user button -->
                <div class="flex justify-end">
                    <a class="w-1/6 bg-indigo-500 hover:bg-indigo-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center"
                        type="button" href="{{ route('admin.user.create') }}">
                        Add User
                    </a>
                </div>
            </div>

            <!-- Organization Details & Divisions Section -->
            <div class=" bg-indigo-600/10 p-6 rounded-lg mb-3 shadow-lg space-y-4">
                <!-- Sender Organization -->
                <div>
                    <!-- Organization Details header -->
                    <h2 class="text-2xl font-medium">Organization Profiles</h2>
                    <p class="text-gray-600 mb-5">
                        Manage organization profiles. You can add and edit profiles here.
                    </p>

                    <!-- Table -->
                    <div class="overflow-auto rounded-lg shadow mb-4">
                        <table>
                            <!-- Table Headers -->
                            <thead class="bg-gray-200 border-b-2 border-gray-300">
                                <tr>
                                    <th class="w-10 p-3 text-sm tracking-wide text-left">ID</th>
                                    <th class="w-24 p-3 text-sm tracking-wide text-left">Name</th>
                                    <th class="w-96 p-3 text-sm tracking-wide text-left">Address</th>
                                    <th class="w-20 p-3 text-sm tracking-wide text-left">Action</th>
                                </tr>
                            </thead>

                            <!-- Table Body -->
                            <tbody class="divide-y divide-gray-200">
                                <!-- Add a new row for every sender organization stored in the database -->
                                @foreach ($senders as $sender)
                                    <x-sender :sender="$sender" />
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination links -->
                        <div class="p-2 bg-gray-50 border-t-2 border-gray-100">
                            {{ $senders->appends(['users' => $users->currentPage(), 'divisions' => $divisions->currentPage()])->links() }}
                        </div>
                    </div>

                    <!-- Add new organization button -->
                    <div class="flex justify-end">
                        <a class="w-1/6 bg-indigo-500 hover:bg-indigo-700 text-white transition-colors duration-200 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center"
                            type="button" href="{{ route('admin.sender.create') }}">
                            Add Organization
                        </a>
                    </div>
                </div>

                <!-- Division -->
                <div>
                    <!-- Division Details header -->
                    <h2 class="text-2xl font-medium">Divisions</h2>
                    <p class="text-gray-600 mb-5">
                        Manage divisions. You can add and edit divisions here.
                    </p>

                    <!-- Table -->
                    <div class="overflow-auto rounded-lg shadow mb-4">
                        <table>
                            <!-- Table Headers -->
                            <thead class="bg-gray-200 border-b-2 border-gray-300">
                                <tr>
                                    <th class="w-10 p-3 text-sm tracking-wide text-left">ID</th>
                                    <th class="w-24 p-3 text-sm tracking-wide text-left">Abbreviation</th>
                                    <th class="w-96 p-3 text-sm tracking-wide text-left">Description</th>
                                    <th class="w-20 p-3 text-sm tracking-wide text-left">Action</th>
                                </tr>
                            </thead>

                            <!-- Table Body -->
                            <tbody class="divide-y divide-gray-200">
                                <!-- Add a new row for every division stored in the database -->
                                @foreach ($divisions as $division)
                                    <x-division :division="$division" />
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination links -->
                        <div class="p-2 bg-gray-50 border-t-2 border-gray-100">
                            {{ $divisions->appends(['users' => $users->currentPage(), 'senders' => $senders->currentPage()])->links() }}
                        </div>
                    </div>

                    <!-- Add new division button -->
                    <div class="flex justify-end">
                        <a class="w-1/6 bg-indigo-500 hover:bg-indigo-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center"
                            type="button" href="{{ route('admin.division.create') }}">
                            Add Division
                        </a>
                    </div>
                </div>
            </div>

            <!-- Client Profiles Section -->
            <div class=" bg-indigo-600/10 p-6 rounded-lg mb-3 shadow-lg">
                <!-- Client Profiles header -->
                <h2 class="text-2xl font-medium">Client Profiles</h2>
                <p class="text-gray-600 mb-5">
                    Manage client details
                </p>

                <!-- Tell the user to go to profiles page to edit clients -->
                <h2 class="text-lg font-medium text-center">
                    Go to <a class="text-blue-600 no-underline hover:underline" href="{{ route('profiles') }}">Profiles
                        page</a> to edit or add clients
                </h2>
            </div>

            <!-- More Settings Section -->
            <div class=" bg-indigo-600/10 p-6 rounded-lg mb-3 shadow-lg">
                <!-- More settings header -->
                <h2 class="text-2xl font-medium">More Settings</h2>
                <p class="text-gray-600 mb-5">
                    More settings for the application such as changing the tax
                </p>

                <form action="{{ route('admin.settings') }}" method="POST">
                    @csrf
                    <!-- Tax -->
                    <div class="flex flex-wrap mb-2">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="tax">
                                Tax
                            </label>
                        </div>
                        <div class="w-2/3 mb-2">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('tax') border-red-500 @enderror"
                                name="tax" type="number" placeholder="Tax" value="{{ $tax }}" min=0 max=100>

                            @error('tax')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Save setting button -->
                    <div class="flex justify-end">
                        <button
                            class="w-1/6 bg-indigo-500 hover:bg-indigo-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center"
                            type="submit">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
