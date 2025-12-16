<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data & Kinerja Teknisi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: right;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>

<body>

    @include('admin.reports.pdf._header')

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 25%">Nama Teknisi</th>
                <th style="width: 20%">Spesialisasi</th>
                <th style="width: 20%">Kontak (WA)</th>
                <th style="width: 15%">Status Saat Ini</th>
                <th style="width: 15%; text-align: center;">Total Job Selesai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($technicians as $index => $tech)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><b>{{ $tech->name }}</b></td>
                    <td>{{ $tech->specialty }}</td>
                    <td>{{ $tech->phone }}</td>
                    <td>
                        @if ($tech->status == 'Available')
                            <span style="color: green;">Ready</span>
                        @else
                            <span style="color: red;">Sibuk</span>
                        @endif
                    </td>
                    <td style="text-align: center; font-weight: bold;">{{ $tech->total_jobs }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh Admin pada: {{ now() }}
    </div>

</body>

</html>
