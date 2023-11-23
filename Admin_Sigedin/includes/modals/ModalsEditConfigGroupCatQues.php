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

<div class="modal fade bd-example-modal-xl" id="modalGroupCatQues" tabindex="-1" role="dialog" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModal">Editar Configuración</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formGroupCatQues" name="formGroupCatQues">
            <input type="hidden" name="idGroupCatQuest" id="idGroupCatQuest" value="">


            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label for="nombreGroupCatQuest" class="col-form-label">Nombre De La Configuración De Agrupación:</label>
                  <select class="form-control" id="nombreGroupCatQuest" name="nombreGroupCatQuest">
                    <option value="">Seleccione Una Opción</option>
                    <?php foreach ($ConfigQuestionnaireQues as $ConfigQuest): ?>
                      <option value="<?php echo $ConfigQuest['ConfigQuestionnaire_Id']; ?>"><?php echo $ConfigQuest['ConfigQuestionnaire_Name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="nombreCategoriOfQuestions" class="col-form-label">Nombre De La Categoria De Preguntas:</label>
                  <select class="form-control" id="nombreCategoriOfQuestions" name="nombreCategoriOfQuestions">
                    <option value="">Seleccione Una Opción</option>
                    <?php foreach ($CategoriOfQuestionsQues as $CategoriOfQuest): ?>
                      <option value="<?php echo $CategoriOfQuest['CatOfQues_Id']; ?>"><?php echo $CategoriOfQuest['CatOfQues_Name']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button class="btn btn-primary" type="submit">Guardar</button>
          </div>
        </form>

        <div>
              <button type="button" class="btn btn-success" type="button" onclick="openModalAddGroupCatQues()">Nueva Configuración</button>
          </div>
          <br>

        
        <div class="row">
          <div class="col-md-12">
            <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                  <table class="table table-hover table-bordered  w-100" id="tableAddGroupCatQues">
                    <thead>
                      <tr>
                        <th style="width: 5%">ID</th>
                        <th>Nombre Del Cuestionario</th>
                        <th style="width: 20%">Acciones</th>
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
      </div>
    </div>
  </div>
</div>