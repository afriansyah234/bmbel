@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex align-items-center">
                        <div>
                            <h4 class="card-title">
                                DATA MATA PELAJARAN
                            </h4>
                        </div>
                        <div class="ms-auto mt-3 mt-md-0">
                            <a href="{{ route('mapel.create') }}" class="btn btn-primary m-1"><i class="ti ti-plus"></i></a>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table mb-4 text-nowrap varient-table align-middle fs-3 table-striped">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col" class="px-0 text-muted">
                                        No
                                    </th>
                                    <th scope="col" class="px-0 text-muted">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-0 text-muted">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($mapels as $mapel)
                                    <tr>
                                        <td class="px-0">{{ $loop->iteration }}</td>
                                        <td class="px-0">
                                            <h6 class="mb-0 fw-bolder">
                                                {{ $mapel->nama_mapel }}
                                            </h6>
                                        </td>
                                        <td class="px-0">
                                            <a href="{{ route('mapel.edit', $mapel->id) }}" class="btn btn-warning"><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <form action="{{ route('mapel.destroy', $mapel->id) }}" method="POST"
                                                class="d-inline form-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-delete">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="3" class="text-center">
                                        <h6 class="mb-0 fw-bolder">
                                            Tidak ada data
                                        </h6>
                                    </td>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $mapels->links('pagination::bootstrap-5') }}
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