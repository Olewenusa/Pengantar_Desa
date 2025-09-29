@extends('layouts.app')

@section('title', 'Detail Surat Pengantar')

@section('content')

{{-- Script untuk Notifikasi --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: 'OK'
        });
    });
</script>
@endif
@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: "Gagal!",
            text: "{{ session('error') }}",
            icon: "error",
            confirmButtonText: 'OK'
        });
    });
</script>
@endif

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Surat Pengantar</h1>
    <a href="{{ route('pengantar.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="row">

    <!-- Kolom Informasi Pengajuan -->
    <div class="col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Pengajuan</h6>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">ID Pengajuan</div>
                    <div class="col-sm-8">#{{ str_pad($pengantar->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">Nama Pemohon</div>
                    <div class="col-sm-8">{{ $pengantar->name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">NIK</div>
                    <div class="col-sm-8">{{ $pengantar->NIK }}</div>
                </div>
                 <div class="row mb-2">
                    <div class="col-sm-4 text-muted">Data Penduduk</div>
                    <div class="col-sm-8">{{ $pengantar->resident->name ?? 'N/A' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">Keperluan</div>
                    <div class="col-sm-8">{{ $pengantar->purpose }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">Tgl Dibutuhkan</div>
                    <div class="col-sm-8">{{ $pengantar->date->format('d F Y') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 text-muted">Tgl Pengajuan</div>
                    <div class="col-sm-8">{{ $pengantar->report_date->format('d F Y, H:i') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Status Proses -->
    <div class="col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Status Proses</h6>
            </div>
            <div class="card-body">
                <!-- Status RT -->
                <div class="d-flex align-items-center mb-3">
                    <div class="mr-3">
                        @if($pengantar->status_rt === 'accepted')
                            <div class="btn btn-success btn-circle"><i class="fas fa-check"></i></div>
                        @elseif($pengantar->status_rt === 'rejected')
                            <div class="btn btn-danger btn-circle"><i class="fas fa-times"></i></div>
                        @else
                             <div class="btn btn-warning btn-circle"><i class="fas fa-clock"></i></div>
                        @endif
                    </div>
                    <div>
                        <div class="font-weight-bold">Persetujuan RT</div>
                        @if($pengantar->status_rt === 'accepted')
                            <div class="small text-success">Disetujui</div>
                        @elseif($pengantar->status_rt === 'rejected')
                             <div class="small text-danger">Ditolak</div>
                        @else
                            <div class="small text-warning">Menunggu Persetujuan</div>
                        @endif
                        @if($pengantar->notes_rt)
                             <small class="text-muted d-block mt-1"><i>"{{ $pengantar->notes_rt }}"</i></small>
                        @endif
                    </div>
                </div>
                
                <!-- Status RW -->
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                         @if($pengantar->status_rt !== 'accepted')
                             <div class="btn btn-secondary btn-circle"><i class="fas fa-lock"></i></div>
                        @elseif($pengantar->status_rw === 'accepted')
                             <div class="btn btn-success btn-circle"><i class="fas fa-check"></i></div>
                        @elseif($pengantar->status_rw === 'rejected')
                            <div class="btn btn-danger btn-circle"><i class="fas fa-times"></i></div>
                        @else
                            <div class="btn btn-warning btn-circle"><i class="fas fa-clock"></i></div>
                        @endif
                    </div>
                    <div>
                        <div class="font-weight-bold">Persetujuan RW</div>
                        @if($pengantar->status_rt !== 'accepted')
                            <div class="small text-muted">Menunggu persetujuan RT</div>
                        @elseif($pengantar->status_rw === 'accepted')
                            <div class="small text-success">Disetujui</div>
                        @elseif($pengantar->status_rw === 'rejected')
                             <div class="small text-danger">Ditolak</div>
                        @else
                            <div class="small text-warning">Menunggu Persetujuan</div>
                        @endif
                         @if($pengantar->notes_rw)
                             <small class="text-muted d-block mt-1"><i>"{{ $pengantar->notes_rw }}"</i></small>
                        @endif
                    </div>
<<<<<<< HEAD
                    
                </div>
            </div>
            
        </div>
    </div>
</div>
@if($pengantar->status_rt === 'accepted' && $pengantar->status_rw === 'accepted')
<div class="row">
    <div class="col-12">
        <div class="alert alert-success shadow" role="alert">
            <h4 class="alert-heading">
                <i class="fas fa-check-circle"></i> Selamat! Pengajuan Diterima
            </h4>
            <p>
                Surat pengantar Anda telah disetujui oleh Ketua RT dan Ketua RW. 
                Proses selanjutnya adalah di Kantor Desa.
            </p>
            <hr>
            <p class="mb-0">
                <strong>Silakan datang ke Kantor Desa</strong> dengan membawa dokumen yang sudah dicetak.
            </p>
        </div>
    </div>
</div>
@endif
=======
                </div>
            </div>
        </div>
    </div>
</div>

>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a

<!-- Form Aksi untuk RT -->
@if(auth()->user()->role === 'rt' && $pengantar->status_rt === 'pending')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Aksi Persetujuan RT</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pengantar.process.rt', $pengantar) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="notes">Catatan (Opsional)</label>
                <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" name="status" value="rejected" class="btn btn-danger mr-2" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">
                    <i class="fas fa-times"></i> Tolak
                </button>
                <button type="submit" name="status" value="accepted" class="btn btn-success">
                    <i class="fas fa-check"></i> Setujui
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- Form Aksi untuk RW -->
@if(auth()->user()->role === 'rw' && $pengantar->status_rt === 'accepted' && $pengantar->status_rw === 'pending')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Aksi Persetujuan RW</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pengantar.process.rw', $pengantar) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="notes_rw">Catatan (Opsional)</label>
                <textarea name="notes" id="notes_rw" rows="3" class="form-control" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
            </div>
             <div class="d-flex justify-content-end">
                <button type="submit" name="status" value="rejected" class="btn btn-danger mr-2" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">
                    <i class="fas fa-times"></i> Tolak
                </button>
                <button type="submit" name="status" value="accepted" class="btn btn-success">
                    <i class="fas fa-check"></i> Setujui
                </button>
            </div>
        </form>
    </div>
</div>
@endif


@endsection
