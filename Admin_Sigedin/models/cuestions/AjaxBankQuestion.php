<?php
  session_start();

require_once '../../../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['nombreBankQuest'])  || empty($_POST['statusBankQuest']) || empty($_POST['StatementBankQuest']) || empty($_POST['GuysBankQuest']) ) {
        $respuesta = array('status' => false, 'msg' => 'Todos los datos son necesarios');
    } else {
        $idBankQuest        = $_POST['idBankQuest'];
        $nombreBankQuest    = $_POST['nombreBankQuest'];
        $statusBankQuest    = $_POST['statusBankQuest'];
        $StatementBankQuest = $_POST['StatementBankQuest'];
        $GuysBankQuest      = $_POST['GuysBankQuest'];
        $ValMinBankQuest    = $_POST['ValMinBankQuest'];
        $ValMaxBankQuest    = $_POST['ValMaxBankQuest'];

        if ($idBankQuest == "") {
            $sql = 'SELECT * FROM EvaSys_Questions WHERE Questions_Name = ?';
            $query = $pdo_eva->prepare($sql);
            $query->execute(array($nombreBankQuest));
            $result = $query->fetch(PDO::FETCH_ASSOC);
        }

        if (!empty($result)) {
            $respuesta = array('status' => false, 'msg' => 'Ya exite una pregunta con el mismo nombre');
        } else {
            if ($idBankQuest == "") {
                if ($ValMinBankQuest == "" ||  $ValMaxBankQuest == "" || $GuysBankQuest != "1" ){
                    $ValMinBankQuest = null;
                    $ValMaxBankQuest = null;
                    $sqlInsert    = 'INSERT INTO EvaSys_Questions (Questions_Name, Questions_Statement, Questions_StatusId, Questions_GuysId, Questions_ValueMinimum, Questions_ValueMaximum ) VALUES (?,?,?,?,?,?)';
                    $queryInsert  = $pdo_eva->prepare($sqlInsert);
                    $request = $queryInsert->execute(array($nombreBankQuest, $StatementBankQuest, $statusBankQuest, $GuysBankQuest, $ValMinBankQuest, $ValMaxBankQuest));
                    $accion = 1;
                }else{
                    $sqlInsert    = 'INSERT INTO EvaSys_Questions (Questions_Name, Questions_Statement, Questions_StatusId, Questions_GuysId, Questions_ValueMinimum, Questions_ValueMaximum ) VALUES (?,?,?,?,?,?)';
                    $queryInsert  = $pdo_eva->prepare($sqlInsert);
                    $request = $queryInsert->execute(array($nombreBankQuest, $StatementBankQuest, $statusBankQuest, $GuysBankQuest, $ValMinBankQuest, $ValMaxBankQuest));
                    $accion = 1;
                }
            } else {
                if ($ValMinBankQuest == "" ||  $ValMaxBankQuest == "" || $GuysBankQuest != "1" ){
                    $ValMinBankQuest = null;
                    $ValMaxBankQuest = null;
                    $sqlUpdate    = 'UPDATE EvaSys_Questions SET Questions_Name = ?, Questions_Statement = ?, Questions_StatusId = ?, Questions_GuysId = ?, Questions_ValueMinimum = ?, Questions_ValueMaximum = ? WHERE Questions_Id = ?';
                    $queryUpdate  = $pdo_eva->prepare($sqlUpdate);
                    $request = $queryUpdate->execute(array($nombreBankQuest, $StatementBankQuest, $statusBankQuest, $GuysBankQuest, $ValMinBankQuest, $ValMaxBankQuest, $idBankQuest));
                    $accion = 2;
                }else{
                    $sqlUpdate    = 'UPDATE EvaSys_Questions SET Questions_Name = ?, Questions_Statement = ?, Questions_StatusId = ?, Questions_GuysId = ?, Questions_ValueMinimum = ?, Questions_ValueMaximum = ? WHERE Questions_Id = ?';
                    $queryUpdate  = $pdo_eva->prepare($sqlUpdate);
                    $request = $queryUpdate->execute(array($nombreBankQuest, $StatementBankQuest, $statusBankQuest, $GuysBankQuest, $ValMinBankQuest, $ValMaxBankQuest, $idBankQuest));
                    $accion = 2;

            }

                
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
