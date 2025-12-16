<style>
    .header-table {
        width: 100%;
        border-bottom: 3px solid #000;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }

    .logo-container {
        width: 15%;
        /* Lebar area logo */
        vertical-align: middle;
        text-align: left;
    }

    .text-container {
        width: 85%;
        /* Lebar area teks */
        text-align: center;
        vertical-align: middle;
    }

    .header h2 {
        font-size: 16px;
        margin: 0;
        font-weight: bold;
        text-transform: uppercase;
    }

    .header p {
        font-size: 11px;
        margin: 2px 0;
        color: #333;
    }

    .logo-img {
        width: 90px;
        /* Sesuaikan ukuran logo */
        height: auto;
    }
</style>

<table class="header-table">
    <tr>
        <td class="logo-container">
            @php
                $path = public_path('logo/logo.jpg');
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            @endphp
            <img src="{{ $base64 }}" class="logo-img" alt="Logo Perusahaan">
        </td>
        <td class="text-container">
            <div class="header">
                <h2>PT. BERKAT SEKUMPUL PUTRA MANDIRI</h2>
                <p>JL. MARTAPURA LAMA KM. 8 RT. 12 BLOK A KOMPLEK KARYA BUDI UTAMA RAYA I no. 1</p>
                <p>KALIMANTAN SELATAN, KAB BANJAR, Sungai Tabuk, Sungai Lulut</p>
                <p>Telepon: 0812-3456-7890 | Email: admin@berkatsekumpul.com</p>
            </div>
        </td>
    </tr>
</table>
