@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex align-items-center">
                        <div>
                            <h4 class="card-title">
                                DATA JADWAL
                            </h4>
                        </div>
                        <div class="ms-auto mt-3 mt-md-0">
                            <a href="{{ route('jadwal.create') }}" class="btn btn-primary m-1"><i
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
                                        Mata Pelajaran
                                    </th>
                                    <th class="px-0 text-muted" scope="col">
                                        Pengajar
                                    </th>
                                    <th class="px-0 text-muted" scope="col">
                                        Kelas
                                    </th>
                                    <th class="px-0 text-muted" scope="col">
                                        Hari
                                    </th>
                                    <th class="px-0 text-muted" scope="col">
                                        Jam Mulai
                                    </th>
                                    <th class="px-0 text-muted" scope="col">
                                        Jam Selesai
                                    </th>
                                    <th class="px-0 text-muted" scope="col">
                                        Biaya
                                    </th>
                                    <th class="px-0 text-muted" scope="col">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($jadwals as $jadwal)
                                    <tr>
                                        <td class="px-0">{{ $loop->iteration }}</td>
                                        <td class="px-0">{{ $jadwal->mapel->nama_mapel }}</td>
                                        <td class="px-0">{{ $jadwal->pengajar->nama }}</td>
                                        <td class="px-0">{{ $jadwal->kelas->nama_kelas }}</td>
                                        <td class="px-0">{{ $jadwal->hari }}</td>
                                        <td class="px-0">{{ substr($jadwal->jam_mulai, 0, 5) }}</td>
                                        <td class="px-0">{{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                                        <td class="px-0">Rp{{ number_format($jadwal->biaya, 0, ',', '.') }}</td>
                                        <td class="px-0">
                                            <a href="{{ route('jadwal.edit', $jadwal->id) }}" class="btn btn-warning"><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST"
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
                                    <td colspan="9" class="text-center">
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