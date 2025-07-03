  <!-- Sidebar -->
  <aside class="w-85 min-h-screen border-white border-b border-t bg-sky-600 text-white p-5 shadow-lg hidden md:block z-40">
    <div class="">
        <h2 class="text-2xl font-bold flex items-center mb-5">
            <i data-lucide="parking-circle" class="w-6 h-6 mr-2"></i> E-Parking
        </h2>
    </div>
    
    <nav  class="space-y-3">
        <ul>
            <li class="mb-3">
                <a href="{{ route('dashboard') }}"  class="flex items-center border-white border-b border-t p-3 rounded-lg hover:bg-sky-300 transition {{ request()->is('dashboard') ? 'bg-sky-500' : 'bg-transparent'}}">
                    <i data-lucide="layout-dashboard" class="w-7 h-7"></i>
                    <span class="ml-6 border-white  p-1 rounded-md">Dashboard</span>
                </a>
            </li>
            <li class="mb-3">
                <a href="{{ route('transaksi') }}" class="flex items-center  border-white border-b border-t  p-3 rounded-lg hover:bg-sky-500 transition {{ request()->is('transaksi') ? 'bg-sky-500' : 'bg-transparent'}}">
                    <i data-lucide="credit-card" class="w-7 h-7"></i>
                    <span class="ml-6 border-white p-1 rounded-md">Transaksi</span>
                </a>
            </li>
            <li class="mb-3">
                <a href="{{ route('topup.admin') }}" class="flex items-center  border-white border-b border-t  p-3 rounded-lg hover:bg-sky-500 transition {{ request()->is('topup/admin') ? 'bg-sky-500' : 'bg-transparent'}}">
                    <i data-lucide="banknote-arrow-up" class="w-7 h-7"></i>
                    <span class="ml-6 border-white p-1 rounded-md">Top Up</span>
                </a>
            </li>
            <li class="mb-3">
                <a href="{{ route('parkir.slot') }}" class="flex items-center  border-white border-b border-t  p-3 rounded-lg hover:bg-sky-500 transition {{ request()->is('slot_parking') ? 'bg-sky-500' : 'bg-transparent'}}">
                    <i data-lucide="parking-meter" class="w-7 h-7"></i>
                    <span class="ml-6 border-white p-1 rounded-md">Slot Parkir</span>
                </a>
            </li>
            <li class="mb-3">
                <a href="{{ route('admin.chart.keuntungan') }}" class="flex items-center  border-white border-b border-t  p-3 rounded-lg hover:bg-sky-500 transition {{ request()->is('admin/chart-keuntungan') ? 'bg-sky-500' : 'bg-transparent'}}">
                    <i data-lucide="badge-dollar-sign" class="w-7 h-7"></i>
                    <span class="ml-6 border-white p-1 rounded-md">Keuntungan</span>
                </a>
            </li>
            <li class="mb-3">
                <a href="{{ route('riwayat.parkir') }}" class="flex items-center  border-white border-b border-t  p-3 rounded-lg hover:bg-sky-500 transition {{ request()->is('riwayat-parkir') ? 'bg-sky-500' : 'bg-transparent'}}">
                    <i data-lucide="history" class="w-7 h-7"></i>
                    <span class="ml-5 border-white p-1 rounded-md">Riwayat Parkir</span>
                </a>
            </li>
            @php
                $isParkirActive = request()->is('parkir_masuk') || request()->is('parkir_keluar');
            @endphp
            

            <li class="mb-3 border-white border-b border-t rounded-lg transition">
                <button type="button"
                    class="flex items-center w-full p-3 rounded-md hover:bg-sky-500 sidebar-item transition"
                    onclick="toggleDropdown('parkirDropdown')">
                    <i data-lucide="square-parking" class="w-7 h-7"></i>
                    <span class="ml-6 flex-1 text-left">Parkir</span>
                    <svg class="w-4 h-4 ml-auto transition-transform {{ $isParkirActive ? 'rotate-180' : '' }}" id="icon-parkirDropdown"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <ul id="parkirDropdown" class="mt-2 ml-8 space-y-2 {{ $isParkirActive ? 'block' : 'hidden' }} mb-2">
                    <li>
                        <a href="{{ route('parkir.masuk') }}"
                            class="flex items-center border-white border-b border-t ml-8 p-2 rounded-md hover:bg-sky-700 {{ request()->is('parkir_masuk') ? 'bg-sky-500' : 'bg-transparent' }}">
                            <i data-lucide="arrow-right-to-line"></i>
                            <span class="ml-2"> Masuk</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('parkir.keluar') }}"
                            class="flex items-center border-white border-b border-t ml-8 p-2 rounded-md hover:bg-sky-700 {{ request()->is('parkir_keluar') ? 'bg-sky-500' : 'bg-transparent' }}">
                            <i data-lucide="arrow-left-from-line"></i>
                            <span class="ml-2"> Keluar</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="mt-2">
                <a href="{{ route('admin.member') }}" class="flex items-center  border-white border-b border-t  p-3 rounded-lg hover:bg-sky-500 transition {{ request()->is('member') ? 'bg-sky-500' : 'bg-transparent'}}">
                    <i data-lucide="user-plus" class="w-7 h-7"></i>
                    <span class="ml-6 border-white p-1 rounded-md">Registrasi</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>