@extends('layout.layout-user')

@section('content')
    <div class="p-6 bg-gray-100 min-h-screen">
        <h1>Selamat datang, {{ auth()->user()->name }}</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-600 text-sm font-medium">Terjadwal</h3>
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-gray-800 mb-1">{{ $stats['terjadwal'] }}</p>
                <p class="text-xs text-gray-500">Jadwal belum terlaksana</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-gray-600 text-sm font-medium">Terlaksana</h3>
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-gray-800 mb-1">{{ $stats['terlaksana'] }}</p>
                <p class="text-xs text-gray-500">Jadwal yang sudah terlaksana</p>
            </div>
        </div>
        {{-- <!-- Court Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($jadwal as $jadwals)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow flex flex-col">
                    <!-- Isi card -->
                    <div class="p-5 flex flex-col h-60">

                        <h3 class="text-xl font-bold mb-3">{{ $jadwals['user'] }}</h3>

                        <p class="text-sm text-gray-600 mb-4 line-clamp-4">
                            {{ $jadwals['description'] }}
                        </p>

                        <!-- Bagian bawah card -->
                        <div class="flex items-center justify-between mt-auto pt-3">
                            <button
                                @click="showDetail({
                                        name: '{{ $jadwals['name'] }}',
                                        type: '{{ $jadwals['type'] }}',
                                        description: '{{ $jadwals['description'] }}',
                                        price: '{{ number_format($jadwals['price_per_hour'], 0, ',', '.') }}',
                                        image: '{{ $jadwals['image_url'] }}',
                                        id: '{{ $jadwals['id'] }}'
                                    })"
                                class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                                Lihat detail...
                            </button>
                        </div>

                    </div>
                </div>
            @endforeach
        </div> --}}
    </div>
@endsection
