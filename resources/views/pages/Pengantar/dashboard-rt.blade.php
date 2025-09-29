@extends('layouts.app')

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
                </div>
            </div>
        </div>
    </div>

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
            </div>
        </div>
    </div>
</div>

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
                </div>
            </form>
        </div>
    </div>
</div>

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
