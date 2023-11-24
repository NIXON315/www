<?php
        error_reporting(0); // Deshabilita temporalmente todas las advertencias y notificaciones

require_once '../includes/conexion.php';

// Obtener los roles de la base de datos
//$sqlRoles = 'SELECT rol_id, nombre_rol FROM rol';

$sqlRoles = 'SELECT * FROM EvaSys_Role';
$queryRoles = $pdo_eva->query($sqlRoles);
$roles = $queryRoles->fetchAll(PDO::FETCH_ASSOC);
error_reporting(E_ALL); // Restablece la configuración de errores a su valor original

?>

<div class="modal fade" id="modalUser" tabindex="-1" role="dialog" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloModal">Editar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formUser" name="formUser">
            <input type="hidden" name="idUser" id="idUser" value="">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Usuario:</label>
            <input type="text" class="form-control" id="usuario" name="usuario">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Contraseña:</label>
            <input type="password" class="form-control" id="clave" name="clave">
          </div>
          <div class="form-group">
            <label for="listRol" class="col-form-label">Rol:</label>
            <select class="form-control" id="listRol" name="listRol">
              <?php foreach ($roles as $rol): ?>
                <option value="<?php echo $rol['Role_Id']; ?>"><?php echo $rol['Role_Name']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="listStatus" class="col-form-label">Estado:</label>
            <select class="form-control" id="listStatus" name="listStatus">
                <option value="1">Activo</option>
                <option value="2">Inactivo</option>
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