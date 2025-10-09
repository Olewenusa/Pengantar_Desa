@extends('layouts.app')

@section('title', 'Ajukan Surat Pengantar')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ajukan Surat Pengantar</h1>
    <a href="{{ route('pengantar.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

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
        <h6 class="m-0 font-weight-bold text-primary">Form Pengajuan Surat Pengantar</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pengantar.store') }}" method="POST">
            @csrf

            {{-- 1. INPUT TERSEMBUNYI UNTUK resident_id --}}
            {{-- Mengirim ID user yang login secara otomatis --}}
            <input type="hidden" name="resident_id" value="{{ auth()->user()->id }}">

            {{-- 2. INPUT NAMA PEMOHON (READONLY) --}}
            <div class="form-group">
                <label for="name">Nama Pemohon</label>
                <input type="text" name="name" id="name" 
                       value="{{ auth()->user()->name }}"
                       class="form-control"
                       readonly>
            </div>

            {{-- 3. INPUT NIK (READONLY) --}}
            <div class="form-group">
    <label for="NIK">NIK <span class="text-danger">*</span></label>
    <input type="text" name="NIK" id="NIK" 
           value="{{ old('NIK') }}"
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
                          required>{{ old('purpose') }}</textarea>
                @error('purpose')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="date">Tanggal Dibutuhkan <span class="text-danger">*</span></label>
                <input type="date" name="date" id="date" 
                       value="{{ old('date', date('Y-m-d')) }}"
                       min="{{ date('Y-m-d') }}"
                       class="form-control @error('date') is-invalid @enderror" required>
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="alert alert-info">
                <h6 class="alert-heading"><i class="fas fa-info-circle"></i> Informasi Proses</h6>
                <ul class="mb-0 pl-3">
                    <li>Surat pengantar akan diproses oleh RT terlebih dahulu.</li>
                    <li>Setelah disetujui RT, akan dilanjutkan ke RW.</li>
                    <li>Proses persetujuan membutuhkan waktu 1-3 hari kerja.</li>
                    <li>Anda akan mendapat notifikasi setiap perubahan status.</li>
                </ul>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('pengantar.index') }}" class="btn btn-secondary mr-2">Batal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Ajukan Surat
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

{{-- 4. JAVASCRIPT DIHAPUS --}}
{{-- Blok @push('scripts') tidak diperlukan lagi --}}