@extends('layouts.footer')
@extends('layouts.base')

@if (Auth::user()->role_id == 2)
@include('researcher.layouts.navbar2')
@elseif(Auth::user()->role_id == 3)
@include('respondent.layouts.navbar2')
@endif

@section('content')

<h3 class="pt-5 ms-5 fw-bold">Saldo Saya</h3>

<section class="user-profile pt-4 pb-5 mx-5" id="user-profile">
    <div class="row">
        <div class="col-lg-2 d-none d-md-block">
            <div class="shadow p-4 me-4" style="border-radius: 16px;">
                <h5>Personal</h5>
                <a href="{{ route('user-profile') }}" class="link-dark text-decoration-none">
                    <p class="mt-3 ms-3"><i class="fas fa-user fa-fw"></i> profil</p>
                </a>
                @if(Auth::user()->role_id == 3)
                <a href="{{ route('respondent.survey.history') }}" class="link-dark text-decoration-none">
                    <p class="mt-3 ms-3"><i class="fas fa-ticket-alt fa-fw"></i> Saldo Hadiah</p>
                </a>
                @endif
                @if (Auth::user()->role_id == 2)
                <a href="{{ route('researcher.transaction.history') }}" class="link-dark text-decoration-none">
                    <p class="mt-3 ms-3"><i class="fas fa-file-invoice-dollar fa-fw"></i> Riwayat Transaksi</p>
                </a>
                <a href="#" class="link-dark text-decoration-none">
                    <p class="mt-3 ms-3"><i class="fas fa-wallet fa-fw"></i> Saldo</p>
                </a>
                <a href="{{ route('researcher.tutorial.index') }}" class="link-dark text-decoration-none">
                    <p class="mt-3 ms-3"><i class="fas fa-tv fa-fw"></i> Tutorial</p>
                </a>
                @endif
                <a href="{{ route('news.index') }}" class="link-dark text-decoration-none">
                    <p class="mt-3 ms-3"><i class="fas fa-newspaper fa-fw"></i> Berita</p>
                </a>
                <a href="{{ route('contact.index') }}" class="link-dark text-decoration-none">
                    <p class="mt-3 ms-3"><i class="fas fa-phone-alt fa-fw"></i> Kontak</p>
                </a>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt fa-fw"></i>
                        Keluar</button>
                </form>
            </div>
        </div>

        <div class="col-lg-10 shadow pt-4 pb-5 px-5" style="border-radius: 16px; position: relative;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold">Saldo Anda: Rp{{ number_format($user->reward_balance ?? 0, 0, ',', '.') }}</h4>
                <button class="btn btn-orange radius-default" data-bs-toggle="modal" data-bs-target="#topUpModal">Top Up Saldo</button>
            </div>

            <div class="modal fade" id="topUpModal" tabindex="-1" aria-labelledby="topUpModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="topUpModalLabel">Top Up Saldo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('balance.topup') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Jumlah Top Up (Rupiah)</label>
                                    <input type="number" class="form-control" id="amount" name="amount" min="10000" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-orange">Top Up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection