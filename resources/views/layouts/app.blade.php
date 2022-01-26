<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paradisestore.org</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-sky-600">
    <!-- Header -->
    <nav class="p-6 bg-white flex justify-between mb-6">
        <!-- Left header -->
        <ul class="flex items-center">
            <li>
                <a href="/" class="p-4 font-bold">Home</a>
            </li>
            <li>
                <a href="" class="p-4 font-bold border-l border-black">Quotation List</a>
            </li>
            <li>
                <a href="" class="p-4 font-bold border-l border-black">Create Quotation</a>
            </li>
        </ul>

        <!-- Right header -->
        <ul class="flex items-center">
            <!-- If the user is not logged in, show Login button -->
            @guest
                <li>
                    <a href="" class="p-4 font-bold text-blue-500">Login</a>
                </li>
            @endguest

            <!-- If the user is logged in, show Logout button -->
            @auth
                <li>
                    <a href="" class="p-4 font-bold text-rose-500">Logged in as: NAME</a>
                </li>
                <li>
                    <a href="" class="p-4 border-l font-bold text-rose-500">Logout</a>
                </li>
            @endauth
        </ul>
    </nav>

    <!-- Display section -->
    @yield('content')
</body>
</html>
