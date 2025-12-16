<!DOCTYPE html>
<html>

<head>
    <title>Tiket Laporan #{{ $order->id }}</title>
    <style>
        body {
            font-family: courier, sans-serif;
            font-size: 14px;
            color: #333;
        }

        .ticket-box {
            border: 2px dashed #333;
            padding: 20px;
            margin: 0 auto;
            width: 90%;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .row {
            margin-bottom: 10px;
        }

        .label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }

        .status-box {
            text-align: center;
            margin-top: 20px;
            border: 1px solid #333;
            padding: 10px;
            font-weight: bold;
            font-size: 18px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="ticket-box">
        <div class="header">
            <h2 style="margin:0;">RESIDENT HELP TICKET</h2>
            <p style="margin:5px 0;">Bukti Pendaftaran Keluhan</p>
        </div>

        <div class="row">
            <span class="label">NO TIKET:</span> #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
        </div>
        <div class="row">
            <span class="label">TANGGAL:</span> {{ $order->complaint_date->locale('id')->translatedFormat('d F Y') }}
        </div>
        <div class="row">
            <span class="label">PELAPOR:</span> {{ Auth::user()->name }}
        </div>
        <div class="row">
            <span class="label">UNIT:</span> Blok {{ $order->ownership->unit->block }} -
            {{ $order->ownership->unit->number }}
        </div>

        <hr style="border-top: 1px dashed #ccc;">

        <div class="row">
            <span class="label">MASALAH:</span><br>
            <b>{{ $order->complaint_title }}</b>
        </div>

        <div class="status-box">
            STATUS: {{ strtoupper($order->status) }}
        </div>

        <div class="footer">
            Harap simpan tiket ini. Tunjukkan kepada teknisi saat berkunjung.<br>
            Layanan Pelanggan: 0812-3456-7890
        </div>
    </div>
</body>

</html>
