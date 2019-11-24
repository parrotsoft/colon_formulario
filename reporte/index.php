<?php
ini_set('memory_limit', '-1');
error_reporting(E_ERROR | E_PARSE);
require_once __DIR__ .'/vendor/autoload.php';

/** Parametros de conexion */
$servername = "146.66.66.95";
$username = "colegioc_rasate";
$password = "201409";

/** Los siguientes son los datos dinamicos, los deben traer por el metodo que quieras POST o GET */
$fecha = "2018-12-05";
$usuario = "Marla Luz Escandón González";

$conn = new mysqli($servername, $username, $password, "colegioc_jo152");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($result = $conn->query("SELECT * FROM coordinador WHERE fecha = '$fecha';")) {
    $html = "<style>td { border: 1px solid; } th { border: 1px solid; }</style>";
    $html .= "<div style='text-align: center;'>";
    $html .= "<h3>COLEGIO COLÓN</h3>";
    $html .= "<h4>REPORTE DE MATRÍCULAS POR USUARIO</h4>";
    $html .= "</div>";
    $html .= "<strong>USUARIO: </strong> $usuario &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
    $html .= "<strong>FECHA: </strong> $fecha";
    $html .= "<br><br>";
    $html .= "<table class='tabla' width='100%'>";
    $html .= "<tr><th>No.</th><th>CÓDIGO.</th><th>APELLIDO Y NOMBRE</th><th>GRADO</th></tr>";

    while ($fila = $result->fetch_assoc()) {
        $html .= "<tr><td align='center'>".$fila['id']."</td><td align='center'>".$fila['codigoestudiante']."</td><td>".$fila['estudiante']."</td><td align='center'>".$fila['gradoingresoestudiante']."</td></tr>";
    }

    $result->free();
} else {
    $html .= "No tenemos datos";
}

$conn->close();

$html .= "</table>";

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output();

?>