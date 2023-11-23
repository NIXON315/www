<?php
require_once '../includes/conexion.php';

// Obtener los roles de la base de datos
$sqlRoles = 'SELECT * FROM EvaSys_Role WHERE Role_StatusId = "1"';
$queryRoles = $pdo_eva->query($sqlRoles);
$roles = $queryRoles->fetchAll(PDO::FETCH_ASSOC);

$sqlConfigQuestionnaire = 'SELECT * FROM EvaSys_ConfigQuestionnaire WHERE ConfigQuestionnaire_StatusId = "1"';
$queryConfigQuestionnaire = $pdo_eva->query($sqlConfigQuestionnaire);
$configQuestionnaire = $queryConfigQuestionnaire->fetchAll(PDO::FETCH_ASSOC);

$sqlPeriodo = 'SELECT * FROM col_periodo ORDER BY cod_periodo DESC';
$queryPeriodo = $pdo_sigeies->query($sqlPeriodo);
$periodos = $queryPeriodo->fetchAll(PDO::FETCH_ASSOC);


//ojo en este codigo reemplazar
$sqlDatetime = 'SELECT * FROM EvaSys_QuestionnaireEva';
$queryDatetime = $pdo_eva->query($sqlDatetime);
$Datetime = $queryDatetime->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="modal fade" id="modalQuestions" tabindex="-1" role="dialog" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModal">Editar Questionario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formQuestiones" name="formQuestiones">
            <input type="hidden" name="idQuestions" id="idQuestions" value="">
          <div class="form-group">
            <label for="nombreQuestions" class="col-form-label">Nombre Del Cuestionario:</label>
            <input type="text" class="form-control" id="nombreQuestions" name="nombreQuestions" required="required">
          </div>
          <div class="form-group">

          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label for="periodoQuestions" class="col-form-label">Periodo:</label>
                <select class="form-control" id="periodoQuestions" name="periodoQuestions" required="required">
                <option value="">Seleccione Una Opción</option>
                  <?php foreach ($periodos as $periQues): ?>
                    <option value="<?php echo $periQues['cod_periodo']; ?>"><?php echo $periQues['nom_periodo']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="statusQuestions" class="col-form-label">Estado Cuestionario:</label>
                <select class="form-control" id="statusQuestions" name="statusQuestions" required="required">
                    <option value="">Seleccione Una Opción</option>
                    <option value="1">Activo</option>
                    <option value="2">Inactivo</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label for="ConfigQuestions" class="col-form-label">Cuestionario Configurado:</label>
                <select class="form-control" id="ConfigQuestions" name="ConfigQuestions" required="required">
                <option value="">Seleccione Una Opción</option>
                  <?php foreach ($configQuestionnaire as $configQuest): ?>
                    <option value="<?php echo $configQuest['ConfigQuestionnaire_Id']; ?>"><?php echo $configQuest['ConfigQuestionnaire_Name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

           

              <div class="col-md-6">
                <label for="PercentQuestions" class="col-form-label">Porcentaje de Calificación:</label>
                <div class="input-group">
                    <input class="form-control" id="PercentQuestions" name="PercentQuestions" min="1" max="100" type="number" placeholder="Peso de la calificación" required="required">
                    <div class="input-group-append"><span class="input-group-text">%</span></div>
                </div>
              </div>
            </div>
          </div>


          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label for="fechaAperturaQuestions" class="col-form-label">Fecha Apertura:</label>
                <input type="date" class="form-control" id="fechaAperturaQuestions" name="fechaAperturaQuestions" required="required">
              </div>
              <div class="col-md-6">
                <label for="horaAperturaQuestions" class="col-form-label">Hora Apertura:</label>
                <input type="time" class="form-control" id="horaAperturaQuestions" name="horaAperturaQuestions" required="required">
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label for="fechaCierreQuestions" class="col-form-label">Fecha Cierre:</label>
                <input type="date" class="form-control" id="fechaCierreQuestions" name="fechaCierreQuestions" required="required">
              </div>
              <div class="col-md-6">
                <label for="horaCierreQuestions" class="col-form-label">Hora Cierre:</label>
                <input type="time" class="form-control" id="horaCierreQuestions" name="horaCierreQuestions" required="required">
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button class="btn btn-primary" type="submit">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>