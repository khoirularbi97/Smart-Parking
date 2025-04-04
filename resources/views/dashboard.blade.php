<x-app-layout>
   
        <div class="flex h-screen bg-gray-100">
                <!-- Sidebar -->
                <aside class="w-64 min-h-screen shadow-md bg-sky-600 text-white p-5">
                    <h2 class="text-2xl font-bold flex items-center mb-5">
                        <i data-lucide="parking-circle" class="w-6 h-6 mr-2"></i> E-Parking
                    </h2>
                    <nav>
                        <ul>
                            <li class="mb-3">
                                <a href="#" class="flex items-center p-3 rounded-md hover:bg-blue-800">
                                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                                    <span class="ml-3">Dashboard</span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#" class="flex items-center p-3 rounded-md hover:bg-blue-800">
                                    <i data-lucide="credit-card" class="w-5 h-5"></i>
                                    <span class="ml-3">Transaksi</span>
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="#" class="flex items-center p-3 rounded-md hover:bg-blue-800">
                                    <i data-lucide="settings" class="w-5 h-5"></i>
                                    <span class="ml-3">Pengaturan</span>
                                </a>
                            </li>
                            <li class="mt-6">
                                <a href="#" class="flex items-center p-3 bg-blue-800 rounded-md hover:bg-blue-900">
                                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                                    <span class="ml-3">Registrasi</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </aside>
                
            
                <!-- Main Content -->
                <main class="flex-1 p-6">
                    <h2 class="text-2xl font-bold">Dashboard</h2>
                     <!-- Navbar -->
        
                    <!-- Dashboard Content -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white border-4 border-indigo-200 border-l-blue-500 shadow-md rounded-lg p-6 flex items-center">
                <i data-lucide="users" class="w-10 h-10 text-blue-500 mr-4"></i>
                <div>
                        <h3 class="text-gray-500">Jumlah Member</h3>
                        <p class="text-2xl font-bold">{{ \App\Models\User::where('role', 'user')->count() }}</p>
                    </div>
                    
                    
                
        
            </div>
            <div class="bg-white border-4 border-indigo-200 border-l-green-500 shadow-md rounded-lg p-6 flex items-center">
                <i data-lucide="shield-check" class="w-10 h-10 text-green-500 mr-4"></i>
                <div>
                    <h3 class="text-gray-500">Jumlah Admin</h3>
                    <p class="text-2xl font-bold">{{ \App\Models\User::where('role', 'admin')->count() }}</p>
                </div>
            </div>
            <div class="bg-white border-4 border-indigo-200 border-l-yellow-500 shadow-md rounded-lg p-6 flex items-center">
                <i data-lucide="credit-card" class="w-10 h-10 text-yellow-500 mr-4"></i>
                <div>
                    <h3 class="text-gray-500">Data Transaksi Kredit</h3>
                    <p class="text-2xl font-bold">Rp. {{ number_format($kredit, 2, ',', '.') }}</p>
                </div>
            </div>
            <div class="bg-white border-4 border-indigo-200 border-l-red-500 shadow-md rounded-lg p-6 flex items-center">
                <i data-lucide="banknote" class="w-10 h-10 text-red-500 mr-4"></i>
                <div>
                    <h3 class="text-gray-500">Data Transaksi Debit</h3>
                    <p class="text-2xl font-bold">Rp.{{ number_format($debit, 2, ',', '.') }}</p>
                </div>
            </div>
            </div>
            <!-- Table & Chart -->
            <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Table -->
            <div class="bg-white shadow-md rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-4">Top Up Saldo</h3>
                <table class="w-full border-collapse ">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border px-4 py-2">UID</th>
                            <th class="border px-4 py-2">Nama</th>
                            <th class="border px-4 py-2">Saldo</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-4 py-2">783492182007</td>
                            <td class="border px-4 py-2">Dio Toar</td>
                            <td class="border px-4 py-2">Rp 39.000</td>
                            <td class="border px-4 py-2 text-center">
                                <button class="bg-green-500 text-white px-2 py-1 rounded">✔</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2">1061221907742</td>
                            <td class="border px-4 py-2">Gladys</td>
                            <td class="border px-4 py-2">Rp 25.000</td>
                            <td class="border px-4 py-2 text-center">
                                <button class="bg-green-500 text-white px-2 py-1 rounded">✔</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Chart Placeholder -->
            <div class="bg-white shadow-md rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-4">Data Transaksi</h3>
                <div class="flex items-center justify-center ">
                    <div class="card">
                        
                    </div>
                    <div class="w-45">
                       
                         <canvas id="transaksiChart"></canvas>
                        
                        
            
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <script>
                         var debit = {{ $debit ?? 0 }};
                         var kredit = {{ $kredit ?? 0 }};
                        
var ctx = document.getElementById('transaksiChart').getContext('2d');
    var transaksiChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Transaksi Debit', 'Transaksi Kredit'],
            datasets: [{
                data: [{{ $debit }}, {{ $kredit }}],
                backgroundColor: ['#007bff', '#dc3545'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }

    });
                    </script>
                    
                </div>
            </div>
            </div>
            </div>
                </main>
            </div>
            
          
        
    
    
</x-app-layout>
