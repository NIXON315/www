<?php
session_start();
require_once 'includes/header.php';

// Obtener el nombre del cuestionario de $_POST
$nombreCuestionario = $_POST['nombreQuestions'];

$idAssignGroupCatQuest = $_POST['idCuestionario'];;

$idEvaluator = $_SESSION['User_UserName'];

$contador = 1;




$sql = 'SELECT
`EvaSys_GroupCatQues`.`GroupCatQues_Id`,
`EvaSys_ConfigQuestionnaire`.`ConfigQuestionnaire_Id`,
`EvaSys_ConfigQuestionnaire`.`ConfigQuestionnaire_Name`,
`EvaSys_CategoriOfQuestions`.`CatOfQues_Id`,
`EvaSys_CategoriOfQuestions`.`CatOfQues_Name`
FROM
`sistema-escolar`.`EvaSys_GroupCatQues`
INNER JOIN `sistema-escolar`.`EvaSys_ConfigQuestionnaire`
  ON (
    `EvaSys_GroupCatQues`.`ConfigQuestionnaire_Id` = `EvaSys_ConfigQuestionnaire`.`ConfigQuestionnaire_Id`
  )
INNER JOIN `sistema-escolar`.`EvaSys_CategoriOfQuestions`
  ON (
    `EvaSys_GroupCatQues`.`CatOfQues_Id` = `EvaSys_CategoriOfQuestions`.`CatOfQues_Id`
  ) WHERE    `EvaSys_ConfigQuestionnaire`.`ConfigQuestionnaire_Id`  = "' . $idAssignGroupCatQuest . '" GROUP BY   `EvaSys_CategoriOfQuestions`.`CatOfQues_Id` DESC';

$query = $pdo_eva->query($sql);
$categori = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<main class="app-content">
  <div class="app-title">
    <div class="div">
      <h1><i class="fa fa-laptop"></i> <?php echo $nombreCuestionario; ?></h1>
      <p>Autoevaluaciòn</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#"><?php echo $nombreCuestionario; ?></a></li>
    </ul>
  </div>

  <!-- Containers -->
  <div class="tile mb-4">
  <div class="row">
      <div class="col-lg-12">
        <div class="page-header">
          <center><h2 class="mb-3 line-head" id="containers"><?php echo $nombreCuestionario; ?></h2></center>
        </div>
        <div class="bs-component">
          <div class="jumbotron">
          <center><h3 class="tile-title">Antes de evaluar recuerda que:</h3></center>
            <p class="text-justify">Frente a cada una de las afirmaciones o preguntas, seleccione la opción según sea su grado de satisfacción, siendo cero(0) la calificación más baja, y cinco(5) la opción más alta. Los resultados aportarán elementos para la evaluación integral y el mejoramiento del desempeño del personal docente en el Instituto Tecnológico del Putumayo.
              <br>
              <br>
            Esta información recopilada en la evaluación docente es totalmente confidencial y su uso está orientado al mejoramiento continuo.
            <br>
              <br>
            Es Importante dar clic en el boton <button class="btn btn-sm btn-primary" title="Guardar" data-toggle="tooltip" data-placement="top"><i class="fa fa-save"></i></button> una vez se registre una calificaciòn, para que pueda guarda la calificacion, en caso de no dar clic en el boton, no se guardara ningun dato, en caso de no aplicar a la pregunta debemos precionar el boton <button class="btn btn-sm btn-dark" title="No Aplica" data-toggle="tooltip" data-placement="top" ><i">N/A</i></button></p> 
            <form id="certificationForm" method="POST" target="_blank">
            <center><button type="submit" class="btn btn-warning">Generar Certificación</button></center>
                        </form>
          </div>
        </div>
      </div>
    </div>

    <?php foreach ($categori as $categoriQues): 
                  $cont = $contador++;
                  ?>
      
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
      <h3 class="tile-title"><?php echo $categoriQues['CatOfQues_Name']; ?></h3>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
          <div class="tile-body">
              <div class="table-responsive">
              <table class="table tabla-categoria" id="tableQuestionsAnswer_<?php echo $cont ?>" data-questionid="<?php echo $categoriQues['CatOfQues_Id']; ?>">
                  <thead>
                    <tr>
                      <th>Pregunta</th>
                      <th style="width: 10%">Calificacion</th>
                      <th style="width: 10%">Acciones</th>
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
      </div>
    </div>
  </div>
<?php endforeach; ?>

    <!-- Tabla Editable -->

    <!-- Fin Tabla Editable -->
    <script>
            document.getElementById('certificationForm').addEventListener('submit', function (event) {
                event.preventDefault(); // Evitar que el formulario se envíe directamente
                <?php
                $sql_UserName = 'SELECT
                    `AnswerEva_UserNameEvaluator`
                    , `AnswerEva_UserNameEvaluated`
                    , `AnswerEva_QualifyNum`
                    , `AnswerEva_QualifyText`
                FROM
                    `sistema-escolar`.`EvaSys_AnswerEva` WHERE AnswerEva_UserNameEvaluator = '. $_SESSION['User_UserName'].';';

                $query_sigeiesUserName = $pdo_sigeies->prepare($sql_UserName);
                $query_sigeiesUserName->execute();

                $consulta_sigeiesUserName = $query_sigeiesUserName->fetchAll(PDO::FETCH_ASSOC);

                $resultado = "Respondio Exitosamente Todo";

                foreach ($consulta_sigeiesUserName as $fila) {
                    if ($fila['AnswerEva_QualifyNum'] === null && $fila['AnswerEva_QualifyText'] === null) {
                        $resultado = "Preguntas Por Responder";
                        break;
                    }
                }

                if ($resultado === "Respondio Exitosamente Todo") {
                    $_SESSION['URL_Net']="Respondio Exitosamente Todo";
                    echo 'window.open("Fpdf/", "_blank");';                    
                } else {
                    echo 'alert("Preguntas Por Responder");';
                }
                ?>
            });
        </script>
  </div>
</main>

<?php
require_once 'includes/footer.php';
?>
