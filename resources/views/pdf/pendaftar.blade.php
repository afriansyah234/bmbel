<!DOCTYPE html>
<html>

<head>
    <title>Data Pendaftar</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .label {
            font-weight: bold;
            width: 150px;
            display: inline-block;
        }
    </style>
</head>

<body>
    <h2>Detail Pendaftar</h2>
    <p><span class="label">Nama:</span> {{ $pendaftar->nama_pendaftar }}</p>
    <p><span class="label">Tanggal Daftar:</span> {{ $pendaftar->tanggal_daftar }}</p>
    <p><span class="label">Status:</span> {{ $pendaftar->status_pendaftaran }}</p>
    <p><span class="label">Jadwal:</span> {{ $pendaftar->jadwal->hari ?? '-' }}
        ({{ $pendaftar->jadwal->jam_mulai ?? '' }} - {{ $pendaftar->jadwal->jam_selesai ?? '' }})</p>
</body>

</html>