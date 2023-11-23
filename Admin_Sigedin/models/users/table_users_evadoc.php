<?php
require_once '../../../includes/conexion.php';

$sql = 'SELECT * FROM EvaSys_Users as u INNER JOIN EvaSys_Role as r ON u.User_IdRole = r.Role_Id';
$query = $pdo_eva->prepare($sql);
$query->execute();

$consulta = $query->fetchAll(PDO::FETCH_ASSOC);


for($i = 0; $i < count($consulta);$i++){
    $estado_sigeitp=$consulta[$i]['User_StatusId'];

    if($consulta[$i]['User_StatusId']==1){
        $consulta[$i]['User_StatusId'] = '<span class="badge badge-success">Activo</span>';
    }else{
        $consulta[$i]['User_StatusId'] = '<span class="badge badge-danger">Inactivo</span>';
    }
    $consulta[$i]['acciones']='
    <button class="btn btn-primary" title="Editar" onclick="editUser('.$consulta[$i]['User_Id'].')">Editar</button>
    ';
}
echo json_encode($consulta,JSON_UNESCAPED_UNICODE);
?>