@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Form Tambah Data</h5>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('jadwal.store') }}" method="POST" class="mb-3 needs-validation" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="mapel_id" class="form-label">Mata Pelajaran</label>
                                <select name="mapel_id" id="mapel_id" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Mata Pelajaran Tersedia --</option>
                                    @foreach ($mapel as $m)
                                        <option value="{{ $m->id }}" {{ old('mapel_id') == $m->id ? 'selected' : '' }}>
                                            {{ $m->nama_mapel }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    pilih mata pelajaran tersedia
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="pengajar_id" class="form-label">Pengajar</label>
                                <select name="pengajar_id" id="pengajar_id" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Pengajar Tersedia --</option>
                                    @foreach ($pengajar as $p)
                                        <option value="{{ $p->id }}" {{ old('pengajar_id') == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kelas_id" class="form-label">Kelas</label>
                                <select name="kelas_id" id="kelas_id" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Kelas Tersedia --</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    pilih kelas tersedia
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="biaya" class="form-label">biaya</label>
                                <input type="number" name="biaya" id="biaya" class="form-control" required min="0"
                                    value="{{ old('biaya') }}">
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    masukkan biaya kelas
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="hari" class="form-label">Hari</label>
                                <select name="hari" id="hari" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Hari --</option>
                                    <option value="senin" {{ old('hari') == 'senin' ? 'selected' : '' }}>Senin</option>
                                    <option value="selasa" {{ old('hari') == 'selasa' ? 'selected' : '' }}>Selasa</option>
                                    <option value="rabu" {{ old('hari') == 'rabu' ? 'selected' : '' }}>Rabu</option>
                                    <option value="kamis" {{ old('hari') == 'kamis' ? 'selected' : '' }}>Kamis</option>
                                    <option value="jumat" {{ old('hari') == 'jumat' ? 'selected' : '' }}>Jumat</option>
                                    <option value="sabtu" {{ old('hari') == 'sabtu' ? 'selected' : '' }}>Sabtu</option>
                                </select>
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    pilih hari
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                <input type="time" class="form-control" id="jam_mulai" name="jam_mulai"
                                    value="{{ old('jam_mulai') }}" required>
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    masukkan jam mulai
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                <input type="time" class="form-control" id="jam_selesai" name="jam_selesai"
                                    value="{{ old('jam_selesai') }}" required>
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    masukkan jam selesai
                                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#0D47A1'
            });
        </script>
    @endif
    <script>
        (() => {
            'use strict'

            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false)
            })
        })()
    </script>
@endpush