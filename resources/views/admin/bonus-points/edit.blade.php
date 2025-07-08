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
                    <h3>Edit Bonus Poin</h3>

                    <form action="{{ route('admin.bonus-points.update', $bonusPointThreshold->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $bonusPointThreshold->name) }}" required>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="min_points" class="form-label">Minimal Poin</label>
                            <input type="number" class="form-control" id="min_points" name="min_points" value="{{ old('min_points', $bonusPointThreshold->min_points) }}" required>
                            @error('min_points')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="max_points" class="form-label">Maksimal Poin (Kosongkan jika tak terbatas)</label>
                            <input type="number" class="form-control" id="max_points" name="max_points" value="{{ old('max_points', $bonusPointThreshold->max_points) }}">
                            @error('max_points')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="bonus_amount" class="form-label">Jumlah Bonus</label>
                            <input type="number" class="form-control" id="bonus_amount" name="bonus_amount" value="{{ old('bonus_amount', $bonusPointThreshold->bonus_amount) }}" required>
                            @error('bonus_amount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.bonus-points.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection