<?php
  session_start();

require_once '../../../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['nombreQuestions']) || empty($_POST['periodoQuestions']) || empty($_POST['statusQuestions']) || empty($_POST['ConfigQuestions']) || empty($_POST['PercentQuestions']) || empty($_POST['fechaAperturaQuestions']) || empty($_POST['horaAperturaQuestions']) || empty($_POST['fechaCierreQuestions']) || empty($_POST['horaCierreQuestions'])) {
        $respuesta = array('status' => false, 'msg' => 'Todos los datos son necesarios');
    } else {
        $idQuestions              = $_POST['idQuestions'];
        $nombreQuestions          = $_POST['nombreQuestions'];
        $periodoQuestions         = $_POST['periodoQuestions'];
        $statusQuestions          = $_POST['statusQuestions'];
        $fechaAperturaQuestions   = $_POST['fechaAperturaQuestions'];
        $horaAperturaQuestions    = $_POST['horaAperturaQuestions'];
        $fechaCierreQuestions     = $_POST['fechaCierreQuestions'];
        $horaCierreQuestions      = $_POST['horaCierreQuestions'];
        $ConfigQuestions          = $_POST['ConfigQuestions'];
        $PercentQuestions         = $_POST['PercentQuestions'];
        $usuarioCreador           = $_SESSION['User_UserName'];
        $fechaCreacion            = date("y-m-d");
        $horaCreacion             = date("H:i:s");



        if ($idQuestions == "") {
            $sql = 'SELECT * FROM EvaSys_QuestionnaireEva WHERE QuesEva_Name = ?';
            $query = $pdo_eva->prepare($sql);
            $query->execute(array($nombreQuestions));
            $result = $query->fetch(PDO::FETCH_ASSOC);
        }

        $sqlIdRolEvaluator = 'SELECT ConfigQuestionnaire_IdRolEvaluator FROM EvaSys_ConfigQuestionnaire WHERE ConfigQuestionnaire_Id = ?';
        $queryIdRolEvaluator = $pdo_eva->prepare($sqlIdRolEvaluator);
        $queryIdRolEvaluator->execute(array($ConfigQuestions));
        $resultIdRolEvaluator = $queryIdRolEvaluator->fetch(PDO::FETCH_ASSOC);

        // Verifica si se obtuvo el valor correctamente
        if ($resultIdRolEvaluator !== false && isset($resultIdRolEvaluator['ConfigQuestionnaire_IdRolEvaluator'])) {
            $ConfigQuestionnaire_IdRolEvaluator = $resultIdRolEvaluator['ConfigQuestionnaire_IdRolEvaluator'];
        }

        $sqlIdRolEvaluated = 'SELECT ConfigQuestionnaire_IdRolEvaluated FROM EvaSys_ConfigQuestionnaire WHERE ConfigQuestionnaire_Id = ?';
        $queryIdRolEvaluated = $pdo_eva->prepare($sqlIdRolEvaluated);
        $queryIdRolEvaluated->execute(array($ConfigQuestions));
        $resultIdRolEvaluated = $queryIdRolEvaluated->fetch(PDO::FETCH_ASSOC);

        // Verifica si se obtuvo el valor correctamente
        if ($resultIdRolEvaluated !== false && isset($resultIdRolEvaluated['ConfigQuestionnaire_IdRolEvaluated'])) {
            $ConfigQuestionnaire_IdRolEvaluated = $resultIdRolEvaluated['ConfigQuestionnaire_IdRolEvaluated'];
        }



        if (!empty($result)) {
            $respuesta = array('status' => false, 'msg' => 'Ya exite un cuestionario con el mismo nombre');
        } else {
            if ($idQuestions == "") {
                $sqlInsert    = 'INSERT INTO EvaSys_QuestionnaireEva (QuesEva_Name, QuesEva_DateOpen, QuesEva_TimeOpen, QuesEva_DateClose, QuesEva_TimeClose, QuesEva_IdPeriodo, QuesEva_ConfigQuestionnaireId, QuesEva_Percent, QuesEva_StatusId, QuesEva_UserNameCreation, QuesEva_DateCreation, QuesEva_TimeCreation ,QuesEva_IdRoleEvaluator, QuesEva_IdRoleEvaluated) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
                $queryInsert  = $pdo_eva->prepare($sqlInsert);

                $request = $queryInsert->execute(array($nombreQuestions, $fechaAperturaQuestions, $horaAperturaQuestions, $fechaCierreQuestions, $horaCierreQuestions, $periodoQuestions, $ConfigQuestions, $PercentQuestions, $statusQuestions, $usuarioCreador, $fechaCreacion, $horaCreacion, $ConfigQuestionnaire_IdRolEvaluator, $ConfigQuestionnaire_IdRolEvaluated));

                $accion = 1;
            } else {
                $sqlUpdate    = 'UPDATE EvaSys_QuestionnaireEva SET QuesEva_Name = ?, QuesEva_DateOpen = ?, QuesEva_TimeOpen = ?, QuesEva_DateClose = ?, QuesEva_TimeClose = ?, QuesEva_IdPeriodo = ?, QuesEva_ConfigQuestionnaireId = ?, QuesEva_Percent = ?, QuesEva_StatusId = ?, QuesEva_UserNameModify = ?, QuesEva_DateModify = ?, QuesEva_TimeModify = ?, ,QuesEva_IdRoleEvaluator = ?, QuesEva_IdRoleEvaluated = ? WHERE QuesEva_Id = ?';
                $queryUpdate  = $pdo_eva->prepare($sqlUpdate);
                $request = $queryUpdate->execute(array($nombreQuestions, $fechaAperturaQuestions, $horaAperturaQuestions, $fechaCierreQuestions, $horaCierreQuestions, $periodoQuestions, $ConfigQuestions, $PercentQuestions, $statusQuestions, $usuarioCreador, $fechaCreacion, $horaCreacion, $ConfigQuestionnaire_IdRolEvaluator, $ConfigQuestionnaire_IdRolEvaluated, $idQuestions));
                $accion = 2;
                
            }

            if ($request > 0) {
                if ($accion == 1) {
                    $respuesta = array('status' => true, 'msg' => 'Cuestionario creado correctamente');
                } elseif ($accion == 2 || $accion == 3) {
                    $respuesta = array('status' => true, 'msg' => 'Cuestionario actualizado correctamente');
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
