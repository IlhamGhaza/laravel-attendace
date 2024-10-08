<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Absen - {{ $qrAbsen->date }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .qr-code {
            text-align: center;
            margin: 20px 0;
        }

        .qr-code img {
            max-width: 200px;
        }

        h1,
        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>QR Absen for {{ $qrAbsen->date }}</h1>

        <div class="qr-code">
            <h2>Check-in QR Code</h2>
            <img src="{{ $qrCodeCheckin }}" alt="Check-in QR Code"width="300">
        </div>

        <div class="qr-code">
            <h2>Check-out QR Code</h2>
            <img src="{{ $qrCodeCheckout }}" alt="Check-out QR Code"width="300">
        </div>
    </div>
</body>

</html>
