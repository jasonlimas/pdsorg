@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <!-- Header -->
            <div class="p-6 text-gray-700">
                <h1 class="text-4xl font-semibold mb-1">Add a Sender Organization Details</h1>
                <p>Store a new sender organization details to the database</p>
            </div>

            <!-- Session Messages -->
            @if (session('status'))
                <div class="bg-green-500 p-4 rounded-lg mb-3 text-white text-center">
                    {{ session('status') }}
                </div>
            @endif

            <div class=" bg-indigo-600/10 p-6 rounded-lg mb-3">
                <!-- Client details form -->
                <form action="{{ route('admin.sender.create') }}" method="POST">
                    @csrf

                    <!-- Client details header -->
                    <h2 class="text-2xl font-medium mb-5">Sender Organization Details</h2>

                    <!-- Name -->
                    <div class="flex flex-wrap mb-2">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="name">
                                Name
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                required
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 leading-none focus:outline-none focus:shadow-outline
                                @error('name') border-red-500 @enderror"
                                name="name"
                                id="name"
                                type="text"
                                placeholder="Organization Name"
                                value="{{ old('name') }}">

                                @error('name')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Client address -->
                    <div class="flex flex-wrap mb-2">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="address">
                                Address
                            </label>
                        </div>
                        <div class="w-2/3">
                            <textarea
                                required
                                cols=30
                                rows=4
                                class="shadow appearance-none border rounded w-full p-3 text-gray-700 focus:outline-none focus:shadow-outline
                                @error('address') border-red-500 @enderror"
                                name="address"
                                id="address"
                                placeholder="Organization Address">{{ old('address') }}</textarea>

                            @error('address')
                                <div class="text-red-500 mt-2 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Logo -->
                    <div class="flex flex-wrap mb-2">
                        <div class="w-1/3 align-middle">
                            <label class="text-md p-3 inline-block align-middle" for="logo">
                                Logo
                            </label>
                        </div>
                        <div class="w-2/3">
                            <input
                                required
                                name="logo"
                                id="logo">
                            <p class="text-sm">Accepted file types: PNG, JPEG, JPG</p>
                        </div>
                    </div>

                    <!-- Sender Organization Bank Details header -->
                    <h2 class="text-2xl font-medium mb-5">Bank Account Details</h2>

                    <!-- Input component -->
                    @livewire('sender-bank-details')

                    <!-- Add sender button -->
                    <div class="flex justify-end">
                        <!-- Cancel button -->
                        <a href="{{ route('admin') }}"
                            class="mr-2 bg-red-500 hover:bg-red-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cancel
                        </a>
                        <button
                            class="bg-indigo-500 hover:bg-indigo-700 transition-colors duration-200 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                            Add Details
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @section('scripts')
        <script>
            // Register the plugin
            FilePond.registerPlugin(FilePondPluginFileValidateType);

            const inputElement = document.querySelector('input[id="logo"]');
            const pond = FilePond.create(inputElement, {
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
            });
            FilePond.setOptions({
                server: {
                    url: '/admin/sender/create/upload',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            });
        </script>
        @endsection
    </div>
@endsection
