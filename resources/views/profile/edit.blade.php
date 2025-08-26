@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Profile Information -->
    <div class="p-6 bg-white rounded-xl shadow dark:bg-gray-800">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Update Profile Information</h2>
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name', $user->name) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm
                              focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 
                              dark:border-gray-600 dark:placeholder-gray-400 dark:text-white sm:text-sm">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email', $user->email) }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm
                              focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 
                              dark:border-gray-600 dark:placeholder-gray-400 dark:text-white sm:text-sm">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 
                               focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                    Save
                </button>
            </div>
        </form>
    </div>

    <!-- Update Password -->
    <div class="p-6 bg-white rounded-xl shadow dark:bg-gray-800">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Update Password</h2>
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Current Password</label>
                <input type="password" id="current_password" name="current_password"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm
                              focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 
                              dark:border-gray-600 dark:placeholder-gray-400 dark:text-white sm:text-sm">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Password</label>
                <input type="password" id="password" name="password"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm
                              focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 
                              dark:border-gray-600 dark:placeholder-gray-400 dark:text-white sm:text-sm">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm
                              focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 
                              dark:border-gray-600 dark:placeholder-gray-400 dark:text-white sm:text-sm">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 
                               focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                    Update Password
                </button>
            </div>
        </form>
    </div>

    <!-- Delete Account -->
    <div class="p-6 bg-white rounded-xl shadow dark:bg-gray-800">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Delete Account</h2>
        <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            Once your account is deleted, all of its resources and data will be permanently deleted.
        </p>
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <button type="submit"
                    onclick="return confirm('Are you sure you want to delete your account?')"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 
                           focus:ring-4 focus:ring-red-300 dark:focus:ring-red-800">
                Delete Account
            </button>
        </form>
    </div>
</div>
@endsection
