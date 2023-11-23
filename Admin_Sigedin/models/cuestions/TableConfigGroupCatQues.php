<?php
require_once '../../../includes/conexion.php';
$idGroupCatQuest = isset($_GET['idGroupCatQuest']) ? $_GET['idGroupCatQuest'] : null;


//$sql = 'SELECT * FROM EvaSys_GroupCatQues WHERE ConfigQuestionnaire_Id = "' . $idGroupCatQuest . '" GROUP BY ConfigQuestionnaire_Id ORDER BY GroupCatQues_Id DESC';
$sql = 'SELECT * FROM EvaSys_GroupCatQues GROUP BY CatOfQues_Id ORDER BY GroupCatQues_Id DESC';

$query = $pdo_eva->prepare($sql);
$query->execute();

$consulta = $query->fetchAll(PDO::FETCH_ASSOC);

for($i = 0; $i < count($consulta);$i++){

    $idCatOfQues_Id=$consulta[$i]['CatOfQues_Id'];

    $sqlCatOfQues = 'SELECT * FROM EvaSys_CategoriOfQuestions WHERE CatOfQues_Id = "'.$idCatOfQues_Id.'"';
    $queryCatOfQues = $pdo_eva->prepare($sqlCatOfQues);
    $queryCatOfQues->execute();
    $consultaCatOfQues = $queryCatOfQues->fetchAll(PDO::FETCH_ASSOC);

    foreach ($consultaCatOfQues as $NameCatOfQuesQuestionnaire):
        $consulta[$i]['NameConfigQuestionnaire']=  $NameCatOfQuesQuestionnaire['CatOfQues_Name']; 
    endforeach; 


    $consulta[$i]['acciones'] = '<center> <button class="btn btn-sm btn-primary" title="Editar" data-toggle="tooltip" data-placement="top" onclick="editGroupCatQues(' . $consulta[$i]['GroupCatQues_Id'] . ')"><i class="fa fa-edit"></i></button>'
    . '<button class="btn btn-sm btn-danger ml-2" title="Eliminar" data-toggle="tooltip" data-placement="top" onclick="deleteGroupCatQues(' . $consulta[$i]['GroupCatQues_Id'] . ')"><i class="fa fa-trash"></i></button>'
    . '<button class="btn btn-sm btn-secondary ml-2" title="Configuración" data-toggle="tooltip" data-placement="top" onclick="configureGroupCatQues(' . $consulta[$i]['GroupCatQues_Id'] . ')"><i class="fa fa-cog"></i></button></center>';
}
echo json_encode($consulta,JSON_UNESCAPED_UNICODE);
?>