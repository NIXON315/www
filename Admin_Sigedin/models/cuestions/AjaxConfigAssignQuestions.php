<?php
  session_start();

require_once '../../../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['idQuestions']) ) {
        $respuesta = array('status' => false, 'msg' => 'Todos los datos son necesarios');
    } else {
        $idQuestions                    = $_POST['idQuestions'];
        $idConfigQuestionForCategoriCat = $_POST['idConfigQuestionForCategoriCat'];
        $idConfigQuestionnaireCat       = $_POST['idConfigQuestionnaireCat'];



        if ($idQuestions != "") {
            $sql = 'SELECT * FROM EvaSys_GroupCatQues WHERE ConfigQuestionnaire_Id = ? AND CatOfQues_Id = ?  AND Questions_Ids = ?';
            $query = $pdo_eva->prepare($sql);
            $query->execute(array($idConfigQuestionnaireCat, $idConfigQuestionForCategoriCat, $idQuestions));
            $result = $query->fetch(PDO::FETCH_ASSOC);
        }

        if (!empty($result)) {
            $respuesta = array('status' => false, 'msg' => 'Ya exite una configuración Tipo de Preguntas con el mismo nombre');
        } else {
            $sqlInsert    = 'INSERT INTO EvaSys_GroupCatQues (ConfigQuestionnaire_Id, CatOfQues_Id, Questions_Ids   ) VALUES (?,?,?)';
            $queryInsert  = $pdo_eva->prepare($sqlInsert);
            $request = $queryInsert->execute(array($idConfigQuestionnaireCat, $idConfigQuestionForCategoriCat, $idQuestions ));
            $accion = 1;

            if ($request > 0) {
                if ($accion == 1) {
                    $respuesta = array('status' => true, 'msg' => ' Configuración Tipo de Preguntas creado correctamente');
                } elseif ($accion == 2 || $accion == 3) {
                    $respuesta = array('status' => true, 'msg' => ' Configuración Tipo de Preguntas actualizado correctamente');
                } else {
                    $respuesta = array('status' => false, 'msg' => 'Acción desconocida');
                }
            } else {
                $respuesta = array('status' => false, 'msg' => 'Error al ejecutar la consulta');
            }
        }
    }
} else {
    $respuesta = array('status' => false, 'msg' => 'Petición inválida');
}

echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
?>
