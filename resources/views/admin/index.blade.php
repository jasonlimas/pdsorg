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
            <!-- Client Profiles -->
            <div class=" bg-indigo-500/10 p-6 rounded-lg mb-3 shadow-lg">
                <!-- Client profiles header -->
                <h2 class="text-2xl font-medium">Registered Users</h2>
                <p class="text-gray-600 mb-5">
                    Manage registered users here. Click the <a class="font-semibold">Add User</a> button to register a new user
                </p>

                <!-- Table -->
                <div class="overflow-auto rounded-lg shadow mb-4">
                    <table class="w-full">
                        <!-- Table Headers -->
                        <thead class="bg-gray-50 border-b-2 border-gray-300">
                            <tr>
                                <th class="w-1/12 p-3 text-sm tracking-wide text-left">ID</th>
                                <th class="w-3/12 p-3 text-sm tracking-wide text-left">Name</th>
                                <th class="w-3/12 p-3 text-sm tracking-wide text-left">Email</th>
                                <th class="p-3/12 p-3 text-sm tracking-wide text-left">Phone</th>
                                <th class="w-1/12 p-3 text-sm tracking-wide text-left">Edit</th>
                                <th class="w-1/12 p-3 text-sm tracking-wide text-left">Delete</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="divide-y divide-gray-100">
                            <!-- Add a new row for every user stored in the database -->
                            @foreach ($users as $user)
                                <x-user :user="$user" />
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination links -->
                    <div class="p-2 bg-gray-50 border-t-2 border-gray-100">
                        {{ $users->appends([])->links() }}
                    </div>
                </div>

                <!-- Add new client button -->
                <div class="flex justify-end">
                    <a
                        class="w-1/6 bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center"
                        type="button"
                        href="{{ route('admin.users.create') }}">
                        Add User
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
