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
                    <td style="padding: 0; margin: 0;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                            <tr>
                                <td align="left" style="vertical-align: top;">
                                    <img src="{{ $rutaImagenLogoAssurant }}" style="width: 100%; max-width: 174px; height: auto; display: block;" alt="">
                                </td>
                                <td align="right" style="vertical-align: top;">
                                    <img src="{{ $rutaImagenLogoMotocare }}" style="width: 100%; max-width: 169px; height: auto; display: block;" alt="">
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
                <tr>
                    <td style="font-family: Arial, sans-serif; font-size: 16px; color: #333333; padding: 0px;">
                    Estimado equipo, <br>
                    A continuación, compartimos el resumen de la semana con los avances realizados por el equipo BAU.<br>¡Seguimos trabajando para alcanzar nuestros objetivos! :cohete:
                    </td>
                </tr>
                <tr><td height="50"></td></tr>
                <tr>
                    <td style="font-family: Arial, sans-serif; font-size: 16px; color: #333333; padding: 0px;">
                        Cordial saludo.<br>
                        Kopernicus - Equipo BAU :cerebro:<br><br>
                        Responsable: Juan Ignacio Moray<br>
                        <a href="mailto:moray.juan@kopernicus.tech">moray.juan@kopernicus.tech</a>
                    </td>
                </tr>
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