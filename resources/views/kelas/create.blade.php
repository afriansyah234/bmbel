@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Form Tambah Data</h5>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('kelas.store') }}" method="POST" class="mb-3 needs-validation" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="nama_kelas" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" required>
                                <div class="form-text">Masukkan Kelas Yang Ingin Ditambahkan</div>
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    masukkan nama kelas yang ingin ditambahkan
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="kapasitas" class="form-label">Kapasitas</label>
                                <input type="number" class="form-control" name="kapasitas" required>
                                <div class="form-text">Masukkan kapasitas Kelas</div>
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    masukkan kapasitas kelas
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