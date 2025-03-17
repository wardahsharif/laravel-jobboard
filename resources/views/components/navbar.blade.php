<nav class="bg-gray-800 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ route('dashboard') }}" class="text-lg font-semibold">My App</a>

        <ul class="flex space-x-4">
            <li>
                <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="hover:underline">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
