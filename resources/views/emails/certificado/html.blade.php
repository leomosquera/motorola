@php
    $rutaImagenLogoAssurant    = asset('images/emails/assurant-logo.png');
    $rutaImagenLogoMotocare    = asset('images/emails/motocare-logo.png');
    $rutaImagenBannerMotocare  = asset('images/emails/motocare-banner.jpg');
    $rutaImagenFooterSSN       = asset('images/emails/ssn-footer.png');
@endphp
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ffffff; padding-top: 30px;">
    <tr>
        <td align="center" style="padding: 0px;">
            <table border="0" cellpadding="10" cellspacing="0" width="100%" style="max-width: 1140px;">
                <tr>
                    <td style="padding: 0px 50px; margin: 0px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                            <tr>
                                <td align="left" style="vertical-align: middle; height: 120px;">
                                    <img src="{{ $rutaImagenLogoAssurant }}" style="width: 100%; max-width: 180px; height: auto; display: block;" alt="">
                                </td>
                                <td align="right" style="vertical-align: middle; height: 120px;">
                                    <img src="{{ $rutaImagenLogoMotocare }}" style="width: 100%; max-width: 220px; height: auto; display: block;" alt="">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding: 0px;">
                        <img src="{{ $rutaImagenBannerMotocare }}" style="width: 100%; height: auto; display: block;" alt="">
                    </td>
                </tr>
				<tr><td height="40"></td></tr>
                <tr>
                    <td style="font-family: Arial, sans-serif; font-size: 16px; color: #333333; padding: 0px 140px;">
                    <h1 style="font-family: Arial, sans-serif; font-size: 32px;">¡Hola Maria!</h1> <br>
                    Te informamos que <b style="font-size: 18px;">hemos recibido tu solicitud al Programa Moto Care</b>, a la brevedad estarás recibiendo el mail de bienvenida con el detalle de la cobertura y el link para que descargues los términos y condiciones de tu póliza.
                    </td>
                </tr>
                <tr><td height="30"></td></tr>
                <tr>
                    <td style="font-family: Arial, sans-serif; font-size: 16px; color: #333333; padding: 0px 140px;">
                        <b style="font-size: 18px;">Detalle de la cobertura:</b> Robo y Daño
                    </td>
                </tr>
                <tr><td height="30"></td></tr>
                <tr>
                    <td style="font-family: Arial, sans-serif; font-size: 16px; color: #333333; padding: 0px 140px;">
                        <b style="font-size: 18px;">Costo Mensual:</b> $3.858,18 por mes
                    </td>
                </tr>
				<tr><td height="30"></td></tr>
                <tr>
                    <td style="font-family: Arial, sans-serif; font-size: 16px; color: #333333; padding: 0px 140px;">
                        Si tenés alguna consulta, podés com.unicarte con nuestro <b style="font-size: 18px;">Centro de Atención al cliente al 0800-222-6161, de lunes a viernes de 9:00 a 17:30 horas</b>
                    </td>
                </tr>
				<tr><td height="40"></td></tr>
                <tr>
                    <td align="center" style="padding: 0px;">
                        <img src="{{ $rutaImagenFooterSSN }}" style="width: 100%; height: auto; display: block;" alt="">
                    </td>
                </tr>
                <tr><td height="50"></td></tr>
            </table>
        </td>
    </tr>
</table>