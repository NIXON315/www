<?php
    error_reporting(0); // Deshabilita temporalmente todas las advertencias y notificaciones

    $host = '192.168.1.101';
    $user = 'DevOps';
    $pass = 'Phz3bzGa@B';
    $db   = 'sigedin_seguridad';
    $port = '3306';
    
    $host_eva = '192.168.1.101';
    $user_eva = 'DevOps';
    $pass_eva = 'Phz3bzGa@B';
    $db_eva   = 'sistema-escolar';
    $port_eva = '3306';
    
    $host_sigeies = '192.168.1.101';
    $user_sigeies = 'DevOps';
    $pass_sigeies = 'Phz3bzGa@B';
    $db_sigeies   = 'sigedin_ies';
    $port_sigeies = '3306';

    
try {
    $pdo = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$db.';charset=utf8', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo_sigeies = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$db_sigeies.';charset=utf8', $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $pdo_sigeies->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo_eva = new PDO('mysql:host='.$host_eva.';port='.$port.';dbname='.$db_eva.';charset=utf8', $user_eva, $pass_eva, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $pdo_eva->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $e) {
    
    echo 'Error: '.$e->getMessage();
    
}
error_reporting(E_ALL); // Restablece la configuración de errores a su valor original

?>