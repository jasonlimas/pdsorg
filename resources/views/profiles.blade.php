@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <!-- Main header -->
            <div class="p-6 text-gray-700 ">
                <h1 class="text-4xl font-semibold mb-1">Profiles</h1>
                <p>Manage profiles here</p>
            </div>
            <!-- Session Messages -->
            @if (session('status'))
                <div class="bg-green-500 p-4 rounded-lg mb-3 text-white text-center">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Your Details (Currently logged in user's details) -->
            <div class="bg-gray-100 p-6 rounded-lg mb-3 shadow-lg">
                <h2 class="text-2xl font-medium">Your Details</h2>
                <p class="text-gray-600 mb-5">
                    Your details. Will be shown in the generated quotes as part of sender
                </p>

                <form action="{{ route('profiles.update', auth()->user()) }}" method="POST">
                    @csrf
                    <!-- Name -->
                    <div class="flex flex-wrap mb-2">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="name">
                                Your Name
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('name') border-red-500 @enderror"
                                name="name"
                                id="name"
                                type="text"
                                placeholder="Your Name"
                                value="{{ $user->name }}">

                                @error('name')
                                    <div class="text-red-500 mt-2 text-sm">
                                        {{ $message }}
                                    </div>
                                @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex flex-wrap mb-2">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="email">
                                Your Work Email
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('email') border-red-500 @enderror"
                                name="email"
                                id="email"
                                type="text"
                                placeholder="Work Email"
                                value="{{ $user->email }}">

                            @error('email')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="phone">
                                Your Work Phone
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('phone') border-red-500 @enderror"
                                name="phone"
                                id="phone"
                                type="text"
                                placeholder="Work Phone"
                                value="{{ $user->phone }}">

                            @error('phone')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Save button -->
                    <div class="flex justify-end">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                            Save Info
                        </button>
                    </div>
                </form>

            </div>

            <!-- Organization Details -->
            <div class=" bg-gray-100 p-6 rounded-lg mb-3 shadow-lg">
                <!-- Header -->
                <h2 class="text-2xl font-medium">Your Organization Details</h2>
                <p class="text-gray-600 mb-5">
                    Your organization. Will be displayed in generated quotes as part of sender
                </p>

                <!-- Table -->
                <div class="overflow-auto rounded-lg shadow mb-4">
                    <table class="w-full">
                        <!-- Table Headers -->
                        <thead class="bg-gray-50 border-b-2 border-gray-300">
                            <tr>
                                <th class="w-20 p-3 text-sm tracking-wide text-left">ID</th>
                                <th class="p-3 text-sm tracking-wide text-left">Name</th>
                                <th class="w-20 p-3 text-sm tracking-wide text-left">Edit</th>
                                <th class="w-20 p-3 text-sm tracking-wide text-left">Delete</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="divide-y divide-gray-100">
                            <!-- Add a new row for every sender organization details stored in the database -->
                            @foreach ($senders as $sender)
                                <x-sender :sender="$sender" />
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination links -->
                    <div class="p-2 bg-gray-50 border-t-2 border-gray-100">
                        {{ $senders->appends(['clients' => $clients->currentPage()])->links() }}
                    </div>
                </div>

                <!-- Add Details button -->
                <div class="flex justify-end">
                    <a
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button"
                        href="{{ route('profiles.sender.create') }}">
                        Add Details
                    </a>
                </div>
            </div>

            <!-- Client Profiles -->
            <div class=" bg-gray-100 p-6 rounded-lg mb-3 shadow-lg">
                <!-- Client profiles header -->
                <h2 class="text-2xl font-medium">Client Profiles</h2>
                <p class="text-gray-600 mb-5">
                    List of clients here, or add a new one by clicking the button below
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
                            <!-- Add a new row for every client stored in the database -->
                            @foreach ($clients as $client)
                                <x-client :client="$client" />
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination links -->
                    <div class="p-2 bg-gray-50 border-t-2 border-gray-100">
                        {{ $clients->appends(['senders' => $senders->currentPage()])->links() }}
                    </div>
                </div>

                <!-- Add new client button -->
                <div class="flex justify-end">
                    <a
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button"
                        href="{{ route('profiles.client.create') }}">
                        Add Client
                    </a>
                </div>
            </div>

            <!-- Terms & Conditions Presets -->
            <div class=" bg-gray-100 p-6 rounded-lg mb-3 shadow-lg">
                <!-- Terms & Conditions Presets header -->
                <h2 class="text-2xl font-medium">Terms & Conditions Presets</h2>
                <p class="text-gray-600 mb-5">
                    List of Terms & Conditions presets. Click Add Preset button to add a new one
                </p>

                <!-- Table -->
                <div class="overflow-auto rounded-lg shadow mb-4">
                    <table class="w-full">
                        <!-- Table Headers -->
                        <thead class="bg-gray-50 border-b-2 border-gray-300">
                            <tr>
                                <th class="w-1/12 p-3 text-sm tracking-wide text-left">ID</th>
                                <th class="w-9/12 p-3 text-sm tracking-wide text-left">Name</th>
                                <th class="w-1/12 p-3 text-sm tracking-wide text-left">Edit</th>
                                <th class="w-1/12 p-3 text-sm tracking-wide text-left">Delete</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody class="divide-y divide-gray-100">
                            <!-- Add a new row for every Terms & Conditions preset stored in the database -->
                            @foreach ($terms as $term)
                                <x-term :term="$term" />
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination links -->
                    <div class="p-2 bg-gray-50 border-t-2 border-gray-100">
                        {{-- {{ $terms->appends(['clients' => $clients->currentPage()])->links() }} --}}
                    </div>
                </div>

                <!-- Add Preset button -->
                <div class="flex justify-end">
                    <a
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button"
                        href="{{ route('profiles.terms.create') }}">
                        Add Preset
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
