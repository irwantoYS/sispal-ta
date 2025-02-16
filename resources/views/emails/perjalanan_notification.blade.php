<!DOCTYPE html><html><head><title>Notifikasi Perjalanan</title></head>
<body>
    @if ($status == 'baru')
        <p>Halo {{ $recipient->nama }},</p>
        <p>Ada permintaan perjalanan baru dari {{ $perjalanan->user->nama }}.</p>
        <p><a href="{{ route('managerarea.persetujuan', $perjalanan->id) }}">Lihat Detail</a></p>
    @elseif ($status == 'disetujui')
        <p>Halo {{ $recipient->nama }},</p><p>Perjalanan Anda disetujui.</p>
         <p><a href="{{ route('driver.status', $perjalanan->id) }}">Lihat Detail</a></p>
    @elseif ($status == 'ditolak')
        <p>Halo {{ $recipient->nama }},</p><p>Perjalanan Anda ditolak.</p>
         <p><a href="{{ route('driver.status', $perjalanan->id) }}">Lihat Detail</a></p>
    @endif
</body></html>