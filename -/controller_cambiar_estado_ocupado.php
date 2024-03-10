<?php

$cuviculo = $_GET['cuviculo'];
$estado_espacio = "OCUPADO";


date_default_timezone_set("surAmerica/caracas");
$fechaHora = date("Y-m-d h:i:s");


$sentencia = $pdo->prepare("UPDATE tb_mapeos SET
estado_espacio = :estado_espacio,
fyh_actualizacion = :fyh_actualizacion 
WHERE id_map = :id_map");

$sentencia->bindParam(':estado_espacio',$estado_espacio);
$sentencia->bindParam(':fyh_actualizacion',$fechaHora);
$sentencia->bindParam(':id_map',$cuviculo);

if($sentencia->execute()){
    echo "se actualizo el registro de la manera correcta";
    ?>
    <?php
}else{
    echo "error al actualizar el registro";
}