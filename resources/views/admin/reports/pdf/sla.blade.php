<!DOCTYPE html>
<html>

<head>
    <title>Laporan Kinerja Respon (SLA)</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
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

        .fast {
            color: green;
            font-weight: bold;
        }

        .slow {
            color: red;
            font-weight: bold;
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
    <div class="header">
        <h2>PT. BERKAT SEKUMPUL PUTRA MANDIRI</h2>
        <p>JL. MARTAPURA LAMA KM. 8 RT. 12 BLOK A KOMPLEK KARYA BUDI UTAMA RAYA I no. 1 KALIMANTAN SELATAN, KAB BANJAR,
            Sungai Tabuk, Sungai Lulut</p>
        <hr>
        <h3>LAPORAN KINERJA KECEPATAN RESPON (SLA)</h3>
        <p>Analisis Durasi Penyelesaian Masalah (Service Level Agreement)</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Tgl Lapor</th>
                <th style="width: 15%">Tgl Selesai</th>
                <th style="width: 30%">Keluhan</th>
                <th style="width: 15%">Teknisi</th>
                <th style="width: 10%">Durasi</th>
                <th style="width: 10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $index => $order)
                @php
                    // Hitung selisih hari
                    $days = $order->complaint_date->diffInDays($order->completion_date);
                    // Kalau 0 hari, hitung jam, kalau < 24 jam dianggap 1 hari (Cepat)
                    $duration = $days == 0 ? '< 1 Hari' : $days . ' Hari';
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->complaint_date->format('d/m/Y') }}</td>
                    <td>{{ $order->completion_date->format('d/m/Y') }}</td>
                    <td>{{ $order->complaint_title }}</td>
                    <td>{{ $order->technician->name ?? '-' }}</td>
                    <td style="text-align: center;">{{ $duration }}</td>
                    <td style="text-align: center;">
                        @if ($days <= 2)
                            <span class="fast">CEPAT</span>
                        @else
                            <span class="slow">LAMBAT</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="font-size: 10px;">*Standar SLA Perusahaan: Maksimal 2 Hari kerja.</p>
    <div class="footer">Dicetak pada: {{ now() }}</div>
</body>

</html>
