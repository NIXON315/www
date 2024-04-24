<?php
try {
session_start();
if (!empty($_POST)){
    // Realiza la conexión a la base de datos y otras configuraciones necesarias
    include './conexion.php';

    // Obtiene los datos enviados por el cliente
    $UserName = $_POST['username'];
    $password = $_POST['password'];

    // Convierte la contraseña a MD5
    $password = md5($password);

    // Prepara la consulta SQL

    $query = "SELECT * FROM EvaSys_Users WHERE User_UserName = :UserName";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['UserName' => $UserName]);

    $sql_verificar = "SELECT COUNT(*) AS Total FROM EvaSys_Users WHERE User_UserName = :UserName";
    $stmt_verificar = $pdo_eva->prepare($sql_verificar);
    $stmt_verificar->bindParam(':UserName', $UserName);
    $stmt_verificar->execute();
    $resultado_verificar = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

    if ($resultado_verificar['Total'] > 0) {
        // El usuario ya existe, devuelve una respuesta indicando el error
        $query_eva = "SELECT User_IdRole, User_Password FROM EvaSys_Users WHERE User_UserName = :UserName";
        $stmt_eva = $pdo_eva->prepare($query_eva);
        $stmt_eva->execute(['UserName' => $UserName]);

        if ($stmt_eva->rowCount() > 0) {
            // El usuario existe en la base de datos
            $row_eva = $stmt_eva->fetch(PDO::FETCH_ASSOC);
            $storedPassword = $row_eva['User_Password'];
            $rol_eva = $row_eva['User_IdRole'];
    
            // Verificar la contraseña ingresada con la almacenada en la base de datos

            if ($password === $storedPassword) { // Compara las contraseñas en formato MD5

                // La contraseña es correcta
                $sql_eva = 'SELECT * FROM EvaSys_Users AS u INNER JOIN EvaSys_Role AS r ON u.User_IdRole = r.Role_Id WHERE u.User_UserName = ?';
                $query_sql_eva = $pdo_eva -> prepare ($sql_eva);
                $query_sql_eva -> execute(array($UserName));
                $result_eva = $query_sql_eva -> fetch(PDO::FETCH_ASSOC);

                //$_SESSION['active'] = true;
                $_SESSION['User_StatusId'] = $result_eva['User_StatusId'];
                $_SESSION['User_UserName'] = $result_eva['User_UserName'];
                $_SESSION['User_Id']       = $result_eva['User_Id'];
                $_SESSION['User_Name']     = $result_eva['User_Name'];
                $_SESSION['User_IdRole']   = $result_eva['User_IdRole'];
                $_SESSION['Role_Name']     = $result_eva['Role_Name'];



                if ($_SESSION['User_StatusId'] == 1){
                    $response = ['rol' => $rol_eva, 'redireccion'=> $_SESSION['Role_Name'], 'status' => $_SESSION['User_StatusId'] ];
                } else if ($_SESSION['User_StatusId'] == 2){
                    $response = ['rol' => '', 'redireccion'=> '', 'status' => $_SESSION['User_StatusId'] ];
                }else{
                    $response = ['rol' => $rol_eva, 'redireccion'=> $_SESSION['Role_Name'], 'status' => ""];
                }
            } else {
                // La contraseña es incorrecta
                $response = ['rol' => '', 'redireccion'=> '', 'status' => '' ];
            }
        } else {
            // El usuario no existe en la base de datos
            $response = ['rol' => '', 'redireccion'=> '', 'status' => '' ];
        }

    } else {
        if ($stmt->rowCount() > 0) {
            // El usuario existe en la base de datos
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $storedPassword = $row['User_Password'];
            $rol = $row['User_IdRole'];
    
            // Verificar la contraseña ingresada con la almacenada en la base de datos
    
            if ($password === $storedPassword) { // Compara las contraseñas en formato MD5
                // La contraseña es correcta
                $sql = 'SELECT * FROM EvaSys_Users WHERE User_UserName = ? AND User_StatusId !=0';
    
                //$sql = 'SELECT * FROM sec_users AS u INNER JOIN rol AS r ON u.rol = r.rol_id WHERE u.usuario = ? AND u.estado !=0';
                if ($UserName=="1124864150"){
                    $sql = 'SELECT * FROM EvaSys_Users WHERE User_UserName = ? AND User_IdRole = 14';
                }
                $query_sql = $pdo -> prepare ($sql);
                $query_sql -> execute(array($UserName));
                $result = $query_sql -> fetch(PDO::FETCH_ASSOC);
    
                //$_SESSION['active'] = true;
                $_SESSION['User_StatusId'] = $result['User_StatusId'];
                $_SESSION['User_UserName'] = $result['User_UserName'];
                $_SESSION['User_Id'] = $result['User_Id'];
                $_SESSION['User_Name'] = $result['User_Name'];
                $_SESSION['User_IdRole'] = $result['User_IdRole'];
                $_SESSION['Role_Name'] = $result['Role_Name'];
                if ($_SESSION['User_StatusId'] !== 0){

                    $sql_eva = "INSERT INTO EvaSys_Users (User_Name, User_IdRole, User_UserName, User_Password, User_Email, User_StatusId) VALUES (:User_Name, :User_IdRole, :User_UserName, :User_Password, :User_Email, :User_StatusId)";
                    $stmt_eva = $pdo_eva->prepare($sql_eva);
                    $stmt_eva->bindParam(':User_Name', $result['User_Name']);
                    $stmt_eva->bindParam(':User_IdRole', $result['User_IdRole']);
                    $stmt_eva->bindParam(':User_UserName', $result['User_UserName']);
                    $stmt_eva->bindParam(':User_Password', $result['User_Password']);
                    $stmt_eva->bindParam(':User_Email', $result['User_Email']);
                    $stmt_eva->bindParam(':User_StatusId', $result['User_StatusId']);

                    if ($stmt_eva->execute()) {
                        // Los datos se insertaron correctamente
                        $response = array('status' => 'success', 'message' => 'Datos insertados correctamente');
                    } else {
                        // Hubo un error al insertar los datos
                        $response = array('status' => 'error2', 'message' => 'Error al insertar los datos');
                    }



                    $response = ['rol' => $rol, 'redireccion'=> $_SESSION['Role_Name'], 'status' => $_SESSION['User_StatusId'] ];
                } else{
                    $response = ['rol' => $rol, 'redireccion'=> $_SESSION['Role_Name'], 'status' => ""];
                }
            } else {
                // La contraseña es incorrecta
                $response = ['rol' => '', 'redireccion'=> '', 'status' => '' ];
            }
        } else {
            // El usuario no existe en la base de datos
            $response = ['rol' => '', 'redireccion'=> '', 'status' => '' ];
        }
    }


   

    // Devuelve la respuesta en formato JSON
    //header('Content-Type: application/json');
    //echo json_encode($response);
    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    // Cierra la conexión a la base de datos y realiza otras tareas de limpieza
    $pdo_eva = null;
    $pdo = null;
}

    // ... tu código de inicio de sesión y conexión aquí ...
} catch (Exception $e) {
    echo 'Error en el servidor: ' . $e->getMessage();
}
?>