<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paradisestore.org</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/7f8b46f267.js" crossorigin="anonymous"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    @livewireStyles
</head>
<body class="bg-slate-200">
    <!-- Header section -->
    <div class="sticky top-0 bg-white mb-4 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex justify-between items-center border-gray-100 py-4 md:justify-start md:space-x-10">
                <div class="flex justify-start lg:w-0 lg:flex-1">
                    <a href="/">
                        <span class="sr-only">XDC Indonesia</span>
                        <img class="h-12 w-auto" src="https://xdc-indonesia.com/wp-content/uploads/2020/10/logo.png" alt="">
                    </a>
                </div>
                <nav class="md:flex space-x-10">

                    <!-- Links -->
                    <div class="relative inline-block text-left" x-data="{ isOpen: false }" @mouseleave="isOpen = false">
                        <a
                            @mouseover="isOpen = true"
                            href="{{ route('quotes') }}"
                            class="text-base font-medium text-gray-500 hover:text-gray-900 transition-colors duration-200">
                            Quote
                            <svg class="-mr-1 ml-0.5 h-5 w-5 inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <!-- Dropdown content -->
                        <div class="absolute left-0 right-0 w-52 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" x-show="isOpen">
                            <a href="{{ route('quotes') }}" class="rounded-tr-md rounded-tl-md block py-3 px-5 text-base font-medium bg-white text-gray-500 hover:text-gray-900 hover:bg-gray-200 transition-colors duration-200"> Quote List </a>
                            <a href="{{ route('quotes.create') }}" class="rounded-br-md rounded-bl-md block py-3 px-5 text-base font-medium bg-white text-gray-500 hover:text-gray-900 hover:bg-gray-200 transition-colors duration-200"> Quote Create </a>
                        </div>
                    </div>
                    <a href="{{ route('profiles') }}" class="text-base font-medium text-gray-500 hover:text-gray-900 transition-colors duration-200"> Profiles </a>
                    @admin
                        <a href="{{ route('admin') }}" class="text-base font-medium text-rose-500 hover:text-rose-900 transition-colors duration-200"> Admin Panel </a>
                    @endadmin
                    @teamleader
                        <a href="{{ route('leader') }}" class="text-base font-medium text-rose-500 hover:text-rose-900 transition-colors duration-200"> Leader Panel </a>
                    @endteamleader

                </nav>

                <div class="md:flex items-center justify-end md:flex-1 lg:w-0">
                    @guest
                        <form action="{{ route('login') }}" method="GET">
                            @csrf
                            <button
                                type="submit"
                                class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transition-colors duration-200">
                                 Sign in </button>
                        </form>
                    @endguest

                    @auth
                        <p>User: <a class="font-semibold">{{ auth()->user()->name }}</a></p>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-red-600 hover:bg-red-700 transition-colors duration-200">
                                 Sign out </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Content section -->
    @yield('content')

    @livewireScripts
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    @yield('scripts')
</body>
</html>
