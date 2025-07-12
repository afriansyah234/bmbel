@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Form Tambah Pembayaran</h5>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pembayaran.store') }}" method="POST" class="mb-3 needs-validation"
                            novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="pendaftar_id" class="form-label">Pilih Pendaftar</label>
                                <select name="pendaftar_id" id="pendaftar_id" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Pendaftar --</option>
                                    @foreach ($pendaftarans as $pendaftar)
                                        <option value="{{ $pendaftar->id }}" {{ old('pendaftar_id') == $pendaftar->id ? 'selected' : '' }}>
                                            {{ $pendaftar->nama_pendaftar }} - {{ $pendaftar->jadwal->mapel->nama_mapel }} -
                                            {{ $pendaftar->jadwal->kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    pilih pendaftar tersedia
                                </div>
                            </div>

                            <input type="hidden" name="tanggal_bayar" id="tanggal_bayar" class="form-control" readonly
                                value="{{ old('tanggal_bayar', $tanggal) }}">

                            <div class="mb-3">
                                <label for="jumlah_bayar" class="form-label">Jumlah Bayar</label>
                                <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" required
                                    min="0" value="{{ old('jumlah_bayar') }}">
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    masukkan uang yang anda bayarkan
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input type="text" name="keterangan" id="keterangan" class="form-control"
                                    value="{{ old('keterangan') }}" required>
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    masukkan keterangan
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                                <select name="status_pembayaran" id="status_pembayaran" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Status --</option>
                                    <option value="belum_lunas" {{ old('status_pembayaran') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                    <option value="lunas" {{ old('status_pembayaran') == 'lunas' ? 'selected' : '' }}>Lunas
                                    </option>
                                </select>
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    pilih status pembayaran
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
@endpush