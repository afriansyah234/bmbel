@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Form Tambah Data</h5>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pengajar.store') }}" method="POST" class="mb-3 needs-validation" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}"
                                    required>
                                <div class="form-text">Masukkan Nama Lengkap Anda</div>
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    masukkan nama anda
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="form-text">Masukkan Email Anda</div>
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    masukkan email anda
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="no_telp" class="form-label">No Telp</label>
                                <input type="tel" class="form-control" id="no_telp" name="no_telp" pattern="08[0-9]{8,11}"
                                    placeholder="08XXXXXXXXXX" required>
                                <div class="form-text">Masukkan No Telp</div>
                                <div class="valid-feedback">
                                    Bagus
                                </div>
                                <div class="invalid-feedback">
                                    masukkan Nomer Telepon anda
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