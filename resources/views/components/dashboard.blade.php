<!-- Dashboard Content -->
<div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white border-4 border-indigo-200 border-l-blue-500 shadow-md rounded-lg p-6 flex items-center">
        <i data-lucide="users" class="w-10 h-10 text-blue-500 mr-4"></i>
        <div>
            <h3 class="text-gray-500">Jumlah Member</h3>
            <p class="text-2xl font-bold">2</p>
        </div>
    </div>
    <div class="bg-white border-4 border-indigo-200 border-l-green-500 shadow-md rounded-lg p-6 flex items-center">
        <i data-lucide="shield-check" class="w-10 h-10 text-green-500 mr-4"></i>
        <div>
            <h3 class="text-gray-500">Jumlah Admin</h3>
            <p class="text-2xl font-bold">1</p>
        </div>
    </div>
    <div class="bg-white border-4 border-indigo-200 border-l-yellow-500 shadow-md rounded-lg p-6 flex items-center">
        <i data-lucide="credit-card" class="w-10 h-10 text-yellow-500 mr-4"></i>
        <div>
            <h3 class="text-gray-500">Data Transaksi Kredit</h3>
            <p class="text-2xl font-bold">2</p>
        </div>
    </div>
    <div class="bg-white border-4 border-indigo-200 border-l-red-500 shadow-md rounded-lg p-6 flex items-center">
        <i data-lucide="banknote" class="w-10 h-10 text-red-500 mr-4"></i>
        <div>
            <h3 class="text-gray-500">Data Transaksi Debit</h3>
            <p class="text-2xl font-bold">3</p>
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
                <tr class="text-left bg-gray-200">
                    <th class="p-2">UID</th>
                    <th class="p-2">Nama</th>
                    <th class="p-2">Saldo</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="p-2">783492182007</td>
                    <td class="p-2">Dio Toar</td>
                    <td class="p-2">Rp 39.000</td>
                </tr>
                <tr>
                    <td class="p-2">1061221907742</td>
                    <td class="p-2">Gladys</td>
                    <td class="p-2">Rp 25.000</td>
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
               
                 <canvas id="chartTransaksi"></canvas>
                
                
    
            </div>
            
        </div>
    </div>
</div>
</div>