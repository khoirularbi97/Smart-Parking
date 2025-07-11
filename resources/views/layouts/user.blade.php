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
        <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    
    @livewireStyles
    </head>
    <body class="font-sans antialiased ">
    <div class="justify-content-md-center">
        <div class="">
      
        <div class="min-h-screen bg-gray-100 ">
            @include('layouts.navigation_user')
            <div class="min-h-screen">
               
                <div class="flex-1 flex flex-col">
                    <!-- Header -->
                    @include('admin.header')
        
                    <!-- Main content -->
                    <main class="flex-1 min-h-screen bg-gradient-to-br from-purple-200 to-indigo-200 p-6 h-full">
                        @yield('content')
                    </main>
                    </div>
                </div>
            </div>
        </div>
            <nav class="bg-white border-t border-gray-200 shadow-inner fixed bottom-0 w-full flex justify-around py-2 ">
                <button onclick="window.location='{{ route('user.dashboard') }}'" class="flex flex-col items-center text-sm p-2 w-20 rounded-xl text-gray-600 hover:text-purple-600 shadow-md {{ request()->is('user/dashboard') ? 'bg-gradient-to-br from-purple-400 to-indigo-400 text-white' : 'bg-transparent'}}">
                <i data-lucide="home" class="w-5 h-5 mb-1 {{ request()->is('user/dashboard') ? 'text-purple-600' : 'bg-transparent'}}"></i>
                Home
                </button>
                <button onclick="window.location='{{ route('topup.form') }}'" class="flex flex-col items-center text-sm p-2 ml w-20 rounded-xl text-gray-600 hover:text-purple-600 shadow-md {{ request()->is('topup') ? 'bg-gradient-to-br from-purple-400 to-indigo-400 text-white' : 'bg-transparent'}}">
                <i data-lucide="wallet" class="w-5 h-5 mb-1 {{ request()->is('topup') ? 'text-purple-600' : 'bg-transparent'}}"></i>
                Topup
                </button>
                <button onclick="window.location='{{ route('transaksi.user') }}'" class="flex flex-col items-center text-sm p-2 ml w-20 rounded-xl text-gray-600 hover:text-purple-600 shadow-md {{ request()->is('transaksi/user') ? 'bg-gradient-to-br from-purple-400 to-indigo-400 text-white' : 'bg-transparent'}}">
                <i data-lucide="file-clock" class="w-5 h-5 mb-1 {{ request()->is('transaksi/user') ? 'text-purple-600' : 'bg-transparent'}}"></i>
                Transaksi
                </button>
                </nav>
        </div>
                    
 
                    {{-- <nav class="fixed bottom-0 inset-x-0 bg-white shadow-md flex justify-around items-center py-2">
                    <a href="{{ route('user.dashboard') }}" class="text-center">
                        <i class="fas fa-home text-xl {{ request()->is('user/dashboard') ? 'text-blue-500' : 'bg-transparent'}} "></i><br><span class="text-xs">Home</span>
                    </a>
                    <a href="{{ route('topup.form') }}" class="text-center">
                        <i class="fas fa-wallet text-xl  {{ request()->is('/topup') ? 'text-blue-500' : 'bg-transparent'}}"></i><br><span class="text-xs">Topup</span>
                    </a>
                    <a href="{{ route('profile_user.edit') }}" class="text-center">
                        <i class="fas fa-user text-xl  {{ request()->is('profile/user') ? 'text-blue-500' : 'bg-transparent'}}"></i><br><span class="text-xs">Profil</span>
                    </a>
                </nav> --}}
        
                
                @stack('scripts')
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                   @foreach (['success', 'error', 'warning', 'info'] as $msg)
                    @if(session($msg))
                    <script>
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: '{{ $msg }}',
                            title: '{{ session($msg) }}',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    </script>
                    @endif
                    @endforeach

    
            
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
