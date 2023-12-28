<?php
session_start();
error_reporting(0); // Deshabilita temporalmente todas las advertencias y notificaciones

require_once '../includes/conexion.php';
error_reporting(E_ALL); // Restablece la configuración de errores a su valor original
date_default_timezone_set('America/Bogota');
$fechadigi = date('Y-m-d');

// Paso 1: Obtener el rol del usuario
$idRole = $_SESSION['User_IdRole'];

// Consulta para obtener los cuestionarios activos
$sql = "SELECT * FROM EvaSys_ConfigQuestionnaire WHERE ConfigQuestionnaire_IdRolEvaluator = :idRole AND ConfigQuestionnaire_StatusId = 1";
$stmt = $pdo_eva->prepare($sql);
$stmt->bindValue(':idRole', $idRole, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="modal fade" id="modalCuestions" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModal">Evaluaciones Activas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCuestions" name="formCuestions" action="./cuestions.php" method="POST">
                    <div class="form-group">
                        <label for="listCuestions" class="col-form-label">Ir a:</label>
                        <select class="form-control" id="listCuestions" name="listCuestions">
                            <?php
                            if ($stmt->rowCount() > 0) {
                                foreach ($result as $row) {
                                    $idCuestionario = $row['ConfigQuestionnaire_Id'];
                                    $nombreQuestions = $row['ConfigQuestionnaire_Name'];
                                    echo "<option value='$idCuestionario'>$nombreQuestions</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" type="submit">Responder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
