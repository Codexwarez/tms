<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TMS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 px-4 py-2.5 fixed w-full z-50">
        <div class="flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-blue-600">TMS</a>
            <div>
                @auth
                    <a href="{{ route('dashboard') }}" 
                       class="text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                       Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Swiper -->
    <section class="pt-16">
        <div class="swiper mySwiper w-full h-[90vh]">
            <div class="swiper-wrapper">
                <div class="swiper-slide relative">
                    <img src="{{ asset('images/landing/hero1.jpg') }}" 
                         class="w-full h-full object-cover" alt="Slide 1">
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/50 text-white">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4 animate-fade-in">
                            Manage Tasks Smarter
                        </h1>
                        <p class="text-lg mb-6 max-w-2xl text-center animate-fade-in-delay">
                            A modern Task Management System to streamline your team’s workflow.
                        </p>
                        <a href="{{ route('login') }}" 
                           class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700">
                            Get Started
                        </a>
                    </div>
                </div>

                <div class="swiper-slide relative">
                    <img src="{{ asset('images/landing/hero2.jpg') }}" 
                         class="w-full h-full object-cover" alt="Slide 2">
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/50 text-white">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Stay on Track</h1>
                        <p class="text-lg mb-6 max-w-2xl text-center">
                            Track project progress and deadlines in one place.
                        </p>
                    </div>
                </div>

                <div class="swiper-slide relative">
                    <img src="{{ asset('images/landing/hero3.jpg') }}" 
                         class="w-full h-full object-cover" alt="Slide 3">
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/50 text-white">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Collaborate Seamlessly</h1>
                        <p class="text-lg mb-6 max-w-2xl text-center">
                            Connect your staff and boost productivity with teamwork.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
</body>
</html>
