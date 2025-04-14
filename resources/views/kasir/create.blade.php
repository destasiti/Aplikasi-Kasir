@extends('layout.template')

@section('content')
    <div class="container mt-5">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-white">BUAT AKUN KASIR</h5>
                    <small>Form tambah akun baru</small>
                </div>                
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('kasir.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="fw-bold">Nama</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Nama lengkap" required>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="fw-bold">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email aktif" required>
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="fw-bold">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 8 karakter" required>
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="fw-bold">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                            </div>

                            <input type="hidden" name="role_as" value="kasir">
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-success btn-lg">Buat Akun</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- DAFTAR USER KASIR -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-warning text-white d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-white">DAFTAR KASIR</h5>
                    <small>Seluruh akun kasir yang terdaftar</small>
                </div>                
                <div class="card-body p-4">
                    @if($kasirs->isEmpty())
                        <p class="text-danger fw-bold text-center">Belum ada akun kasir yang terdaftar</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="bg-light text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Tanggal Dibuat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kasirs as $index => $kasir)
                                        <tr class="text-center">
                                            <td>{{ $index + 1 }}</td>
                                            <td class="text-start">{{ $kasir->name }}</td>
                                            <td class="text-start">{{ $kasir->email }}</td>
                                            <td>{{ $kasir->created_at->format('d-m-Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
