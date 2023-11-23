<?php
require_once 'includes/header.php';
require_once '../includes/conexion.php';

$sql = 'SELECT User_Id, User_Name, User_UserName, User_Password, User_Email, User_IdRole, Role_Name, User_StatusId
FROM EvaSys_Users
GROUP BY User_UserName;';
$query = $pdo->prepare($sql);
$query->execute();

$consulta = $query->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['countusersSigeitp']=count($consulta);

$sql_eva = 'SELECT u.User_Id, u.User_Name, u.User_UserName, r.Role_Name
FROM EvaSys_Users AS u
INNER JOIN EvaSys_Role AS r ON u.User_IdRole = r.Role_Id
GROUP BY u.User_Id;';
$query_eva = $pdo_eva->prepare($sql_eva);
$query_eva->execute();

$consulta_eva = $query_eva->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['countusersEvadoc']=count($consulta_eva);

$sql_Study = 'SELECT  ID_ESTUDIANTE  FROM VISTA_EVADOCENTE  WHERE ID_DOCENTE = '.$_SESSION['User_UserName'].' GROUP BY ID_ESTUDIANTE';
$query_sigeiesStudy = $pdo_sigeies->prepare($sql_Study);
$query_sigeiesStudy->execute();

$consulta_sigeiesStudy = $query_sigeiesStudy->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['countStudy']=count($consulta_sigeiesStudy);

$sql_Teacher = 'SELECT  ASIGNATURA  FROM VISTA_EVADOCENTE  WHERE ID_DOCENTE = '.$_SESSION['User_UserName'].' GROUP BY ASIGNATURA';
$query_sigeiesTeacher = $pdo_sigeies->prepare($sql_Teacher);
$query_sigeiesTeacher->execute();

$consulta_sigeiesTeacher = $query_sigeiesTeacher->fetchAll(PDO::FETCH_ASSOC);
$_SESSION['countTeacher']=count($consulta_sigeiesTeacher);



$sql_UserName = 'SELECT
      `EvaSys_AnswerEva`.`AnswerEva_IdRolEvaluator`
    , `EvaSys_AnswerEva`.`AnswerEva_UserNameEvaluator`
    , `EvaSys_AnswerEva`.`AnswerEva_QuesEvaId`
    , `EvaSys_QuestionnaireEva`.`QuesEva_Name`
FROM
    `sistema-escolar`.`EvaSys_AnswerEva`
    INNER JOIN `sistema-escolar`.`EvaSys_QuestionnaireEva` 
        ON (`EvaSys_AnswerEva`.`AnswerEva_QuesEvaId` = `EvaSys_QuestionnaireEva`.`QuesEva_Id`) WHERE `EvaSys_AnswerEva`.`AnswerEva_UserNameEvaluator`= :username GROUP BY AnswerEva_UserNameEvaluator;';

$query_sigeiesUserName = $pdo_eva->prepare($sql_UserName);
$query_sigeiesUserName->bindParam(':username', $_SESSION['User_UserName']);
$query_sigeiesUserName->execute();

$consulta_sigeiesUserName = $query_sigeiesUserName->fetchAll(PDO::FETCH_ASSOC);

if (count($consulta_sigeiesUserName) > 0) {
    $_SESSION['QuesEvaName'] = ucwords(mb_strtolower($consulta_sigeiesUserName[0]['QuesEva_Name']));
} else {
    // Si no hay resultados, puedes asignar un valor por defecto o manejarlo según tus necesidades
    $_SESSION['QuesEvaName'] = 'No hay nombre disponible';
}
$_SESSION['URL_Net'] = "";


?>

<main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
          <p>En esta seccion solo encontraras informacion de la evaluacion docente</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
      </div>
      <div class="row"><!--
        <div class="col-md-6 col-lg-3">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h4>Sigedin</h4>
              <p><b><?= $_SESSION['countusersSigeitp'] ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h4>EvaDocente</h4>
              <p><b><?= $_SESSION['countusersEvadoc'] ?></b></p>
            </div>
          </div>
        </div>-->
        <div class="col-md-6 col-lg-3">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-address-card fa-3x"></i>
            <div class="info">
              <h4>Alumnos</h4>
              <p><b><?= $_SESSION['countStudy'] ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-suitcase fa-3x"></i>
            <div class="info">
              <h4>Cursos</h4>
              <p><b><?= $_SESSION['countTeacher'] ?></b></p>
            </div>
          </div>
        </div>
      </div><!--
      <div class="row">
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Monthly Sales</h3>
            <div class="embed-responsive embed-responsive-16by9">
              <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">Support Requests</h3>
            <div class="embed-responsive embed-responsive-16by9">
              <canvas class="embed-responsive-item" id="pieChartDemo"></canvas>
            </div>
          </div>
        </div>
      </div>-->
    </main>
    

<?php
require_once 'includes/footer.php';
?>