<?php
  session_start();

require_once '../../../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['nombreConfigQuestionnaire'])  || empty($_POST['statusConfigQuestionnaire']) || empty($_POST['evaluadorConfigQuestionnaire']) || empty($_POST['evaluadoConfigQuestionnaire'])) {
        $respuesta = array('status' => false, 'msg' => 'Todos los datos son necesarios');
    } else {
        $idConfigQuestionnaire              = $_POST['idConfigQuestionnaire'];
        $nombreConfigQuestionnaire          = $_POST['nombreConfigQuestionnaire'];
        $statusConfigQuestionnaire          = $_POST['statusConfigQuestionnaire'];
        $evaluadorConfigQuestionnaire       = $_POST['evaluadorConfigQuestionnaire'];
        $evaluadoConfigQuestionnaire        = $_POST['evaluadoConfigQuestionnaire'];
        $usuarioCreador           = $_SESSION['User_UserName'];
        $fechaCreacion            = date("y-m-d");
        $horaCreacion             = date("H:i:s");


        if ($idConfigQuestionnaire == "") {
            $sql = 'SELECT * FROM EvaSys_ConfigQuestionnaire WHERE ConfigQuestionnaire_Name = ?';
            $query = $pdo_eva->prepare($sql);
            $query->execute(array($nombreConfigQuestionnaire));
            $result = $query->fetch(PDO::FETCH_ASSOC);
        }

        if (!empty($result)) {
            $respuesta = array('status' => false, 'msg' => 'Ya exite una Configuración con el mismo nombre');
        } else {
            if ($idConfigQuestionnaire == "") {
                $sqlInsert    = 'INSERT INTO EvaSys_ConfigQuestionnaire (ConfigQuestionnaire_Name, ConfigQuestionnaire_IdRolEvaluator, ConfigQuestionnaire_IdRolEvaluated, ConfigQuestionnaire_StatusId, ConfigQuestionnaire_UserNameCreation, ConfigQuestionnaire_DateCreation, ConfigQuestionnaire_TimeCreation  ) VALUES (?,?,?,?,?,?,?)';
                $queryInsert  = $pdo_eva->prepare($sqlInsert);
                $request = $queryInsert->execute(array($nombreConfigQuestionnaire, $evaluadorConfigQuestionnaire, $evaluadoConfigQuestionnaire, $statusConfigQuestionnaire, $usuarioCreador, $fechaCreacion, $horaCreacion));
                $accion = 1;
            } else {
                $sqlUpdate    = 'UPDATE EvaSys_ConfigQuestionnaire SET ConfigQuestionnaire_Name = ?, ConfigQuestionnaire_IdRolEvaluator = ?, ConfigQuestionnaire_IdRolEvaluated = ?, ConfigQuestionnaire_StatusId = ?, ConfigQuestionnaire_UserNameModify = ?, ConfigQuestionnaire_DateModify = ?, ConfigQuestionnaire_TimeModify = ? WHERE ConfigQuestionnaire_Id = ?';
                $queryUpdate  = $pdo_eva->prepare($sqlUpdate);
                $request = $queryUpdate->execute(array($nombreConfigQuestionnaire, $evaluadorConfigQuestionnaire, $evaluadoConfigQuestionnaire, $statusConfigQuestionnaire, $usuarioCreador, $fechaCreacion, $horaCreacion, $idConfigQuestionnaire));
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
