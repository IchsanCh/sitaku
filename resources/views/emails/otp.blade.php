<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        }

        .otp-container {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 10px;
            padding: 25px;
            margin: 30px 0;
            display: inline-block;
        }

        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: white;
            letter-spacing: 8px;
            margin: 0;
            font-family: 'Courier New', monospace;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .validity {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }

        .validity-icon {
            font-size: 18px;
            margin-right: 8px;
        }

        .security-note {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
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

            .otp-code {
                font-size: 28px;
                letter-spacing: 4px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                🔐
            </div>
            <h1>Verifikasi Email</h1>
        </div>

        <div class="content">
            <div class="greeting">
                Halo!
            </div>

            <p class="message">
                Kami telah menerima permintaan untuk memverifikasi alamat email Anda.
                Gunakan kode OTP di bawah ini untuk melanjutkan proses verifikasi.
            </p>

            <div class="otp-container">
                <div class="otp-code">{{ $otp }}</div>
            </div>

            <div class="validity">
                <span class="validity-icon">⏰</span>
                <strong>Kode ini berlaku selama 10 menit</strong> dari waktu pengiriman email ini.
            </div>

            <div class="security-note">
                <strong>🛡️ Catatan Keamanan:</strong><br>
                • Jangan bagikan kode ini kepada siapa pun<br>
                • Kami tidak akan pernah meminta kode OTP melalui telepon atau email<br>
                • Jika Anda tidak meminta verifikasi ini, abaikan email ini
            </div>
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis. Mohon jangan membalas email ini.</p>
            <p>&copy; 2025 Sitaku. All Right Reserved</p>
        </div>
    </div>
</body>

</html>
