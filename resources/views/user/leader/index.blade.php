@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <!-- Main header -->
            <div class="p-6 text-gray-700">
                <h1 class="text-4xl font-semibold mb-1">Leader Panel</h1>
                <p>Manage users in your division here</p>
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
                    Manage registered users here. Click the <a class="font-semibold">Add User</a> button to register a new user.
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
                        {{ $users->links() }}
                    </div>
                </div>

                <p class="text-red-600 text-sm">You can only manage users from your division and add users to your division.</p>

                <!-- Add new user button -->
                <div class="flex justify-end">
                    <a
                        class="w-1/6 bg-indigo-500 hover:bg-indigo-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center"
                        type="button"
                        href="{{ route('leader.user.create') }}">
                        Add User
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
