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
  ) WHERE    `EvaSys_ConfigQuestionnaire`.`ConfigQuestionnaire_Id`  = "' . $idAssignGroupCatQuest . '" GROUP BY   `EvaSys_CategoriOfQuestions`.`CatOfQues_Id`';

$query = $pdo_eva->query($sql);
$categori = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<main class="app-content">
  <div class="app-title">
    <div class="div">
      <h1><i class="fa fa-laptop"></i> <?php echo $nombreCuestionario; ?></h1>
      <p>Bootstrap Components</p>
    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="#">Bootstrap Elements</a></li>
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
            <p class="text-justify">Frente a cada una de las afirmaciones o preguntas, seleccione la opción según sea su grado de satisfacción, siendo cero(0) la calificación más baja, y cinco(5) la opción más alta. (Por favor no marque(seleccione más de una respuesta por pregunta y conteste las preguntas del cuestionario). Los resultados aportarán elementos para la evaluación integral y el mejoramiento del cuerpo profesional del Instituto Tecnológico del Putumayo (Esta información es anónima y totalmente confidencial y su uso está orientado al mejoramiento).</p>
          </div>
        </div>
      </div>
    </div>

    <?php foreach ($categori as $categoriQues): ?>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <h3 class="tile-title"><?php echo $categoriQues['CatOfQues_Name']; ?></h3>
        <?php
          $sql = '    SELECT
          `EvaSys_AnswerEva`.`AnswerEva_QuestionId`,
          `EvaSys_Questions`.`Questions_Name`,
          `EvaSys_Questions`.`Questions_Statement`,
          `EvaSys_AnswerEva`.`AnswerEva_IdRolEvaluator`,
          `EvaSys_AnswerEva`.`AnswerEva_CatOfQues_Id`
        FROM
          `sistema-escolar`.`EvaSys_AnswerEva`
          INNER JOIN `sistema-escolar`.`EvaSys_Questions`
            ON (
              `EvaSys_AnswerEva`.`AnswerEva_QuestionId` = `EvaSys_Questions`.`Questions_Id`
            )WHERE AnswerEva_UserNameEvaluator = 1000105388 AND AnswerEva_CatOfQues_Id = '.$categoriQues['CatOfQues_Id'].' GROUP BY AnswerEva_QuestionId ASC';

          $query = $pdo_eva->query($sql);
          $Questions = $query->fetchAll(PDO::FETCH_ASSOC);
          foreach ($Questions as $QuestionsTable):
            $cont = $contador++;
            $_SESSION['QuestionsIdGnerate'] =$QuestionsTable['AnswerEva_QuestionId'];
            $IdQuestions =$QuestionsTable['AnswerEva_QuestionId'];
        ?>

        <table class="table tabla-categoria" id="tableQuestionsAnswer_<?php echo $cont ?>" data-questionid="<?php echo $IdQuestions; ?>">
          <p><h5><?php echo "Pregunta ".$cont.":"; ?></h5><?php echo $QuestionsTable['Questions_Statement']; ?></p>
          <thead>
            <tr>
              <th style="inline-size: 40%;">Nombre del docente</th>
              <th style="inline-size: 45%;">Asignatura</th>
              <th style="inline-size: 12%;">Calificación</th>
              <th style="inline-size: 12%;">Guardar</th>
            </tr>
          </thead>
          <tbody>
            <!-- Aquí puedes agregar las filas de datos si es necesario -->
          </tbody>
        </table>
        <?php
          endforeach;
        ?>
      </div>
    </div>
  </div>
<?php endforeach; ?>

    <!-- Tabla Editable -->

    <!-- Fin Tabla Editable -->
  </div>
</main>

<?php
require_once 'includes/footer.php';
?>
