<?php
      error_reporting(0); // Deshabilita temporalmente todas las advertencias y notificaciones

session_start();
require_once '../../../includes/conexion.php';
error_reporting(E_ALL); // Restablece la configuración de errores a su valor original

$variableRecibida = json_decode(file_get_contents('php://input'), true);
$questionId = $variableRecibida['questionId'];
$IdPeriod = '44';
$UserNameEvaluator = $_SESSION['User_UserName'];

$idAssignGroupCatQuest = $_SESSION['idAssignGroupCatQuest'];
$IdRolEvaluated = $_SESSION['IdRolEvaluated'] ;


$AnswerEva_Question = $questionId;
$sql = 'SELECT * FROM EvaSys_AnswerEva WHERE   AnswerEva_UserNameEvaluator = :UserNameEvaluator AND AnswerEva_QuestionId = :AnswerEva_Question AND AnswerEva_IdPeriod = :IdPeriod AND AnswerEva_IdRolEvaluated = :IdRolEvaluated';
$consul = $pdo_eva->prepare($sql);
$consul->bindValue(':UserNameEvaluator', $UserNameEvaluator, PDO::PARAM_STR);
$consul->bindValue(':AnswerEva_Question', $AnswerEva_Question, PDO::PARAM_STR);
$consul->bindValue(':IdPeriod', $IdPeriod, PDO::PARAM_STR);
$consul->bindValue(':IdRolEvaluated', $IdRolEvaluated, PDO::PARAM_STR);
$consul->execute();
$result = $consul->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < count($result); $i++) {
  $User_Name = "";
  $UserNameEvaluated = $result[$i]['AnswerEva_UserNameEvaluated'];
  $sqlUsers = 'SELECT User_Name FROM EvaSys_Users WHERE User_UserName = ?';
  $queryUsers = $pdo_eva->prepare($sqlUsers);
  $queryUsers->execute(array($UserNameEvaluated));
  $resultUsers = $queryUsers->fetch(PDO::FETCH_ASSOC);
  if ($resultUsers !== false && isset($resultUsers['User_Name'])) {
    $User_Name = $resultUsers['User_Name'];
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
      $qualifyField = '<center><input type="number" id="qualify_' . $result[$i]['AnswerEva_Id'] . '" min="0" max="5"/></center>';
    }
  } else {

    if ($result[$i]['AnswerEva_GuysQuesId'] != "1") {
      $qualifyField = '<center><textarea id="qualify_' . $result[$i]['AnswerEva_Id'] . '"  disabled>' . $result[$i]['AnswerEva_QualifyText'] . ' </textarea></center>';
    } else {
      $qualifyField = '<center><input type="number" id="qualify_' . $result[$i]['AnswerEva_Id'] . '" value="' . $result[$i]['AnswerEva_QualifyNum'] . '" min="0" max="5" disabled/></center>';
    }
    $saveButtonDisabled = 'disabled';
  }

  $result[$i]['Qualify'] = $qualifyField;
  $result[$i]['NameUser'] = $User_Name;
  //$result[$i]['accion'] = '<center> <button class="btn btn-sm btn-primary" title="Guardar" data-toggle="tooltip" data-placement="top" onclick="saveAnswer(' . $result[$i]['AnswerEva_Id'] . ',' . $questionId . ',' . $result[$i]['AnswerEva_GuysQuesId'] . ')" ' . $saveButtonDisabled . '><i class="fa fa-save"></i></button></center>';
  if ($result[$i]['AnswerEva_CatOfQues_Id'] == 16 || $result[$i]['AnswerEva_CatOfQues_Id'] == 1 || $result[$i]['AnswerEva_CatOfQues_Id']==7){
    $result[$i]['accion'] = '<center> <button class="btn btn-sm btn-primary" title="Guardar" data-toggle="tooltip" data-placement="top" onclick="saveAnswer(' . $result[$i]['AnswerEva_Id'] . ',' . $result[$i]['AnswerEva_QuestionId'] . ',' . $result[$i]['AnswerEva_GuysQuesId'] . ')" ' . $saveButtonDisabled . '><i class="fa fa-save"></i></button>'.' <button class="btn btn-sm btn-dark" title="No Aplica" data-toggle="tooltip" data-placement="top" onclick="saveAnswerNA(' . $result[$i]['AnswerEva_Id'] . ',' . $result[$i]['AnswerEva_QuestionId'] . ',' . $result[$i]['AnswerEva_GuysQuesId'] . ')" ' . $saveButtonDisabled . '><i">N/A</i></button></center>';
  }else{
    $result[$i]['accion'] = '<center> <button class="btn btn-sm btn-primary" title="Guardar" data-toggle="tooltip" data-placement="top" onclick="saveAnswer(' . $result[$i]['AnswerEva_Id'] . ',' . $result[$i]['AnswerEva_QuestionId'] . ',' . $result[$i]['AnswerEva_GuysQuesId'] . ')" ' . $saveButtonDisabled . '><i class="fa fa-save"></i></button></center>';
  }
}

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
