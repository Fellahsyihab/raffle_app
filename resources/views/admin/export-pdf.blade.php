<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pemenang Raffle</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>DATA PEMENANG RAFFLE JCH</h2>
        <p>Tanggal: {{ $date ?? 'Semua Data' }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Nama</th>
                <th>Hadiah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participants as $p)
            <tr>
                <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ strtoupper($p->name) }}</td>
                <td>{{ $p->prize_won }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>