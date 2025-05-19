<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Smart-Parking') }}</title>
       
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
        
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
       

    @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')
            <div class="min-h-screen flex">
                <!-- Sidebar -->
                @include('admin.sidebar')
        
                <div class="flex-1 flex flex-col">
                    <!-- Header -->
                    @include('admin.header')
        
                    <!-- Main content -->
                    <main class="flex-1 p-6">
                        @yield('content')
                    </main>
        
                    <!-- Footer -->
                    @include('admin.footer')
                </div>
            </div>
            @stack('scripts')
    </body>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

    
    lucide.createIcons();

    function toggleSidebar() {
        let sidebar = document.getElementById("sidebar");
        let title = document.getElementById("sidebar-title");

        if (sidebar.classList.contains("w-64")) {
            sidebar.classList.remove("w-64");
            sidebar.classList.add("w-16");
            title.style.display = "none";
        } else {
            sidebar.classList.remove("w-16");
            sidebar.classList.add("w-64");
            title.style.display = "block";
        }
    }

    function toggleDropdown() {
        let dropdown = document.getElementById("dropdown");
        dropdown.classList.toggle("hidden");
    }
    </script>
    

   
</html>
