<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paradisestore.org</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @livewireStyles
</head>
<body class="bg-sky-900">
    <!-- Header -->
    <nav class="p-6 bg-sky-700 flex justify-between mb-6">
        <!-- Left header -->
        <ul class="flex items-center text-cyan-200">
            <li>
                <a href="/" class="p-3 font-semibold">Home</a>
            </li>
            <li>
                <a href="" class="p-3 font-semibold border-l border-sky-900">Quotation List</a>
            </li>
            <li>
                <a href="{{ route('quotes.create') }}" class="p-3 font-semibold border-l border-sky-900">Create Quotation</a>
            </li>
            <li>
                <a href="{{ route('profiles') }}" class="p-3 font-semibold border-l border-sky-900">Profiles</a>
            </li>
        </ul>

        <!-- Right header -->
        <ul class="flex items-center text-cyan-200">
            <!-- If the user is not logged in, show Login button -->
            @guest
                <li>
                    <a href="{{ route('login') }}" class="p-3 font-bold text-lime-400">Login</a>
                </li>
            @endguest

            <!-- If the user is logged in, show Logout button -->
            @auth
                <li>
                    <a class="p-3 font-semibold">Logged in as: {{ auth()->user()->name }}</a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="p-3 inline border-l border-sky-900">
                        @csrf
                        <button type="submit" class="font-bold text-red-400">Logout</button>
                    </form>
                </li>
            @endauth
        </ul>
    </nav>

    <!-- Display section -->
    @yield('content')

    @livewireScripts
</body>
</html>
