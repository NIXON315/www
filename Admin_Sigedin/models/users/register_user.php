<?php
session_start();
if (!empty($_POST)) {
    // Realiza la conexión a la base de datos y otras configuraciones necesarias
    include '../../../includes/conexion.php';

    // Obtiene los datos enviados por el cliente
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $email = $_POST['email'];
    $nombre_rol = $_POST['nombre_rol'];
    $estado = $_POST['estado'];

    // Verificar si el usuario ya existe en la base de datos
    $sql_verificar = "SELECT COUNT(*) AS Total FROM EvaSys_Users WHERE User_UserName = :User_UserName";
    $stmt_verificar = $pdo_eva->prepare($sql_verificar);
    $stmt_verificar->bindParam(':User_UserName', $usuario);
    $stmt_verificar->execute();
    $resultado_verificar = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

    if ($resultado_verificar['Total'] > 0) {
        // El usuario ya existe, devuelve una respuesta indicando el error
        $response = array('status' => 'error1', 'message' => 'El usuario ya existe en la base de datos');
    } else {
        // El usuario no existe, procede a insertarlo
        // Preparar la consulta SQL para insertar los datos
        $sql_eva = "INSERT INTO EvaSys_Users (User_Name, User_IdRole, User_UserName, User_Password, User_Email, User_StatusId) VALUES (:User_Name, :User_IdRole, :User_UserName, :User_Password, :User_Email, :User_StatusId)";
        $stmt_eva = $pdo_eva->prepare($sql_eva);
        $stmt_eva->bindParam(':User_Name', $nombre);
        $stmt_eva->bindParam(':User_IdRole', $rol);
        $stmt_eva->bindParam(':User_UserName', $usuario);
        $stmt_eva->bindParam(':User_Password', $clave);
        $stmt_eva->bindParam(':User_Email', $email);
        $stmt_eva->bindParam(':User_StatusId', $estado);

        if ($stmt_eva->execute()) {
            // Los datos se insertaron correctamente
            $response = array('status' => 'success', 'message' => 'Datos insertados correctamente');
        } else {
            // Hubo un error al insertar los datos
            $response = array('status' => 'error2', 'message' => 'Error al insertar los datos');
        }
    }

    // Devolver la respuesta como JSON
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    // Cierra la conexión a la base de datos y realiza otras tareas de limpieza
    $stmt_verificar = null;
    $stmt_eva = null;
    $pdo_eva = null;
}
?>