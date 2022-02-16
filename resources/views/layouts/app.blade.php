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
    <!-- Header -->
    <nav class="py-2 px-3 bg-sky-500 flex justify-between mb-4">
        <!-- Left header -->
        <ul class="flex items-center text-black">
            <li>
                <a href="/" class="px-3 py-1 rounded-tl rounded-bl hover:bg-sky-600 font-semibold">Home</a>
            </li>
            <li>
                <a href="{{ route('quotes') }}" class="px-3 py-1 hover:bg-sky-600 font-semibold">Quotation List</a>
            </li>
            <li>
                <a href="{{ route('quotes.create') }}" class="px-3 py-1 hover:bg-sky-600 font-semibold">Create Quotation</a>
            </li>
            <li>
                <a href="{{ route('profiles') }}" class="px-3 py-1 rounded-tr rounded-br hover:bg-sky-600 font-semibold">Profiles</a>
            </li>
        </ul>

        <!-- Right header -->
        <ul class="flex items-center text-black">
            <!-- If the user is not logged in, show Login button -->
            @guest
                <li>
                    <form action="{{ route('login') }}" method="GET" class="mr-2 inline">
                        @csrf
                        <button type="submit" class="shadow font-semibold rounded py-1 px-4 text-white bg-green-500 hover:bg-emerald-600">Login</button>
                    </form>
                </li>
            @endguest

            <!-- If the user is logged in, show Logout button -->
            @auth
                <li>
                    <a class="px-5 py-1 font-semibold">Logged in as: {{ auth()->user()->name }}</a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="mr-2 inline">
                        @csrf
                        <button type="submit" class="shadow font-semibold rounded py-1 px-4 text-white bg-red-500 hover:bg-red-700">Logout</button>
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
