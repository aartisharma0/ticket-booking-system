<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket Booking System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100 text-gray-800">
    @include('layouts.header')

    <main class="container mx-auto py-6">
        @yield('content')
    </main>

    @include('layouts.footer')
</body>
</html>