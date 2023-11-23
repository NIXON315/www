<?php
require_once '../includes/conexion.php';

// Obtener los roles de la base de datos
//$sqlGuys = 'SELECT * FROM EvaSys_GuysQues WHERE GuysQues_StatusId = "1" ORDER BY GuysQues_Id DESC';
//$queryGuys = $pdo_eva->query($sqlGuys);
//$GuysQues = $queryGuys->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="modal fade" id="modalRoles" tabindex="-1" role="dialog" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModal">Editar Configuración</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formRoles" name="formRoles">
            <input type="hidden" name="idRole" id="idRole" value="">
          <div class="form-group">
            <label for="nombreRole" class="col-form-label">Nombre De La Configuración:</label>
            <input type="text" class="form-control" id="nombreRole" name="nombreRole">
          </div>
          <div class="form-group">

          </div>

          <div class="form-group">
            <div class="row">
            <div class="col-md-3">
              </div>
                <div class="col-md-6">
                    <label for="statusRole" class="col-form-label">Estado:</label>
                    <select class="form-control" id="statusRole" name="statusRole">
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