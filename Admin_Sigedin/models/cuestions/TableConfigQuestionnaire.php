<?php
require_once '../../../includes/conexion.php';

$sql = 'SELECT * FROM EvaSys_ConfigQuestionnaire ORDER BY ConfigQuestionnaire_Id DESC';
$query = $pdo_eva->prepare($sql);
$query->execute();

$consulta = $query->fetchAll(PDO::FETCH_ASSOC);

for($i = 0; $i < count($consulta);$i++){
    $estado_cuestionario=$consulta[$i]['ConfigQuestionnaire_StatusId'];

    if($consulta[$i]['ConfigQuestionnaire_StatusId']==1){
        $consulta[$i]['ConfigQuestionnaire_StatusId'] = '<span class="badge badge-success">Activo</span>';
    }else{
        $consulta[$i]['ConfigQuestionnaire_StatusId'] = '<span class="badge badge-danger">Inactivo</span>';
    }
    //$consulta[$i]['acciones']='<button class="btn btn-primary" title="Editar" onclick="editQuestions('.$consulta[$i]['IdCuesti'].')">Editar</button>';

    $consulta[$i]['acciones'] = '<center> <button class="btn btn-sm btn-primary" title="Editar" data-toggle="tooltip" data-placement="top" onclick="editConfigQuestionnaire(' . $consulta[$i]['ConfigQuestionnaire_Id'] . ')"><i class="fa fa-edit"></i></button>'
    . '<button class="btn btn-sm btn-danger ml-2" title="Eliminar" data-toggle="tooltip" data-placement="top" onclick="deleteConfigQuestionnaire(' . $consulta[$i]['ConfigQuestionnaire_Id'] . ')"><i class="fa fa-trash"></i></button>'
    . '<button class="btn btn-sm btn-success ml-2" title="Agregar Categoria de Preguntas" data-toggle="tooltip" data-placement="top" onclick="configureConfigQuestionnaireCat(' . $consulta[$i]['ConfigQuestionnaire_Id'] . ')"><i class="fa fa-plus"></i><i class="fa fa-cog"></i></button></center>';

    $IdRolEvaluator=$consulta[$i]['ConfigQuestionnaire_IdRolEvaluator'];
 
    $sqlRolNameEvaluator = 'SELECT * FROM EvaSys_Role WHERE Role_Id = "'.$IdRolEvaluator.'"';
    $queryRolNameEvaluator = $pdo_eva->query($sqlRolNameEvaluator);
    $RolNameEvaluator = $queryRolNameEvaluator->fetchAll(PDO::FETCH_ASSOC);

    foreach ($RolNameEvaluator as $NameEvaluator):
        $consulta[$i]['NameEvaluator']=  $NameEvaluator['Role_Name']; 
    endforeach; 

    $IdRolEvaluated=$consulta[$i]['ConfigQuestionnaire_IdRolEvaluated'];
 
    $sqlRolNameEvaluated = 'SELECT * FROM EvaSys_Role WHERE Role_Id = "'.$IdRolEvaluated.'"';
    $queryRolNameEvaluated = $pdo_eva->query($sqlRolNameEvaluated);
    $RolNameEvaluated = $queryRolNameEvaluated->fetchAll(PDO::FETCH_ASSOC);

    foreach ($RolNameEvaluated as $NameEvaluated):
        $consulta[$i]['NameEvaluated']=  $NameEvaluated['Role_Name']; 
    endforeach; 

}
echo json_encode($consulta,JSON_UNESCAPED_UNICODE);
?>