@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex align-items-center">
                        <div>
                            <h4 class="card-title">
                                DATA PENDAFTAR
                            </h4>
                        </div>
                        <div class="ms-auto mt-3 mt-md-0">
                            <a href="{{ route('pendaftar.create') }}" class="btn btn-primary m-1"><i
                                    class="ti ti-plus"></i></a>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table mb-4 text-nowrap varient-table align-middle fs-3 table-striped">
                            <thead class="text-center">
                                <tr>
                                    <th class="px-0 text-muted" scope="col">
                                        No
                                    </th>
                                    <th class="px-0 text-muted" scope="col">
                                        Nama Pendaftar
                                    </th>
                                    <th class="px-0 text-muted" scope="col">
                                        Jadwal Bimbel
                                    </th>
                                    <th class="px-0 text-muted" scope="col">
                                        Tanggal Daftar
                                    </th>
                                    <th class="px-0 text-muted" scope="col">
                                        Biaya
                                    </th>
                                    <th class="px-0 text-muted" scope="col">
                                        Status
                                    </th>
                                    <th class="px-0 text-muted" scope="col">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($pendaftars as $pendaftar)
                                    <tr>
                                        <td class="px-0">{{ $loop->iteration }}</td>
                                        <td class="px-0">{{ $pendaftar->nama_pendaftar ?? '-' }}</td>
                                        <td class="px-0">{{ $pendaftar->jadwal->mapel->nama_mapel ?? '-' }} -
                                            {{ $pendaftar->jadwal->pengajar->nama ?? '-' }} -
                                            {{ $pendaftar->jadwal->kelas->nama_kelas ?? '-' }} -
                                            {{ $pendaftar->jadwal->hari ?? '-' }}
                                            {{ substr($pendaftar->jadwal->jam_mulai, 0, 5) ?? '-' }}
                                        </td>
                                        <td class="px-0">{{ $pendaftar->tanggal_daftar }}</td>
                                        <td class="px-0">
                                            @php
                                                $totalBayar = $pendaftar->pembayaran->sum('jumlah_bayar');
                                                $sisa = $pendaftar->jadwal->biaya - $totalBayar;
                                            @endphp
                                            Rp{{ number_format($sisa, 0, ',', '.') }}
                                        </td>

                                        <td class="px-0">{{ $pendaftar->status_pendaftaran }}</td>
                                        <td class="px-0">
                                            <a href="{{ route('pendaftar.edit', $pendaftar->id) }}" class="btn btn-warning"><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <form action="{{ route('pendaftar.destroy', $pendaftar->id) }}" method="POST"
                                                class="d-inline form-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-delete">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="8" class="text-center">
                                        <h6 class="mb-0 fw-bolder">
                                            Tidak ada data
                                        </h6>
                                    </td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('link')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closest('form').submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush