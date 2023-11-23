<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $answerId = $_POST['answerId'];
  $questionId = $_POST['questionId'];
  $guysQuesId = $_POST['guysQuesId'];
  $qualifyValue = $_POST['qualifyValue'];
  

  require_once '../../../includes/conexion.php';

  // Verificar el valor de guysQuesId y realizar la actualización correspondiente
  if ($guysQuesId == 1) {
    // Actualización para AnswerEva_QualifyNum
    $sql = 'UPDATE EvaSys_AnswerEva SET AnswerEva_QualifyNum = :qualifyValue WHERE AnswerEva_Id = :answerId';
  } else {
    // Actualización para AnswerEva_QualifyText
    $sql = 'UPDATE EvaSys_AnswerEva SET AnswerEva_QualifyText = :qualifyValue WHERE AnswerEva_Id = :answerId';
  }

  $stmt = $pdo_eva->prepare($sql);
  $stmt->bindValue(':qualifyValue', $qualifyValue, PDO::PARAM_STR);
  $stmt->bindValue(':answerId', $answerId, PDO::PARAM_INT);

  if ($stmt->execute()) {
    echo 'Guardado exitosamente';
  } else {
    echo 'Error al guardar';
  }
}
?>
