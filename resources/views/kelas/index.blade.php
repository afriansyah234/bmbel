@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-md-flex align-items-center">
                        <div>
                            <h4 class="card-title">
                                DATA KELAS
                            </h4>
                        </div>
                        <div class="ms-auto mt-3 mt-md-0">
                            <a href="{{ route('kelas.create') }}" class="btn btn-primary m-1"><i class="ti ti-plus"></i></a>
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
                                        Nama Kelas
                                    </th>
                                    <th scope="col" class="px-0 text-muted">
                                        Kapasitas
                                    </th>
                                    <th scope="col" class="px-0 text-muted">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse($kelass as $kelas)
                                    <tr>
                                        <td class="px-0">{{ $loop->iteration }}</td>
                                        <td class="px-0">
                                            <h6 class="mb-0 fw-bolder">
                                                {{ $kelas->nama_kelas }}
                                            </h6>
                                        </td>
                                        <td class="px-0 text-dark fw-medium">
                                            {{ $kelas->kapasitas }}
                                        </td>
                                        <td class="px-0">
                                            <a href="{{ route('kelas.edit', $kelas->id) }}" class="btn btn-warning"><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('are u sure?')">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <td colspan="4" class="text-center">
                                        <h6 class="mb-0 fw-bolder">
                                            Tidak ada data
                                        </h6>
                                    </td>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $kelass->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection