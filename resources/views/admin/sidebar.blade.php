  <!-- Sidebar -->
  <aside class="w-64 min-h-screen  bg-sky-600 text-white p-5 shadow-lg hidden md:block z-40">
    <div class="border-b">
        <h2 class="text-2xl font-bold flex items-center mb-5">
            <i data-lucide="parking-circle" class="w-6 h-6 mr-2"></i> E-Parking
        </h2>
    </div>
    
    <nav  class="space-y-2">
        <ul>
            <li class="mb-3">
                <a href="{{ route('dashboard') }}"  class="flex items-center p-3 rounded-md hover:bg-sky-500 sidebar-item {{ request()->is('dashboard') ? 'bg-sky-500' : 'bg-transparent'}}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            <li class="mb-3">
                <a href="{{ route('transaksi') }}" class="flex items-center p-3 rounded-md hover:bg-sky-500sidebar-item {{ request()->is('transaksi') ? 'bg-sky-500' : 'bg-transparent'}}">
                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                    <span class="ml-3">Transaksi</span>
                </a>
            </li>
            <li class="mb-3">
                <a href="{{ route('parkir.masuk') }}" class="flex items-center p-3 rounded-md hover:bg-sky-500 sidebar-item {{ request()->is('parkir_masuk') ? 'bg-sky-500' : 'bg-transparent'}}">
                    <i data-lucide="settings" class="w-5 h-5"></i>
                    <span class="ml-3">Parkir Masuk</span>
                </a>
            </li>
            <li class="mt-6">
                <a href="{{ route('admin.member') }}" class="flex items-center p-3 rounded-md hover:bg-sky-500 sidebar-item {{ request()->is('member') ? 'bg-sky-500' : 'bg-transparent'}}">
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                    <span class="ml-3">Registrasi</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>