<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Exavro</title>
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
                            <h1 style="margin:0 0 12px; font-size:20px; font-weight:700; color:#10131a;">Reset password akun Anda</h1>
                            <p style="margin:0 0 24px; font-size:14px; line-height:1.6; color:#52565f;">
                                Kami menerima permintaan reset password. Kalau ini Anda, klik tombol di bawah untuk membuat password baru.
                            </p>
                        </td>
                    </tr>

                    <!-- CTA -->
                    <tr>
                        <td style="padding:0 32px 24px;" align="center">
                            <a href="{{ url('/reset-password/' . $token . '?email=' . $email) }}"
                                style="display:inline-block; background-color:#ff5a2e; color:#17110c; text-decoration:none; font-weight:700; font-size:15px; padding:14px 32px; border-radius:8px;">
                                Reset Password Saya
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 32px 20px;">
                            <p style="margin:0; font-size:13px; color:#52565f;">
                                <strong style="color:#10131a;">Link ini berlaku 60 menit</strong> sejak email ini dikirim.
                            </p>
                        </td>
                    </tr>

                    <!-- Steps -->
                    <tr>
                        <td style="padding:0 32px 20px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f6f3ec; border-radius:8px;">
                                <tr>
                                    <td style="padding:16px 18px;">
                                        <strong style="display:block; margin-bottom:8px; font-size:13px; color:#10131a;">Langkah selanjutnya</strong>
                                        <ol style="margin:0; padding-left:18px; font-size:12.5px; line-height:1.9; color:#52565f;">
                                            <li>Klik tombol "Reset Password Saya" di atas</li>
                                            <li>Masukkan password baru yang kuat</li>
                                            <li>Konfirmasi password baru Anda</li>
                                            <li>Klik "Perbarui Password" untuk menyelesaikan</li>
                                        </ol>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Fallback link -->
                    <tr>
                        <td style="padding:0 32px 20px;">
                            <p style="margin:0 0 6px; font-size:12px; color:#8a8d94;">Kalau tombolnya tidak berfungsi, salin link ini ke browser:</p>
                            <p style="margin:0; font-size:12px; word-break:break-all; color:#52565f; font-family:'SF Mono','Courier New',monospace;">
                                {{ url('/reset-password/' . $token . '?email=' . $email) }}
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
                                        Kalau Anda tidak meminta reset ini, abaikan saja email ini — password Anda tidak akan berubah. Jangan bagikan link ini kepada siapa pun; setelah password diperbarui, semua sesi aktif akan diakhiri demi keamanan.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:18px 32px; border-top:1px solid rgba(16,19,26,0.1); font-size:11.5px; color:#8a8d94;">
                            Email ini dikirim otomatis, mohon jangan dibalas. Ada kendala? Hubungi tim support kami.<br>
                            &copy; {{ date('Y') }} Exavro. Seluruh hak cipta dilindungi.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>