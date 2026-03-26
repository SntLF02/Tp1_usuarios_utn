<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$accion = $_GET['action'];

if ($accion == "BUSCAR"){
    if (isset($_GET['usuario']) && $_GET['usuario'] != ""){
        $usuario = $_GET['usuario'];
        $sql = "SELECT * FROM usuarios_utn WHERE usuario LIKE '%$usuario%'";
    } else {
        $sql = "SELECT * FROM usuarios_utn";
    }
    
    $result = $conn->query($sql);
    $usuarios = [];
    
    if ($result) {
        while($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
    }
    echo json_encode($usuarios);
}

if ($accion == "ACTUALIZAR_ESTADO"){
    $idUser = $_GET['idUser'];
    $estado = $_GET['estado']; // 'Y' o 'N'
    
    try {
        $sql = "UPDATE usuarios_utn SET bloqueado='$estado' WHERE Id='$idUser'";
        $conn->query($sql);

        if($estado == 'Y') {
            echo json_encode(["respuesta" => "OK", "mje" => "Usuario bloqueado exitosamente"]);
        } else {
            echo json_encode(["respuesta" => "OK", "mje" => "Usuario desbloqueado exitosamente"]);
        }
    } catch (Exception $e) {
        echo json_encode(["respuesta" => "ERROR", "mje" => $e->getMessage()]);
    }
}
?>