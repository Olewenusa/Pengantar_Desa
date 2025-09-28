@extends('layouts.app')

@section('title', 'Edit Surat Pengantar')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Surat Pengantar</h1>
    <a href="{{ route('pengantar.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<!-- Display Validation Errors -->
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Surat Pengantar</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pengantar.update', $pengantar) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="resident_id">Data Penduduk <span class="text-danger">*</span></label>
                <select name="resident_id" id="resident_id" class="form-control @error('resident_id') is-invalid @enderror" required>
                    <option value="">Pilih Data Penduduk</option>
                    @foreach($residents as $resident)
                        <option value="{{ $resident->id }}" 
                            {{ (old('resident_id', $pengantar->resident_id) == $resident->id) ? 'selected' : '' }}>
                            {{ $resident->name }} - {{ $resident->NIK }}
                        </option>
                    @endforeach
                </select>
                @error('resident_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Nama Pemohon <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" 
                       value="{{ old('name', $pengantar->name) }}"
                       class="form-control @error('name') is-invalid @enderror"
                       placeholder="Masukkan nama pemohon" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="NIK">NIK <span class="text-danger">*</span></label>
                <input type="text" name="NIK" id="NIK" 
                       value="{{ old('NIK', $pengantar->NIK) }}"
                       class="form-control @error('NIK') is-invalid @enderror"
                       placeholder="Masukkan NIK (16 digit)"
                       maxlength="16" pattern="[0-9]{16}" required>
                <small class="form-text text-muted">NIK harus terdiri dari 16 digit angka.</small>
                @error('NIK')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="purpose">Keperluan <span class="text-danger">*</span></label>
                <textarea name="purpose" id="purpose" rows="4"
                          class="form-control @error('purpose') is-invalid @enderror"
                          placeholder="Jelaskan keperluan surat pengantar..."
                          required>{{ old('purpose', $pengantar->purpose) }}</textarea>
                @error('purpose')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="date">Tanggal Dibutuhkan <span class="text-danger">*</span></label>
                <input type="date" name="date" id="date" 
                       value="{{ old('date', $pengantar->date->format('Y-m-d')) }}"
                       min="{{ date('Y-m-d') }}"
                       class="form-control @error('date') is-invalid @enderror" required>
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="alert alert-warning">
                <h6 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Perhatian!</h6>
                <p class="mb-0">Surat pengantar hanya dapat diedit selama status masih "Menunggu Persetujuan RT". Setelah diproses oleh RT, surat tidak dapat diubah lagi.</p>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('pengantar.index') }}" class="btn btn-secondary mr-2">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Auto-fill name and NIK based on resident selection
    document.getElementById('resident_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const text = selectedOption.text.trim();
            const parts = text.split(' - ');
            if (parts.length >= 2) {
                document.getElementById('name').value = parts[0];
                document.getElementById('NIK').value = parts[1];
            }
        }
    });

    // Format NIK input to numbers only
    document.getElementById('NIK').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    });
});
</script>
@endpush
