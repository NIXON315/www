<?php
require_once '../../../includes/conexion.php';

$sql = 'SELECT * FROM EvaSys_GuysQues ORDER BY GuysQues_Id DESC';
$query = $pdo_eva->prepare($sql);
$query->execute();

$consulta = $query->fetchAll(PDO::FETCH_ASSOC);


for($i = 0; $i < count($consulta);$i++){
    $estado_cuestionario=$consulta[$i]['GuysQues_StatusId'];

    if($consulta[$i]['GuysQues_StatusId']==1){
        $consulta[$i]['GuysQues_StatusId'] = '<span class="badge badge-success">Activo</span>';
    }else{
        $consulta[$i]['GuysQues_StatusId'] = '<span class="badge badge-danger">Inactivo</span>';
    }
    //$consulta[$i]['acciones']='<button class="btn btn-primary" title="Editar" onclick="editQuestions('.$consulta[$i]['IdCuesti'].')">Editar</button>';

    $consulta[$i]['acciones'] = '<center> <button class="btn btn-sm btn-primary" title="Editar" data-toggle="tooltip" data-placement="top" onclick="editGuysQues(' . $consulta[$i]['GuysQues_Id'] . ')"><i class="fa fa-edit"></i></button>'
    . '<button class="btn btn-sm btn-danger ml-2" title="Eliminar" data-toggle="tooltip" data-placement="top" onclick="deleteGuysQues(' . $consulta[$i]['GuysQues_Id'] . ')"><i class="fa fa-trash"></i></button>'
    . '<button class="btn btn-sm btn-secondary ml-2" title="Configuración" data-toggle="tooltip" data-placement="top" onclick="configureGuysQues(' . $consulta[$i]['GuysQues_Id'] . ')"><i class="fa fa-cog"></i></button></center>';

/*
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

    

    $codigoPeriodo=$consulta[$i]['CodPeriodo'];
 
    $sqlNomPeriodo = 'SELECT * FROM col_periodo WHERE cod_periodo = "'.$codigoPeriodo.'"';
    $queryNomPeriodo = $pdo_sigeies->query($sqlNomPeriodo);
    $NomPeriodo = $queryNomPeriodo->fetchAll(PDO::FETCH_ASSOC);

    foreach ($NomPeriodo as $NomPeriodoSigedin):
        $consulta[$i]['NomPeriodoSigedin']=  $NomPeriodoSigedin['nom_periodo']; 
    endforeach; 
    */
    
}
echo json_encode($consulta,JSON_UNESCAPED_UNICODE);
?>