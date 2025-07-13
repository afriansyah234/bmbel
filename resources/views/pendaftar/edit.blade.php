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
                <h5 class="card-title fw-semibold mb-4">Form Edit Data</h5>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pendaftar.edit', $pendaftar->id) }}" method="POST"
                            class="mb-3 needs-validation" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="nama_pendaftar" class="form-label">Nama pendaftar</label>
                                <input type="text" class="form-control" name="nama_pendaftar" id="nama_pendaftar"
                                    value="{{ $pendaftar->nama_pendaftar }}" required>
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    masukkan nama anda
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="jadwal_bimbel_id" class="form-label">Jadwal Bimbel</label>
                                <select name="jadwal_bimbel_id" id="jadwal_bimbel_id" class="form-select" required>
                                    @foreach ($jadwals as $jadwal)
                                        <option value="" disabled selected>{{ $jadwal->mapel->nama_mapel }} -
                                            {{ $jadwal->pengajar->nama }} -
                                            {{ $jadwal->kelas->nama_kelas }} - {{ $jadwal->hari }} {{ $jadwal->jam_mulai }}
                                        </option>
                                        <option value="{{ $jadwal->id }}" {{ old('jadwal_bimbel_id') == $jadwal->id ? 'selected' : '' }}>{{ $jadwal->mapel->nama_mapel }} - {{ $jadwal->pengajar->nama }} -
                                            {{ $jadwal->kelas->nama_kelas }} - {{ $jadwal->hari }} {{ $jadwal->jam_mulai }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    pilih jadwal bimbel tersedia
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_daftar" class="form-label">Tanggal Daftar</label>
                                <input type="date" class="form-control" name="tanggal_daftar" id="tanggal_daftar"
                                    value="{{ $pendaftar->tanggal_daftar }}" readonly>
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    masukkan tanggal daftar
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="status_pendaftaran" class="form-label">Status Pendftaran</label>
                                <select name="status_pendaftaran" id="status_pendaftaran" class="form-select">
                                    <option value="" selected disabled>{{ $pendaftar->status_pendaftaran }}</option>
                                    <option value="terdaftar" {{ request('status_pendaftaran') == 'terdaftar' ? 'selected' : '' }}>terdaftar</option>
                                    <option value="pending" {{ request('status_pendaftaran') == 'pending' ? 'selected' : '' }}>pending</option>
                                    <option value="dibatalkan" {{ request('status_pendaftaran') == 'dibatalkan' ? 'selected' : '' }}>dibatalkan</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
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