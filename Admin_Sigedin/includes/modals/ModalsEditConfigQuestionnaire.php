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

<div class="modal fade" id="modalConfigQuestionnaire" tabindex="-1" role="dialog" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModal">Editar Configuración</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formConfigQuestionnaire" name="formConfigQuestionnaire">
            <input type="hidden" name="idConfigQuestionnaire" id="idConfigQuestionnaire" value="">
          <div class="form-group">
            <label for="nombreConfigQuestionnaire" class="col-form-label">Nombre De La Configuración:</label>
            <input type="text" class="form-control" id="nombreConfigQuestionnaire" name="nombreConfigQuestionnaire">
          </div>
          <div class="form-group">

          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label for="evaluadorConfigQuestionnaire" class="col-form-label">Evaluador:</label>
                <select class="form-control" id="evaluadorConfigQuestionnaire" name="evaluadorConfigQuestionnaire">
                  <option value="">Seleccione Una Opción</option>
                  <?php foreach ($roles as $rol): ?>
                    <option value="<?php echo $rol['Role_Id']; ?>"><?php echo $rol['Role_Name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="evaluadoConfigQuestionnaire" class="col-form-label">Evaluado:</label>
                <select class="form-control" id="evaluadoConfigQuestionnaire" name="evaluadoConfigQuestionnaire">
                  <option value="">Seleccione Una Opción</option>
                  <?php foreach ($roles as $rol): ?>
                    <option value="<?php echo $rol['Role_Id']; ?>"><?php echo $rol['Role_Name']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
            <div class="col-md-3">
              </div>
                <div class="col-md-6">
                    <label for="statusConfigQuestionnaire" class="col-form-label">Estado:</label>
                    <select class="form-control" id="statusConfigQuestionnaire" name="statusConfigQuestionnaire">
                        <option value="">Seleccione Una Opción</option>
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                </select>
              </div>
              <div class="col-md-3">
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