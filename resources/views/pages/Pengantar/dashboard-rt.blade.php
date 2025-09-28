@extends('layouts.app')

@section('title', 'Dashboard RT - Surat Pengantar')

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

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard RT - Surat Pengantar</h1>
</div>
<p class="mb-4">Kelola persetujuan surat pengantar sebagai RT.</p>

<!-- Content Row - Statistics Cards -->
<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu Persetujuan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pending }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $accepted }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rejected }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Requests Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-clock mr-2"></i>Pengajuan Menunggu Persetujuan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pemohon</th>
                        <th>NIK</th>
                        <th>Keperluan</th>
                        <th>Tgl Dibutuhkan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $pendingRequests = $pengantars->where('status_rt', 'pending') @endphp
                    @forelse($pendingRequests as $pengantar)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div>{{ $pengantar->name }}</div>
                            <small class="text-muted">{{ $pengantar->resident->name ?? 'N/A' }}</small>
                        </td>
                        <td>{{ $pengantar->NIK }}</td>
                        <td>{{ $pengantar->purpose }}</td>
                        <td>{{ $pengantar->date->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('pengantar.show', $pengantar) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <button onclick="openQuickApprovalModal({{ $pengantar->id }}, '{{ addslashes($pengantar->name) }}')" class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i> Proses
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada pengajuan yang menunggu persetujuan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- All Requests Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Semua Riwayat Pengajuan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pemohon</th>
                        <th>NIK</th>
                        <th>Status RT</th>
                        <th>Status RW</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengantars as $key => $pengantar)
                    <tr>
                        <td>{{ $pengantars->firstItem() + $key }}</td>
                        <td>{{ $pengantar->name }}</td>
                        <td>{{ $pengantar->NIK }}</td>
                        <td>
                            @if($pengantar->status_rt === 'pending')
                                <span class="badge badge-warning">Menunggu</span>
                            @elseif($pengantar->status_rt === 'accepted')
                                <span class="badge badge-success">Disetujui</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if($pengantar->status_rw === 'pending')
                                <span class="badge badge-warning">{{ $pengantar->status_rt === 'accepted' ? 'Menunggu' : 'Belum Diproses' }}</span>
                            @elseif($pengantar->status_rw === 'accepted')
                                <span class="badge badge-success">Disetujui</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $pengantar->report_date->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('pengantar.show', $pengantar) }}" class="btn btn-info btn-circle btn-sm" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada riwayat pengajuan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end">
            {{ $pengantars->links() }}
        </div>
    </div>
</div>

<!-- Quick Approval Modal -->
<div class="modal fade" id="quickApprovalModal" tabindex="-1" role="dialog" aria-labelledby="quickApprovalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickApprovalModalLabel">Proses Persetujuan untuk <strong id="modalPengantarName"></strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="approvalForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="modalNotes">Catatan (Opsional)</label>
                        <textarea name="notes" id="modalNotes" rows="3" class="form-control" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" name="status" value="rejected" class="btn btn-danger">Tolak</button>
                    <button type="submit" name="status" value="accepted" class="btn btn-success">Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openQuickApprovalModal(pengantarId, pengantarName) {
    // Setel nama pemohon di judul modal
    document.getElementById('modalPengantarName').textContent = pengantarName;
    
    // Setel URL action untuk form
    const form = document.getElementById('approvalForm');
    const baseUrl = "{{ url('pengantar/process/rt') }}";
    form.action = `${baseUrl}/${pengantarId}`;
    
    // Tampilkan modal
    $('#quickApprovalModal').modal('show');
}
</script>
@endpush
