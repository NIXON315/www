<?php
require_once '../../../includes/conexion.php';

$sql = 'SELECT * FROM EvaSys_CategoriOfQuestions ORDER BY CatOfQues_Id DESC';
$query = $pdo_eva->prepare($sql);
$query->execute();

$consulta = $query->fetchAll(PDO::FETCH_ASSOC);

for($i = 0; $i < count($consulta);$i++){
    $estado_cuestionario=$consulta[$i]['CatOfQues_StatusId'];

    if($consulta[$i]['CatOfQues_StatusId']==1){
        $consulta[$i]['CatOfQues_StatusIdText'] = '<span class="badge badge-success">Activo</span>';
    }else{
        $consulta[$i]['CatOfQues_StatusIdText'] = '<span class="badge badge-danger">Inactivo</span>';
    }
    //$consulta[$i]['acciones']='<button class="btn btn-primary" title="Editar" onclick="editQuestions('.$consulta[$i]['IdCuesti'].')">Editar</button>';

    $consulta[$i]['acciones'] = '<center> <button class="btn btn-sm btn-primary" title="Editar" data-toggle="tooltip" data-placement="top" onclick="editCatOfQuest(' . $consulta[$i]['CatOfQues_Id'] . ')"><i class="fa fa-edit"></i></button>'
    . '<button class="btn btn-sm btn-danger ml-2" title="Eliminar" data-toggle="tooltip" data-placement="top" onclick="deleteCatOfQuest(' . $consulta[$i]['CatOfQues_Id'] . ')"><i class="fa fa-trash"></i></button>'
    . '<button class="btn btn-sm btn-secondary ml-2" title="Configuración" data-toggle="tooltip" data-placement="top" onclick="configureCatOfQuest(' . $consulta[$i]['CatOfQues_Id'] . ')"><i class="fa fa-cog"></i></button></center>';
}
echo json_encode($consulta,JSON_UNESCAPED_UNICODE);
?>