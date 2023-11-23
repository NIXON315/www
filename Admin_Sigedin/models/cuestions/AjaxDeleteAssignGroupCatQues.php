<?php
require_once '../../../includes/conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        // Obtener el ID a eliminar desde la solicitud AJAX
        $idToDelete = $_POST['id'];

        try {
            // Consulta SQL para eliminar
            $sqlDelete = 'DELETE FROM EvaSys_GroupCatQues WHERE GroupCatQues_Id = ?';
            $queryDelete = $pdo_eva->prepare($sqlDelete);
            $queryDelete->execute([$idToDelete]);

            $response = array(
                'status' => true,
                'msg' => 'La configuración Tipo de Preguntas se eliminado exitosamente'
            );
        } catch (PDOException $e) {
            $response = array(
                'status' => false,
                'msg' => 'Error al eliminar la configuración Tipo de Preguntas: ' . $e->getMessage()
            );
        }
    } else {
        $response = array(
            'status' => false,
            'msg' => 'ID no proporcionado para la eliminación'
        );
    }
} else {
    $response = array(
        'status' => false,
        'msg' => 'Petición inválida'
    );
}

header('Content-Type: application/json');
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
