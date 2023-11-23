<?php
require_once 'includes/header.php';
require_once 'includes/modals/ModalsEditConfigGroupCatQues.php';

?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-users"></i> Construir Cuestionario</h1>
          <p>Configuración Construir Cuestionario.</p>
          <button type="button" class="btn btn-success" type="button" onclick="openModalGroupCatQues()">Nueva Configuración</button>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Construir Cuestionario</a></li>
        </ul>
      </div>
      <div class="d-flex justify-content-end">
            <div class="btn-group">
                <button class="btn btn-sm btn-primary" title="Editar" data-toggle="tooltip" data-placement="top">
                    <i class="fa fa-edit"></i> Editar
                </button>
                <button class="btn btn-sm btn-danger ml-2" title="Eliminar" data-toggle="tooltip" data-placement="top">
                    <i class="fa fa-trash"></i> Eliminar
                </button>
                <button class="btn btn-sm btn-secondary ml-2" title="Configuración" data-toggle="tooltip" data-placement="top">
                    <i class="fa fa-cog"></i> Configuración
                </button>
            </div>
          </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
          <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableGroupCatQues">
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
    </main>
<?php
require_once 'includes/footer.php';
?>