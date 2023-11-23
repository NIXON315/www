<?php
  session_start();
  if(!empty($_SESSION['User_IdRole'])){
    header('Location: '.$_SESSION['Role_Name'].'/');
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Login - Vali Admin</title>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>Evaluación Docente</h1>
      </div>
      <div class="login-box">
        <form class="login-form">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Iniciar Sesión</h3>
          <div class="form-group">
            <center><label class="control-label">Usuario</label></center>
            <input class="form-control text-center" id="username" type="text" placeholder="Número de Identificación" autofocus>
          </div>
          <div class="form-group">
            <center><label class="control-label">Contraseña</label></center>
            <input class="form-control text-center" id="password" type="password" placeholder="Contraseña">
          </div>
          <div id="messageUser"></div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block btn-login"><i class="fa fa-sign-in fa-lg fa-fw"></i>INICIAR SESIÓN</button>
          </div>
        </form>
        <form class="forget-form" action="index.html">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
          <div class="form-group">
            <label class="control-label">EMAIL</label>
            <input class="form-control" type="text" placeholder="Email">
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
          </div>
        </form>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>    
    <script src="js/login.js"></script>

    <!-- The javascript plugin to display page loading on top-->
    <script src="js/plugins/pace.min.js"></script>
  </body>
</html>
<script>
  // Esta función se ejecutará cuando la página se cargue completamente.
  window.addEventListener('load', function () {
    // Puedes personalizar el mensaje de la ventana emergente como desees.
    Swal.fire({
      title: '¡Bienvenido!',
      text: 'Para ingresar al sistema de evaluación Docente es necesario que ingresen su número de identificación como usuario y la contraseña que utilizan para ingresar a SIGEDIN, se recomineda realizar la evaluacion docente desde un computador',
      icon: 'success', // Puedes usar 'success', 'info', 'warning', 'error', etc.
      confirmButtonText: 'OK'
    });
  });
</script>

