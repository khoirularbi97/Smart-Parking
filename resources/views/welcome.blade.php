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
            <h1 class="text-2xl font-bold text-blue-600">E-Parking</h1>
           
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
    <section class="bg-gray-100 py-20">
  <div class="container mx-auto px-6 text-center">
    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
      Solusi Parkir Cerdas dan Otomatis
    </h1>
    <p class="text-lg text-gray-600 mb-8">
      Kelola area parkir Anda secara efisien dengan teknologi ANPR, kartu RFID, dan sistem pembayaran digital terintegrasi.
    </p>
    <div class="space-x-4">
      <a href="#fitur" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition">
        Pelajari Lebih Lanjut
      </a>
      <a href="{{ route('login') }}" class="bg-gray-300 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-400 transition">
        Coba Sekarang
      </a>
    </div>
  </div>
</section>
<section class="relative flex items-center justify-center h-screen bg-gradient-to-r from-blue-500 to-blue-700">
        <div class="max-w-7xl mx-auto px-6 lg:flex lg:items-center">
            <!-- Bagian Kiri -->
            {{-- <div class="lg:w-1/2 text-white">
                <h1 class="text-4xl lg:text-6xl font-bold leading-tight">
                    Sistem Parkir Otomatis Berbasis IoT
                </h1>
                <p class="mt-4 text-lg">
                    Solusi modern untuk parkir yang lebih cepat, aman, dan efisien menggunakan teknologi terkini.
                </p>
               
            </div> --}}

            <!-- Bagian Kanan (Gambar) -->
            <div class="lg:w-1/2 mt-10 lg:mt-0">
                <img src="{{ asset('images/logo.png') }}"  alt="Smart Parking" class="rounded-lg shadow-xl">
            
            </div>
                    <div class="container mx-auto mt-2 px-6 text-center">
                <h2 class="text-3xl font-semibold text-white mb-4">Apa itu E-Parking?</h2>
                <p class="text-white text-lg max-w-2xl mx-auto">
                E-Parking adalah sistem parkir pintar berbasis web dan IoT yang memudahkan pengguna dalam proses parkir. 
                Pengguna cukup melakukan tapping kartu RFID untuk akses masuk/keluar dan melakukan top-up saldo melalui Web User. 
                Semua terintegrasi dalam satu dashboard digital dengan pelaporan lengkap.
                </p>
            </div>
        </div>
  
    </section>
    </section>
<section class="bg-white py-16" id="fitur">
  <div class="container mx-auto px-6">
    <h2 class="text-3xl font-bold text-gray-800 text-center mb-12">Fitur Unggulan E-Parking</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
      <!-- Fitur 1 -->
      <div class="flex items-start space-x-4">
        <div class="text-blue-600 text-3xl">
          <i class="fas fa-camera"></i>
        </div>
        <div>
          <h3 class="text-xl font-semibold text-gray-800 mb-1">Deteksi Plat Nomor Otomatis (ANPR)</h3>
          <p class="text-gray-600">Sistem mengenali plat nomor kendaraan secara otomatis saat masuk dan keluar, meningkatkan efisiensi dan keamanan.</p>
        </div>
      </div>

      <!-- Fitur 2 -->
      <div class="flex items-start space-x-4">
        <div class="text-green-600 text-3xl">
          <i class="fas fa-id-card"></i>
        </div>
        <div>
          <h3 class="text-xl font-semibold text-gray-800 mb-1">Tapping RFID</h3>
          <p class="text-gray-600">Pengguna hanya perlu tapping kartu RFID untuk membuka gate parkir, tanpa perlu antri atau interaksi manual.</p>
        </div>
      </div>

      <!-- Fitur 3 -->
      <div class="flex items-start space-x-4">
        <div class="text-purple-600 text-3xl">
          <i class="fas fa-wallet"></i>
        </div>
        <div>
          <h3 class="text-xl font-semibold text-gray-800 mb-1">Top-Up Saldo via Web User</h3>
          <p class="text-gray-600">Isi ulang saldo kartu RFID langsung melalui halaman Web User yang terintegrasi dengan metode pembayaran digital seperti transfer bank, GoPay, dan kartu kredit.</p>
        </div>
      </div>

      <!-- Fitur 4 -->
      <div class="flex items-start space-x-4">
        <div class="text-yellow-600 text-3xl">
          <i class="fas fa-chart-line"></i>
        </div>
        <div>
          <h3 class="text-xl font-semibold text-gray-800 mb-1">Dashboard Admin & Laporan</h3>
          <p class="text-gray-600">Pantau statistik parkir, riwayat transaksi, dan aktivitas pengguna melalui dashboard admin yang mudah digunakan.</p>
        </div>
      </div>
    </div>

    <div class="text-center mt-12">
      <a href="{{ route('login') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition">
        Mulai Sekarang
      </a>
    </div>
  </div>
</section>




<section class="bg-gray-900 py-16 text-white" id="kontak">
  <div class="container mx-auto px-6">
    <h2 class="text-3xl font-semibold mb-6 text-center">Hubungi Kami</h2>
    <div class="max-w-xl mx-auto text-center space-y-3">
      <p>Email: <a href="mailto:arinklise@khoirularbi.com" class="underline">arinklise@khoirularbi.com</a></p>
      <p>Telepon/WhatsApp: <a href="https://wa.me/0895369834425" class="underline">+62 895-3698-34425</a></p>
      <p>Alamat: Kampus Universitas Pelita Bangsa Jl. Inspeksi Kalimalang Tegal Danas Arah Deltamas, Cibatu, Cikarang, Bekasi ,Jawa Barat Indonesia 17532</p>
      <p>Instagram: <a href="https://instagram.com/eparking.id" class="underline">@eparking.id</a></p>
      <p>Website: <a href="https://www.scurebot.cloud" class="underline">www.scurebot.cloud</a></p>
    </div>
  </div>
</section>
<footer class="bg-gray-800 text-white py-6 ">
  <div class="container mx-auto px-6 text-center">
    <p class="text-sm">&copy; {{ date('Y') }} E-Parking. All rights reserved.</p>
    <p class="text-xs text-gray-400 mt-1">
      Dibuat dengan ❤️ oleh Tim E-Parking Indonesia.
    </p>
  </div>
</footer>




    
    @if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
@endif
</body>
</html>
