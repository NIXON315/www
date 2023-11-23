<?php
  session_start();

require_once '../../../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['nombreGroupCatQuest'])  || empty($_POST['statusGroupCatQuest']) ) {
        $respuesta = array('status' => false, 'msg' => 'Todos los datos son necesarios');
    } else {
        $GroupCatQuest_Id       = $_POST['idGroupCatQuest'];
        $GroupCatQuest_Name     = $_POST['nombreGroupCatQuest'];
        $GroupCatQuest_StatusId = $_POST['statusGroupCatQuest'];


        if ($GroupCatQuest_Id == "") {
            $sql = 'SELECT * FROM EvaSys_Role WHERE Role_Name = ?';
            $query = $pdo_eva->prepare($sql);
            $query->execute(array($GroupCatQuest_Name));
            $result = $query->fetch(PDO::FETCH_ASSOC);
        }

        if (!empty($result)) {
            $respuesta = array('status' => false, 'msg' => 'Ya exite una configuración Tipo de Preguntas con el mismo nombre');
        } else {
            if ($GroupCatQuest_Id == "") {
                $sqlInsert    = 'INSERT INTO EvaSys_Role (Role_Name, Role_StatusId ) VALUES (?,?)';
                $queryInsert  = $pdo_eva->prepare($sqlInsert);
                $request = $queryInsert->execute(array($GroupCatQuest_Name, $GroupCatQuest_StatusId));
                $accion = 1;
            } else {
                $sqlUpdate    = 'UPDATE EvaSys_Role SET Role_Name = ?, Role_StatusId = ? WHERE Role_Id = ?';
                $queryUpdate  = $pdo_eva->prepare($sqlUpdate);
                $request = $queryUpdate->execute(array($GroupCatQuest_Name, $GroupCatQuest_StatusId, $GroupCatQuest_Id));
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
