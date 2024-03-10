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
$PDF_HEADER_TITLE = $nombre_parqueo;
$PDF_HEADER_STRING = $direccion.' Telf: '.$telefono;
$PDF_HEADER_LOGO = 'auto4.jpg';

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
$pdf->setFooterMargin(PDF_MARGIN_FOOTER);

$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);

$pdf->setFont('Helvetica', '', 11);

$pdf->AddPage();

$html = '
<P><b>Reporte del Listado de espacios</b></P>
<table border="1" cellpadding="4">
<tr>
<td style="background-color: #c0c0c0;text-align: center" width="80px">Nro</td>
<td style="background-color: #c0c0c0;text-align: center" width="100px">Nro de espacio</td>
</tr>
';
$contador = 0;
$query_mapeos = $pdo->prepare("SELECT * FROM tb_mapeos WHERE estado = '1' ");
$query_mapeos->execute();
$mapeos = $query_mapeos->fetchAll(PDO::FETCH_ASSOC);
foreach($mapeos as $mapeo){
    $id_map = $mapeo['id_map'];
    $nro_espacio = $mapeo['nro_espacio'];
    $contador = $contador + 1;

    $html .= '
    <tr>
    <td style="text-align: center">'.$contador.'</td>
    <td style="text-align: center">'.$nro_espacio.'</td>
    </tr>
    ';


}

$html.='
</table>
';


$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('example_004.pdf', 'I');

