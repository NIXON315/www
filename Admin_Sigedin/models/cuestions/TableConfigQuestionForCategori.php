<?php
require_once '../../../includes/conexion.php';

$idQuestionForCategorit = isset($_GET['idQuestionForCategorit']) ? $_GET['idQuestionForCategorit'] : null;
$idConfigQuestionnaire = isset($_GET['idConfigQuestionnaire']) ? $_GET['idConfigQuestionnaire'] : null;


$sql = 'SELECT * FROM EvaSys_GroupCatQues WHERE ConfigQuestionnaire_Id = "' . $idConfigQuestionnaire . '" AND CatOfQues_Id = "' . $idQuestionForCategorit . '" AND Questions_Ids IS NOT NULL ORDER BY GroupCatQues_Id DESC';

//$sql = 'SELECT * FROM EvaSys_GroupCatQues GROUP BY CatOfQues_Id ORDER BY GroupCatQues_Id DESC';

$query = $pdo_eva->prepare($sql);
$query->execute();

$consulta = $query->fetchAll(PDO::FETCH_ASSOC);

for($i = 0; $i < count($consulta);$i++){

    $idCatOfQues_Id=$consulta[$i]['Questions_Ids'];

    $sqlCatOfQues = 'SELECT * FROM EvaSys_Questions WHERE Questions_Id = "'.$idCatOfQues_Id.'"';
    $queryCatOfQues = $pdo_eva->prepare($sqlCatOfQues);
    $queryCatOfQues->execute();
    $consultaCatOfQues = $queryCatOfQues->fetchAll(PDO::FETCH_ASSOC);

    foreach ($consultaCatOfQues as $NameCatOfQuesQuestionnaire):
        $consulta[$i]['NameQuestion']=  $NameCatOfQuesQuestionnaire['Questions_Name']; 
    endforeach; 


    $consulta[$i]['acciones'] ='<center> <button class="btn btn-sm btn-danger ml-2" title="Eliminar" type="button" onclick="deleteQuestionForCategori(' . $consulta[$i]['GroupCatQues_Id'] . ')"><i class="fa fa-trash"></i></button>'
    . '<!--<button class="btn btn-sm btn-secondary ml-2" title="Configuración" type="button" onclick="configureQuestionsForCategori(' . $consulta[$i]['GroupCatQues_Id'] . ')"><i class="fa fa-cog"></i></button>--></center>';
}
echo json_encode($consulta,JSON_UNESCAPED_UNICODE);
?>