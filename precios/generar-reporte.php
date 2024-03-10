<?php
$query_informacions = $pdo->prepare("SELECT * FROM tb_informaciones WHERE estado = '1' ");
$query_informacions->execute();
$informacions = $query_informacions->fetchAll(PDO::FETCH_ASSOC);
foreach($informacions as $informacion){
    $id_informacion = $informacion['id_informacion'];
    $nombre_parqueo = $informacion['nombre_parqueo'];
    $actividad_empresa = $informacion['actividad_empresa'];
    $sucursal = $informacion['sucursal'];
    $direccion = $informacion['direccion'];
    $zona = $informacion['zona'];
    $telefono = $informacion['telefono'];
    $departamento_ciudad = $informacion['departamento_ciudad'];
    $pais = $informacion['pais'];
}
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Nicola Asuni');
$pdf->setTitle('TCPDF Example 004');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

$PDF_HEADER_TITLE = $nombre_parqueo;
$PDF_HEADER_STRING = $direccion.' Telf: '.$telefono;
$PDF_HEADER_LOGO = 'auto4.jpg';

$pdf->setHeaderData($PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
$pdf->setFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}
$pdf->setFont('Helvetica', '', 11);
$pdf->AddPage();
$html = '
<P><b>Reporte del Listado de precios</b></P>
<table border="1" cellpadding="4">
<tr>
<td style="background-color: #c0c0c0;text-align: center" width="80px">Nro</td>
<td style="background-color: #c0c0c0;text-align: center" >Cantidad</td>
<td style="background-color: #c0c0c0;text-align: center" >Detalle</td>
<td style="background-color: #c0c0c0;text-align: center" >Precio</td>
</tr>
';
$contador_precio = 0;
$query_precios = $pdo->prepare("SELECT * FROM tb_precios WHERE estado = '1'  ");
$query_precios->execute();
$datos_precios = $query_precios->fetchAll(PDO::FETCH_ASSOC);
foreach($datos_precios as $datos_precio){
    $contador_precio = $contador_precio + 1;
    $id_precio = $datos_precio['id_precio'];
    $cantidad = $datos_precio['cantidad'];
    $detalle = $datos_precio['detalle'];
    $precio = $datos_precio['precio'];

    $html .= '
    <tr>
    <td style="text-align: center">'.$contador_precio.'</td>
    <td style="text-align: center">'.$cantidad.'</td>
    <td style="text-align: center">'.$detalle.'</td>
    <td style="text-align: center">'.$precio.'</td>
    </tr>
    ';


}

$html.='
</table>
';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('example_004.pdf', 'I');

