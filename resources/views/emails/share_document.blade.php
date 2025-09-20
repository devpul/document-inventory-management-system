<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dokumen Dibagikan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }
        h2 {
            color: #2c3e50;
            font-size: 22px;
        }
        p {
            color: #555;
            line-height: 1.6;
        }
        .doc-title {
            background: #f0f4ff;
            padding: 10px;
            border-radius: 6px;
            font-weight: bold;
            color: #1a73e8;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background-color: #1a73e8;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Bisa tambahin logo di sini -->
        <h2>📄 Dokumen Dibagikan</h2>

        <p>Halo,</p>
        <p><b>{{ $sender->nama }}</b> telah membagikan dokumen kepada Anda.</p>

        <p class="doc-title">{{ $document->nama_dokumen }}</p>

        <p>
            Klik tombol di bawah untuk mengunduh:
        </p>
        <a href="{{ $url }}" target="_blank" class="btn">Download Dokumen</a>

        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas pesan ini.</p>
            <p>&copy; {{ date('Y') }} Sistem Manajemen Dokumen</p>
        </div>
    </div>
</body>
</html>
