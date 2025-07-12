@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Riwayat Pembayaran (Data Terhapus)</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pendaftar</th>
                    <th>Tanggal Bayar</th>
                    <th>Jumlah Bayar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pembayarans as $pembayaran)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pembayaran->pendaftar->nama_pendaftar ?? '-' }}</td>
                        <td>{{ $pembayaran->tanggal_pembayaran }}</td>
                        <td>Rp{{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($pembayaran->status_pembayaran) }}</td>
                @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data riwayat.</td>
                        </tr>
                    @endforelse
            </tbody>
        </table>
    </div>
@endsection