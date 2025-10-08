
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12pt;
    }
</style>
<div style="width: 100%; max-width:960px; margin: 0 auto;">
    <div>
        <div>
            <img src="{{ $logo }}" style="width: 100%; max-width:180px; padding: 15px 0;">
        </div>
        <div style="border: 1px solid #000000; padding: 4px; font-weight: bold; text-align: center;">
            SOLICITUD DE SEGURO – PROTECCIÓN PARA EQUIPOS ELECTRÓNICOS
        </div>
        <div style="padding: 30px 0; text-align: center;">
            <strong>Fecha:</strong> {{$terminos['fventa']}}
        </div>
        <div style="border: 1px solid #000000; padding: 4px; font-weight: bold; background-color: #d9d9d9; text-align: center;">
            DATOS DEL ASEGURADO
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <table style="width: 100%; border: 2px solid #000000; border-collapse: collapse; ">
                <tr>
                    <td style="padding: .35rem; width: 50%; border: 1px solid #000;">APELLIDO y NOMBRE: {{$terminos['nombre']}}</td>
                    <td style="padding: .35rem; width: 50%; border: 1px solid #000;">TIPO y NRO DE DOCUMENTO: {{$terminos['dni']}}</td>
                </tr>
                <tr>
                    <td style="padding: .35rem; width: 50%; border: 1px solid #000;">CUIL / CUIT: {{$terminos['cuit']}}</td>
                    <td style="padding: .35rem; width: 50%; border: 1px solid #000;">FECHA DE NACIMIENTO: {{$terminos['fnac']}}</td>
                </tr>
                <tr>
                    <td style="padding: .35rem; width: 50%; border: 1px solid #000;">ESTADO CIVIL: {{$terminos['estadocivil']}}</td>
                    <td style="padding: .35rem; width: 50%; border: 1px solid #000;">NACIONALIDAD: {{$terminos['nacionalidad']}}</td>
                </tr>
                <tr>
                    <td style="padding: .35rem; width: 50%; border: 1px solid #000;">DOMICILIO: {{$terminos['domicilio']}}</td>
                    <td style="padding: .35rem; width: 50%; border: 1px solid #000;">LOCALIDAD: {{$terminos['localidad']}}</td>
                </tr>
                <tr>
                    <td style="padding: .35rem; width: 50%; border: 1px solid #000;">PROVINCIA: {{$terminos['provincia']}}</td>
                    <td style="padding: .35rem; width: 50%; border: 1px solid #000;">CODIGO POSTAL: {{$terminos['cp']}}</td>
                </tr>
                <tr>
                    <td style="padding: .35rem; width: 50%; border: 1px solid #000;">TELÉFONO:{{$terminos['telefono']}}</td>
                    <td style="padding: .35rem; width: 50%; border: 1px solid #000;">CELULAR: {{$terminos['telefono']}}</td>
                </tr>
                <tr>
                    <td style="padding: .35rem; width: 50%; border: 1px solid #000;">EMAIL: {{$terminos['email']}}</td>
                    <td style="padding: .35rem; width: 50%; border: 1px solid #000;">OCUPACION: {{$terminos['ocupacion']}}</td>
                </tr>
            </table>
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <p><strong>¿Es usted una Persona Expuesta Políticamente (PEP)?</strong> {{$terminos['pers']}}</p>
            <p><strong>¿Es usted un Sujeto Obligado (SO)?</strong> {{$terminos['sujetoso']}}</p>
        </div>
    </div>
    <div>
        <div style="border: 1px solid #000000; padding: 4px; font-weight: bold; background-color: #d9d9d9; text-align: center;">
            RIESGO CUBIERTO POR EL SEGURO SOLICITADO
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <p><strong>Cobertura:</strong> Daño Accidental. (incluye daños como consecuencia de exposición a líquidos.) y Robo Total</p>
            <p><strong>Datos del Bien asegurado:</strong> Dispositivo móvil Marca MOTOROLA aprobado por el Asegurador.</p>
            <p><strong>Marca:</strong> Motorola</p>
            <p><strong>Modelo:</strong> {{$terminos['producto_version']}}</p>
            <p><strong>IMEI:</strong> {{$terminos['imei']}}</p>
            <p><strong>Suma máxima asegurada:</strong> {{$terminos['producto_precio']}}</p>
            <p><strong>Solución al asegurado:</strong> REEMPLAZO. El equipo que se dé en reemplazo podrá ser nuevo o reacondicionado de similares características.</p>
            <p><strong>Total de eventos anuales cubiertos:</strong> 2 (dos) <i><strong>NOTA IMPORTANTE:</strong> Sí el límite no fuera alcanzado cumplidos los 12 (doce) meses de vigencia, el límite de responsabilidad volverá a la cantidad máxima de eventos por año. Estos plazos se cuentan siempre desde la fecha de inicio de la vigencia de la póliza.</i></p>
            <p><strong>Premio mensual:</strong> {{$terminos['producto_precio_seguro']}}</p>
            <p><strong>Ámbito de cobertura:</strong> Mundial. El reemplazo se realizará en territorio argentino.</p>
            <p><strong>Franquicia:</strong> 15% Daño Accidental y 20% Robo Total. Ambos sobre el valor del equipo de reemplazo al momento del siniestro.</p>
            <p><strong>Accesorios:</strong> No cubiertos</p>
        </div>
    </div>
    <div>
        <div style="border: 1px solid #000000; padding: 4px; font-weight: bold; background-color: #d9d9d9; text-align: center;">
            RIESGO CUBIERTO POR EL SEGURO SOLICITADO
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>Costo del Seguro:</strong> 100% a cargo del asegurado. <strong>Periodicidad:</strong> mensual. <strong>Moneda del contrato:</strong> pesos argentinos
        </div>
    </div>
    <div>
        <div style="border: 1px solid #000000; padding: 4px; font-weight: bold; background-color: #d9d9d9; text-align: center;">
            NOTIFICACION
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            Afirmo que los datos consignados en este formulario son correctos y completos, y que he confeccionado esta declaración sin omitir ni falsear dato alguno que deba contener, siendo fiel expresión de la verdad. Asimismo, declaro que los fondos a utilizar para el pago de los premios provienen de actividades lícitas. Por el presente faculto a Assurant Argentina Compañía de Seguros S.A. a presentar esta solicitud en el correspondiente ente de pago seleccionado. El solicitante declara haberse notificado de las condiciones generales, particulares y específicas las que deberá conocer en todas sus partes y afirma que las informaciones dadas son completas y exactas aun cuando no estén escritas en puño y letra. En tal caso se compromete a pagar el premio correspondiente según la liquidación que figura más arriba. Además, consiento expresamente que las sumas aseguradas de la póliza se ajusten regularmente, con el correspondiente aumento del precio mensual del seguro, para resguardar adecuadamente el valor de la cobertura. Lo antes declarado en esta solicitud se considera integrado a la póliza de seguro que cubrirá el objeto del seguro indicado en esta solicitud. Toda reticencia, declaración inexacta o no veraz implicará la nulidad del presente seguro y la pérdida de los eventuales derechos del asegurado a ser indemnizado (art. 5 a 10 de la Ley N° 17.418). Art. 5 Ley N° 17.418: toda declaración falsa o reticencia de circunstancias conocidas por el Asegurado, aun hechas de buen a fe, que a juicio de peritos hubiese impedido el contrato o modificado sus condiciones, si el Asegurador hubiese sido cerciorado del verdadero estado del riesgo, hace nulo el contrato.
        </div>
    </div>
    <div>
        <div style="border: 1px solid #000000; padding: 4px; font-weight: bold; background-color: #d9d9d9; text-align: center;">
            INFORMACION GENERAL
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            Los únicos sistemas habilitados para pagar premios de contratos de seguros son los siguientes: a) Entidades especializadas en cobranzas, registro y procesamiento de pagos por medios electrónicos habilitados por la Superintendencia de Seguros de la Nación. b) Entidades financieras sometidas al régimen de la Ley Nº 21.526. c)Tarjetas de crédito, débito o compras emitidas en el marco de la Ley Nº 25.065. d) Medios electrónicos de cobro habilitados previamente por la Superintendencia de Seguros de la Nación a cada entidad de seguros, los que deberán funcionar en sus domicilios, puntos de venta o cobranza. En este caso, el pago deberá ser realizado mediante alguna de las siguientes formas: efectivo en moneda de curso legal, cheque cancelatorio Ley Nº 25.345 o cheque no a la orden librado por el Asegurado o Tomador a favor de la Entidad Aseguradora. De acuerdo a las Resoluciones SSN N° 40.541/2017 y N° 40.761/2017, cuando el pago de las primas se haga a través de un Productor Asesor de Seguros, una Sociedad de Productores o un Agente Institorio, el cobro deberá efectuarse exclusivamente a través de los siguientes medios: a) Medios electrónicos de cobro autorizados por el BANCO CENTRAL DE LA REPÚBLICA ARGENTINA. b) Cheque, en las modalidades previstas en el Artículo 1° inciso d) de la Resolución ME N° 429/00 mencionada en el párrafo anterior. c) Cheques de terceros los que deberán ser indefectiblemente endosados por el asegurado o tomador de la póliza. d) Entidades especializadas en cobranza, registro y procesamiento de pagos por medios electrónicos habilitados por la SUPERINTENDENCIA DE SEGUROS DE LA NACIÓN. e) Efectivo en moneda de curso legal, mediante la utilizado de un controlador fiscal homologado por la ADMINISTRACIÓN FEDERAL DE INGRESOS PÚBLICOS y registrado ante la SUPERINTENDENCIA DE SEGUROS DE LA NACIÓN, únicamente hasta la suma máxima establecida por la normativa (Artículo 1° de la Ley N° 25.345 o la que en el futuro la reemplace y/o modifique). Comprobante provisorio hasta la recepción del certificado de incorporación. Autorizo el envío del certificado de incorporación y de copia de las condiciones generales, específicas y particulares de la póliza por medios electrónicos. La compañía pone a disposición su certificado en <a href="https://autogestion.assurant.com.ar/">https://autogestion.assurant.com.ar/</a><br>
            La celebración del contrato de seguro y la cobertura solicitada queda supeditada a la aceptación de esta solicitud por parte de la compañía de seguros (art. 4 Ley N° 17.418).<br><br>
            El seguro es emitido por Assurant Argentina Compañía de Seguros S.A., CUIT 30-50004540-6, Ing. Butty 240, piso 15, Ciudad Autónoma de Buenos Aires. El número de inscripción en el registro     correspondiente a la Superintendencia de Seguros de la Nación es 0209.<br><br>
            Esta póliza fue aprobada por la SSN A través de la resolución aprobatoria RESOL 2020-490
        </div>
    </div>
    <div>
        <div style="border: 1px solid #000000; padding: 4px; font-weight: bold; background-color: #d9d9d9; text-align: center;">
            PROTECCION DE DATOS PERSONALES
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            Mediante la presente el Solicitante autoriza de manera previa, expresa e informada a Assurant Argentina Cia De seguros S.A. para que realice la recolección, almacenamiento, uso, circulación, supresión, transferencia, transmisión y, en general, cualquier operación o conjunto de operaciones en y sobre información vinculada que permite su identificación que se recoge a través de esta contratación (los “Datos Personales”). La presente autorización se otorga para el cumplimiento de los fines de Assurant Argentina Cia De seguros S.A. que incluyen, pero no se limitan a: el cumplimiento de obligaciones legales o contractuales de Assurant Argentina Cia De seguros S.A. con terceros; la debida ejecución de la relación con el Cliente; el cumplimiento de las políticas internas de Assurant Argentina Cia de seguros S.A..; la verificación del cumplimiento de las obligaciones corresponden al Cliente; la entrega de los Datos Personales a terceros para que éstos desarrollen alguna tarea por encargo de Assurant Argentina Cia De seguros S.A..; el ofrecimiento y promoción de productos nuevos y existentes; la contratación de la cobertura; la realización de campañas de actualización de datos; el envío de información adicional o comercial acerca de las ofertas y promociones de productos, nuevos o existentes; estudios de seguridad para la prevención de fraudes, lavado de activos y financiación del terrorismo, entre otros; la administración de sus sistemas de información y comunicaciones, y el reporte de información a las autoridades competentes. El Solicitante acepta y conoce que ha sido informado de los derechos que le asisten en su calidad de titular de los Datos Personales, entre los que se encuentran el derecho a presentar a solicitudes de información, actualización, supresión y/o rectificación sobre los Datos Personales. Assurant Argentina Cia De seguros S.A. protege sus Datos Personales, los que serán tratados de acuerdo con el secreto profesional y en estricto cumplimiento de la Ley 25.326 de Protección de Datos Personales y el Decreto 1558/2001 así como de cualquier otra normativa que en el futuro la modifique, reemplace y/o complemente. A fin de ejercer los derechos que como titular de sus datos personales, o ante cualquier comentario en relación con el tratamiento de los mismos, por favor contáctese con nosotros en Ingeniero Butty 240, Piso 15°, Ciudad Autónoma de Buenos Aires o a través de la web <a href="https://www.assurant.com.ar/Centro-de-Atención-al-Cliente">https://www.assurant.com.ar/Centro-de-Atención-al-Cliente</a>
        </div>
    </div>
    <div>
        <div style="border: 1px solid #000000; padding: 4px; font-weight: bold; background-color: #d9d9d9; text-align: center;">
            ANEXO I - EXCLUSIONES
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            Se detallan a continuación las exclusiones aplicables a cada una de las coberturas de la Póliza.<br><br>
            <strong style="text-decoration: underline;">CONDICIONES ESPECÍFICAS - DAÑOS POR ACCIDENTE EXCLUSIONES A LA COBERTURA</strong><br><br>
            El Asegurador no indemnizará, salvo pacto en contrario en las Condiciones Particulares, las pérdidas o daños que sean consecuencia inmediata, mediata o casual de:<br>
            <ol type="a">
                <li>Vicio propio, depreciación, desgaste, deterioro o rotura de cualquier pieza causados por el natural y normal manejo, uso o funcionamiento del Equipo Asegurado.</li>
                <li>Daños o pérdidas que sean consecuencia directa del deterioro gradual a consecuencia de condiciones atmosféricas, químicas, corrosión o herrumbre.</li>
                <li>Uso indebido o abusivo o contrariando las instrucciones del fabricante.</li>
                <li>Deficiencias en la tensión de alimentación eléctrica o de conexiones indebidas.</li>
                <li>Acción de roedores, insectos, vermes, gérmenes, moho, oxidación, efectos de temperatura, vapores, humedad, humo, hollín, polvo, trepidaciones de máquinas, ruidos, olores y luminosidad.</li>
                <li>Daños que se manifiesten exclusivamente como defectos estéticos, incluyendo, pero no limitado a rayaduras en superficies pintadas, pulidas o esmaltadas.</li>
                <li>Daños de los que sea responsable el fabricante o proveedor del Equipo Asegurado, ya sea legal o contractualmente.</li>
                <li>Arreglo, reparación o desarme del Equipo Asegurado por un técnico no autorizado por el Asegurador o el fabricante durante el período de garantía de fábrica.</li>
                <li>Daños o pérdidas de información originados por la introducción de programas informáticos por cualquier medio en el software del Equipo Asegurado.</li>
                <li>Programación, reparación y/o reconstrucción de datos, instalación o reconfiguración de programas, excepto en caso de corresponder el restablecimiento del software de fábrica, actualizado en la última versión disponible brindada por el fabricante.</li>
                <li>Obsolescencia o caída en desuso.</li>
                <li>Servicios de mantenimiento.</li>
                <li>Daños o pérdidas causados por fallas o desperfectos ya existentes en el momento de inicio de vigencia del Seguro y de los cuales tuvo o debería tener conocimiento el Asegurado.</li>
                <li>Daños o fallas que cubrió o debió cubrir el fabricante por la garantía por él otorgada.</li>
                <li>Daños como consecuencia de la exposición a líquidos.</li>
            </ol>
            Asimismo, queda expresamente entendido y pactado que, el Asegurador no indemnizará, salvo pacto en contrario en las Condiciones Particulares, las pérdidas que sean consecuencia inmediata, mediata o casual de:<br>
            <ol type="a">
                <li>Secuestro, confiscación, incautación o decomiso u otras decisiones, legítimas o no de la autoridad o de quien se la arrogue.</li>
                <li>Dolo o culpa grave del Asegurado.</li>
                <li>Hechos ocurridos a bordo de aeronaves, naves, embarcaciones o equipos flotantes, siempre que el siniestro se haya producido con ocasión del transporte del Equipo Asegurado en calidad de carga no acompañada (Ejemplo: mudanza, correo, etc.). Esta exclusión no alcanza los siniestros que puedan producirse cuando el Equipo Asegurado es transportado por el Asegurado en ocasión de un viaje en alguno de los medios descriptos.</li>
                <li>Hechos que se produzcan durante la utilización o custodia del Equipo Asegurado por personas distintas al Asegurado que no hayan sido expresamente autorizadas por éste o que sean menores de edad.</li>
                <li>Daños o pérdidas que experimenten en forma aislada los componentes o accesorios tales como transformadores, cargadores, cables eléctricos, manos libres, baterías, auriculares o parlantes.</li>
                <li>Tumulto popular, vandalismo o lock out.</li>
            </ol>
            <strong style="text-decoration: underline">CONDICIONES ESPECÍFICAS - ROBO TOTAL EXCLUSIONES A LA COBERTURA</strong><br><br>
            El Asegurador no indemnizará, salvo pacto en contrario en las Condiciones Particulares, las pérdidas o daños que sean consecuencia inmediata, mediata o casual de:<br>
            <ol type="a">
                <li>Cuando el delito haya sido instigado o cometido por o en complicidad con cualquier miembro de la familia del Asegurado o personas allegadas.</li>
                <li>Robo o hurto de los accesorios en forma aislada del Equipo Asegurado.</li>
                <li>Extravío.</li>
                <li>Cuando el Equipo Asegurado se encontrara en un vehículo al momento de ser robado, a menos que el vehículo estuviera cerrado con todos los sistemas de seguridad activados y todos los cuidados razonables fueran tomados.</li>
            </ol>
            Asimismo, queda expresamente entendido y pactado que, el Asegurador no indemnizará, salvo pacto en contrario en las Condiciones Particulares, las pérdidas que sean consecuencia inmediata, mediata o casual de:<br>
            <ol type="a">
                <li>Secuestro, confiscación, incautación o decomiso u otras decisiones, legítimas o no de la autoridad o de quien se la arrogue.</li>
                <li>Dolo o culpa grave del Asegurado.</li>
                <li>Hechos ocurridos a bordo de aeronaves, naves, embarcaciones o equipos flotantes, siempre que el siniestro se haya producido con ocasión del transporte del Equipo Asegurado en calidad de carga no acompañada (Ejemplo: mudanza, correo, etc.). Esta exclusión no alcanza los siniestros que puedan producirse cuando el Equipo Asegurado es transportado por el Asegurado en ocasión de un viaje en alguno de los medios descriptos.</li>
                <li>Hechos que se produzcan durante la utilización o custodia del Equipo Asegurado por personas distintas al Asegurado que no hayan sido expresamente autorizadas por éste o que sean menores de edad.</li>
                <li>Daños o pérdidas que experimenten en forma aislada los componentes o accesorios tales como transformadores, cargadores, cables eléctricos, manos libres, baterías, auriculares o parlantes.</li>
                <li>Tumulto popular, vandalismo o lock out.</li>
            </ol>
        </div>
    </div>
    <div>
        <div style="border: 1px solid #000000; padding: 4px; font-weight: bold; background-color: #d9d9d9; text-align: center;">
            CONDICIONES ESPECÍFICAS PROTECCIÓN PARA EQUIPOS ELECTRÓNICOS
        </div>
    </div>
    <div>
        <div style="text-decoration: underline; font-weight: bold; padding: 30px 0; text-align: center;">
            CONDICIONES ESPECÍFICAS<br>
            COBERTURA DE DAÑOS POR ACCIDENTE<br>
            REEMPLAZO
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>RIESGO CUBIERTO</strong><br>
            <strong>ARTÍCULO 1</strong><br>
            El Asegurador se obliga a reemplazar el Equipo Asegurado por los daños materiales totales o parciales que hubiera sufrido como consecuencia de un accidente. Se entiende por accidente cualquier causa externa, súbita e imprevista que no haya sido expresamente excluida en esta Póliza. El Equipo Asegurado debe encontrarse identificado inequívocamente (marca, modelo, Nº de serie, artículo, etc.) en el respectivo comprobante de compra que obre en poder del Asegurado.<br><br>
            A los efectos de esta cobertura, existirá Daño Total cuando el Equipo Asegurado haya quedado totalmente destruido como consecuencia de un accidente cubierto o el costo de reparación de los daños sufridos igualen o excedan el precio en plaza del mismo.<br><br>
            Asimismo, se entenderá que existe Daño Parcial cuando, en virtud de un accidente, el costo de reparación de los daños sufridos por el Equipo Asegurado sea inferior al precio en plaza del mismo.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>LÍMITE DE INDEMNIZACIÓN</strong><br>
            <strong>ARTÍCULO 2</strong><br>
            La responsabilidad del Asegurador en cada siniestro no superará la Suma Asegurada Máxima por evento establecida en las Condiciones Particulares.<br><br>
            Asimismo, por cada Equipo Asegurado cubierto, podrá pactarse la aplicación de los siguientes límites de responsabilidad:<br><br>
            <ul>
                <li>Límite de responsabilidad máximo anual aplicable por cada vigencia anual del seguro y/o</li>
                <li>Cantidad máxima de eventos cubiertos por cada vigencia anual del seguro.</li>
            </ul>
            Los límites precedentes serán aplicables por cada Equipo Asegurado para todas las coberturas en forma conjunta, salvo que se hubiere establecido alguna condición diferente en las Condiciones Particulares.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>BENEFICIO</strong><br>
            <strong>ARTÍCULO 3</strong><br>
            Aceptada la procedencia del siniestro, el Asegurador reemplazará el bien siniestrado por uno reacondicionado o nuevo de similares condiciones y funcionalidad.<br><br>
            Si no resultara posible realizar tal reemplazo, el Asegurador indemnizará al Asegurado por un importe igual al valor de mercado de un bien de iguales condiciones y funcionalidad que el Equipo Asegurado siniestrado, hasta los límites de responsabilidad establecidos en la presente Póliza.<br><br>
            En caso que proceda el reemplazo del Equipo Asegurado o el pago de una indemnización, el Asegurado debe poner el Equipo Asegurado a disposición del Asegurador, en el lugar indicado por éste último.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>EXCLUSIONES A LA COBERTURA</strong><br>
            <strong>ARTÍCULO 4</strong><br>
            El Asegurador no indemnizará, salvo pacto en contrario en las Condiciones Particulares, las pérdidas o daños que sean consecuencia inmediata, mediata o casual de:<br>
            <ol type="a">
                <li>Vicio propio, depreciación, desgaste, deterioro o rotura de cualquier pieza causados por el natural y normal manejo, uso o funcionamiento del Equipo Asegurado.</li>
                <li>Daños o pérdidas que sean consecuencia directa del deterioro gradual a consecuencia de condiciones atmosféricas, químicas, corrosión o herrumbre.</li>
                <li>Uso indebido o abusivo o contrariando las instrucciones del fabricante.</li>
                <li>Deficiencias en la tensión de alimentación eléctrica o de conexiones indebidas.</li>
                <li>Acción de roedores, insectos, vermes, gérmenes, moho, oxidación, efectos de temperatura, vapores, humedad, humo, hollín, polvo, trepidaciones de máquinas, ruidos, olores y luminosidad.</li>
                <li>Daños que se manifiesten exclusivamente como defectos estéticos, incluyendo, pero no limitado a rayaduras en superficies pintadas, pulidas o esmaltadas.</li>
                <li>Daños de los que sea responsable el fabricante o proveedor del Equipo Asegurado, ya sea legal o contractualmente.</li>
                <li>Arreglo, reparación o desarme del Equipo Asegurado por un técnico no autorizado por el Asegurador o el fabricante durante el período de garantía de fábrica.</li>
                <li>Daños o pérdidas de información originados por la introducción de programas informáticos por cualquier medio en el software del Equipo Asegurado.</li>
                <li>Programación, reparación y/o reconstrucción de datos, instalación o reconfiguración de programas, excepto en caso de corresponder el restablecimiento del software de fábrica, actualizado en la última versión disponible brindada por el fabricante.</li>
                <li>Obsolescencia o caída en desuso.</li>
                <li>Servicios de mantenimiento.</li>
                <li>Daños o pérdidas causados por fallas o desperfectos ya existentes en el momento de inicio de vigencia del Seguro y de los cuales tuvo o debería tener conocimiento el Asegurado.</li>
                <li>Daños o fallas que cubrió o debió cubrir el fabricante por la garantía por él otorgada.</li>
                <li>Daños como consecuencia de la exposición a líquidos.</li>
            </ol>
            Asimismo, queda expresamente entendido y pactado que, el Asegurador no indemnizará, salvo pacto en contrario en las Condiciones Particulares, las pérdidas que sean consecuencia inmediata, mediata o casual de:<br>
            <ol type="a">
                <li>Secuestro, confiscación, incautación o decomiso u otras decisiones, legítimas o no de la autoridad o de quien se la arrogue.</li>
                <li>Dolo o culpa grave del Asegurado.</li>
                <li>Hechos ocurridos a bordo de aeronaves, naves, embarcaciones o equipos flotantes, siempre que el siniestro se haya producido con ocasión del transporte del Equipo Asegurado en calidad de carga no acompañada (Ejemplo: mudanza, correo, etc.). Esta exclusión no alcanza los siniestros que puedan producirse cuando el Equipo Asegurado es transportado por el Asegurado en ocasión de un viaje en alguno de los medios descriptos.</li>
                <li>Hechos que se produzcan durante la utilización o custodia del Equipo Asegurado por personas distintas al Asegurado que no hayan sido expresamente autorizadas por éste o que sean menores de edad.</li>
                <li>Daños o pérdidas que experimenten en forma aislada los componentes o accesorios tales como transformadores, cargadores, cables eléctricos, manos libres, baterías, auriculares o parlantes.</li>
                <li>Tumulto popular, vandalismo o lock out.</li>
            </ol>
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>FRANQUICIAS A CARGO DEL ASEGURADO</strong><br>
            <strong>ARTÍCULO 5</strong><br>
            Se podrá pactar que el Asegurado participe en todo y cada siniestro en un porcentaje de la suma asegurada y/o de la indemnización y/o del costo de la reposición que pudiera corresponder por aplicación de las presentes Condiciones Específicas y/o en un monto fijo, de acuerdo a lo que se establezca en las Condiciones Particulares.<br><br>
            De igual forma, se podrá establecer un valor mínimo y máximo para la referida franquicia a cargo del Asegurado, también indicadas en las Condiciones Particulares.<br><br>
            Podrán preverse franquicias diferenciadas para los siniestros que ocasionen Daño Total y aquellos que generen Daños Parciales.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>CARENCIA</strong><br>
            <strong>ARTÍCULO 6</strong><br>
            El Asegurador otorgará el beneficio previsto en la presente cobertura, siempre que el siniestro haya ocurrido una vez finalizado el período de carencia estipulado en las Condiciones Particulares. Dicho plazo se contará a partir del inicio de vigencia del seguro.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>ÁMBITO DE LA COBERTURA</strong><br>
            <strong>ARTÍCULO 7</strong><br>
            Se deja constancia que el Asegurador será responsable por los siniestros ocurridos en cualquier parte del mundo, salvo pacto en contrario establecido en las Condiciones Particulares. Queda expresamente pactado que independientemente del lugar de ocurrencia del siniestro, el reemplazo que corresponda deberá realizarse en la República Argentina, en los puntos de servicio autorizados por el Asegurador para efectuar tales reemplazos.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>CARGAS Y OBLIGACIONES DEL ASEGURADO</strong><br>
            <strong>ARTÍCULO 8</strong><br>
            Adicionalmente a lo establecido en las Condiciones Generales, queda entendido y convenido que el Asegurado deberá cumplir con las siguientes cargas u obligaciones, salvo pacto en contrario estipulado en las Condiciones Particulares:<br>
            <ol type="a">
                <li>Observar las instrucciones del fabricante en cuanto al manejo, inspección y mantenimiento del Equipo Asegurado.</li>
                <li>Tomar las medidas de seguridad razonables para prevenir el siniestro.</li>
                <li>No hacer abandono de la cosa dañada.</li>
                <li>Abstenerse de reponer o reparar el Equipo Asegurado sin autorización del Asegurador.</li>
            </ol>
            El incumplimiento por parte del Asegurado de cualquiera de las cargas mencionadas precedentemente hará perder al Asegurado el derecho a la indemnización de acuerdo al régimen del Artículo 36 de la Ley de Seguros.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>CARGA ESPECIAL</strong><br>
            <strong>ARTÍCULO 9</strong><br>
            En caso de siniestro, el Asegurado deberá presentar el Equipo Asegurado, las piezas o partes reemplazadas, quedando éstas en propiedad del Asegurador.<br><br>
            El incumplimiento por parte del Asegurado de esta carga especial hará perder al Asegurado el derecho a la indemnización de acuerdo al régimen del Artículo 36 de la Ley de Seguros.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>DENUNCIA DEL SINIESTRO</strong><br>
            <strong>ARTÍCULO 10</strong><br>
            En concordancia con lo establecido en el Artículo 13 de las Condiciones Generales, el Asegurado deberá denunciar la ocurrencia del siniestro en los plazos allí establecidos.
        </div>
    </div>
    <div>
        <div style="text-decoration: underline; font-weight: bold; padding: 30px 0; text-align: center;">
            CONDICIONES ESPECÍFICAS<br>
            COBERTURA DE ROBO TOTAL<br>
            REEMPLAZO
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>RIESGO CUBIERTO</strong><br>
            <strong>ARTÍCULO 1</strong><br>
            El Asegurador se obliga a indemnizar al Asegurado por la pérdida sufrida como consecuencia del robo del Equipo Asegurado, procediendo al reemplazo del mismo. El Equipo Asegurado debe encontrarse identificado inequívocamente (marca, modelo, Nº de serie, artículo, etc.) en el respectivo comprobante de compra que obre en poder del Asegurado.<br><br>
            Se entenderá que existe robo cuando medie apoderamiento ilegítimo del Equipo Asegurado, con fuerza en las cosas o intimidación o violencia en las personas, ya sea que tengan lugar antes del hecho para facilitarlo o en el acto de cometerlo o inmediatamente después, para lograr el fin propuesto o la impunidad (Art. 164 del Código Penal).<br><br>
            Por intimidación se entenderá únicamente la amenaza irresistible, directa o indirecta de daño físico inminente al Asegurado.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>LÍMITE DE INDEMNIZACIÓN </strong><br>
            <strong>ARTÍCULO 2</strong><br>
            La responsabilidad del Asegurador en cada siniestro no superará la Suma Asegurada Máxima por evento establecida en las Condiciones Particulares.<br><br>
            Asimismo, por cada Equipo Asegurado cubierto, podrá pactarse la aplicación de los siguientes límites de responsabilidad:<br>
            <ul>
                <li>Límite de responsabilidad máximo anual aplicable por cada vigencia anual del seguro y/o</li>
                <li>Cantidad máxima de eventos cubiertos por cada vigencia anual del seguro.</li>
            </ul>
            Los límites precedentes serán aplicables por cada Equipo Asegurado para todas las coberturas en forma conjunta, salvo que se hubiere establecido alguna condición diferente en las Condiciones Particulares. 
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>BENEFICIO</strong><br>
            <strong>ARTÍCULO 3</strong><br>
            Aceptada la procedencia del siniestro, el Asegurador reemplazará el bien siniestrado por uno reacondicionado o nuevo de similares condiciones y funcionalidad.<br><br>
            Si no resultara posible realizar tal reemplazo, el Asegurador indemnizará al Asegurado por un importe igual al valor de mercado de un bien de iguales condiciones y funcionalidad que el Equipo Asegurado siniestrado, hasta los límites de responsabilidad establecidos en la presente Póliza. 
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>EXCLUSIONES A LA COBERTURA</strong><br>
            <strong>ARTÍCULO 4</strong><br>
            El Asegurador no indemnizará, salvo pacto en contrario en las Condiciones Particulares, las pérdidas o daños que sean consecuencia inmediata, mediata o casual de:<br>
            <ol type="a">
                <li>Cuando el delito haya sido instigado o cometido por o en complicidad con cualquier miembro de la familia del Asegurado o personas allegadas.</li>
                <li>Robo de los accesorios en forma aislada del Equipo Asegurado.</li>
                <li>Hurto o extravío.</li>
                <li>Cuando el Equipo Asegurado se encontrara en un vehículo al momento de ser robado, a menos que el vehículo estuviera cerrado con todos los sistemas de seguridad activados y todos los cuidados razonables fueran tomados.</li>
            </ol>
            Asimismo, queda expresamente entendido y pactado que, el Asegurador no indemnizará, salvo pacto en contrario en las Condiciones Particulares, las pérdidas que sean consecuencia inmediata, mediata o casual de:<br>
            <ol type="a">
                <li>Secuestro, confiscación, incautación o decomiso u otras decisiones, legítimas o no de la autoridad o de quien se la arrogue.</li>
                <li>Dolo o culpa grave del Asegurado.</li>
                <li>Hechos ocurridos a bordo de aeronaves, naves, embarcaciones o equipos flotantes, siempre que el siniestro se haya producido con ocasión del transporte del Equipo Asegurado en calidad de carga no acompañada (Ejemplo: mudanza, correo, etc.). Esta exclusión no alcanza los siniestros que puedan producirse cuando el Equipo Asegurado es transportado por el Asegurado en ocasión de un viaje en alguno de los medios descriptos.</li>
                <li>Hechos que se produzcan durante la utilización o custodia del Equipo Asegurado por personas distintas al Asegurado que no hayan sido expresamente autorizadas por éste o que sean menores de edad.</li>
                <li>Daños o pérdidas que experimenten en forma aislada los componentes o accesorios tales como transformadores, cargadores, cables eléctricos, manos libres, baterías, auriculares o parlantes.</li>
                <li>Tumulto popular, vandalismo o lock out.</li>
            </ol>
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>FRANQUICIAS A CARGO DEL ASEGURADO</strong><br>
            <strong>ARTÍCULO 5</strong><br>
            Se podrá pactar que el Asegurado participe en todo y cada siniestro en un porcentaje de la suma asegurada y/o de la indemnización y/o del costo de la reposición que pudiera corresponder por aplicación de las presentes Condiciones Específicas y/o en un monto fijo, de acuerdo a lo que se establezca en las Condiciones Particulares.<br><br>
            De igual forma, se podrá establecer un valor mínimo y máximo para la referida franquicia a cargo del Asegurado, también indicadas en las Condiciones Particulares.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>CARENCIA</strong><br>
            <strong>ARTÍCULO 6</strong><br>
            El Asegurador otorgará el beneficio previsto en la presente cobertura, siempre que el siniestro haya ocurrido una vez finalizado el período de carencia estipulado en las Condiciones Particulares. Dicho plazo se contará a partir del inicio de vigencia del seguro.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>RECUPERO DEL EQUIPO ASEGURADO</strong><br>
            <strong>ARTÍCULO 7</strong><br>
            Si el Equipo Asegurado afectado por un siniestro se recuperara antes de la indemnización, ésta no tendrá lugar. El Equipo Asegurado se considerará recuperado cuando esté en poder de la policía, justicia u otra autoridad.<br>
            Si el recupero se produjera dentro de los ciento ochenta (180) días posteriores a la indemnización, el Asegurado tendrá derecho a conservar la propiedad del Equipo Asegurado, con devolución al Asegurador del importe respectivo, deduciendo el valor de los daños sufridos por el Equipo Asegurado. El Asegurado podrá hacer uso de este derecho hasta treinta (30) días después de tener conocimiento del recupero; transcurrido ese plazo el Equipo Asegurado pasará a ser de propiedad del Asegurador, obligándose el Asegurado a realizar cualquier acto que se requiera para ello.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>ÁMBITO DE LA COBERTURA</strong><br>
            <strong>ARTÍCULO 8</strong><br>
            Se cubrirán aquellos siniestros ocurridos dentro del territorio de la República Argentina, salvo pacto en contrario establecido en las Condiciones Particulares.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>CARGAS Y OBLIGACIONES DEL ASEGURADO</strong><br>
            <strong>ARTÍCULO 9</strong><br>
            Adicionalmente a lo establecido en las Condiciones Generales, queda entendido y convenido que el Asegurado deberá cumplir con las siguientes cargas u obligaciones, salvo pacto en contrario estipulado en las Condiciones Particulares:<br>
            <ol type="a">
                <li>Tomar las medidas de seguridad razonables para prevenir el siniestro.</li>
                <li>Denunciar a las autoridades policiales el acaecimiento del siniestro dentro de los 3 días de acaecido el hecho.</li>
            </ol>
            El incumplimiento por parte del Asegurado de cualquiera de las cargas mencionadas precedentemente, hará perder al Asegurado el derecho a la indemnización de acuerdo al régimen del Artículo 36 de la Ley de Seguros Nº 17.418.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>DENUNCIA DEL SINIESTRO</strong><br>
            <strong>ARTÍCULO 10</strong><br>
            En concordancia con lo establecido en el Artículo 13 de las Condiciones Generales, el Asegurado deberá denunciar la ocurrencia del siniestro en los plazos allí establecidos.
        </div>
    </div>
    <div>
        <div style="text-decoration: underline; font-weight: bold; padding: 30px 0; text-align: center;">
            SEGURO INDIVIDUAL DE PROTECCIÓN PARA EQUIPOS ELECTRÓNICOS<br>
            CONDICIONES GENERALES
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>PREEMINENCIA NORMATIVA</strong><br>
            <strong>ARTÍCULO 1</strong><br>
            Esta Póliza consta de Condiciones Generales, Condiciones Específicas, Cláusulas Adicionales y Condiciones Particulares. En caso de discordancia entre las mismas, regirá el siguiente orden de prelación:<br>
            <ul>
                <li>Condiciones Particulares</li>
                <li>Cláusulas Adicionales</li>
                <li>Condiciones Específicas</li>
                <li>Condiciones Generales</li>
            </ul>
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>DEFINICIONES</strong><br>
            <strong>ARTÍCULO 2</strong><br>
            A todos los fines y efectos de la presente Póliza los términos que se indican a continuación tendrán específicamente los siguientes significados y/o alcances:<br><br>
            2.1. Asegurado: es la persona física o jurídica que contrata la cobertura, en su beneficio personal o de terceros, pudiendo ser propietario o comodatario del Equipo Asegurado, designada como Asegurado en las respectivas Condiciones Particulares.<br><br>
            2.2. Asegurador: es ASSURANT ARGENTINA COMPAÑÍA DE SEGUROS S.A., quien asume el riesgo contractualmente pactado.<br><br>
            2.3. Equipos Asegurados: son los dispositivos electrónicos declarados por el Asegurado al momento de contratar el seguro, e identificados inequívocamente en las Condiciones Particulares en relación a sus características (tipo, modelo, valor y/o antigüedad), y en el respectivo comprobante de compra que obre en poder del Asegurado, y que hubieran sido adquiridos por el Asegurado en la República Argentina (salvo pacto en contrario).<br><br>
            En caso que el Asegurado solicitara, con posterioridad al inicio de vigencia de su seguro, cobertura para otros dispositivos electrónicos, estos serán incorporados a la póliza mediante la emisión de un endoso.<br><br>
            2.4. Póliza: es el instrumento contractual emitido por el Asegurador, por el cual se instrumenta el seguro suscripto por el Asegurado y en el cual se establecen las condiciones, riesgos cubiertos, alcances, limitaciones y exclusiones del seguro. Forman parte integrante de la Póliza: la Solicitud del Seguro firmada por el Asegurado o cualquier otro medio digital o electrónico que acredite su conformidad respecto a la contratación de la cobertura, las presentes Condiciones Generales, las Condiciones Específicas aplicables a cada cobertura, las Condiciones Particulares y los Anexos y Cláusulas Adicionales que allí se indican y los endosos o suplementos que se emitan a la misma para complementarla o modificarla.            
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>RIESGOS CUBIERTOS</strong><br>
            <strong>ARTÍCULO 3</strong><br>
            Los alcances de cada una de las coberturas que se otorgan por la presente Póliza se detallan en las Condiciones Específicas y Cláusulas Adicionales, sólo en la medida que las mismas se encuentren expresamente detalladas en las Condiciones Particulares. 
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>RETICENCIA</strong><br>
            <strong>ARTÍCULO 4</strong><br>
            Esta Póliza ha sida extendida por el Asegurador sobre la base de las declaraciones suscriptas por el Asegurado en su Solicitud del Seguro.<br><br>
            Toda declaración falsa o toda reticencia de circunstancias conocidas por el Asegurado, aun hechas de buena fe, que a juicio de peritos hubiese impedido el contrato y/o la aceptación de la cobertura o hubiera modificado las condiciones del mismo, si el Asegurador hubiese sido cerciorado del verdadero estado del riesgo, hace nulo el contrato.<br><br>
            El Asegurador debe impugnar el contrato dentro de los tres meses de haber conocido la reticencia o falsedad (Art. 5 - L. de S.).<br>
            Cuando la reticencia no dolosa es alegada en el plazo del Artículo 5 de la Ley de Seguros, el Asegurador, a su exclusivo juicio, puede anular el contrato, restituyendo la prima percibida con deducción de los gastos, o reajustarla con la conformidad del Asegurado al verdadero estado del riesgo (Art. 6 - L. de S.).<br><br>
            Si la reticencia fuese dolosa o de mala fe, el Asegurador tiene derecho a las primas de los períodos transcurridos y del período en cuyo transcurso invoque la reticencia o falsa declaración (Art. 8 - L. de S.).<br><br>
            En todos los casos, si el siniestro ocurre durante el plazo para impugnar, el Asegurador no adeuda prestación alguna (Art. 9 - L. de S.).
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>AGRAVACIÓN DEL RIESGO</strong><br>
            <strong>ARTÍCULO 5</strong><br>
            El Asegurado debe denunciar al Asegurador las agravaciones del riesgo asumido causadas por un hecho suyo, antes de que se produzcan y las debidas a un hecho ajeno, inmediatamente después de conocerlas (Art. 38 – L. de S.).<br><br>
            Se entiende por agravación del riesgo asumido, la que si hubiese existido al tiempo de la celebración, a juicio de peritos, habría impedido este contrato o modificado sus condiciones (Art. 37 - L. de S.).<br><br>
            Cuando la agravación se deba a un hecho del Asegurado la cobertura queda suspendida. El Asegurador, en el término de siete días, deberá notificar su decisión de rescindir (Art. 39 - L. de S.).<br><br>
            Cuando la agravación resulte de un hecho ajeno al Asegurado o si éste debió permitirlo o provocarlo por razones ajenas a su voluntad, el Asegurador deberá notificarle su decisión de rescindir dentro del término de un mes y con un preaviso de siete días. Se aplicará el Artículo 39 de la Ley de Seguros si el riesgo no se hubiera asumido según las prácticas comerciales del Asegurador (Art. 40 - L. de S.).<br><br>
            La rescisión del contrato por agravación del riesgo da derecho al Asegurador:<br>
            <ol type="a">
                <li>Si la agravación del riesgo le fue comunicada oportunamente, a percibir la prima proporcional al tiempo transcurrido.</li>
                <li>Si no le fue comunicada oportunamente, a percibir la prima por el período de seguro en curso (Art. 41 - L. de S.). </li>
            </ol>
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>PLURALIDAD DE SEGUROS</strong><br>
            <strong>ARTÍCULO 6</strong><br>
            Quien asegura el mismo interés y el mismo riesgo con más de un asegurador, notificará sin dilación a cada uno de ellos los demás contratos celebrados con indicación del Asegurador y de la suma asegurada, bajo pena de caducidad. Con esta salvedad, en caso de siniestro el Asegurador contribuirá proporcionalmente al monto de su contrato, hasta la concurrencia de la indemnización debida.<br><br>
            El Asegurado no puede pretender en el conjunto una indemnización que supere el monto del daño sufrido. Si se celebró el seguro plural con la intención de un enriquecimiento indebido, son nulos los contratos celebrados con esa intención, sin perjuicio del derecho de los aseguradores a percibir la prima devengada en el período durante el cual conocieron esa intención (Arts. 67 y 68 - L. de S.).
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>PAGO DE LA PRIMA</strong><br>
            <strong>ARTÍCULO 7</strong><br>
            La prima es debida desde la celebración del contrato pero no es exigible sino contra entrega de la Póliza, salvo que se haya emitido un certificado o instrumento provisorio de cobertura (Art. 30 - L. de S.).<br><br>
            En el caso que la prima no se pague contra la entrega de la presente Póliza, su pago queda sujeto a las condiciones y efectos establecidos en la Cláusula de Cobranza del Premio que forma parte del presente contrato.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>PROVOCACIÓN DEL SINIESTRO</strong><br>
            <strong>ARTÍCULO 8</strong><br>
            El Asegurador queda liberado si el Asegurado provoca por acción u omisión el siniestro, dolosamente o con culpa grave, salvo los actos realizados para precaver el siniestro o atenuar sus consecuencias o por un deber de humanidad generalmente aceptado (Arts. 70 - L. de S.). 
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>ABANDONO</strong><br>
            <strong>ARTÍCULO 9</strong><br>
            El Asegurado no puede hacer abandono de los bienes afectados por el siniestro (Art. 74 - L de S.).
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>CAMBIO EN LAS COSAS DAÑADAS</strong><br>
            <strong>ARTÍCULO 10</strong><br>
            El Asegurado no puede, sin el consentimiento del Asegurador, introducir cambios en las cosas dañadas que hagan más difícil establecer la causa del daño o el daño mismo, salvo que se cumpla para disminuir el daño o en el interés público.<br><br>
            El Asegurador sólo puede invocar esta disposición cuando proceda sin demoras a la determinación de las causas del siniestro y a la valuación de los daños.<br><br>
            La violación maliciosa de esta carga libera al Asegurador (Art. 77 - L. de S.).
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>DENUNCIA DEL SINIESTRO</strong><br>
            <strong>ARTÍCULO 11</strong><br>
            El Asegurado está obligado a comunicar sin demora a las autoridades competentes el acaecimiento del hecho, cuando así corresponda por su naturaleza.<br><br>
            El Asegurado debe denunciar al Asegurador el acaecimiento del siniestro dentro de los tres días de conocerlo, bajo pena de perder el derecho a ser indemnizado, salvo que acredite caso fortuito, fuerza mayor o imposibilidad de hecho sin culpa o negligencia (Arts. 46 y 47 – L. de S.).<br><br>
            También está obligado a suministrar al Asegurador, a su pedido, la información necesaria para verificar el siniestro o la extensión de la prestación a su cargo, la prueba instrumental en cuanto sea razonable que la suministre y a permitirle al Asegurador las indagaciones necesarias a tales fines (Art. 46 – L. de S.).
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>EXAGERACIÓN FRAUDULENTA O PRUEBA FALSA DEL SINIESTRO</strong><br>
            <strong>ARTÍCULO 12</strong><br>
            El Asegurado pierde el derecho a ser indemnizado si deja de cumplir maliciosamente las cargas previstas en el segundo párrafo del Artículo 46 de la Ley de Seguros o exagera fraudulentamente los daños o emplea pruebas falsas para acreditar los mismos (Art. 48 – L. de S.).
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>PLAZO PARA PRONUNCIARSE SOBRE EL DERECHO DEL ASEGURADO</strong><br>
            <strong>ARTÍCULO 13</strong><br>
            El Asegurador debe pronunciarse acerca del derecho del Asegurado dentro de los treinta días de recibida la información complementaria que se requiera para la verificación del siniestro o de la extensión de la prestación a su cargo. La omisión de pronunciarse importa aceptación (Art. 56 - L. de S.).
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>VENCIMIENTO DE LA OBLIGACIÓN DEL ASEGURADOR</strong><br>
            <strong>ARTÍCULO 14</strong><br>
            En el caso de reparación o reemplazo, la Aseguradora cumplirá con la prestación a su cargo dentro de los 15 (quince) días de aceptada la procedencia del siniestro.<br><br>
            En caso que la Aseguradora tuviera que dar en pago al Asegurado una suma de dinero en concepto de indemnización, el crédito del Asegurado se pagará dentro de los quince días de fijado el monto de la indemnización o de la aceptación de la indemnización ofrecida, una vez vencido el plazo fijado en la Cláusula precedente para que el Asegurador se pronuncie acerca del derecho del Asegurado.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>RESCISIÓN UNILATERAL</strong><br>
            <strong>ARTÍCULO 15</strong><br>
            El Asegurado y el Asegurador tendrán derecho a rescindir la Póliza sin expresar causa.<br><br>
            Cuando el Asegurador ejerza este derecho, dará un preaviso no menor de quince días. Cuando lo ejerza el Asegurado, la rescisión se producirá desde la fecha en que el Asegurador reciba la notificación por escrito.<br><br>
            Cuando el seguro rija de doce a doce horas, la rescisión se computará desde la hora doce inmediata siguiente, y en caso contrario, desde la hora veinticuatro.<br><br>
            Si el Asegurador ejerce el derecho de rescindir, la prima se reducirá proporcionalmente por el plazo no corrido.<br><br>
            Si el Asegurado opta por la rescisión, el Asegurador tendrá derecho a la prima devengada por el tiempo transcurrido, según las tarifas de corto plazo (Art. 18, segundo párrafo – L. de S.). 
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>CADUCIDAD POR INCUMPLIMIENTO DE OBLIGACIONES Y CARGAS</strong><br>
            <strong>ARTÍCULO 16</strong><br>
            El incumplimiento de las obligaciones y cargas impuestas al Asegurado por la Ley de Seguros (salvo que se haya previsto otro efecto en la misma para el incumplimiento) y por el presente contrato, produce la caducidad de los derechos del Asegurado si el incumplimiento obedece a su culpa o negligencia, de acuerdo con el régimen previsto en el Artículo 36 de la Ley de Seguros.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>CAMBIO DE TITULAR DEL INTERÉS ASEGURADO</strong><br>
            <strong>ARTÍCULO 17</strong><br>
            El cambio de titular del interés asegurado debe ser notificado por el Asegurado al Asegurador en el término de siete días desde la fecha en que se produzca dicho cambio. La omisión libera al Asegurador si el siniestro ocurriera después de quince días de vencido este plazo.<br>
            El Asegurador podrá rescindir el contrato en el plazo de veinte días de notificado, dando un preaviso de quince días. (Arts. 82 - L. de S.).
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>SUBROGACIÓN</strong><br>
            <strong>ARTÍCULO 18</strong><br>
            Los derechos que correspondan al Asegurado contra un tercero, en razón del siniestro, se transfieren al Asegurador hasta el monto de la indemnización abonada. El Asegurado es responsable de todo acto que perjudique este derecho del Asegurador.<br><br>
            El Asegurador no puede valerse de la subrogación en perjuicio del Asegurado.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>FACULTADES DEL PRODUCTOR O AGENTE</strong><br>
            <strong>ARTÍCULO 19</strong><br>
            El productor o agente de seguro, cualquiera sea su vinculación con el Asegurador, autorizado por éste para la mediación, sólo está facultado con respecto a las operaciones en las cuales interviene para:<br>
            <ol type="a">
                <li>Recibir propuestas de celebración y modificación de contratos de seguros.</li>
                <li>Entregar los instrumentos emitidos por el Asegurador, referentes a contratos o sus prórrogas.</li>
            </ol>
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>DUPLICADO DE PÓLIZA – COPIAS</strong><br>
            <strong>ARTÍCULO 20</strong><br>
            En caso de robo, pérdida o destrucción de esta Póliza, el Asegurado podrá obtener un duplicado en sustitución de la Póliza original. Las modificaciones o suplementos que se incluyan en el duplicado, a pedido del Asegurado serán los únicos válidos.<br><br>
            El Asegurado tiene derecho a que se le entregue copia de las declaraciones efectuadas con motivo de este contrato y copia no negociable de la Póliza.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>IMPUESTOS, TASAS Y CONTRIBUCIONES</strong><br>
            <strong>ARTÍCULO 21</strong><br>
            Los impuestos, tasas y contribuciones de cualquier índole y jurisdicción que se crearen en lo sucesivo o los aumentos eventuales de los existentes, estarán a cargo del Asegurado, salvo cuando la ley los declare expresamente a cargo exclusivo del Asegurador.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>MORA AUTOMÁTICA – DOMICILIO PARA DENUNCIAS Y DECLARACIONES</strong><br>
            <strong>ARTÍCULO 22</strong><br>
            Toda denuncia o declaración impuesta por esta Póliza o por la Ley debe efectuarse en el plazo fijado al efecto. Las partes incurren en mora por el mero vencimiento del plazo (Art. 15 – L. de S.).<br><br>
            El domicilio en que las partes deben efectuar las denuncias y declaraciones previstas en la Ley de Seguros o en el presente contrato, es el último declarado (Art. 16 – L. de S.).
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>CÓMPUTO DE LOS PLAZOS</strong><br>
            <strong>ARTÍCULO 23</strong><br>
            Todos los plazos de días, indicados en la presente Póliza, se computarán corridos, salvo disposición expresa en contrario.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>PRÓRROGA DE JURISDICCIÓN</strong><br>
            <strong>ARTÍCULO 24</strong><br>
            Toda controversia judicial que se plantee en relación al presente contrato, se substanciará a opción del Asegurado, ante los jueces competentes del domicilio del Asegurado o el lugar de ocurrencia del siniestro, siempre que sea dentro de los límites del país.<br><br>
            Sin perjuicio de ello, el Asegurado o sus derecho-habientes, podrá presentar sus demandas contra el Asegurador ante los tribunales competentes del domicilio de la sede central o sucursal donde se emitió la Póliza e igualmente se tramitarán ante ellos las acciones judiciales relativas al cobro de las primas.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>CESIONES</strong><br>
            <strong>ARTÍCULO 25</strong><br>
            Cualquier cesión de derechos que tenga por base este contrato, deberá notificarse fehacientemente por escrito al Asegurador, el que dejará debida constancia de ello en las Condiciones Particulares.<br><br>
            Si no se cumpliera con la notificación al Asegurador referida en el párrafo anterior, los convenios realizados por el Asegurado con terceros no tendrán ningún valor frente al Asegurador.
        </div>
    </div>
    <div>
        <div style="padding: 30px 0;">
            <strong>PRESCRIPCIÓN</strong><br>
            <strong>ARTÍCULO 26</strong><br>
            Las acciones fundadas en el presente contrato prescriben en el plazo de un año, computado desde que la correspondiente obligación es exigible. 
        </div>
    </div>
</div>