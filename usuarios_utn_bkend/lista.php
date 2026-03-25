<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$accion = $_GET['action'];

if ($action == "BUSCAR"){
    if (isset($_GET['usuario'])){
        $usuario = $_GET['usuario'];
        $sql = "SELECT * FROM usuarios_utn WHERE usuario LIKE '%$usuario%'";
    } else {
        $sql = "SELECT * FROM usuarios_utn";
    }
    $result = $conn->query($sql);
    $usuarios = [];
    while($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
    echo json_encode($usuarios);
}

if ($action == "ACTUALIZAR_ESTADO"){
    $isUser = $_GET['isUser'];
    $estado = $_GET['estado']; // 'Y' o 'N'
    try {
        $sql = "UPDATE usuarios_utn SET bloqueado='$estado' WHERE usuario='$isUser'";
        $conn->query($sql);

        if($estado == 'Y') {
            echo json_encode(["respuesta" => "ok", "mje" => "Usuario $isUser bloqueado"]);
        } else {
            echo json_encode(["respuesta" => "ok", "mje" => "Usuario $isUser desbloqueado"]);
        }
    } catch (Exception $e) {
        echo json_encode(["respuesta" => "error", "mje" => $e->getMessage()]);
    }
}
?>