    <!-- Sidebar menu-->
    <?php
        error_reporting(0); // Deshabilita temporalmente todas las advertencias y notificaciones

      include '../../includes/conexion.php';
      error_reporting(E_ALL); // Restablece la configuración de errores a su valor original

      //include '../../includes/conexion';
      require_once './includes/modals/modals_cuestions.php';

    ?>
    <!--<button type="button" class="btn btn-success" type="button" onclick="openModal()">Nuevo Usuarios</button>-->

    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
    <div class="app-sidebar__user">
        <img class="app-sidebar__user-avatar img-fluid" src="./images/admin.png" alt="User Image" style="max-inline-size: 30%; block-size: auto;"> 
        <div>
          <p class="app-sidebar__user-name"><?= $_SESSION['User_Name'] ?></p>
          <p class="app-sidebar__user-designation"><?= $_SESSION['Role_Name'] ?></p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item" href="dashboard.php"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        <li><a class="app-menu__item" href="#" onclick="openModalCuestions()"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Evaluaciones</span></a></li>
        <!--<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Informes-Reportes</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="form-components.html"><i class="icon fa fa-circle-o"></i> Informe Docentes</a></li>
            <li><a class="treeview-item" href="form-custom.html"><i class="icon fa fa-circle-o"></i> Resultados Docentes</a></li>
            <li><a class="treeview-item" href="form-samples.html"><i class="icon fa fa-circle-o"></i> Resultados Todos Docentes</a></li>

          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-edit"></i><span class="app-menu__label">Informes Directivos</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="form-components.html"><i class="icon fa fa-circle-o"></i> Evaluaron</a></li>
            <li><a class="treeview-item" href="form-custom.html"><i class="icon fa fa-circle-o"></i> Informe Resultados Cuantitativos</a></li>
            <li><a class="treeview-item" href="form-samples.html"><i class="icon fa fa-circle-o"></i> Informe Resultados Cualitativos u Observaciones(Docentes)</a></li>

          </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-edit"></i><span class="app-menu__label">Gestión</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="ManageQuestions.php"><i class="icon fa fa-circle-o"></i> Cuestionarios</a></li>
            <li><a class="treeview-item" href="ConfigQuestionnaire.php"><i class="icon fa fa-circle-o"></i> Config. de Cuestionarios</a></li>
            <li><a class="treeview-item" href="BankQuestion.php"><i class="icon fa fa-circle-o"></i> Banco de Preguntas</a></li>
            <li><a class="treeview-item" href="ConfigCategoriOfQuestions.php"><i class="icon fa fa-circle-o"></i> Categorias de Preguntas</a></li>
            <li><a class="treeview-item" href="ConfigGuysQues.php"><i class="icon fa fa-circle-o"></i> Config. Tipos de Preguntas</a></li>
            <li><a class="treeview-item" href="ConfigRoles.php"><i class="icon fa fa-circle-o"></i> Config. Roles</a></li>

          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Usuarios</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="users_sigeitp.php"><i class="icon fa fa-circle-o"></i>Usuarios Sigedin</a></li>
            <li><a class="treeview-item" href="users_evadoc.php"><i class="icon fa fa-circle-o"></i> Usuarios Eva-Docente</a></li>
          </ul>
        </li>
   
        
        <li><a class="app-menu__item" href="docs.html"><i class="app-menu__icon fa fa-file-code-o"></i><span class="app-menu__label">Docs</span></a></li>-->  
        <li><a class="app-menu__item" href="../logout.php"><i class="app-menu__icon fa fa-sign-out fa-lg"></i></i><span class="app-menu__label"> Cerrar Sesión</span></a></li>
      </ul>
    </aside>