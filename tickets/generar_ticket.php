<?php

require_once('../app/templeates/TCPDF-main/tcpdf.php');
include('../app/config.php');

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



$query_tickets = $pdo->prepare("SELECT * FROM tb_tickets WHERE estado = '1' ");
$query_tickets->execute();
$tickets = $query_tickets->fetchAll(PDO::FETCH_ASSOC);
foreach($tickets as $ticket){
    $id_ticket = $ticket['id_ticket'];
    $nombre_cliente = $ticket['nombre_cliente'];
    $nit_ci = $ticket['nit_ci'];
    $cuviculo = $ticket['cuviculo'];
    $fecha_ingreso = $ticket['fecha_ingreso'];
    $hora_ingreso = $ticket['hora_ingreso'];
    $user_sesion = $ticket['user_sesion'];
}



$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(79,80), true, 'UTF-8', false);


$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Nicola Asuni');
$pdf->setTitle('TCPDF Example 002');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');


$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);


$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->setMargins(5, 5, 5);

$pdf->setAutoPageBreak(true, 5);


$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------


$pdf->setFont('Helvetica', '', 7);


$pdf->AddPage();




$html = '
<div>
    <p style="text-align: center">
        <b>'.$nombre_parqueo.'</b> <br>
        '.$actividad_empresa.' <br>
        SUCURSAL No '.$sucursal.' <br>
        '.$direccion.' <br>
        ZONA: '.$zona.' <br>
        TELÉFONO: '.$telefono.' <br>
        '.$departamento_ciudad.' - '.$pais.' <br>
        --------------------------------------------------------------------------------
        <div style="text-align: left">
            <b>DATOS DEL CLIENTE</b> <br>
            <b>SEÑOR(A): </b> '.$nombre_cliente.' <br>
            <b>NIT/CI.: </b> '.$nit_ci.'  <br>
            -------------------------------------------------------------------------------- <br>
        <b>Cuviculo de parqueo: </b> '.$cuviculo.' <br>
        <b>Fecha de ingreso: </b> '.$fecha_ingreso.' <br>
        <b>Hora de ingreso: </b> '.$hora_ingreso.' <br>
         -------------------------------------------------------------------------------- <br>
         <b>USUARIO:</b> '.$user_sesion.'
        </div>
    </p>
    

</div>
';


$pdf->writeHTML($html, true, false, true, false, '');


$pdf->Output
