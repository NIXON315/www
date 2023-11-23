<?php
  session_start();

require_once '../../../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['nombreCatOfQuest'])  || empty($_POST['statusCatOfQuest']) ) {
        $respuesta = array('status' => false, 'msg' => 'Todos los datos son necesarios');
    } else {
        $CatOfQuest_Id       = $_POST['idCatOfQuest'];
        $CatOfQuest_Name     = $_POST['nombreCatOfQuest'];
        $CatOfQuest_StatusId = $_POST['statusCatOfQuest'];

        if ($CatOfQuest_Id == "") {
            $sql = 'SELECT * FROM EvaSys_CategoriOfQuestions WHERE CatOfQues_Name = ?';
            $query = $pdo_eva->prepare($sql);
            $query->execute(array($CatOfQuest_Name));
            $result = $query->fetch(PDO::FETCH_ASSOC);
        }

        if (!empty($result)) {
            $respuesta = array('status' => false, 'msg' => 'Ya exite una configuración Tipo de Preguntas con el mismo nombre');
        } else {
            if ($CatOfQuest_Id == "") {
                $sqlInsert    = 'INSERT INTO EvaSys_CategoriOfQuestions (CatOfQues_Name, CatOfQues_StatusId ) VALUES (?,?)';
                $queryInsert  = $pdo_eva->prepare($sqlInsert);
                $request = $queryInsert->execute(array($CatOfQuest_Name, $CatOfQuest_StatusId));
                $accion = 1;
            } else {
                $sqlUpdate    = 'UPDATE EvaSys_CategoriOfQuestions SET CatOfQues_Name = ?, CatOfQues_StatusId = ? WHERE CatOfQues_Id = ?';
                $queryUpdate  = $pdo_eva->prepare($sqlUpdate);
                $request = $queryUpdate->execute(array($CatOfQuest_Name, $CatOfQuest_StatusId, $CatOfQuest_Id));
                $accion = 2;
                
            }

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
