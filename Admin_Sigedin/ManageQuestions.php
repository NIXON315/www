<?php
require_once 'includes/header.php';
require_once 'includes/modals/ModalsEditQuestions.php';
?>

    <main class="app-content">
      <div class="app-title">
        
        <div>
          <h1><i class="fa fa-users"></i> Cuestionarios</h1>
          <p>Gestion de Cuestionarios.</p>
          <button type="button" class="btn btn-success" type="button" onclick="openModalEditQuestions()">Crear Cuestionario</button>

        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Cuestionarios</a></li>
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
                <table class="table table-hover table-bordered" id="tablemanagequestions">
                  <thead>
                    <tr>
                      <th style="width: 5%">ID</th>
                      <th>Nombre Del Cuestionario</th>
                      <th style="width: 10%">Periodo</th>
                      <th style="width: 10%">Estado</th>
                      <th >Acciones</th>

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
    <div id="myModal" class="modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ejecutando...</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="bs-component">
              <div class="progress mb-2">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" id="progressBar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



<?php
require_once 'includes/footer.php';
?>