<?php
require_once '../includes/conexion.php';


// Obtener los roles de la base de datos
$sqlRoles = 'SELECT * FROM EvaSys_Role WHERE Role_StatusId = "1" ORDER BY Role_Id DESC';
$queryRoles = $pdo_eva->query($sqlRoles);
$roles = $queryRoles->fetchAll(PDO::FETCH_ASSOC);

//ojo en este codigo reemplazar
$sqlDatetime = 'SELECT * FROM EvaSys_ConfigQuestionnaire';
$queryDatetime = $pdo_eva->query($sqlDatetime);
$Datetime = $queryDatetime->fetchAll(PDO::FETCH_ASSOC);

?>



<div class="modal fade bd-example-modal-xl" id="modalConfigQuestionnaireCat" tabindex="-1" role="dialog" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModal">Configuración</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formConfigQuestionnaireCat" name="formConfigQuestionnaireCat">
            <input type="hidden" name="idConfigQuestionnaireCat" id="idConfigQuestionnaireCat" value="">

          <div class="form-group">
            <div class="row">
              <div class="col-md-3">
                  <label for="nombreConfigQuestionnaireCat" class="col-form-label">Nombre De La Configuración:</label>
                  <input type="text" class="form-control" id="nombreConfigQuestionnaireCat" name="nombreConfigQuestionnaireCat" disabled>
              </div>
              <div class="col-md-3">
                <label for="evaluadorConfigQuestionnaireCat" class="col-form-label">Evaluador:</label>
                <select class="form-control" id="evaluadorConfigQuestionnaireCat" name="evaluadorConfigQuestionnaireCat" disabled>
                  <option value="">Seleccione Una Opción</option>
                  <?php foreach ($roles as $rol): ?>
                    <option value="<?php echo $rol['Role_Id']; ?>"><?php echo $rol['Role_Name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-3">
                <label for="evaluadoConfigQuestionnaireCat" class="col-form-label">Evaluado:</label>
                <select class="form-control" id="evaluadoConfigQuestionnaireCat" name="evaluadoConfigQuestionnaireCat" disabled>
                  <option value="">Seleccione Una Opción</option>
                  <?php foreach ($roles as $rol): ?>
                    <option value="<?php echo $rol['Role_Id']; ?>"><?php echo $rol['Role_Name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-3">
                      <label for="statusConfigQuestionnaireCat" class="col-form-label">Estado:</label>
                      <select class="form-control" id="statusConfigQuestionnaireCat" name="statusConfigQuestionnaireCat" disabled>
                          <option value="">Seleccione Una Opción</option>
                          <option value="1">Activo</option>
                          <option value="2">Inactivo</option>
                      </select>
                  </div>
            </div>
          </div>
          <div>
              <button type="button" class="btn btn-success" type="button" onclick="openModalAssignGroupCatQues()">Nueva Configuración</button>
          </div>
          <br>

        
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
          <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered  w-100" id="tableAssignGroupCatQues">
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
