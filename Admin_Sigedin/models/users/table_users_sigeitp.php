<?php
require_once '../../../includes/conexion.php';

$sql = 'SELECT * FROM EvaSys_Users';
$query = $pdo->prepare($sql);
$query->execute();

$consulta = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < count($consulta); $i++) {
    $estado_sigeitp=$consulta[$i]['User_StatusId'];

    
    if ($consulta[$i]['User_StatusId'] == 1 || $consulta[$i]['User_StatusId'] == "Y") {
        $consulta[$i]['User_StatusId_Table'] = '<span class="badge badge-success">Activo</span>';
    } else {
        $consulta[$i]['User_StatusId_Table'] = '<span class="badge badge-danger">Inactivo</span>';
    }
    
    $nombre = $consulta[$i]['User_Name'];
    $usuario = $consulta[$i]['User_UserName'];
    $clave = $consulta[$i]['User_Password'];
    $email = $consulta[$i]['User_Email'];
    $rol = $consulta[$i]['User_IdRole'];
    $nombre_rol = $consulta[$i]['Role_Name'];
    $estado = $estado_sigeitp;
    
    $consulta[$i]['acciones'] = '<button class="btn btn-primary" title="Enviar" onclick="enviarUsuario(\'' . $nombre . '\', \'' . $usuario . '\', \'' . $clave . '\', \'' . $email . '\', \'' . $rol . '\', \'' . $nombre_rol . '\', \'' . $estado . '\')"><i class="icon fa fa-arrow-circle-up" aria-hidden="true"></i> Enviar</button>';
}

echo json_encode($consulta, JSON_UNESCAPED_UNICODE);

?>