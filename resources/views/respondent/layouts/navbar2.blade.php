<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light shadow-sm">
    <a class="navbar-brand link-default ms-3" href="/"><img src="{{ asset('assets/img/surveyasia_black.svg') }}"
            alt="Surveyasia" width="150"></a>
    <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse ms-3" id="navbarNav">
        <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item">
                <a class="nav-link" href="/">Beranda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('respondent.survey.leaderboard') }}">Leaderboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('respondent.survey.history') }}">Riwayat Survey</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('contact.index') }}">Kontak</a>
            </li>
            <li class="nav-item me-3">
                <a class="nav-link" href="{{ route('news.index') }}">Berita</a>
            </li>
            @auth
                <li class="nav-item dropdown position-relative">
                    <a class="nav-link px-2" href="#" id="navbarDropdownNotification" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell fa-lg"></i>
                        @if (Auth::user()->unreadNotifications->count() > 0)
                            <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle" style="font-size: 0.6em;">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownNotification" style="min-width: 280px;">
                        <li><h6 class="dropdown-header">Notifikasi</h6></li>
                        @forelse (Auth::user()->unreadNotifications as $notification)
                            <li><a class="dropdown-item" href="#" onclick="markAsRead('{{ $notification->id }}')">{{ $notification->data['message'] }}</a></li>
                        @empty
                            <li><a class="dropdown-item" href="#">Tidak ada notifikasi baru.</a></li>
                        @endforelse
                        @if (Auth::user()->unreadNotifications->count() > 0)
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-center" href="#" onclick="markAllAsRead()">Tandai semua sudah dibaca</a></li>
                        @endif
                    </ul>
                </li>
                @if (\Auth::user()->avatar == null)
                    <li>
                        <img class="rounded-circle object-fit-cover" src="{{ asset('assets/img/noimage.png') }}"
                            width="40px" name="avatar" height="40px" alt="User Avatar">
                    </li>
                @elseif (Auth::user()->provider_name != null)
                    <li>
                        <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->nama_lengkap }}" width="40"
                            height="40" class="d-block mb-2 ms-3 rounded-pill object-fit-cover">
                    </li>
                @else
                    <li>
                        <img class="rounded-circle object-fit-cover" src="{{ asset('storage/' . Auth::user()->avatar) }}"
                            width="40px" height="40px" alt="User Avatar" name="avatar">
                    </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->nama_lengkap }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('user-profile') }}"><i class="fas fa-user fa-fw"></i>
                                Profil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/"><i class="fas fa-tachometer-alt fa-fw"></i> Beranda</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('change.notice') }}"><i
                                    class="fas fa-user-friends fa-fw"></i> Jadi Researcher</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt fa-fw"></i>
                                    Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            @endauth
        </ul>
    </div>
</nav>

<script>
    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }

    function markAllAsRead() {
        fetch(`/notifications/mark-all-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
</script>
