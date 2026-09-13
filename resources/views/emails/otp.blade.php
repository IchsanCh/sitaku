<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Exavro</title>
</head>

<body style="margin:0; padding:0; background-color:#f6f3ec; font-family:-apple-system,'Segoe UI',Helvetica,Arial,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f6f3ec; padding:40px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" style="max-width:480px; background-color:#ffffff; border:1px solid rgba(16,19,26,0.1); border-radius:12px; overflow:hidden;" cellpadding="0" cellspacing="0">
                    <!-- Brand bar -->
                    <tr>
                        <td style="background-color:#10131a; padding:22px 32px;">
                            <span style="color:#f6f3ec; font-size:15px; font-weight:700; letter-spacing:0.08em;">EXAVRO</span>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:36px 32px 8px;">
                            <h1 style="margin:0 0 12px; font-size:20px; font-weight:700; color:#10131a;">Verifikasi alamat email Anda</h1>
                            <p style="margin:0 0 24px; font-size:14px; line-height:1.6; color:#52565f;">
                                Gunakan kode di bawah ini untuk menyelesaikan pendaftaran akun Exavro Anda.
                            </p>
                        </td>
                    </tr>

                    <!-- OTP code -->
                    <tr>
                        <td style="padding:0 32px 24px;" align="center">
                            <table role="presentation" cellpadding="0" cellspacing="0" style="width:100%; background-color:#f6f3ec; border:1px solid rgba(16,19,26,0.1); border-radius:10px;">
                                <tr>
                                    <td align="center" style="padding:22px 12px;">
                                        <span style="font-family:'SF Mono','Courier New',monospace; font-size:32px; font-weight:700; letter-spacing:0.5em; color:#ff5a2e;">{{ $otp }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 32px 8px;">
                            <p style="margin:0 0 20px; font-size:13px; color:#52565f;">
                                <strong style="color:#10131a;">Kode ini berlaku 10 menit</strong> sejak email ini dikirim.
                            </p>
                        </td>
                    </tr>

                    <!-- Security note -->
                    <tr>
                        <td style="padding:0 32px 32px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f6f3ec; border-radius:8px;">
                                <tr>
                                    <td style="padding:16px 18px; font-size:12.5px; line-height:1.7; color:#52565f;">
                                        <strong style="color:#10131a; display:block; margin-bottom:4px;">Catatan keamanan</strong>
                                        Jangan bagikan kode ini kepada siapa pun. Exavro tidak akan pernah meminta kode OTP lewat telepon atau email. Kalau Anda tidak meminta verifikasi ini, abaikan saja email ini.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:18px 32px; border-top:1px solid rgba(16,19,26,0.1); font-size:11.5px; color:#8a8d94;">
                            Email ini dikirim otomatis, mohon jangan dibalas.<br>
                            &copy; {{ date('Y') }} Exavro. Seluruh hak cipta dilindungi.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>