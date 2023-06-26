<?php
ini_set('display_errors', 'off');
@session_start();
date_default_timezone_set("America/Sao_Paulo");
setlocale(LC_ALL, 'pt_BR');
if ($_SERVER['HTTP_HOST'] == 'localhost'){
    $url = "http://localhost/vercan2/public/";
    $url_site = "http://localhost/vercan2/public/";
    $diretorio_site = "C:/xampp2/htdocs/vercan2/public/";
    $diretorio = "C:/xampp2/htdocs/vercan2/public/";
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "vercan";
}
else{
    $url = "https://vercan.bhcommerce.com.br/";
    $url_site = "https://vercan.bhcommerce.com.br/";
    $diretorio_site = "/home/bhcommer/public_html/vercan/public/";
    $diretorio = "/home/bhcommer/public_html/vercan/public/";
    $dbhost = "localhost";
    $dbuser = "bhcommer_todas";
    $dbpass = "BHC2021todas";
    $dbname = "bhcommer_vercan";
}
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die(mysqli_error());
define("URL", $url);
define("URL_SITE", $url_site);
define("DIRETORIO_SITE", $diretorio_site);
define("DIRETORIO", $diretorio);
?>
