<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Kursus</title>
    <style>
        /* Style Umum */
        body {
            font-family: 'Georgia', serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .certificate {
            border: 10px solid #333;
            padding: 50px;
            width: 90%;
            height: 82%;
            max-width: 1000px; /* Membuat lebih lebar untuk tampilan landscape */
            background-color: white;
            position: relative;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
        }
        .certificate::before,
        .certificate::after {
            content: '';
            position: absolute;
            width: 30px;
            height: 30px;
            background-color: #333;
        }
        .certificate::before {
            top: -15px;
            left: -15px;
            border-radius: 0 0 15px 0;
        }
        .certificate::after {
            bottom: -15px;
            right: -15px;
            border-radius: 15px 0 0 0;
        }
        h1 {
            font-size: 40px;
            color: #333;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .certificate p {
            font-size: 20px;
            color: #555;
            margin: 10px 0;
        }
        h2 {
            font-size: 32px;
            color: #333;
            margin: 20px 0;
            text-transform: uppercase;
            border-bottom: 2px solid #333;
            display: inline-block;
            padding: 5px 10px;
        }
        .signature {
            margin-top: 30px;
            font-size: 18px;
            font-style: italic;
            text-align: right;
            color: #555;
        }

        /* Cetak Mode Landscape */
        @media print {
            @page {
                size: landscape;
                margin: 0;
            }
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: auto;
                margin: 0;
            }
            .certificate {
                width: 100vw;
                height: 100vh; /* Memastikan penuh satu halaman landscape */
                max-width: 100%;
                box-shadow: none; /* Hilangkan bayangan saat dicetak */
                margin: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>Sertifikat Penyelesaian Kursus</h1>
        <p>Ini adalah sertifikat yang diberikan kepada</p>
        <h2>{{ $user->name }}</h2>
        <p>atas penyelesaian kursus <strong>{{ $course->nama_course }}</strong></p>
        <p>Tanggal: {{ now()->format('d M Y') }}</p>
        <br><br><br><br><br>
        <div class="signature">
            <p>Penandatangan: <em>{{ $course->user->name }}</em></p>
        </div>
    </div>
</body>
</html>
