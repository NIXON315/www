<?php
require_once '../../../includes/conexion.php';

if (!empty($_GET)) {
    $idConfigQuestionnaire = $_GET['idConfigQuestionnaire'];
    $idConfigQuestionForCategori = $_GET['idConfigQuestionForCategori'];

    $sql_evaConfigQuestionnaire = 'SELECT * FROM EvaSys_ConfigQuestionnaire WHERE ConfigQuestionnaire_Id = ?';
    $query_evaConfigQuestionnaire = $pdo_eva->prepare($sql_evaConfigQuestionnaire);
    $query_evaConfigQuestionnaire->execute(array($idConfigQuestionnaire));
    $result_evaConfigQuestionnaire = $query_evaConfigQuestionnaire->fetch(PDO::FETCH_ASSOC);

    $sql_evaConfigQuestionForCategori = 'SELECT * FROM EvaSys_CategoriOfQuestions WHERE CatOfQues_Id = ?';
    $query_evaConfigQuestionForCategori = $pdo_eva->prepare($sql_evaConfigQuestionForCategori);
    $query_evaConfigQuestionForCategori->execute(array($idConfigQuestionForCategori));
    $result_evaConfigQuestionForCategori = $query_evaConfigQuestionForCategori->fetch(PDO::FETCH_ASSOC);

    $respuesta = array();

    if (!empty($result_evaConfigQuestionnaire)) {
        $respuesta['configQuestionnaire'] = $result_evaConfigQuestionnaire;
    } else {
        $respuesta['configQuestionnaire'] = null;
    }

    if (!empty($result_evaConfigQuestionForCategori)) {
        $respuesta['configQuestionForCategori'] = $result_evaConfigQuestionForCategori;
    } else {
        $respuesta['configQuestionForCategori'] = null;
    }


    if ( $respuesta['configQuestionnaire'] == null or  $respuesta['configQuestionForCategori'] == null){
        $respuesta['status'] = false;
    }else{
        $respuesta['status'] = true;

    }
    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
}

?>