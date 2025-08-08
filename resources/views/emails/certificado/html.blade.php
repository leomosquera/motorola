@php
    // Para DOMPDF es más seguro usar public_path (archivos locales)
    $rutaImagenLogoAssurant    = asset('images/emails/assurant-logo.png');
    $rutaImagenLogoMotocare    = asset('images/emails/motocare-logo.png');
    $rutaImagenBannerMotocare  = asset('images/emails/motocare-banner.jpg');
    $rutaImagenFooterSSN       = asset('images/emails/ssn-footer.png');
@endphp
<table width="100%" cellpadding="0" cellspacing="0" style="background:#fff; padding-top:30px;">
    <tr>
        <td align="center">
            <table width="100%" cellpadding="10" cellspacing="0" style="max-width:1140px;">
                <tr>
                    <td style="padding:0 30px;">
                        <table width="100%">
                        <tr>
                            <td align="left" style="vertical-align:middle; height:120px;">
                            <img src="{{ $rutaImagenLogoAssurant }}" style="max-width:180px; display:block;">
                            </td>
                            <td align="right" style="vertical-align:middle; height:120px;">
                            <img src="{{ $rutaImagenLogoMotocare }}" style="max-width:220px; display:block;">
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
                <tr><td height="30"></td></tr>
                <tr>
                    <td style="font-family: DejaVu Sans, Arial, sans-serif; font-size:16px; color:#333; padding:0 140px;">
                        <h1 style="font-family: DejaVu Sans, Arial, sans-serif; font-size:32px;">¡Hola {{ $nombre }}!</h1>
                        <br>
                        Te informamos que <b style="font-size:18px;">hemos recibido tu solicitud al Programa Moto Care</b>, a la brevedad estarás recibiendo el mail de bienvenida con el detalle de la cobertura y el link para que descargues los términos y condiciones de tu póliza.
                    </td>
                </tr>
                <tr><td height="20"></td></tr>
                <tr>
                    <td style="font-family: DejaVu Sans, Arial, sans-serif; font-size:16px; color:#333; padding:0 140px;">
                        <b style="font-size:18px;">Detalle de la cobertura:</b> {{ $detalleCobertura }}
                    </td>
                </tr>
                <tr>
                    <td style="font-family: DejaVu Sans, Arial, sans-serif; font-size:16px; color:#333; padding:0 140px;">
                        <b style="font-size:18px;">Costo Mensual:</b> {{ $costoMensual }}
                    </td>
                </tr>
                <tr><td height="20"></td></tr>
                <tr>
                    <td style="font-family: DejaVu Sans, Arial, sans-serif; font-size:16px; color:#333; padding:0 140px;">
                        Si tenés alguna consulta, podés comunicarte con nuestro <b style="font-size:18px;">Centro de Atención al cliente al 0800-222-6161, de lunes a viernes de 9:00 a 17:30 hs</b>
                    </td>
                </tr>
                <tr><td height="20"></td></tr>
                <tr>
                    <td align="center">
                        <img src="{{ $rutaImagenFooterSSN }}" style="width:100%; display:block;">
                    </td>
                </tr>
                <tr><td height="50"></td></tr>
            </table>
        </td>
    </tr>
</table>