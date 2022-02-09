@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <div class="p-6 text-gray-200">
                <h1 class="text-4xl font-semibold mb-1">Profiles</h1>
                <p>Manage profiles here</p>
            </div>

            <!-- Organization Details -->
            <div class=" bg-gray-100 p-6 rounded-lg mb-3">
                <h2 class="text-2xl font-medium mb-5">Your Organization Details</h2>

                <form action="">
                    <!-- Organization name -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="organization_name">
                                Organization Name
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="organization_name"
                                type="text"
                                placeholder="Organization Name"
                                value="">
                        </div>
                    </div>

                    <!-- Work email -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="work_email">
                                Work Email
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="work_email"
                                type="text"
                                placeholder="Work Email"
                                value="">
                        </div>
                    </div>

                    <!-- Work phone -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="work_phone">
                                Work Phone
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="work_phone"
                                type="text"
                                placeholder="Work Phone"
                                value="">
                        </div>
                    </div>

                    <!-- Work address -->
                    <div class="flex flex-wrap mb-4">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="work_address">
                                Work Address
                            </label>
                        </div>
                        <div class="w-2/3">
                            <textarea
                                cols=30
                                rows=4
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 focus:outline-none focus:shadow-outline"
                                id="work_address"
                                placeholder="Work Address"></textarea>
                        </div>
                    </div>

                    <!-- Update info button -->
                    <div class="flex justify-end">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="button">
                            Update Info
                        </button>
                    </div>
                </form>
            </div>

            <!-- Client Profiles -->
            <div class=" bg-gray-100 p-6 rounded-lg mb-3">
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
                                <th class="w-20 p-3 text-sm tracking-wide text-left">ID</th>
                                <th class="p-3 text-sm tracking-wide text-left">Name</th>
                                <th class="p-3 text-sm tracking-wide text-left">Email</th>
                                <th class="w-20 p-3 text-sm tracking-wide text-left">Edit</th>
                                <th class="w-20 p-3 text-sm tracking-wide text-left">Delete</th>
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
                        {{ $clients->links() }}
                    </div>
                </div>

                <!-- Add new client button -->
                <div class="flex justify-end">
                    <a
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button"
                        href="{{ route('profiles.create_client') }}">
                        Add Client
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
