@php
    $rutaImagenHeaderBck   = asset('email-images/sura/sura-header-bck.png');
    $rutaImagenHeaderDesc  = asset('email-images/sura/sura-descriptor-seguros.png');
    $rutaImagenHeaderLogo  = asset('email-images/sura/sura-seguros.png');
    $rutaImagenHeaderTitle = asset('email-images/sura/titulo-bau-informe-semanal.png');
    $rutaImagenHeaderIllus = asset('email-images/sura/sura-bau.png');
    $rutaImagenFooter1     = asset('email-images/kps/kopernicus.png');
    $rutaImagenFooter2     = asset('email-images/kps/kopernicus-identidad.png');
    $rutaImagenFooter3     = asset('email-images/kps/kopernicus-servicios.png');
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
                                    <img src="$rutaImagenHeaderDesc" style="width: 100%; max-width: 174px; height: auto; display: block;" alt="">
                                </td>
                                <td align="right" style="vertical-align: top;">
                                    <img src="$rutaImagenHeaderLogo" style="width: 100%; max-width: 169px; height: auto; display: block;" alt="">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="font-family: Arial, sans-serif; font-size: 16px; color: #333333; padding: 0px;">
                    Estimado equipo, <br>
                    A continuación, compartimos el resumen de la semana <strong>$numeroSemana ( {$inicioSemana->format('d/m/Y')} - {$finSemana->format('d/m/Y')} )</strong> con los avances realizados por el equipo BAU.<br>¡Seguimos trabajando para alcanzar nuestros objetivos! :cohete:
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
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="vertical-align: bottom; padding: 0px;" align="left">
                                    <img src="$rutaImagenFooter1" style="width: 100%; max-width: 268px; height: auto; display: block;">
                                </td>
                                <td style="vertical-align: middle; padding-left: 10px; padding-right: 10px;" align="left">
                                    <img src="$rutaImagenFooter2" style="width: 100%; max-width: 311px; height: auto; display: block;">
                                </td>
                                <td style="vertical-align: bottom; padding-bottom: 14px;" align="right">
                                    <img src="$rutaImagenFooter3" style="width: 100%; max-width: 160px; height: auto; display: block;">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td height="50"></td></tr>
            </table>
        </td>
    </tr>
</table>