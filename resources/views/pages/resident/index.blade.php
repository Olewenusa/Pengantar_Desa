@extends('layouts.app')

@section('content')
                   <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Data Penduduk</h1>
                        <a href="/resident/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
                    </div>

        {{-- TABLE --}}
    <div class="row">
        <div class="col">
            <div class="card" shadow>
                <div class="card-body">
                <table class="table table-responsive table-bordered table-hovered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Tempat, Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>RT</th>
                            <th>RW</th>
                            <th>Agama</th>
                            <th>No Telephone</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    @if (count($residents)<1)
                        <tbody>
                            <tr>
                                <td colspan="11">
                                    <p class="pt-3 text-center">Tidak Ada Data</p>
                                </td>
                            </tr>
                        </tbody>
                    @else
                        <tbody>
                        @foreach ($residents as $item)
                            <tr>
                            <td>{{ $loop->iteration + $residents->firstItem() - 1 }}</td>
                            <td>{{$item ->nik}}</td>
                            <td>{{$item ->name}}</td>
                            <td>{{$item ->gender}}</td>
                            <td>{{$item ->birth_place}}, {{$item ->birth_date}}</td>
                            <td>{{$item ->address}}</td>
                            <td>{{$item ->RT}}</td>
                            <td>{{$item ->RW}}</td>
                            <td>{{$item ->religion}}</td>
                            <td>{{$item ->phone}}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="/resident/{{ $item ->id }}" class="d-inline-block mr-2 btn btn-sm btn-warning">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <div class="">
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#ConfirmationDelete-{{ $item->id }}">
                                        <i class="fas fa-eraser"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @include('pages.resident.confirmationdelete')
                        @endforeach
                    </tbody>
                    @endif
                </table>
                </div>
                @if ($residents->lastPage()>1)
                
                    <div class="card-footer">
                        {{ $residents->links('pagination::bootstrap-5') }}
                    </div>
                
                @endif
            </div>
        </div>
    </div>
@endsection