


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
    <header class="bg-slate-800 shadow-lg"> 
        <nav>

           
    <a href='{{route('home')}}' class="nav-link text-4xl">Home</a>

    @auth
 <div class="relative grid place-items-center">
{{--Dropdown menu button--}}


 </div>
    @endauth


    @guest
      <div class="flex items-center gap-4">
      <a href='{{ route('login')}}' class="nav-link">Login</a>
      <a href='{{route('register')}}'class="nav-link">Register</a>
    </div>
    @endguest

        </nav>
    </header>

    <main class="py-8 px-4 mx-auto max-w-screen-lg">
        {{$slot}}
    </main>
</body>
</html>