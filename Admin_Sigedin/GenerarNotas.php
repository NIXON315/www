<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once '../includes/conexion.php';

// Inicializar matrices
$NotasFinales = array();

// Query 1
$query1 = "SELECT `AnswerEva_UserNameEvaluated`, `AnswerEva_IdPeriod` FROM `sistema-escolar`.`EvaSys_AnswerEva` WHERE `AnswerEva_IdPeriod` ='43' GROUP BY `AnswerEva_UserNameEvaluated`;";
$result1 = $pdo_eva->query($query1);

while ($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
    $UserNameEvaluated = $row1['AnswerEva_UserNameEvaluated'];

    // Inicializar variables para acumular notas
    $contadorEstudiantes = 0;
    $promedioEstudiantes = 0;

    $contadorDecano = 0;
    $promedioDecano = 0;

    $contadorCompromiso = 0;
    $promedioCompromiso = 0;

    $contadorAutoevaluacion = 0;
    $promedioAutoevaluacion = 0;

    // Query 2
    $query2 = " SELECT
        `AnswerEva_Id`
        , `AnswerEva_UserNameEvaluator`
        , `AnswerEva_UserNameEvaluated`
        , `EvaSys_Users`.`User_Name`
        , `AnswerEva_IdPeriod`
        , `AnswerEva_IdCourse`
        , `AnswerEva_QuesEvaId`
        , `EvaSys_AnswerEva`.`AnswerEva_Campus`
        , `EvaSys_AnswerEva`.`AnswerEva_Faculty`
    FROM
        `sistema-escolar`.`EvaSys_AnswerEva`
    INNER JOIN `sistema-escolar`.`EvaSys_Users` 
        ON (`EvaSys_AnswerEva`.`AnswerEva_UserNameEvaluated` = `EvaSys_Users`.`User_UserName`) WHERE `AnswerEva_UserNameEvaluated` = '$UserNameEvaluated' and `AnswerEva_IdPeriod` ='43' GROUP BY `AnswerEva_UserNameEvaluator`, `AnswerEva_IdCourse`, `AnswerEva_QuesEvaId`";
    $result2 = $pdo_eva->query($query2);

    while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
        $UserNameEvaluator = $row2['AnswerEva_UserNameEvaluator'];
        $QuesEvaId = $row2['AnswerEva_QuesEvaId'];

        // Contar evaluaciones
        $contador2 = 0;
        $promedioPorEvaluador = array();

        $AuxNombreCompleto = $row2['User_Name'];
        $AuxCampus = $row2['AnswerEva_Campus'];
        $AuxFaculty = $row2['AnswerEva_Faculty'];

        if($AuxNombreCompleto !== 0 || $AuxNombreCompleto !== "" || $AuxNombreCompleto !== null){
            $NombreCompleto = $AuxNombreCompleto;
        }

        if($AuxCampus !== 0 || $AuxCampus !== "" || $AuxCampus !== null){
            $Campus = $AuxCampus;
        }

        if($AuxFaculty !== 0 || $AuxFaculty !== "" || $AuxFaculty !== null){
            $Faculty = $AuxFaculty;
        }

        // Query 3
        $query3 = "SELECT
        `AnswerEva_Id`
        , `AnswerEva_IdRolEvaluator`
        , `AnswerEva_UserNameEvaluator`
        , `AnswerEva_IdRolEvaluated`
        , `AnswerEva_UserNameEvaluated`
        , `AnswerEva_IdPeriod`
        , `AnswerEva_IdCourse`
        , `AnswerEva_CourseName`
        , `AnswerEva_GuysQuesId`
        , `AnswerEva_QualifyNum`
        , `AnswerEva_QuesEvaId`
    FROM
        `sistema-escolar`.`EvaSys_AnswerEva` WHERE  `AnswerEva_UserNameEvaluated` = '$UserNameEvaluated' AND `AnswerEva_UserNameEvaluator` = '$UserNameEvaluator' AND `AnswerEva_GuysQuesId` ='1' AND `AnswerEva_IdPeriod` ='43' AND `AnswerEva_QuesEvaId` = $QuesEvaId  AND `AnswerEva_QualifyNum` IS NOT NULL AND `AnswerEva_QualifyNum` != ''; ";
        $result3 = $pdo_eva->query($query3);

        while ($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {
            $AnswerEva_IdRolEvaluator = $row3['AnswerEva_IdRolEvaluator'];
            $QualifyNum = $row3['AnswerEva_QualifyNum'];




            // Lógica según AnswerEva_IdRolEvaluator y QuesEvaId
            $contador2++;
            $promedioPorEvaluador[] = $QualifyNum;

            // Acumular notas por tipo de evaluador
            switch ($AnswerEva_IdRolEvaluator) {
                case 1:
                    if ($QualifyNum!=="" || $QualifyNum!==null ){
                        $contadorEstudiantes++;
                        $promedioEstudiantes += $QualifyNum;
                    }
                    
                    break;
                case 17:
                    if ($QualifyNum!=="" || $QualifyNum!==null ){
                        $contadorDecano++;
                        $promedioDecano += $QualifyNum;
                        if ($QuesEvaId == 13) {
                            $contadorCompromiso++;
                            $promedioCompromiso += $QualifyNum;
                        }
                    }
                    
                    break;
                case 4:
                    if ($QualifyNum!=="" || $QualifyNum!==null ){
                        $contadorAutoevaluacion++;
                        $promedioAutoevaluacion += $QualifyNum;
                    }
                    
                    break;
                case 5:
                    if ($QualifyNum!=="" || $QualifyNum!==null ){
                        $contadorAutoevaluacion++;
                        $promedioAutoevaluacion += $QualifyNum;
                    }
                    
                    break;
            }
        }
    }

    
    // Calcular promedios finales
    $notaFinalEstudiantes = ($contadorEstudiantes > 0) ? number_format($promedioEstudiantes / $contadorEstudiantes, 2) : 0;
    $notaFinalAutoevaluacion = ($contadorAutoevaluacion > 0) ? number_format($promedioAutoevaluacion / $contadorAutoevaluacion, 2) : 0;
    $notaFinalDecano = ($contadorDecano > 0) ? number_format($promedioDecano / $contadorDecano, 2) : 0;
    $notaFinalCompromiso = ($contadorCompromiso > 0) ? number_format($promedioCompromiso / $contadorCompromiso, 2) : 0;

    // Calcular la nota final total (combinación ponderada)
    $notaFinalTotal = ($notaFinalEstudiantes * 0.3) + ($notaFinalAutoevaluacion * 0.2) + ($notaFinalDecano * 0.3) + ($notaFinalCompromiso * 0.2);

    $NotasFinales[] = [
        'Sede' => $Campus,
        'Facultad' => $Faculty,
        'Usuario Evaluado' => $UserNameEvaluated,
        'Nombre Del Evaluado' => $NombreCompleto,
        'Nota Final Estudiantes' => $notaFinalEstudiantes,
        'Nota Final Autoevaluacion' => $notaFinalAutoevaluacion,
        'Nota Final Decano' => $notaFinalDecano,
        'Nota Final Compromiso Institucional' => $notaFinalCompromiso,
        'Total Nota Final' => number_format($notaFinalTotal, 2), // aquí va la nota final total
    ];
}

// Configurar cabeceras para generar archivo CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename=NotasAutoEvaluacion.csv');

// Abrir el flujo de salida CSV directamente al navegador
$csvFile = fopen('php://output', 'w');

// Escribir las cabeceras CSV
fputcsv($csvFile, array_keys($NotasFinales[0]));

// Escribir los datos CSV
foreach ($NotasFinales as $row) {
    fputcsv($csvFile, $row);
}

// Cerrar el flujo de salida CSV
fclose($csvFile);

exit;
?>
