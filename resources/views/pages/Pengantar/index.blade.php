@extends('layouts.app')

@section('title', 'Daftar Surat Pengantar')

@section('content')

{{-- Script untuk Notifikasi --}}
@if (session('success'))
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
@if (session('error'))
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
    <h1 class="h3 mb-0 text-gray-800">Daftar Surat Pengantar</h1>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-end">
        <a href="{{ route('pengantar.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Ajukan Surat Pengantar
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Keperluan</th>
                        <th class="text-center">Status RT</th>
                        <th class="text-center">Status RW</th>
                        <th>Tanggal Pengajuan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengantars as $key => $pengantar)
                        <tr>
                            <td class="text-center">{{ $pengantars->firstItem() + $key }}</td>
                            <td>
    {{-- Menampilkan nama penduduk (dari tabel users) --}}
    <strong>{{ $pengantar->resident->name ?? 'Data Penduduk Tidak Ditemukan' }}</strong>
    
    {{-- Menampilkan nama user yang mengajukan surat (dari tabel users juga) --}}
    <br>
    <small class="text-muted">Diajukan oleh: {{ $pengantar->user->name ?? 'N/A' }}</small>
</td>
                            <td>{{ $pengantar->NIK }}</td>
                            <td>{{ Str::limit($pengantar->purpose, 35) }}</td>
                            <td class="text-center">
                                @if($pengantar->status_rt === 'pending')
                                    <span class="badge badge-warning">Menunggu</span>
                                @elseif($pengantar->status_rt === 'accepted')
                                    <span class="badge badge-success">Disetujui</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($pengantar->status_rw === 'pending')
                                    <span class="badge badge-secondary">
                                        {{ $pengantar->status_rt === 'accepted' ? 'Menunggu' : 'Belum Diproses' }}
                                    </span>
                                @elseif($pengantar->status_rw === 'accepted')
                                    <span class="badge badge-success">Disetujui</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>{{ $pengantar->report_date->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('pengantar.show', $pengantar) }}" class="btn btn-info btn-circle btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($pengantar->status_rt === 'pending')
                                    <a href="{{ route('pengantar.edit', $pengantar) }}" class="btn btn-success btn-circle btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pengantar.destroy', $pengantar) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-circle btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                Belum ada surat pengantar yang diajukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-4">
            {{ $pengantars->links() }}
        </div>
    </div>
</div>

@endsection

