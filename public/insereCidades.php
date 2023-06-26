<?php
require_once('connect.php');
require_once('funcoes.php');
ini_set('display_erros', 'on');
header('Content-type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');
$sql = "TRUNCATE cities";
mysqli_query($con, $sql);
$link = DIRETORIO."cidades.xml";
$xml = simplexml_load_file($link);
foreach ($xml->CIDADE as $key => $value){
    $sql = "SELECT * FROM cities WHERE id = '".$value->ID."'";
    $query = mysqli_query($con, $sql);
    if (!mysqli_num_rows($query)){
        $sql = utf8_decode("INSERT INTO cities (id, name, state, created_at, updated_at) VALUES ('".$value->ID."', '" .addslashes($value->NOME) . "', '".$value->IDESTADO."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
        mysqli_query($con, $sql) or die(mysqli_error($con));
    }
    else{
        $sql = utf8_decode("UPDATE states SET name = '".$value->NOME."', uf = '".$value->SIGLA."', ");
        $sql .= ("updated_at='".date('Y-m-d H:i:s')."' WHERE id = '".$value->id."'");
        mysqli_query($con, $sql) or die(mysqli_error($con)."\r\nSQL: ".$sql);
    }
}
?>