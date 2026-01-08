@php
    // Para DOMPDF es más seguro usar public_path (archivos locales)
    $rutaImagenLogoAssurant   = storage_path('app/public/emails/assurant-logo.png');
    $rutaImagenLogoMotocare   = storage_path('app/public/emails/motocare-logo.png');
    $rutaImagenBannerMotocare = storage_path('app/public/emails/motocare-banner.jpg');
    $rutaImagenFooterSSN      = storage_path('app/public/emails/ssn-footer.png');
@endphp
<table width="100%" cellpadding="0" cellspacing="0" style="background:#fff;">
    <tr>
        <td align="center">
            <table width="100%" cellpadding="10" cellspacing="0" style="max-width:960px;">
                <tr>
                    <td style="padding:0 30px;">
                        <table width="100%">
                        <tr>
                            <td align="left" width="50%" style="vertical-align:middle; height:120px;">
                                <img src="{{ $rutaImagenLogoAssurant }}" style="width:90%; max-width:180px; display:block;">
                            </td>
                            <td align="right" width="50%" style="vertical-align:middle; height:120px;">
                                <img src="{{ $rutaImagenLogoMotocare }}" style="width:90%; max-width:220px; display:block;">
                            </td>
                        </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <img src="{{ $rutaImagenBannerMotocare }}" style="width:100%; display:block;">
                    </td>
                </tr>
                <tr><td height="10"></td></tr>
                <tr>
                    <td style="font-family: DejaVu Sans, Arial, sans-serif; font-size:14px; color:#333; padding:0 70px;">
                        <h1 style="font-family: DejaVu Sans, Arial, sans-serif; font-size:28px;">¡Hola {{ $nombre }}!</h1>
                        <br>
                        Te informamos que <b style="font-size:16px;">hemos recibido tu solicitud al Programa Moto Care</b>, a la brevedad estarás recibiendo el mail de bienvenida con el detalle de la cobertura y el link para que descargues los términos y condiciones de tu póliza.
                    </td>
                </tr>
                <tr><td height="5"></td></tr>
                <tr>
                    <td style="font-family: DejaVu Sans, Arial, sans-serif; font-size:14px; color:#333; padding:0 70px;">
                        <b style="font-size:16px;">Detalle de la cobertura:</b> {{ $detalleCobertura }}
                    </td>
                </tr>
                <tr>
                    <td style="font-family: DejaVu Sans, Arial, sans-serif; font-size:14px; color:#333; padding:0 70px;">
                        <b style="font-size:16px;">Costo Mensual:</b> $ {{ $costoMensual }}
                    </td>
                </tr>
                <tr><td height="5"></td></tr>
                <tr>
                    <td style="font-family: DejaVu Sans, Arial, sans-serif; font-size:14px; color:#333; padding:0 70px;">
                        Si tenés alguna consulta, podés comunicarte con nuestro <b style="font-size:16px;">Centro de Atención al cliente al 0800-222-6161, de lunes a viernes de 9:00 a 17:30 hs</b>
                    </td>
                </tr>
                <tr><td height="10"></td></tr>
                <tr>
                    <td align="center">
                        <img src="{{ $rutaImagenFooterSSN }}" style="width:100%; display:block;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>