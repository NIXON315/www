<?php
require_once 'includes/header.php';
?>

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-users"></i> Usuarios</h1>
          <p>Gestion de Usuarios.</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Usuarios</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
          <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableuserssigeitp">
                  <thead>
                    <tr>
                      <th>Acciones</th>
                      <th>ID</th>
                      <th>Nombre</th>
                      <th>Rol</th>
                      <th>Estado</th>
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