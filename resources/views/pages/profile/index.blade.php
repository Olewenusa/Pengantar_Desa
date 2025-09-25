@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Detail Profil</h1>
                    </div>
    {{-- @if ($errors->any())
        @dd($errors->all())
    @endif --}}
    <div class="row">
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
        <div class="col">
                        {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}
            
            <form action="/profile/{{ auth()->user()->id}}" method="post">
                @csrf
                @method('POST')
                <div class="card">
                    <div class="card-body">
                        

                        <div class="form-group mb-3" >
                            <label for="name" >Nama Lengkap</label>
                            <input type="text" inputmode="numeric" name="name" id="name" class="form-control @error('name') is-invalid
                            @enderror" value="{{ old('name',auth()->user()->name) }}">
                            @error('name')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                                
                            @enderror
                        </div>
                        <div class="form-group mb-3" >
                            <label for="email" >Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid
                                
                            @enderror" value="{{ old('email',auth()->user()->email) }}" readonly>
                            @error('email')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>        
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="rt">RT</label>
                                    <input type="text" name="rt" id="rt" class="form-control" value="{{ auth()->user()->rt ?? '-' }}" readonly>
                                </div>
                            </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="rw">RW</label>
                                <input type="text" name="rw" id="rw" class="form-control" value="{{ auth()->user()->rw ?? '-' }}" readonly>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap:10px">
                            <a href="/dashboard" class="btn btn-outline-secondary" >
                            Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection