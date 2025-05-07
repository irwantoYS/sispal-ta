<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mode Offline - Sispal TA</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            background-color: #f4f6f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
            flex-direction: column;
            padding: 20px;
            box-sizing: border-box;
        }

        .container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #e74c3c;
            font-size: 2em;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.1em;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #2980b9;
        }

        .icon {
            font-size: 3em;
            margin-bottom: 15px;
            color: #3498db;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="icon">⚠️</div>
        <h1>Oops! Anda Sedang Offline</h1>
        <p>Sepertinya Anda tidak terhubung ke internet. Silakan periksa koneksi Anda.</p>
        <p>Beberapa fitur mungkin tidak tersedia saat ini.</p>
        {{-- Anda bisa menambahkan link ke halaman utama jika sudah di-cache dan Anda yakin akan berfungsi --}}
        {{-- <p><a href="/">Coba Kembali ke Beranda</a></p> --}}
    </div>
</body>

</html>
