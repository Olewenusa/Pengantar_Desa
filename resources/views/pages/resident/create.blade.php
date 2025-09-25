@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tambah Penduduk</h1>
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
            <form action="/resident" method="post">
                @csrf
                @method('POST')
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3" >
                            <label for="nik" >NIK</label>
                            <input type="number" inputmode="numeric" name="nik" id="nik" class="form-control @error('nik') is-invalid
                                
                            @enderror" value="{{ old('nik') }}">
                            @error('nik')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>        
                            @enderror
                        </div>

                        <div class="form-group mb-3" >
                            <label for="name" >Nama Lengkap</label>
                            <input type="text" inputmode="numeric" name="name" id="name" class="form-control @error('name') is-invalid
                            @enderror" value="{{ old('name') }}">
                            @error('name')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                                
                            @enderror
                        </div>
                        <div class="form-group mb-3" >
                            <label for="gender" >Jenis Kelamin</label>
                            <select name="gender" id="gender" 
                            class="form-control @error('gender') is-invalid
                                
                            @enderror" value="{{ old('gender') }}" required>

                                @foreach ([
                                    (object)[
                                        "label" => "Laki-Laki",
                                        "value" => "Laki-Laki",
                                        ],
                                    (object)[
                                        "label" => "Perempuan",
                                        "value" => "Perempuan",
                                         ],
                                ] as $item)
                                    <option value="{{ $item->value }}" @selected(old('gender') == $item->value)>
                                    {{ $item->label }}</option>
                                    
                                @endforeach
                               
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="birth_place">Tempat Lahir</label>
                                    <input type="text" name="birth_place" id="birth_place" class="form-control @error('birth_place') is-invalid
                                
                            @enderror" value="{{ old('birth_place') }}">
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
                                
                            @enderror " value="{{ old('birth_date') }}">
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
                                
                            @enderror" cols="30" rows="10" >{{old('address')}}</textarea>
                            @error('address')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3" >
                            <label for="religion" >Agama</label>
                            <input type="text" name="religion" id="religion" class="form-control @error('religion') is-invalid
                                
                            @enderror" value="{{ old('religion') }}">
                            @error('religion')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3" >
                            <label for="phone" >Telepon</label>
                            <input type="number" inputmode="numeric" name="phone" id="phone" class="form-control @error('phone') is-invalid
                                
                            @enderror" value="{{ old('phone') }}">
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
                                <option value="{{ $rw }}" {{ old('RW') == $rw ? 'selected' : '' }}>RW {{ $rw }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-mb-3">
                            <label for="rt_select">RT</label>
                    <select name="RT" id="rt_select" class="form-control @error('RT') is-invalid @enderror" {{ old('RW') ? '' : 'disabled' }}>
                        <option value="">-- Pilih RW Terlebih Dahulu --</option>
                        @if(old('RW'))
                            @for($i = 1; $i <= $wilayahData[old('RW')]; $i++)
                                @php $rtNumber = str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                                <option value="{{ $rtNumber }}" {{ old('RT') == $rtNumber ? 'selected' : '' }}>RT {{ $rtNumber }}</option>
                            @endfor
                        @endif
                    </select>
                        </div>
                    </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap:10px">
                            <a href="/resident" class="btn btn-outline-secondary" >
                            Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
    // 1. Ambil data wilayah dari PHP (Controller) ke JavaScript
    const wilayahData = @json($wilayahData);

    // 2. Ambil elemen dropdown RW dan RT dari HTML
    const rwSelect = document.getElementById('rw_select');
    const rtSelect = document.getElementById('rt_select');

    // 3. Tambahkan event listener untuk memantau perubahan pada dropdown RW
    rwSelect.addEventListener('change', function() {
        // Ambil nilai RW yang dipilih
        const selectedRW = this.value;

        // Kosongkan dan nonaktifkan dropdown RT terlebih dahulu
        rtSelect.innerHTML = '<option value="">-- Pilih RW Terlebih Dahulu --</option>';
        rtSelect.disabled = true;

        // Jika ada RW yang dipilih (bukan pilihan default "-- Pilih RW --")
        if (selectedRW) {
            // Dapatkan jumlah maksimal RT untuk RW yang dipilih
            const maxRT = wilayahData[selectedRW];
            
            // Aktifkan kembali dropdown RT
            rtSelect.disabled = false;
            rtSelect.innerHTML = '<option value="">-- Pilih RT --</option>';

            // Isi dropdown RT dengan pilihan nomor 1 sampai maksimal
            for (let i = 1; i <= maxRT; i++) {
                // Buat elemen option baru
                const option = document.createElement('option');
                
                // Format angka agar menjadi 2 digit (01, 02, dst.)
                const rtNumber = String(i).padStart(2, '0');

                option.value = rtNumber;
                option.textContent = `RT ${rtNumber}`;
                
                // Tambahkan option ke dalam dropdown RT
                rtSelect.appendChild(option);
            }
        }
    });
</script>
@endsection