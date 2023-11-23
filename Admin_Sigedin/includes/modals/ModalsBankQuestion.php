<?php
require_once '../includes/conexion.php';

// Obtener los roles de la base de datos
$sqlGuys = 'SELECT * FROM EvaSys_Questions WHERE Questions_StatusId = "1" ORDER BY Questions_Id DESC';
$queryGuys = $pdo_eva->query($sqlGuys);
$BankQuest = $queryGuys->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="modal fade" id="modalBankQuest" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModal">Editar Configuración</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formBankQuest" name="formBankQuest">
          <input type="hidden" name="idBankQuest" id="idBankQuest" value="">
          <div class="form-group">
            <label for="nombreBankQuest" class="col-form-label">Nombre De La Pregunta:</label>
            <input type="text" class="form-control" id="nombreBankQuest" name="nombreBankQuest">
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <label for="GuysBankQuest" class="col-form-label">Tipo de Pregunta:</label>
                <select class="form-control" id="GuysBankQuest" name="GuysBankQuest">
                  <option value="">Seleccione Una Opción</option>
                  <option value="1">Numérico</option>
                  <option value="2">Texto</option>
                  <option value="3">Abierta</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="statusBankQuest" class="col-form-label">Estado:</label>
                <select class="form-control" id="statusBankQuest" name="statusBankQuest">
                  <option value="">Seleccione Una Opción</option>
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group" id="numericFields" style="display: none;">
            <div class="row">
              <div class="col-md-6">
                <label for="ValMinBankQuest" class="col-form-label">Nota Minima:</label>
                <input type="number" class="form-control" id="ValMinBankQuest" name="ValMinBankQuest" min="0" max="5">
              </div>
              <div class="col-md-6">
                <label for="ValMaxBankQuest" class="col-form-label">Nota Maxima:</label>
                <input type="number" class="form-control" id="ValMaxBankQuest" name="ValMaxBankQuest" min="0" max="5">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="StatementBankQuest">Example textarea</label>
            <textarea class="form-control" id="StatementBankQuest" name="StatementBankQuest" rows="3"></textarea>
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

<script>
  document.getElementById('GuysBankQuest').addEventListener('change', function() {
    var numericFields = document.getElementById('numericFields');
    if (this.value === '1') {
      numericFields.style.display = 'block';
    } else {
      numericFields.style.display = 'none';
    }
  });
</script>
