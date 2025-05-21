<div id="errorAlert" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg px-6 py-6 ring shadow-xl w-1/3">
        <h2 class="text-center font-semibold mb-4">Error!</h2>
        
        <span class="text-center p-6">{{ session('error') }}</span>
        <span class="inline-flex items-center justify-center rounded-md bg-red-500 p-3 shadow-lg">
            <i data-lucide="octagon-alert"></i>
          </span>
        
        
        <div class="mt-4 text-center">
            <button onclick="document.getElementById('errorAlert').classList.add('hidden')"
                class="bg-red-500 text-white px-4 py-2 rounded">Tutup</button>
        </div>
    </div>
</div>
