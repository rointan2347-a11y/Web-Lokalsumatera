<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Desain Kaos</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        .page {
            width: 210mm;
            height: 297mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            page-break-after: always;
        }

        .page img {
            width: 180mm;
            height: auto;
            max-height: 250mm;
            object-fit: contain;
        }

        .label {
            margin-bottom: 10mm;
            font-size: 20px;
            font-weight: bold;
        }

        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="page">
        <div class="label">Desain Depan</div>
        <img src="{{ asset('storage/' . $depan) }}" alt="Desain Depan">
    </div>

    <div class="page">
        <div class="label">Desain Belakang</div>
        <img src="{{ asset('storage/' . $belakang) }}" alt="Desain Belakang">
    </div>
</body>

</html>
