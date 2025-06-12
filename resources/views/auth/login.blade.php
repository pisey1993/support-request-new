@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="flex justify-center mt-20 px-4">
        <div class="w-full max-w-md">
            <h2 class="text-2xl font-semibold mb-6 text-gray-900">Login</h2>

            @if(session('error'))
                <div class="mb-4 px-4 py-3 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block mb-1 font-medium text-gray-700">Name</label>
                    <input id="name" name="name" type="text" required autofocus
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500" />
                </div>

                <div>
                    <label for="password" class="block mb-1 font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500" />
                </div>

                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded" />
                    <label for="remember" class="ml-2 block text-gray-700">Remember Me</label>
                </div>

                <button type="submit"
                        class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 rounded-md shadow-sm transition duration-150">
                    Login
                </button>
            </form>
        </div>
    </div>
@endsection
