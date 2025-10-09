@extends('layouts.app')

@section('content')
                   <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Daftar Akun Penduduk</h1>
                    </div>
        @if (session('success'))
        <script>
        Swal.fire({
        title: "berhasil",
        text: "{{ session()->get('success') }}",
        icon: "success"
        });
    </script>
    @else
    @endif
        {{-- TABLE --}}
    <div class="row">
        <div class="col">
            <div class="card" shadow>
                <div class="card-body">
                    <div style="overflow-x: auto;">
                        <table class="table table-bordered table-hovered" style"min-width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>RT</th>
                                    <th>RW</th>
                                    <th>Role_ID</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            @if (count($users)<1)
                                <tbody>
                                    <tr>
                                        <td colspan="11">
                                            <p class="pt-3 text-center">Tidak Ada Data</p>
                                        </td>
                                    </tr>
                                </tbody>
                            @else
                                <tbody>
                                @foreach ($users as $item)
                                    <tr>
                                    <td>{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->rt ?? '-' }}</td>
                                    <td>{{ $item->rw ?? '-' }}</td>
                                    <td>{{ $item->role_id }}</td>
                                    <td>
                                        @if ($item->status == 'approved')
                                            <span class="badge bg-success text-white">Aktif</span>
                                        @else
                                            <span class="badge bg-danger text-white">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex" style="gap: 10px">
                                            <div class="">
                                                @if ($item->status == 'approved')
                                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmationReject-{{ $item->id }}">
                                                        Non-Aktifkan Akun
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#confirmationApprove-{{ $item->id }}">
                                                        Aktifkan Akun
                                                    </button>
                                                @endif
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @include('pages.account_list.confirmationApprove')
                                @include('pages.account_list.confirmationReject')
                                @endforeach
                            </tbody>
                            @endif
                        </table>
                    </div>
                </div>
                @if ($users->lastPage()>1)
                
                    <div class="card-footer">
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                
                @endif
            </div>
        </div>
    </div>
@endsection