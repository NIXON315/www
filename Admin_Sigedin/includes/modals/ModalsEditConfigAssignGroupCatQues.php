<?php
require_once '../includes/conexion.php';

// Obtener los roles de la base de datos
$sqlConfigQuestionnaire = 'SELECT * FROM EvaSys_ConfigQuestionnaire ORDER BY ConfigQuestionnaire_Id DESC';
$queryConfigQuestionnaire = $pdo_eva->query($sqlConfigQuestionnaire);
$ConfigQuestionnaireQues = $queryConfigQuestionnaire->fetchAll(PDO::FETCH_ASSOC);

$sqlCategoriOfQuestions = 'SELECT * FROM EvaSys_CategoriOfQuestions ORDER BY CatOfQues_Id DESC';
$queryCategoriOfQuestions = $pdo_eva->query($sqlCategoriOfQuestions);
$CategoriOfQuestionsQues = $queryCategoriOfQuestions->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="modal fade" id="modalAssignGroupCatQues" tabindex="-1" role="dialog" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModal">Agregar Nueva Categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formAssignGroupCatQues" name="formAssignGroupCatQues">
            <div class="form-group">
             
                  <label for="idCategoriOfQuestions" class="col-form-label">Nombre De La Categoria De Preguntas:</label>
                  <select class="form-control" id="idCategoriOfQuestions" name="idCategoriOfQuestions">
                    <option value="">Seleccione Una Opción</option>
                    <?php foreach ($CategoriOfQuestionsQues as $CategoriOfQuest): ?>
                      <option value="<?php echo $CategoriOfQuest['CatOfQues_Id']; ?>"><?php echo $CategoriOfQuest['CatOfQues_Name']; ?></option>
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