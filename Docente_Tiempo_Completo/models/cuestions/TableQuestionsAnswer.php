<?php
session_start();
require_once '../../../includes/conexion.php';

$variableRecibida = json_decode(file_get_contents('php://input'), true);
$IdCategoriQues = $variableRecibida['questionId'];
$IdPeriod = '44';
$UserNameEvaluator = $_SESSION['User_UserName'];


$sql = 'SELECT * FROM EvaSys_AnswerEva WHERE AnswerEva_UserNameEvaluator = :UserNameEvaluator AND AnswerEva_IdPeriod = :IdPeriod AND AnswerEva_CatOfQues_Id = :IdCategoriQues ORDER BY AnswerEva_Id';
$consul = $pdo_eva->prepare($sql);
$consul->bindValue(':UserNameEvaluator', $UserNameEvaluator, PDO::PARAM_STR);
$consul->bindValue(':IdPeriod', $IdPeriod, PDO::PARAM_STR);
$consul->bindValue(':IdCategoriQues', $IdCategoriQues, PDO::PARAM_STR);

$consul->execute();
$result = $consul->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < count($result); $i++) {
  $User_Name = "";
  $UserNameEvaluated = $result[$i]['AnswerEva_QuestionId'];
  $sqlUsers = 'SELECT Questions_Statement FROM EvaSys_Questions WHERE Questions_id = ? ';
  $queryUsers = $pdo_eva->prepare($sqlUsers);
  $queryUsers->execute(array($UserNameEvaluated));
  $resultUsers = $queryUsers->fetch(PDO::FETCH_ASSOC);

  
  if ($resultUsers !== false && isset($resultUsers['Questions_Statement'])) {
    $QuestionStatement = $resultUsers['Questions_Statement'];
  }else{
    $UserNameEvaluated = $result[$i]['AnswerEva_UserNameEvaluated'];
    $sqlUserss = 'SELECT DOCENTE FROM VISTA_EVADOCENTE WHERE ID_DOCENTE = ?';
    $queryUsers = $pdo_sigeies->prepare($sqlUserss);
    $queryUsers->execute(array($UserNameEvaluated));
    $resultUsers = $queryUsers->fetch(PDO::FETCH_ASSOC);
    if ($resultUsers !== false && isset($resultUsers['DOCENTE'])) {
      $User_Name = $resultUsers['DOCENTE'];
    }
  }

  $qualifyField = '';
  $saveButtonDisabled = '';
  if (empty($result[$i]['AnswerEva_QualifyText']) && empty($result[$i]['AnswerEva_QualifyNum'])) {
    if ($result[$i]['AnswerEva_GuysQuesId'] != "1") {
      $qualifyField = '<center><textarea id="qualify_' . $result[$i]['AnswerEva_Id'] . '"></textarea></center>';
    } else {
      $qualifyField = '<center><input type="number" id="qualify_' . $result[$i]['AnswerEva_Id'] . '" min="0" max="5" style="width: 100px;" /></center>';
    }
  } else {

    if ($result[$i]['AnswerEva_GuysQuesId'] != "1") {
      $qualifyField = '<center><textarea id="qualify_' . $result[$i]['AnswerEva_Id'] . '"  disabled>' . $result[$i]['AnswerEva_QualifyText'] . ' </textarea></center>';
    } else {
      $qualifyField = '<center><input type="number" id="qualify_' . $result[$i]['AnswerEva_Id'] . '" value="' . $result[$i]['AnswerEva_QualifyNum'] . '" min="0" max="5" style="width: 100px;" disabled/></center>';
    }
    $saveButtonDisabled = 'disabled';
  }

  $result[$i]['Qualify'] = $qualifyField;
  $result[$i]['QuestionStatement'] = $QuestionStatement;
  if ($result[$i]['AnswerEva_CatOfQues_Id'] == 16 || $result[$i]['AnswerEva_CatOfQues_Id'] == 1 || $result[$i]['AnswerEva_CatOfQues_Id']==7){
    $result[$i]['accion'] = '<center> <button class="btn btn-sm btn-primary" title="Guardar" data-toggle="tooltip" data-placement="top" onclick="saveAnswer(' . $result[$i]['AnswerEva_Id'] . ',' . $result[$i]['AnswerEva_QuestionId'] . ',' . $result[$i]['AnswerEva_GuysQuesId'] . ')" ' . $saveButtonDisabled . '><i class="fa fa-save"></i></button>'.' <button class="btn btn-sm btn-dark" title="No Aplica" data-toggle="tooltip" data-placement="top" onclick="saveAnswerNA(' . $result[$i]['AnswerEva_Id'] . ',' . $result[$i]['AnswerEva_QuestionId'] . ',' . $result[$i]['AnswerEva_GuysQuesId'] . ')" ' . $saveButtonDisabled . '><i">N/A</i></button></center>';
  }else{
    $result[$i]['accion'] = '<center> <button class="btn btn-sm btn-primary" title="Guardar" data-toggle="tooltip" data-placement="top" onclick="saveAnswer(' . $result[$i]['AnswerEva_Id'] . ',' . $result[$i]['AnswerEva_QuestionId'] . ',' . $result[$i]['AnswerEva_GuysQuesId'] . ')" ' . $saveButtonDisabled . '><i class="fa fa-save"></i></button></center>';
  }
}


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
