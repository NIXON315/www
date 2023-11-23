<?php
require_once '../../../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['nombre']) || empty($_POST['usuario'])) {
        $respuesta = array('status' => false, 'msg' => 'Todos los datos son necesarios');
    } else {
        $idUser  = $_POST['idUser'];
        $nombre  = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $clave   = $_POST['clave'];
        $rol     = $_POST['listRol'];
        $estado  = $_POST['listStatus'];

        if ($clave !== "") {
            $clave = md5($clave);
        }

        $sql = 'SELECT * FROM EvaSys_Users WHERE User_UserName = ? AND User_Id != ?';
        $query = $pdo_eva->prepare($sql);
        $query->execute(array($usuario, $idUser));
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (!empty($result)) {
            $respuesta = array('status' => false, 'msg' => 'El usuario ya existe');
        } else {
            if ($idUser == 0) {
                $sqlInsert    = 'INSERT INTO EvaSys_Users (User_Name, User_UserName, User_Password, User_IdRole, User_StatusId) VALUES (?,?,?,?,?)';
                $queryInsert  = $pdo_eva->prepare($sqlInsert);
                $request = $queryInsert->execute(array($nombre, $usuario, $clave, $rol, $estado));
                $accion = 1;
            } else {
                if (empty($clave)) {
                    $sqlUpdate    = 'UPDATE EvaSys_Users SET User_Name = ?, User_UserName = ?, User_IdRole = ?, User_StatusId = ? WHERE User_Id = ?';
                    $queryUpdate  = $pdo_eva->prepare($sqlUpdate);
                    $request = $queryUpdate->execute(array($nombre, $usuario, $rol, $estado, $idUser));
                    $accion = 2;
                } else {
                    $sqlUpdate    = 'UPDATE EvaSys_Users SET User_Name = ?, User_UserName = ?, User_Password = ?, User_IdRole = ?, User_StatusId = ? WHERE User_Id = ?';
                    $queryUpdate  = $pdo_eva->prepare($sqlUpdate);
                    $request = $queryUpdate->execute(array($nombre, $usuario, $clave, $rol, $estado, $idUser));
                    $accion = 3;
                }
            }

            if ($request > 0) {
                if ($accion == 1) {
                    $respuesta = array('status' => true, 'msg' => 'Usuario creado correctamente');
                } elseif ($accion == 2 || $accion == 3) {
                    $respuesta = array('status' => true, 'msg' => 'Usuario actualizado correctamente');
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
