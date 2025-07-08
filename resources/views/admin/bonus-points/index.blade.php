@extends('admin.layouts.base')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 nopadding">
                @include('admin.component.sidebar')
            </div>
            <div class="col-10 nopadding">
                @include('admin.component.newheader')

                <div class="container mt-4">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3>Manajemen Bonus Poin</h3>
                        <a href="{{ route('admin.bonus-points.create') }}" class="btn btn-primary">Tambah Bonus Poin Baru</a>
                    </div>

                    <div class="alert alert-info" role="alert">
                        Pembagian bonus poin berikutnya dalam: <span id="countdown"></span>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Minimal Poin</th>
                                <th>Maksimal Poin</th>
                                <th>Jumlah Bonus</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bonusPointThresholds as $threshold)
                                <tr>
                                    <td>{{ $threshold->id }}</td>
                                    <td>{{ $threshold->name }}</td>
                                    <td>{{ $threshold->min_points }}</td>
                                    <td>{{ $threshold->max_points ?? 'Tak Terhingga' }}</td>
                                    <td>{{ $threshold->bonus_amount }}</td>
                                    <td>
                                        <a href="{{ route('admin.bonus-points.edit', $threshold->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.bonus-points.destroy', $threshold->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus bonus poin ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Set the date we're counting down to
    var countDownDate = new Date("{{ $nextDistributionTime->toIso8601String() }}").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="countdown"
        document.getElementById("countdown").innerHTML = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdown").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>
@endpush