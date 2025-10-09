<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Desa Cimandala - Register</title>
                                    @if ($errors->any())
                                        <div class="alert alert-danger mt-3 mx-4">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                    @endforeach
                                            </ul>
                                        </div>
                                    @endif

    <!-- Custom fonts for this template-->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

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

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Halaman Registrasi!</h1>
                                    </div>
                                    <form class="user" action="/register" method="POST">
                                        @csrf
                                        @method('POST')
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="inputname" name="name"
                                                placeholder="Nama Lengkap anda">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="inputEmail" name="email" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" id="rw_select" name="rw" required>
                                                <option value="">-- Pilih RW --</option>
                                                @foreach(array_keys($wilayahData) as $rw)
                                                    <option value="{{ $rw }}">RW {{ str_pad($rw, 2, '0', STR_PAD_LEFT) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" id="rt_select" name="rt" disabled required>
                                                <option value="">-- Pilih RW Terlebih Dahulu --</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="inputPassword" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Register
                                        </button>
                                        <hr>
                                        
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="/">Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>
    <script>
        const wilayahData = @json($wilayahData);
        const rwSelect = document.getElementById('rw_select');
        const rtSelect = document.getElementById('rt_select');

        rwSelect.addEventListener('change', function() {
            const selectedRW = this.value;
            rtSelect.innerHTML = '<option value="">-- Pilih RW Terlebih Dahulu --</option>';
            rtSelect.disabled = true;

            if (selectedRW) {
                const maxRT = wilayahData[selectedRW];
                rtSelect.disabled = false;
                rtSelect.innerHTML = '<option value="">-- Pilih RT --</option>';
                for (let i = 1; i <= maxRT; i++) {
                    const option = document.createElement('option');
                    const rtNumber = String(i).padStart(2, '0');
                    option.value = rtNumber;
                    option.textContent = `RT ${rtNumber}`;
                    rtSelect.appendChild(option);
                }
            }
        });
    </script>

</body>

</html>