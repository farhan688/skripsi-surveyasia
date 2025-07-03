<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center">
            <div class="flex items-center space-x-2">
              <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-500 rounded transform rotate-45"></div>
              <span class="text-xl font-bold text-gray-800">SurveyAsia</span>
            </div>
          </div>
          <nav class="hidden md:flex space-x-8">
            <a href="#" class="text-gray-600 hover:text-gray-900">Beranda</a>
            <a href="#" class="text-gray-600 hover:text-gray-900">Riwayat Survey</a>
            <a href="#" class="text-gray-600 hover:text-gray-900">Kontak</a>
            <a href="#" class="text-gray-600 hover:text-gray-900">Berita</a>
          </nav>
          <div class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
            <span class="text-gray-700">faniel sianipar</span>
            <ChevronDown class="w-4 h-4 text-gray-500" />
          </div>
        </div>
      </div>
    </header>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-orange-500 to-red-500 h-48 relative overflow-hidden">
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
      <!-- Top 3 Podium -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- 2nd Place -->
        <div class="order-2 md:order-1">
          <div class="bg-white rounded-lg shadow-md p-6 text-center border-t-4 border-gray-400">
            <div class="w-16 h-16 bg-gray-400 rounded-full mx-auto mb-4 flex items-center justify-center">
              <span class="text-white font-bold text-xl">2</span>
            </div>
            <h3 class="font-semibold text-lg text-gray-800">{{ leaderboard[1]?.name }}</h3>
            <p class="text-gray-600 mb-2">{{ leaderboard[1]?.points }} poin</p>
            <div class="bg-gray-100 rounded-full px-3 py-1 text-sm text-gray-600">
              Peringkat 2
            </div>
          </div>
        </div>

        <!-- 1st Place -->
        <div class="order-1 md:order-2">
          <div class="bg-white rounded-lg shadow-lg p-6 text-center border-t-4 border-gradient-to-r from-orange-500 to-red-500 transform md:scale-105">
            <div class="w-20 h-20 bg-gradient-to-r from-orange-500 to-red-500 rounded-full mx-auto mb-4 flex items-center justify-center">
              <Crown class="w-8 h-8 text-white" />
            </div>
            <h3 class="font-bold text-xl text-gray-800">{{ leaderboard[0]?.name }}</h3>
            <p class="text-gray-600 mb-2 text-lg">{{ leaderboard[0]?.points }} poin</p>
            <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-full px-4 py-2 text-sm font-semibold">
              🏆 Juara 1
            </div>
          </div>
        </div>

        <!-- 3rd Place -->
        <div class="order-3">
          <div class="bg-white rounded-lg shadow-md p-6 text-center border-t-4 border-orange-300">
            <div class="w-16 h-16 bg-orange-300 rounded-full mx-auto mb-4 flex items-center justify-center">
              <span class="text-white font-bold text-xl">3</span>
            </div>
            <h3 class="font-semibold text-lg text-gray-800">{{ leaderboard[2]?.name }}</h3>
            <p class="text-gray-600 mb-2">{{ leaderboard[2]?.points }} poin</p>
            <div class="bg-orange-100 text-orange-600 rounded-full px-3 py-1 text-sm">
              Peringkat 3
            </div>
          </div>
        </div>
      </div>

      <!-- Rest of Leaderboard -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 py-4">
          <h2 class="text-xl font-semibold text-white">Peringkat Lengkap</h2>
        </div>
        <div class="divide-y divide-gray-200">
          <div 
            v-for="(participant, index) in leaderboard.slice(3)" 
            :key="participant.id"
            class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors"
          >
            <div class="flex items-center space-x-4">
              <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                <span class="font-semibold text-gray-600">{{ index + 4 }}</span>
              </div>
              <div>
                <h4 class="font-medium text-gray-800">{{ participant.name }}</h4>
                <p class="text-sm text-gray-500">Peserta Survey</p>
              </div>
            </div>
            <div class="text-right">
              <p class="font-semibold text-gray-800">{{ participant.points }}</p>
              <p class="text-sm text-gray-500">poin</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
              <Users class="w-6 h-6 text-orange-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm text-gray-600">Total Peserta</p>
              <p class="text-2xl font-bold text-gray-800">{{ leaderboard.length }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
              <Trophy class="w-6 h-6 text-red-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm text-gray-600">Poin Tertinggi</p>
              <p class="text-2xl font-bold text-gray-800">{{ leaderboard[0]?.points || 0 }}</p>
            </div>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
              <Target class="w-6 h-6 text-orange-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm text-gray-600">Rata-rata Poin</p>
              <p class="text-2xl font-bold text-gray-800">{{ averagePoints }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { ChevronDown, Crown, Users, Trophy, Target } from 'lucide-vue-next'

// Sample leaderboard data
const leaderboard = ref([
  { id: 1, name: 'Ahmad Rizki Pratama', points: 2850 },
  { id: 2, name: 'Siti Nurhaliza', points: 2720 },
  { id: 3, name: 'Budi Santoso', points: 2650 },
  { id: 4, name: 'Dewi Sartika', points: 2480 },
  { id: 5, name: 'Eko Prasetyo', points: 2350 },
  { id: 6, name: 'Fitri Handayani', points: 2280 },
  { id: 7, name: 'Gunawan Wijaya', points: 2150 },
  { id: 8, name: 'Hani Kusuma', points: 2050 },
  { id: 9, name: 'Indra Permana', points: 1980 },
  { id: 10, name: 'Joko Widodo', points: 1850 },
  { id: 11, name: 'Kartika Sari', points: 1750 },
  { id: 12, name: 'Lukman Hakim', points: 1650 },
  { id: 13, name: 'Maya Sari', points: 1580 },
  { id: 14, name: 'Nanda Pratama', points: 1450 },
  { id: 15, name: 'Oki Setiawan', points: 1350 }
])

// Computed property for average points
const averagePoints = computed(() => {
  if (leaderboard.value.length === 0) return 0
  const total = leaderboard.value.reduce((sum, participant) => sum + participant.points, 0)
  return Math.round(total / leaderboard.value.length)
})
</script>

<style scoped>
.border-gradient-to-r {
  border-image: linear-gradient(to right, #f97316, #ef4444) 1;
}
</style>