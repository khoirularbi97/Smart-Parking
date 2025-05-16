<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hero Page - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <header class="w-full bg-white shadow-md">
        @if (Route::has('login'))
        <div class="max-w-7xl mx-auto flex justify-between items-center p-4">
            <h1 class="text-2xl font-bold text-blue-600">Smart Parking</h1>
           
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                    >
                        Log in
                    </a>

                    {{-- @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Register
                        </a>
                    @endif --}}
                @endauth
            </nav>
        </div>
        @endif
    </header>



    <section class="relative flex items-center justify-center h-screen bg-gradient-to-r from-blue-500 to-blue-700">
        <div class="max-w-7xl mx-auto px-6 lg:flex lg:items-center">
            <!-- Bagian Kiri -->
            <div class="lg:w-1/2 text-white">
                <h1 class="text-4xl lg:text-6xl font-bold leading-tight">
                    Sistem Parkir Otomatis Berbasis IoT
                </h1>
                <p class="mt-4 text-lg">
                    Solusi modern untuk parkir yang lebih cepat, aman, dan efisien menggunakan teknologi terkini.
                </p>
               
            </div>

            <!-- Bagian Kanan (Gambar) -->
            <div class="lg:w-1/2 mt-10 lg:mt-0">
                <img src="{{ asset('images/logo.png') }}"  alt="Smart Parking" class="rounded-lg shadow-xl">
            
            </div>
        </div>
    </section>
    @if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
@endif
</body>
</html>
