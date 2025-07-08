<nav class="sb-topnav navbar sticky-top navbar-expand-lg navbar-light bg-light shadow-sm">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="/"><img src="{{ asset('assets/img/surveyasia_black.svg') }}" alt="Surveyasia"
            width="150"></a>
    {{-- Navbar Toggle --}}
    <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Navbar-->
    <div class="collapse navbar-collapse bg-light" id="navbarNav">
        <ul class="navbar-nav ms-auto me-3 me-lg-4">
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
            @if (Auth::user()->avatar == null)
            <img src="{{ asset('assets/img/noimage.png') }}" alt="Profile Picture" width="40px" height="40px"
                class="d-block mb-2 ms-3 rounded-pill object-fit-cover">
            @elseif (Auth::user()->provider_name != null)
            <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->nama_lengkap }}" width="40" height="40"
                class="d-block mb-2 ms-3 rounded-pill object-fit-cover">
            @else
            <img src="{{ asset('storage/' . \auth::user()->avatar) }}" width="40" height="40" alt="User Avatar"
                class="d-block mb-2 ms-3 rounded-pill object-fit-cover" name="avatar">
            @endif
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ Auth::user()->nama_lengkap }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('user-profile') }}"><i class="fas fa-user fa-fw"></i>
                            Profil</a></li>
                    <li><a class="dropdown-item" href="{{ route('researcher.surveys.index') }}"><i
                                class="fas fa-tachometer-alt fa-fw"></i>
                            Beranda</a>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('change.notice') }}"><i
                                class="fas fa-user-friends fa-fw"></i> Jadi
                            Responden</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt fa-fw"></i>
                                Keluar</a></button>
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