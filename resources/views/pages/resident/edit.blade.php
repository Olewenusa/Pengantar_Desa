@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Ubah Penduduk</h1>
                    </div>
    {{-- @if ($errors->any())
        @dd($errors->all())
    @endif --}}
    <div class="row">
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
            
            <form action="/resident/{{ $resident->id }}" method="post">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3" >
                            <label for="nik" >NIK</label>
                            <input type="number" inputmode="numeric" name="nik" id="nik" class="form-control @error('nik') is-invalid
                                
                            @enderror" value="{{ old('nik',$resident->nik) }}">
                            @error('nik')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>        
                            @enderror
                        </div>

                        <div class="form-group mb-3" >
                            <label for="name" >Nama Lengkap</label>
                            <input type="text" inputmode="numeric" name="name" id="name" class="form-control @error('name') is-invalid
                            @enderror" value="{{ old('name',$resident->name) }}">
                            @error('name')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                                
                            @enderror
                        </div>
                        <div class="form-group mb-3" >
                            <label for="gender" >Jenis Kelamin</label>
                            <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror">
                                @foreach ([
                                    (object)[ "label" =>"Laki-Laki", "value" =>"Laki-Laki"  ],
                                    (object)[ "label" =>"Perempuan", "value" =>"Perempuan"],
                                ] as $item)
                                    <option value="{{ $item->value }}" 
                                        @selected(old('gender', $resident->gender) == $item->value)>{{ $item->label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gender')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="birth_place">Tempat Lahir</label>
                                    <input type="text" name="birth_place" id="birth_place" class="form-control @error('birth_place') is-invalid
                                
                            @enderror" value="{{ old('birth_place',$resident->birth_place) }}">
                            @error('birth_place')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                            @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="birth_date">Tanggal Lahir</label>
                                    <input type="date" name="birth_date" id="birth_date" class="form-control @error('birth_date') is-invalid
                                
                            @enderror " value="{{ old('birth_date',$resident->birth_date) }}">
                             @error('birth_date')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                            @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3" >
                            <label for="address" >Alamat</label>
                            <textarea name="address" id="address" class="form-control @error('address') is-invalid
                                
                            @enderror" cols="30" rows="10" >{{old('address',$resident->address)}}</textarea>
                            @error('address')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3" >
                            <label for="religion" >Agama</label>
                            <input type="text" name="religion" id="religion" class="form-control @error('religion') is-invalid
                                
                            @enderror" value="{{ old('religion',$resident->religion) }}">
                            @error('religion')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3" >
                            <label for="phone" >Telepon</label>
                            <input type="number" inputmode="numeric" name="phone" id="phone" class="form-control @error('phone') is-invalid
                                
                            @enderror" value="{{ old('phone',$resident->phone) }}">
                            @error('phone')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="rw_select">RW</label>
                                <select name="RW" id="rw_select" class="form-control @error('RW') is-invalid @enderror">
                                    <option value="">-- Pilih RW --</option>
                                    @foreach($wilayahData as $rw => $maxRt)
                                        <option value="{{ $rw }}" {{ old('RW', $resident->RW) == $rw ? 'selected' : '' }}>RW {{ $rw }}</option>
                                    @endforeach
                                </select>
                                @error('RW')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="rt_select">RT</label>
                                <select name="RT" id="rt_select" class="form-control @error('RT') is-invalid @enderror">
                                    <option value="">-- Pilih RW Terlebih Dahulu --</option>
                                </select>
                                @error('RT')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap:10px">
                            <a href="/resident" class="btn btn-outline-secondary" >
                            Kembali
                            </a>
                            <button type="submit" class="btn btn-warning">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script>
    const wilayahData = @json($wilayahData);
    const rwSelect = document.getElementById('rw_select');
    const rtSelect = document.getElementById('rt_select');

    // Helper to populate RT options
    function populateRT(selectedRW, selectedRT = null) {
        rtSelect.innerHTML = '<option value="">-- Pilih RT --</option>';
        rtSelect.disabled = true;
        if (selectedRW && wilayahData[selectedRW]) {
            const maxRT = wilayahData[selectedRW];
            rtSelect.disabled = false;
            for (let i = 1; i <= maxRT; i++) {
                const rtNumber = String(i).padStart(2, '0');
                const option = document.createElement('option');
                option.value = rtNumber;
                option.textContent = `RT ${rtNumber}`;
                if (selectedRT && selectedRT === rtNumber) {
                    option.selected = true;
                }
                rtSelect.appendChild(option);
            }
        } else {
            rtSelect.innerHTML = '<option value="">-- Pilih RW Terlebih Dahulu --</option>';
        }
    }

    // On RW change
    rwSelect.addEventListener('change', function() {
        populateRT(this.value);
    });

    // On page load, set RT if RW is selected
    window.addEventListener('DOMContentLoaded', function() {
        const selectedRW = rwSelect.value;
        // Use old RT if exists, else resident RT
        const selectedRT = "{{ old('RT', $resident->RT) }}";
        if (selectedRW) {
            populateRT(selectedRW, selectedRT);
        }
    });
    </script>
@endsection