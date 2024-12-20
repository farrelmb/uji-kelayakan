<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <title>Laravel App</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<nav class="p-4" style="background-color: green;">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <!-- Mobile menu button-->
            </div>
            <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                <a href="#" class="text-white font-bold text-xl">Pengaduan</a>
            </div>
            <div class="flex items-center">
                @if (Auth::check())
                    <div class="relative">
                        <button class="text-black bg-white    p-2 rounded-md focus:outline-none" id="userMenuButton" aria-expanded="false" aria-haspopup="true">
                           {{ Auth::user()->email }}   <i class="fas fa-user pl-2"> </i>
                        </button>
                        <div class="absolute right-0 mt-2 w-44 bg-white border rounded-md shadow-lg z-10 hidden" id="userMenu">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                @endif
            </div>
        </div>
    </div>
</nav>

<!-- Content -->
<div class="min-h-screen bg-gray-100">
    @yield('content')
</div>


<div class="absolute top-1/2 right-10 transform -translate-y-1/2 space-y-4 z-20 mt-8">
    @if (auth()->user()->role != 'HEAD_STAFF')
    <a href="{{ auth()->check() ? route('report.create') : route('login') }}"
        class="flex items-center justify-center w-16 h-16 text-white bg-teal-600 hover:bg-teal-700 rounded-full shadow-lg">
        <i class="fa fa-plus" aria-hidden="true"></i>
        @else
        <i class="fa-solid fa-square-poll-vertical"></i>
    </a>
    @endif

    <a href="{{ route(auth()->user()->role == 'HEAD_STAFF' ? 'user' : 'article') }}"
        class="flex items-center justify-center w-16 h-16 text-white bg-teal-600 hover:bg-teal-700 rounded-full shadow-lg">
       @if (auth()->user()->role != 'HEAD_STAFF')
       <i class="fa fa-newspaper" aria-hidden="true"></i>
       @else
       <i class="fas fa-users"></i>
       @endif
    </a>

    {{-- @if (auth()->user()->role != 'HEAD_STAFF')
    <a href="{{ route('index.reports.me') }}"
        class="flex items-center justify-center w-16 h-16 text-white bg-teal-600 hover:bg-teal-700 rounded-full shadow-lg">
        <i class="fa fa-list" aria-hidden="true"></i>
    </a>
    @endif --}}
    <a href="{{ route(auth()->user()->role == 'HEAD_STAFF' ? 'head.staff' : 'index.reports.me') }}"
        class="flex items-center justify-center w-16 h-16 text-white bg-teal-600 hover:bg-teal-700 rounded-full shadow-lg">
       @if (auth()->user()->role != 'HEAD_STAFF')
       <i class="fa fa-list" aria-hidden="true"></i>
       @else
       <i class="fas fa-chart-bar"></i>
       @endif
    </a>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userMenuButton = document.getElementById('userMenuButton');
        const userMenu = document.getElementById('userMenu');

        userMenuButton.addEventListener('click', function () {
            userMenu.classList.toggle('hidden');
        });

        window.addEventListener('click', function (event) {
            if (!userMenu.contains(event.target) && !userMenuButton.contains(event.target)) {
                userMenu.classList.add('hidden');
            }
        });
    });
</script>



</body>
</html>
