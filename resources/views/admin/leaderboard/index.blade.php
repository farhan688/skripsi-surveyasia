@extends('admin.layouts.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <style>
        body {
            background-color: #F7FAFC;
        }
    </style>
@endsection

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap5.min.css">

@section('content')
    <div class="container-fluid" style="background-color: #F7F8FC;">
        <div class="row">
            <div class="col-2 nopadding">
                @include('admin.component.sidebar')
            </div>
            <div class="col-10 nopadding">
                @include('admin.component.newheader')

                <!-- Leaderboard Content -->
                <div class="container py-5">
                    @if (count($podium) >= 3)
                        <!-- Top 3 Podium -->
                        <div class="row g-4 mb-5">
                            <!-- 2nd Place -->
                            <div class="col-md-4 order-2 order-md-1">
                                <div
                                    class="bg-white rounded-3 shadow-sm p-4 text-center border-top border-4 border-secondary h-100">
                                    <div class="bg-secondary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                        style="width: 60px; height: 60px;">
                                        <span class="fw-bold fs-5">2</span>
                                    </div>
                                    <h3 class="fw-semibold mb-1">{{ $podium[1]->nama_lengkap }}</h3>
                                    <p class="text-muted mb-2">{{ number_format($podium[1]->points) }} point</p>
                                    <div class="badge bg-secondary bg-opacity-10 text-secondary">
                                        Peringkat 2
                                    </div>
                                </div>
                            </div>

                            <!-- 1st Place -->
                            <div class="col-md-4 order-1 order-md-2">
                                <div class="bg-white rounded-3 shadow p-4 text-center border-top border-4 border-warning h-100"
                                    style="border-color: #f97316 !important; transform: translateY(-10px);">
                                    <div class="bg-warning text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                        style="width: 80px; height: 80px; background: linear-gradient(to right, #f97316, #ef4444) !important;">
                                        <i class="fas fa-trophy fs-4"></i>
                                    </div>
                                    <h3 class="fw-bold mb-1">{{ $podium[0]->nama_lengkap }}</h3>
                                    <p class="text-muted mb-2 fs-5">{{ number_format($podium[0]->points) }} point</p>
                                    <div class="badge text-white"
                                        style="background: linear-gradient(to right, #f97316, #ef4444);">
                                        🏆 Juara 1
                                    </div>
                                </div>
                            </div>

                            <!-- 3rd Place -->
                            <div class="col-md-4 order-3">
                                <div class="bg-white rounded-3 shadow-sm p-4 text-center border-top border-4 border-info h-100"
                                    style="border-color: #fdba74 !important;">
                                    <div class="bg-info text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                        style="width: 60px; height: 60px; background-color: #fdba74 !important;">
                                        <span class="fw-bold fs-5">3</span>
                                    </div>
                                    <h3 class="fw-semibold mb-1">{{ $podium[2]->nama_lengkap }}</h3>
                                    <p class="text-muted mb-2">{{ number_format($podium[2]->points) }} point</p>
                                    <div class="badge bg-info bg-opacity-10 text-info" style="color: #9a3412 !important;">
                                        Peringkat 3
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif(count($leaderboard) > 0)
                        <div class="bg-white rounded-3 shadow-sm p-5 text-center mb-5">
                            <div class="bg-warning text-white rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center"
                                style="width: 120px; height: 120px; background: linear-gradient(to right, #f97316, #ef4444) !important;">
                                <i class="fas fa-trophy fs-1"></i>
                            </div>
                            <h2 class="fw-bold mb-2">Pemimpin Saat Ini</h2>
                            <p class="text-warning fs-4 fw-semibold mb-1" style="color: #f97316 !important;">
                                {{ $leaderboard[0]->nama_lengkap }}</p>
                            <p class="text-muted fs-5">{{ number_format($leaderboard[0]->points) }} point</p>
                        </div>
                    @endif

                    <!-- Rest of Leaderboard -->
                    <div class="bg-white rounded-3 shadow-sm overflow-hidden">
                        <div class="p-4 text-white" style="background: linear-gradient(to right, #f97316, #ef4444);">
                            <h2 class="fw-semibold mb-0">Peringkat Lengkap</h2>
                        </div>
                        <div class="list-group list-group-flush">
                            @php
                                $startNumber = ($leaderboard->currentPage() - 1) * $leaderboard->perPage() + 1;
                            @endphp
                            @forelse($leaderboard as $index => $participant)
                                <div
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                                    <div class="d-flex align-items-center">
                                        @if ($startNumber + $index <= 3)
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3 
                            @if ($index === 0) bg-warning text-white @endif
                            @if ($index === 1) bg-secondary text-white @endif
                            @if ($index === 2) bg-info text-white @endif"
                                                style="width: 40px; height: 40px; @if ($startNumber + $index === 3) background-color: #fdba74 !important; @endif">
                                                <span class="fw-bold">{{ $startNumber + $index }}</span>
                                            </div>
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                                style="width: 40px; height: 40px;">
                                                <span class="fw-bold">{{ $startNumber + $index }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <h5 class="mb-0">{{ $participant->nama_lengkap }}</h5>
                                            <small class="text-muted">Peserta Survey</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-bold d-block">{{ number_format($participant->points) }}</span>
                                        <small class="text-muted">point</small>
                                    </div>
                                </div>
                            @empty
                                <div class="p-5 text-center text-muted">
                                    <i class="fas fa-trophy fa-3x mb-3 opacity-25"></i>
                                    <h5 class="mb-2">Belum ada peserta dalam leaderboard</h5>
                                    <p class="mb-0">Ikuti survey untuk menjadi yang pertama!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $leaderboard->links() }}
                    </div>

                    <!-- Stats Cards -->
                    <div class="row g-4 mt-4">
                        <div class="col-md-4">
                            <div class="bg-white rounded-3 shadow-sm p-4 h-100">
                                <div class="d-flex align-items-center">
                                    <div class="bg-orange-100 rounded-2 p-3 me-3"
                                        style="background-color: #ffedd5 !important;">
                                        <i class="fas fa-users text-orange" style="color: #f97316 !important;"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0">Total Peserta</p>
                                        <h3 class="fw-bold mb-0">{{ $totalPeserta }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="bg-white rounded-3 shadow-sm p-4 h-100">
                                <div class="d-flex align-items-center">
                                    <div class="bg-red-100 rounded-2 p-3 me-3"
                                        style="background-color: #fee2e2 !important;">
                                        <i class="fas fa-crown text-danger"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0">Point Tertinggi</p>
                                        <h3 class="fw-bold mb-0">{{ number_format($pointTertinggi) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="bg-white rounded-3 shadow-sm p-4 h-100">
                                <div class="d-flex align-items-center">
                                    <div class="bg-orange-100 rounded-2 p-3 me-3"
                                        style="background-color: #ffedd5 !important;">
                                        <i class="fas fa-chart-line text-orange" style="color: #f97316 !important;"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0">Rata-rata Poin</p>
                                        <h3 class="fw-bold mb-0">{{ number_format($rataRataPoin) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-10 -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection
