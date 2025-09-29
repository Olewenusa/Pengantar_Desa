@extends('layouts.app')

<<<<<<< HEAD
@section('content')
<div class="container">
    <h2>Dashboard RT - Surat Pengantar</h2>
    <p class="text-muted">RT {{ auth()->user()->rt }} / RW {{ auth()->user()->rw }}</p>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h1>{{ $pengantars->where('status_rt', 'pending')->count() }}</h1>
                    <p class="mb-0">Menunggu Persetujuan</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h1>{{ $pengantars->where('status_rt', 'accepted')->count() }}</h1>
                    <p class="mb-0">Disetujui</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h1>{{ $pengantars->where('status_rt', 'rejected')->count() }}</h1>
                    <p class="mb-0">Ditolak</p>
=======
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
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD

    <!-- Tabel Pengajuan -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Pengajuan Surat Pengantar</h5>
            <div>
                <button class="btn btn-sm btn-outline-warning" onclick="filterStatus('pending')">
                    <i class="bi bi-clock"></i> Menunggu
                </button>
                <button class="btn btn-sm btn-outline-success" onclick="filterStatus('accepted')">
                    <i class="bi bi-check-circle"></i> Disetujui
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="filterStatus('rejected')">
                    <i class="bi bi-x-circle"></i> Ditolak
                </button>
                <button class="btn btn-sm btn-outline-secondary" onclick="filterStatus('all')">
                    <i class="bi bi-list"></i> Semua
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemohon</th>
                            <th>NIK</th>
                            <th>Keperluan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status RT</th>
                            <th>Status RW</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($pengantars as $key => $item)
                        <tr data-status="{{ $item->status_rt }}">
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <strong>{{ $item->name }}</strong><br>
                                <small class="text-muted">{{ $item->resident->name ?? '-' }}</small>
                            </td>
                            <td>{{ $item->NIK }}</td>
                            <td>{{ Str::limit($item->purpose, 50) }}</td>
                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($item->status_rt == 'pending')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($item->status_rt == 'accepted')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if($item->status_rw == 'pending')
                                    <span class="badge bg-secondary">Menunggu</span>
                                @elseif($item->status_rw == 'accepted')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-info" onclick="showDetail({{ $item->id }})" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    
                                    @if($item->status_rt == 'pending')
                                        <button type="button" class="btn btn-sm btn-success" onclick="openApprovalModal({{ $item->id }}, '{{ $item->name }}', 'accepted')" title="Setujui">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="openApprovalModal({{ $item->id }}, '{{ $item->name }}', 'rejected')" title="Tolak">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-2">Belum ada pengajuan surat pengantar</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
=======
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
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
            </div>
        </div>
    </div>
</div>

<<<<<<< HEAD
<!-- Modal Approval -->
<div class="modal fade" id="approvalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="approvalForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Konfirmasi Persetujuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="modalMessage"></p>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                    <input type="hidden" name="status" id="statusInput">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="confirmBtn">Konfirmasi</button>
=======
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
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
                </div>
            </form>
        </div>
    </div>
</div>

<<<<<<< HEAD
<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Surat Pengantar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <div class="text-center py-4">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Filter status
function filterStatus(status) {
    const rows = document.querySelectorAll('#tableBody tr[data-status]');
    rows.forEach(row => {
        if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Open approval modal
function openApprovalModal(id, name, action) {
    const modal = new bootstrap.Modal(document.getElementById('approvalModal'));
    const form = document.getElementById('approvalForm');
    const title = document.getElementById('modalTitle');
    const message = document.getElementById('modalMessage');
    const statusInput = document.getElementById('statusInput');
    const confirmBtn = document.getElementById('confirmBtn');
    
    // Set form action
    form.action = `/pengantar/${id}/update-rt`;
    
    // Set status
    statusInput.value = action;
    
    // Set modal content
    if (action === 'accepted') {
        title.textContent = 'Setujui Pengajuan';
        message.innerHTML = `Apakah Anda yakin ingin <strong class="text-success">MENYETUJUI</strong> pengajuan dari <strong>${name}</strong>?`;
        confirmBtn.className = 'btn btn-success';
        confirmBtn.textContent = 'Setujui';
    } else {
        title.textContent = 'Tolak Pengajuan';
        message.innerHTML = `Apakah Anda yakin ingin <strong class="text-danger">MENOLAK</strong> pengajuan dari <strong>${name}</strong>?`;
        confirmBtn.className = 'btn btn-danger';
        confirmBtn.textContent = 'Tolak';
    }
    
    // Clear notes
    document.getElementById('notes').value = '';
    
    modal.show();
}

// Show detail
function showDetail(id) {
    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    const content = document.getElementById('detailContent');
    
    // Show loading
    content.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
    
    modal.show();
    
    // Fetch detail via AJAX
    fetch(`/pengantar/${id}/detail`)
        .then(response => response.json())
        .then(data => {
            content.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informasi Pemohon</h6>
                        <table class="table table-sm">
                            <tr><th>Nama</th><td>${data.name}</td></tr>
                            <tr><th>NIK</th><td>${data.NIK}</td></tr>
                            <tr><th>Data Penduduk</th><td>${data.resident_name || '-'}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Detail Pengajuan</h6>
                        <table class="table table-sm">
                            <tr><th>Keperluan</th><td>${data.purpose}</td></tr>
                            <tr><th>Tanggal Dibutuhkan</th><td>${data.date}</td></tr>
                            <tr><th>Tanggal Pengajuan</th><td>${data.created_at}</td></tr>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Status RT</h6>
                        <p><span class="badge bg-${data.status_rt_color}">${data.status_rt_text}</span></p>
                        ${data.notes_rt ? `<p><strong>Catatan:</strong> ${data.notes_rt}</p>` : ''}
                    </div>
                    <div class="col-md-6">
                        <h6>Status RW</h6>
                        <p><span class="badge bg-${data.status_rw_color}">${data.status_rw_text}</span></p>
                        ${data.notes_rw ? `<p><strong>Catatan:</strong> ${data.notes_rw}</p>` : ''}
                    </div>
                </div>
            `;
        })
        .catch(error => {
            content.innerHTML = `
                <div class="alert alert-danger">
                    Gagal memuat detail. Silakan coba lagi.
                </div>
            `;
        });
}
</script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
@endsection
=======
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
>>>>>>> 233322a9c996a99db394807f7489572fb8c4a25a
