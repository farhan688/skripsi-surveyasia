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
                        <h3>Manajemen Badge</h3>
                        <a href="{{ route('admin.badges.create') }}" class="btn btn-primary">Tambah Badge Baru</a>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Minimal Point</th>
                                <th>Maksimal Point</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($badges as $badge)
                                <tr>
                                    <td>{{ $badge->id }}</td>
                                    <td>{{ $badge->name }}</td>
                                    <td>{{ $badge->min_threshold_points }}</td>
                                    <td>{{ $badge->max_threshold_points }}</td>
                                    <td><img src="{{ Storage::url($badge->image_path) }}" alt="{{ $badge->name }}" width="50"></td>
                                    <td>
                                        <a href="{{ route('admin.badges.edit', $badge->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.badges.destroy', $badge->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus badge ini?')">Hapus</button>
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