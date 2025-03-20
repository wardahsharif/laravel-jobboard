<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Website')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
</head>
<body>
   <!-- Check if user is logged in -->
   @auth
   <x-navbar /> <!-- Dashboard Navigation -->
@else
   <x-guest-navbar /> <!-- Show Guest Navigation as a Blade component -->
@endauth


    <!-- Page Content -->
    <div class="min-h-screen bg-gray-100">
        <main>
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
