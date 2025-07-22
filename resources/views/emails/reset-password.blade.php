<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            padding: 30px 40px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 300;
        }

        .content {
            padding: 40px;
            text-align: center;
        }

        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }

        .message {
            color: #666;
            margin-bottom: 30px;
            font-size: 16px;
            text-align: left;
        }

        .reset-button {
            display: inline-block;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 16px 32px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }

        .reset-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 172, 254, 0.4);
        }

        .alternative-link {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            word-break: break-all;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            color: #495057;
        }

        .expiry-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }

        .warning-icon {
            font-size: 18px;
            margin-right: 8px;
        }

        .security-note {
            background-color: #f8f9fa;
            border-left: 4px solid #dc3545;
            padding: 15px;
            margin: 20px 0;
            color: #495057;
            font-size: 14px;
            text-align: left;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px 40px;
            text-align: center;
            color: #6c757d;
            font-size: 12px;
            border-top: 1px solid #e9ecef;
        }

        .logo {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .steps {
            text-align: left;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .steps h3 {
            color: #495057;
            margin-top: 0;
            font-size: 16px;
        }

        .steps ol {
            color: #6c757d;
            margin: 0;
            padding-left: 20px;
        }

        .steps li {
            margin-bottom: 8px;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px;
                border-radius: 8px;
            }

            .content {
                padding: 30px 20px;
            }

            .header {
                padding: 25px 20px;
            }

            .reset-button {
                padding: 14px 28px;
                font-size: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                🔑
            </div>
            <h1>Reset Password</h1>
        </div>

        <div class="content">
            <div class="greeting">
                Halo!
            </div>

            <div class="message">
                <p>Kami menerima permintaan untuk mereset password akun Anda. Jika Anda yang meminta reset password,
                    silakan klik tombol di bawah ini untuk melanjutkan proses reset.</p>
            </div>

            <a href="{{ url('/reset-password/' . $token . '?email=' . $email) }}" class="reset-button">
                🔐 Reset Password Saya
            </a>

            <div class="expiry-warning">
                <span class="warning-icon">⏰</span>
                <strong>Link ini akan kedaluwarsa dalam 60 menit</strong> setelah email ini dikirim.
            </div>

            <div class="steps">
                <h3>📋 Langkah-langkah selanjutnya:</h3>
                <ol>
                    <li>Klik tombol "Reset Password Saya" di atas</li>
                    <li>Anda akan diarahkan ke halaman reset password</li>
                    <li>Masukkan password baru yang kuat</li>
                    <li>Konfirmasi password baru Anda</li>
                    <li>Klik "Update Password" untuk menyelesaikan</li>
                </ol>
            </div>

            <div class="alternative-link">
                <strong>Jika tombol tidak berfungsi, salin dan tempel link ini ke browser:</strong><br>
                {{ url('/reset-password/' . $token . '?email=' . $email) }}
            </div>

            <div class="security-note">
                <strong>🛡️ Catatan Keamanan:</strong><br>
                • Jika Anda tidak meminta reset password, abaikan email ini<br>
                • Jangan bagikan link ini kepada siapa pun<br>
                • Pastikan menggunakan password yang kuat dan unik<br>
                • Setelah reset, semua sesi aktif akan diakhiri untuk keamanan
            </div>
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis. Mohon jangan membalas email ini.</p>
            <p>Jika Anda mengalami masalah, silakan hubungi tim support kami.</p>
            <p>&copy; 2025 Sitaku. All Right Reserved.</p>
        </div>
    </div>
</body>
</body>

</html>
