@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Add New Staff</h2>

        <form action="{{ route('admin.staff.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300" required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full border rounded px-3 py-2 focus:ring focus:ring-blue-300" required>
            </div>

            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded 
           hover:bg-blue-700 
           dark:bg-blue-500 dark:hover:bg-blue-400">
                Create Staff
            </button>

        </form>
    </div>
@endsection
