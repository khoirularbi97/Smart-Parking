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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

        <style>
@media print {
    body * {
        visibility: hidden;
    }
    .invoice, .invoice * {
        visibility: visible;
    }
    .invoice {
        position: absolute;
        left: 0;
        top: 0;
    }

    /* Sembunyikan tombol cetak */
    button, .no-print,  {
        display: none !important;
    }
}
</style>


       

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
            <!-- SweetAlert2 -->

           
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@foreach (['success', 'error', 'warning', 'info'] as $msg)
    @if(session($msg))
        <script>
            Swal.fire({
                icon: '{{ $msg }}',
                title: '{{ session($msg) }}',
                position: 'center',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        </script>
    @endif
@endforeach

    
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

            function showConfirmModal(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus? ',
                text: "Data ini akan hilang secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
            

    
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

    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        const icon = document.getElementById(`icon-${id}`);
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            dropdown.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
    

   
</script>
</body>

    
    

   
</html>
