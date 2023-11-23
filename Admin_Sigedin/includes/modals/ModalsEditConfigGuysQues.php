<?php
require_once '../includes/conexion.php';

// Obtener los roles de la base de datos
//$sqlGuys = 'SELECT * FROM EvaSys_GuysQues WHERE GuysQues_StatusId = "1" ORDER BY GuysQues_Id DESC';
//$queryGuys = $pdo_eva->query($sqlGuys);
//$GuysQues = $queryGuys->fetchAll(PDO::FETCH_ASSOC);

echo "Hello Word";

?>

<div class="modal fade" id="modalGuysQues" tabindex="-1" role="dialog" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModal">Editar Configuración</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formGuysQues" name="formGuysQues">
            <input type="hidden" name="idGuysQues" id="idGuysQues" value="">
          <div class="form-group">
            <label for="nombreGuysQues" class="col-form-label">Nombre De La Configuración:</label>
            <input type="text" class="form-control" id="nombreGuysQues" name="nombreGuysQues">
          </div>
          <div class="form-group">

          </div>

          <div class="form-group">
            <div class="row">
            <div class="col-md-3">
              </div>
                <div class="col-md-6">
                    <label for="statusGuysQues" class="col-form-label">Estado:</label>
                    <select class="form-control" id="statusGuysQues" name="statusGuysQues">
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