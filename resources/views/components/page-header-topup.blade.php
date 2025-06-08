@props([
    'title',
    'breadcrumbs' => [],
    'back' => true
])

<div class="flex items-center justify-between mb-6">
    {{-- Breadcrumb dan Judul --}}
    <div class="space-y-1">
        <nav class="text-md text-gray-500 flex items-center space-x-2">
            @foreach ($breadcrumbs as $breadcrumb)
                @if (!$loop->last)
                    <a href="{{ $breadcrumb['url'] }}" class="hover:text-blue-600">{{ $breadcrumb['label'] }}</a>
                    <span>/</span>
                @else
                    <span class="text-gray-700 font-semibold">{{ $breadcrumb['label'] }}</span>
                @endif
            @endforeach
        </nav>
        <div class="flex justify-between items-center mb-2 mt-3">
            <h1 class="text-2xl font-bold">{{ $title }}</h1>

        </div>
       
    </div>

    {{-- Tombol Back --}}
    @if ($back)
        <a href="{{ route('topup.admin') }}" class="inline-flex items-center text-lg text-gray-500 hover:text-black">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    Kembali
</a>
    @endif
</div>
