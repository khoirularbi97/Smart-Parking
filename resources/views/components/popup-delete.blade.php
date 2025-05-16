<div id="confirmModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
  <div class="bg-white rounded shadow-lg p-6 w-full max-w-md">
    <h2 class="text-lg font-semibold mb-4">Yakin ingin menghapus pengguna ini?</h2>
    <div class="flex justify-end gap-4">
      <button onclick="hideConfirmModal()" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
      <button onclick="submitDelete()" class="px-4 py-2 bg-red-600 text-white rounded">Ya, Hapus</button>
    </div>
  </div>
</div>
