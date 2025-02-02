<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bahan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .kop-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .kop-logo {
            flex: 0 0 100px; /* Tetapkan ukuran tetap untuk logo */
        }
        .kop-logo img {
            width: 80px; /* Sesuaikan ukuran logo */
            height: auto;
        }
        .kop-text {
            flex: 1;
            text-align: center;
        }
        .kop-text .kop-title {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            line-height: 1.4;
        }
        .kop-text .kop-address {
            font-size: 12px;
            margin: 0;
            line-height: 1.2;
        }
        .line {
            border-top: 2px solid black;
            border-bottom: 2px solid black;
            margin-top: 8px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }

        /* Styles for color-coding based on sisa_stok */
        .low-stock { background-color: yellow; }
        .out-of-stock { background-color: red; color: white; }
    </style>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="kop-container">
        <!-- Logo -->
        <div class="d-flex">
            <div class="kop-logo">
                <img src="{{ public_path('logo-stikes.png') }}" alt="Logo">
            </div>
            <!-- Teks Kop -->
            <div class="kop-text">
                <p class="kop-title">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</p>
                <p class="kop-title">SEKOLAH TINGGI ILMU KESEHATAN (STIKes) SAMBAS</p>
                <p class="kop-address">Jl. Sukaramai Dalam Kaum, Kec. Sambas, Kab. Sambas - Kalimantan Barat</p>
                <p class="kop-address">Email : sambas.stikes@gmail.com, Kode Pos 79460</p>
            </div>
        </div>
    </div>
    <div class="line"></div>

    <h2>Laporan Bahan</h2>
    <div class="header">
        <p><strong>Generated by:</strong> {{ auth()->user()->name }}</p>
        <p><strong>Tanggal Generate:</strong> {{ \Carbon\Carbon::now()->format('d M Y, H:i:s') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Kode Bahan</th>
                <th>Nama Bahan</th>
                <th>Jenis Obat</th>
                <th>Sisa Stok</th>
                <th>Stok Obat</th>
                <th>Exp Obat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bahans as $bahan)
                <tr class="
                    @if($bahan->sisa_obat == 0) out-of-stock
                    @elseif($bahan->sisa_obat < 5) low-stock
                    @endif
                ">
                    <td>{{ $bahan->kode_obat }}</td>
                    <td>{{ $bahan->nama_obat }}</td>
                    <td>{{ $bahan->jenis_obat }}</td>
                    <td>{{ $bahan->sisa_obat }}</td>
                    <td>{{ $bahan->stok_obat }}</td>
                    <td>{{ $bahan->exp_obat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
