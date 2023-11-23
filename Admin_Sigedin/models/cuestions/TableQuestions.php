<?php
require_once '../../../includes/conexion.php';

$sql = 'SELECT * FROM EvaSys_QuestionnaireEva ORDER BY QuesEva_Id DESC';
$query = $pdo_eva->prepare($sql);
$query->execute();

$consulta = $query->fetchAll(PDO::FETCH_ASSOC);


for($i = 0; $i < count($consulta);$i++){
    $estado_cuestionario=$consulta[$i]['QuesEva_StatusId'];

    if($consulta[$i]['QuesEva_StatusId']==1){
        $consulta[$i]['QuesEva_StatusIdText'] = '<span class="badge badge-success">Activo</span>';
    }else{
        $consulta[$i]['QuesEva_StatusIdText'] = '<span class="badge badge-danger">Inactivo</span>';
    }
    //$consulta[$i]['acciones']='<button class="btn btn-primary" title="Editar" onclick="editQuestions('.$consulta[$i]['IdCuesti'].')">Editar</button>';

    $consulta[$i]['acciones'] = '<center> <button class="btn btn-sm btn-primary" title="Editar" data-toggle="tooltip" data-placement="top" onclick="editQuestions(' . $consulta[$i]['QuesEva_Id'] . ')"><i class="fa fa-edit"></i></button>'
    . '<button class="btn btn-sm btn-danger ml-2" title="Eliminar" data-toggle="tooltip" data-placement="top" onclick="deleteQuestions(' . $consulta[$i]['QuesEva_Id'] . ')"><i class="fa fa-trash"></i></button>'
    . '<button class="btn btn-sm btn-secondary ml-2" title="Configuración" data-toggle="tooltip" data-placement="top" onclick="configureQuestions(' . $consulta[$i]['QuesEva_Id'] . ')"><i class="fa fa-cog"></i></button>'
    .'<button class="btn btn-sm btn-warning ml-2" title="Ejecutar" data-toggle="tooltip" data-placement="top" onclick="executeQuestions(' . $consulta[$i]['QuesEva_Id'] . ',' . $consulta[$i]['QuesEva_ConfigQuestionnaireId'] . ',' . $consulta[$i]['QuesEva_IdPeriodo'] . ',' . $consulta[$i]['QuesEva_IdRoleEvaluator'] . ',' . $consulta[$i]['QuesEva_IdRoleEvaluated'] . ')"><i class="fa fa-play"></i></button></center>';

    $codigoPeriodo=$consulta[$i]['QuesEva_IdPeriodo'];
 
    $sqlNomPeriodo = 'SELECT * FROM col_periodo WHERE cod_periodo = "'.$codigoPeriodo.'"';
    $queryNomPeriodo = $pdo_sigeies->query($sqlNomPeriodo);
    $NomPeriodo = $queryNomPeriodo->fetchAll(PDO::FETCH_ASSOC);

    foreach ($NomPeriodo as $NomPeriodoSigedin):
        $consulta[$i]['NomPeriodoSigedin']=  $NomPeriodoSigedin['nom_periodo']; 
    endforeach; 

    
}
echo json_encode($consulta,JSON_UNESCAPED_UNICODE);
?>