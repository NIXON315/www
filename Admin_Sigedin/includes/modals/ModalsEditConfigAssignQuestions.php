<?php
require_once '../includes/conexion.php';

// Obtener los roles de la base de datos
$sqlConfigQuestions = 'SELECT * FROM EvaSys_Questions ORDER BY Questions_Id DESC';
$queryConfigQuestions = $pdo_eva->query($sqlConfigQuestions);
$ConfigQuestionsQues = $queryConfigQuestions->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="modal fade bd-example-modal-lg" id="modalAssignQuestions" tabindex="-1" role="dialog" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModal">Agregar Preguntas al cuestionario:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formAssignQuestions" name="formAssignQuestions">
            <div class="form-group">
             
                  <label for="idQuestions" class="col-form-label">Nombre De La Preguntas:</label>
                  <select class="form-control" id="idQuestions" name="idQuestions">
                    <option value="">Seleccione Una Opción</option>
                    <?php foreach ($ConfigQuestionsQues as $Quest): ?>
                      <option value="<?php echo $Quest['Questions_Id']; ?>"><?php echo $Quest['Questions_Statement']; ?></option>
                    <?php endforeach; ?>
                  </select>
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


