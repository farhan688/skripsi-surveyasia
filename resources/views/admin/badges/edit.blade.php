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
                    <h3>Edit Badge</h3>

                    <form action="{{ route('admin.badges.update', $badge->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Badge</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $badge->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="min_threshold_points" class="form-label">Minimum Threshold Poin</label>
                            <input type="number" class="form-control" id="min_threshold_points" name="min_threshold_points" value="{{ $badge->min_threshold_points }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="max_threshold_points" class="form-label">Maximum Threshold Poin</label>
                            <input type="number" class="form-control" id="max_threshold_points" name="max_threshold_points" value="{{ $badge->max_threshold_points }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Badge</label>
                            @if ($badge->image_path)
                                <img src="{{ asset('storage/' . $badge->image_path) }}" alt="{{ $badge->name }}" width="100" class="d-block mb-2">
                            @endif
                            <input type="file" class="form-control" id="image" name="image">
                            <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.badges.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection