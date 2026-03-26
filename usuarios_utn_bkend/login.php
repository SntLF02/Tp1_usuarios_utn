<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$user = $_GET['user'];
$pass = $_GET['pass'];

$sql = "SELECT * FROM usuarios_utn WHERE usuario='$user' AND clave='$pass'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode(["respuesta" => "OK", "mje" => "Bienvenido $user"]);
} else {
    echo json_encode(["respuesta" => "ERROR", "mje" => "Usuario o contraseña incorrectos"]);
}
