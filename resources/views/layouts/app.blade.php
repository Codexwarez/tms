<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TMS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body class="bg-gray-50 text-gray-900">
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <nav
            class="bg-white border-b border-gray-200 px-4 py-2.5 dark:bg-gray-800 dark:border-gray-700 fixed left-0 right-0 top-0 z-50">
            <div class="flex flex-wrap justify-between items-center">
                <div class="flex justify-start items-center">
                    <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                        aria-controls="drawer-navigation"
                        class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <svg aria-hidden="true" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Toggle sidebar</span>
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex items-center justify-between mr-4">
                        {{-- <img src="https://flowbite.s3.amazonaws.com/logo.svg" class="mr-3 h-8" alt="Flowbite Logo" /> --}}
                        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">TMS</span>
                    </a>

                </div>
                <div class="flex items-center lg:order-2">
                    <button type="button" data-dropdown-toggle="notification-dropdown"
                        class="relative p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                        <span class="sr-only">View notifications</span>

                        <!-- Bell icon -->
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                            </path>
                        </svg>

                        @php $unread = auth()->user()->unreadNotifications()->count(); @endphp
                        @if ($unread)
                            <span
                                class="absolute -top-1 -right-1 inline-flex items-center justify-center 
                   px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                                {{ $unread }}
                            </span>
                        @endif
                    </button>

                    <!-- Dropdown menu -->
                    <div class="hidden overflow-hidden z-50 my-4 max-w-sm text-base list-none bg-white rounded divide-y divide-gray-100 shadow-lg dark:divide-gray-600 dark:bg-gray-700 rounded-xl"
                        id="notification-dropdown">
                        <div
                            class="block py-2 px-4 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-600 dark:text-gray-300">
                            Notifications
                        </div>
                        <div id="notifications">
                            @forelse(auth()->user()->notifications()->latest()->limit(5)->get() as $notif)
                                <a href="#"
                                    class="flex py-3 px-4 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                                    <div class="flex-shrink-0">
                                        <!-- Placeholder avatar -->
                                        <img class="w-11 h-11 rounded-full"
                                            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}"
                                            alt="avatar" />
                                    </div>
                                    <div class="pl-3 w-full">
                                        <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                            {{ $notif->data['message'] ?? 'Notification' }}
                                        </div>
                                        <div class="text-xs font-medium text-primary-600 dark:text-primary-500">
                                            {{ $notif->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="p-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No new notifications
                                </div>
                            @endforelse
                        </div>

                        <a href="{{ route('notifications.index') }}"
                            class="block py-2 text-md font-medium text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-600 dark:text-white dark:hover:underline">
                            <div class="inline-flex items-center">
                                <svg aria-hidden="true" class="mr-2 w-4 h-4 text-gray-500 dark:text-gray-400"
                                    fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                View all
                            </div>
                        </a>

                    </div>

                    <!-- User Dropdown Component -->
                    <div class="relative ml-3">
                        <button type="button"
                            class="flex text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full"
                                src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/michael-gough.png"
                                alt="user photo" />
                        </button>
                        <div class="hidden z-50 my-4 w-56 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600 rounded-xl"
                            id="dropdown">
                            <div class="py-3 px-4">
                                <span
                                    class="block text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</span>
                                <span
                                    class="block text-sm text-gray-900 truncate dark:text-white">{{ auth()->user()->email }}</span>
                            </div>
                            <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="dropdown">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button
                                            class="block w-full text-left py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                            Sign out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </nav>

        <!-- Sidebar -->

        <aside
            class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full 
           bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
            aria-label="Sidenav" id="drawer-navigation">
            <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">

                <ul class="space-y-2">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white 
                           hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 
                                dark:text-gray-400 dark:group-hover:text-white"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                            </svg>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>

                    <!-- Projects -->
                    <li>
                        <a href= "
                        @if (auth()->user()->role === 'admin') {{ route('admin.projects.index') }}
                        @else
                            {{ route('projects.index') }} @endif
                        "
                            class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg transition duration-75 
                           hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                            <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 
                                dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2h14V5a2 2 0 00-2-2H5z"></path>
                                <path fill-rule="evenodd" d="M3 9h14v6a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-3">Projects</span>
                        </a>
                    </li>

                    <!-- Reports -->
                    <li>
                        <a href="{{ route('reports.index') }}"
                            class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg transition duration-75 
                           hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                            <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 
                                dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 3a2 2 0 00-2 2v12a1 1 0 001.447.894L10 15l6.553 2.894A1 1 0 0018 17V5a2 2 0 00-2-2H4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-3">Reports</span>
                        </a>
                    </li>

                    <!-- Requests -->
                    <li>
                        <a href="{{ route('requests.index') }}"
                            class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg transition duration-75 
                           hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                            <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 
                                dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM2 16a6 6 0 1112 0H2z"></path>
                            </svg>
                            <span class="ml-3">Requests</span>
                        </a>
                    </li>

                    <!-- Staff (Admin only) -->
                    @if (auth()->user()->role === 'admin')
                        <li>
                            <a href="{{ route('admin.staff.index') }}"
                                class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg transition duration-75 
                           hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 
                                dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a6 6 0 100 12A6 6 0 0010 2zM2 18a8 8 0 0116 0H2z"></path>
                                </svg>
                                <span class="ml-3">Staff</span>
                            </a>
                        </li>
                    @endif

                    <!-- Settings -->
                    <li>
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg transition duration-75 
                           hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group">
                            <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 
                                dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 10a2 2 0 114 0 2 2 0 01-4 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-3">Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>


        <main class="p-4 md:ml-64 h-auto pt-20">
            @if (session('success'))
                <div class="p-3 mb-4 text-green-800 bg-green-100 rounded-lg">{{ session('success') }}</div>
            @endif
            {{-- Error Message --}}
            @if (session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <span class="font-medium">Error!</span> {{ session('error') }}
                </div>
            @endif

            {{-- Validation Errors (if using $errors variable from validation) --}}
            @if ($errors->any())
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <span class="font-medium">Whoops!</span> There were some problems with your input.
                    <ul class="mt-1.5 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    <script>
        Echo.private('App.Models.User.{{ auth()->id() }}')
            .notification((notification) => {
                console.log(notification);

                // Show a toast (with Flowbite or your own)
                const el = document.createElement('div');
                el.className = "p-3 bg-blue-100 text-blue-800 rounded mb-2";
                el.innerText = notification.message;
                document.getElementById('notifications').prepend(el);
            });
    </script>
    @yield('scripts')
</body>

</html>
