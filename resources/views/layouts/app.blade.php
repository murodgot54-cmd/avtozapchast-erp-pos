<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AVTOZAPCHAST ERP')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen bg-gray-900">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white">
            <div class="p-6 border-b border-gray-700">
                <h1 class="text-2xl font-bold">
                    <i class="fas fa-car-side mr-2"></i>AVTOZAPCHAST
                </h1>
            </div>
            <nav class="p-6 space-y-2">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                    <i class="fas fa-dashboard mr-2"></i>Dashboard
                </a>
                <a href="{{ route('products.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                    <i class="fas fa-box mr-2"></i>Mahsulotlar
                </a>
                <a href="{{ route('customers.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                    <i class="fas fa-users mr-2"></i>Mijozlar
                </a>
                <a href="{{ route('pos.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                    <i class="fas fa-cash-register mr-2"></i>POS
                </a>
                <hr class="my-4 border-gray-700">
                <a href="{{ route('auth.profile') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                    <i class="fas fa-user mr-2"></i>Profil
                </a>
                <form method="POST" action="{{ route('auth.logout') }}" class="inline-block w-full">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 rounded hover:bg-gray-700">
                        <i class="fas fa-sign-out-alt mr-2"></i>Chiqish
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <div class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">@yield('header')</h2>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">{{ auth()->user()->name }}</span>
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ auth()->user()->id }}" 
                         alt="User" class="w-10 h-10 rounded-full">
                </div>
            </div>

            <!-- Content Area -->
            <div class="flex-1 overflow-auto p-8">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <i class="fas fa-exclamation-circle mr-2"></i>Xata:
                        <ul class="mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
