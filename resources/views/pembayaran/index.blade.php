@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex align-items-center">
                        <div>
                            <h4 class="card-title">
                                DATA PEMBAYARAN
                            </h4>
                        </div>
                        <div class="ms-auto mt-3 mt-md-0">
                            <a href="{{ route('pembayaran.create') }}" class="btn btn-primary m-1">
                                <i class="ti ti-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table mb-4 text-nowrap varient-table align-middle fs-3 table-striped">
                            <thead class="text-center">
                                <tr>
                                    <th class="px-0">No</th>
                                    <th class="px-0">Nama Pendaftar</th>
                                    <th class="px-0">Jadwal Bimbel</th>
                                    <th class="px-0">Tanggal Bayar</th>
                                    <th class="px-0">Jumlah Bayar</th>
                                    <th class="px-0">Status Pembayaran</th>
                                    <th class="px-0">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($pembayarans as $pembayaran)
                                    <tr>
                                        <td class="px-0">{{ $loop->iteration }}</td>
                                        <td class="px-0">{{ $pembayaran->pendaftar->nama_pendaftar ?? '-' }}</td>
                                        <td class="px-0">
                                            @if($pembayaran->pendaftar && $pembayaran->pendaftar->jadwal)
                                                {{ $pembayaran->pendaftar->jadwal->mapel->nama_mapel ?? '-' }} -
                                                {{ $pembayaran->pendaftar->jadwal->pengajar->nama ?? '-' }} -
                                                {{ $pembayaran->pendaftar->jadwal->kelas->nama_kelas ?? '-' }} -
                                                {{ $pembayaran->pendaftar->jadwal->hari ?? '-' }}
                                                {{ substr($pembayaran->pendaftar->jadwal->jam_mulai, 0, 5) ?? '-' }}
                                            @else
                                                <span class="text-danger">Jadwal tidak ditemukan</span>
                                            @endif
                                        </td>
                                        <td class="px-0">{{ $pembayaran->tanggal_pembayaran }}</td>
                                        <td class="px-0">Rp{{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                                        <td class="px-0">{{ ucfirst($pembayaran->status_pembayaran) }}</td>
                                        <td class="px-0">
                                            <form action="{{ route('pembayaran.destroy', $pembayaran->id) }}" method="POST"
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
                                    <td colspan="7" class="text-center">
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