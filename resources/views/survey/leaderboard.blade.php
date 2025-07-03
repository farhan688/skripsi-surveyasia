@extends('layouts.base')
@extends('respondent.layouts.nav')

@section('content')
<div class="min-h-screen bg-gray-50">

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-survey-orange to-survey-red h-48 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-red-400 opacity-90"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
            <div>
                <h1 class="text-4xl font-bold text-white mb-2">Leaderboard</h1>
                <p class="text-orange-100 text-lg">Peringkat peserta berdasarkan poin yang dikumpulkan</p>
            </div>
        </div>
    </div>

    <!-- Leaderboard Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(count($leaderboard) >= 3)
        <!-- Top 3 Podium -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- Peringkat 2 --}}
            <div class="order-2 md:order-1">
                <div class="bg-white rounded-lg shadow-md p-6 text-center border-t-4 border-gray-400">
                    <div class="w-16 h-16 bg-gray-400 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-white font-bold text-xl">2</span>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-800">{{ $leaderboard[1]->name }}</h3>
                    <p class="text-gray-600 mb-2">{{ number_format($leaderboard[1]->points) }} poin</p>
                    <div class="bg-gray-100 rounded-full px-3 py-1 text-sm text-gray-600">Peringkat 2</div>
                </div>
            </div>

            {{-- Peringkat 1 --}}
            <div class="order-1 md:order-2">
                <div class="bg-white rounded-lg shadow-lg p-6 text-center border-t-4 border-survey-orange transform md:scale-105">
                    <div class="w-20 h-20 bg-gradient-to-r from-survey-orange to-survey-red rounded-full mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 16L3 21l5.25-1.25L12 19l3.75.75L21 21l-2-5H5zm7-13A2 2 0 1 1 10 1a2 2 0 0 1 2 2zM12 4a8 8 0 0 1 8 8 8 8 0 0 1-8 8 8 8 0 0 1-8-8 8 8 0 0 1 8-8z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800">{{ $leaderboard[0]->name }}</h3>
                    <p class="text-gray-600 mb-2 text-lg">{{ number_format($leaderboard[0]->points) }} poin</p>
                    <div class="bg-gradient-to-r from-survey-orange to-survey-red text-white rounded-full px-4 py-2 text-sm font-semibold">🏆 Juara 1</div>
                </div>
            </div>

            {{-- Peringkat 3 --}}
            <div class="order-3">
                <div class="bg-white rounded-lg shadow-md p-6 text-center border-t-4 border-orange-300">
                    <div class="w-16 h-16 bg-orange-300 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-white font-bold text-xl">3</span>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-800">{{ $leaderboard[2]->name }}</h3>
                    <p class="text-gray-600 mb-2">{{ number_format($leaderboard[2]->points) }} poin</p>
                    <div class="bg-orange-100 text-orange-600 rounded-full px-3 py-1 text-sm">Peringkat 3</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Peringkat Lainnya -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-survey-orange to-survey-red px-6 py-4">
                <h2 class="text-xl font-semibold text-white">Peringkat Lengkap</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($leaderboard->skip(3) as $index => $participant)
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                            <span class="font-semibold text-gray-600">{{ $index + 4 }}</span>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800">{{ $participant->name }}</h4>
                            <p class="text-sm text-gray-500">Peserta Survey</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">{{ number_format($participant->points) }}</p>
                        <p class="text-sm text-gray-500">poin</p>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-gray-500">
                    <p>Belum ada peserta lain dalam leaderboard</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Statistik -->
        {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <!-- Total Peserta -->
            <x-stat-card label="Total Peserta" iconColor="orange-600" iconBg="orange-100" :value="count($leaderboard)" icon="users" />

            <!-- Poin Tertinggi -->
            <x-stat-card label="Poin Tertinggi" iconColor="red-600" iconBg="red-100" :value="count($leaderboard) > 0 ? number_format($leaderboard[0]->points) : 0" icon="star" />

            <!-- Rata-rata Poin -->
            <x-stat-card label="Rata-rata Poin" iconColor="orange-600" iconBg="orange-100" :value="count($leaderboard) > 0 ? number_format($leaderboard->avg('points')) : 0" icon="chart-bar" />
        </div> --}}
    </div>
</div>
@endsection
