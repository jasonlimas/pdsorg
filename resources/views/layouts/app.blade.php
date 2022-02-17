<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paradisestore.org</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/7f8b46f267.js" crossorigin="anonymous"></script>
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
                    <a href="{{ route('quotes') }}" class="text-base font-medium text-gray-500 hover:text-gray-900"> Quote List </a>
                    <a href="{{ route('quotes.create') }}" class="text-base font-medium text-gray-500 hover:text-gray-900"> Create Quote </a>
                    <a href="{{ route('profiles') }}" class="text-base font-medium text-gray-500 hover:text-gray-900"> Profiles </a>
                    @admin
                        <a href="{{ route('admin') }}" class="text-base font-medium text-rose-500 hover:text-rose-900"> Admin Panel </a>
                    @endadmin

                </nav>

                <div class="md:flex items-center justify-end md:flex-1 lg:w-0">
                    @guest
                        <form action="{{ route('login') }}" method="GET">
                            @csrf
                            <button type="submit" class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700"> Sign in </button>
                        </form>
                    @endguest

                    @auth
                        <a class="text-gray-500 font-semibold">{{ auth()->user()->name }}</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-red-600 hover:bg-red-700"> Sign out </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Content section -->
    @yield('content')

    @livewireScripts
</body>
</html>
