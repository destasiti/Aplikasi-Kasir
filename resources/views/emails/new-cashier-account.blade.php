<!DOCTYPE html>
<html>
<head>
    <title>Informasi Akun Kasir</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 3px;
        }
        .content {
            padding: 20px 0;
        }
        .credentials {
            background-color: #f9f9f9;
            padding: 15px;
            margin: 15px 0;
            border-radius: 3px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 3px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Informasi Akun Kasir</h2>
        </div>
        
        <div class="content">
            <p>Halo <strong>{{ $name }}</strong>,</p>
            
            <p>Akun kasir untuk Anda telah berhasil dibuat. Berikut adalah detail akun Anda:</p>
            
            <div class="credentials">
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
            </div>
            
            <p>Silakan gunakan kredensial di atas untuk login ke sistem.</p>
            
            <p>
                <a href="{{ url('/login') }}" class="btn">Login Sekarang</a>
            </p>
            
            <p><strong>Catatan Penting:</strong> Demi keamanan, silakan mencoba login untuk pertama kali.</p>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis. Mohon jangan membalas email ini.</p>
            <p>&copy; {{ date('Y') }} Sistem Kasir. All rights reserved.</p>
        </div>
    </div>
</body>
</html>