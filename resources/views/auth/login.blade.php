@extends('layouts.app')

@section('title', 'Login')

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AVTOZAPCHAST ERP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-600 to-blue-800">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-2xl p-8">
                <div class="text-center mb-8">
                    <i class="fas fa-car-side text-4xl text-blue-600 mb-4"></i>
                    <h1 class="text-3xl font-bold text-gray-800">AVTOZAPCHAST</h1>
                    <p class="text-gray-500 mt-2">ERP + POS Tizimi</p>
                </div>

                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('auth.login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-envelope mr-2"></i>Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-lock mr-2"></i>Parol
                        </label>
                        <input type="password" name="password" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="rounded">
                        <label for="remember" class="ml-2 text-gray-600">Eslab qolish</label>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                        <i class="fas fa-sign-in-alt mr-2"></i>Kirish
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
