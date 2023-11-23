<?php
require_once '../../../includes/conexion.php';
if(!empty($_GET)){
    $idGuysQues = $_GET['idGuysQues'];
    $sql_eva ='SELECT * FROM EvaSys_GuysQues WHERE GuysQues_Id = ?';
    $query_eva = $pdo_eva->prepare($sql_eva);
    $query_eva->execute(array($idGuysQues));
    $result_eva = $query_eva->fetch(PDO::FETCH_ASSOC);
    if(empty($result_eva)){
        $respuesta = array('status' => false, 'msg' => 'datos no encontrados');
    }else{
        $respuesta = array('status' => true, 'data' => $result_eva);
    }
    echo json_encode($respuesta,JSON_UNESCAPED_UNICODE);
    //echo json_encode($respuesta, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

}
?>