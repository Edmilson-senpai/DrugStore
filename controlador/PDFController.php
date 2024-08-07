<?php
require_once ('../vendor/autoload.php');
$id_venta = $_POST['id'];
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('Hello world!');
$mpdf->Output();
?>
