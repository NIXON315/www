<?php
  session_start();

require_once '../../../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['nombreGuysQues'])  || empty($_POST['statusGuysQues']) ) {
        $respuesta = array('status' => false, 'msg' => 'Todos los datos son necesarios');
    } else {
        $GuysQues_Id       = $_POST['idGuysQues'];
        $GuysQues_Name     = $_POST['nombreGuysQues'];
        $GuysQues_StatusId = $_POST['statusGuysQues'];


        if ($GuysQues_Id == "") {
            $sql = 'SELECT * FROM EvaSys_GuysQues WHERE GuysQues_Name = ?';
            $query = $pdo_eva->prepare($sql);
            $query->execute(array($GuysQues_Name));
            $result = $query->fetch(PDO::FETCH_ASSOC);
        }

        if (!empty($result)) {
            $respuesta = array('status' => false, 'msg' => 'Ya exite una configuración Tipo de Preguntas con el mismo nombre');
        } else {
            if ($GuysQues_Id == "") {
                $sqlInsert    = 'INSERT INTO EvaSys_GuysQues (GuysQues_Name, GuysQues_StatusId ) VALUES (?,?)';
                $queryInsert  = $pdo_eva->prepare($sqlInsert);
                $request = $queryInsert->execute(array($GuysQues_Name, $GuysQues_StatusId));
                $accion = 1;
            } else {
                $sqlUpdate    = 'UPDATE EvaSys_GuysQues SET GuysQues_Name = ?, GuysQues_StatusId = ? WHERE GuysQues_Id = ?';
                $queryUpdate  = $pdo_eva->prepare($sqlUpdate);
                $request = $queryUpdate->execute(array($GuysQues_Name, $GuysQues_StatusId, $GuysQues_Id));
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
