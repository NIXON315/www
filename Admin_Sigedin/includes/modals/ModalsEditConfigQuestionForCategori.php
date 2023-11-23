<?php
require_once '../includes/conexion.php';

// Obtener los roles de la base de datos
$sqlConfigQuestionnaire = 'SELECT * FROM EvaSys_ConfigQuestionnaire ORDER BY ConfigQuestionnaire_Id DESC';
$queryConfigQuestionnaire = $pdo_eva->query($sqlConfigQuestionnaire);
$ConfigQuestionnaireQues = $queryConfigQuestionnaire->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="modal fade" id="modalConfigQuestionForCategori" tabindex="-1" role="dialog" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModal">Agregar Nueva Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formQuestionForCategori" name="formQuestionForCategori">
        
        <input type="hidden" name="idConfigQuestionForCategori" id="idConfigQuestionForCategori" value="">
        <input type="hidden" name="idConfigQuestionna" id="idConfigQuestionna" value="">


        <div class="form-group">

          <label for="nombreConfigQuestionna" class="col-form-label">Nombre De La Configuración:</label>
          <input type="text" class="form-control" id="nombreConfigQuestionna" name="nombreConfigQuestionna" disabled>

          </div>

          <div class="form-group">

                  <label for="nombreConfigQuestionForCategori" class="col-form-label">Nombre De La Categoria:</label>
                  <input type="text" class="form-control" id="nombreConfigQuestionForCategori" name="nombreConfigQuestionForCategori" disabled>
          </div>

            <div>
              <button type="button" class="btn btn-success" type="button" onclick="openModalAssignQuestions()">Nueva Configuración</button>
          </div>
          <br>

        
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
          <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered  w-100" id="tableQuestionForCategori">
                  <thead>
                    <tr>
                      <th style="width: 5%">ID</th>
                      <th style="width: 90%">Nombre Del Cuestionario</th>
                      <th style="width: 5%">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
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