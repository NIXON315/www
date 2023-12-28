<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once '../includes/conexion.php';

// Inicializar matrices
$NotaFinalEstudiantes = array();
$NotaFinalDecano = array();
$NotaFinalDecanoCompromisoInstitucional = array();
$NotaFinalAutoEvaluacion = array();

// Query 1
$query1 = "SELECT `AnswerEva_UserNameEvaluated`, `AnswerEva_IdPeriod` FROM `sistema-escolar`.`EvaSys_AnswerEva` WHERE `AnswerEva_IdPeriod` ='43' GROUP BY `AnswerEva_UserNameEvaluated`;";
$result1 = $pdo_eva->query($query1);

while ($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
    $UserNameEvaluated = $row1['AnswerEva_UserNameEvaluated'];

    // Contar evaluadores
    $contador1 = 0;

    // Query 2
    $query2 = "SELECT `AnswerEva_Id`, `AnswerEva_UserNameEvaluated`, `AnswerEva_UserNameEvaluator`, `AnswerEva_IdPeriod`, `AnswerEva_IdCourse`, `AnswerEva_QuesEvaId` FROM `sistema-escolar`.`EvaSys_AnswerEva` WHERE `AnswerEva_UserNameEvaluated` = '$UserNameEvaluated' and `AnswerEva_IdPeriod` ='43' GROUP BY `AnswerEva_UserNameEvaluator`, `AnswerEva_IdCourse`, `AnswerEva_QuesEvaId`";
    $result2 = $pdo_eva->query($query2);

    while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
        $UserNameEvaluator = $row2['AnswerEva_UserNameEvaluator'];
        $QuesEvaId = $row2['AnswerEva_QuesEvaId'];

        // Contar evaluaciones
        $contador2 = 0;
        $promedioPorEvaluador = array();

        // Query 3
        $query3 = "SELECT `AnswerEva_Id`, `AnswerEva_IdRolEvaluator`, `AnswerEva_UserNameEvaluator`, `AnswerEva_IdRolEvaluated`, `AnswerEva_UserNameEvaluated`, `AnswerEva_IdPeriod`, `AnswerEva_IdCourse`, `AnswerEva_CourseName`, `AnswerEva_GuysQuesId`, `AnswerEva_QualifyNum` FROM `sistema-escolar`.`EvaSys_AnswerEva` WHERE `AnswerEva_UserNameEvaluated` = '$UserNameEvaluated' AND `AnswerEva_UserNameEvaluator` = '$UserNameEvaluator' AND `AnswerEva_GuysQuesId` ='1' AND `AnswerEva_IdPeriod` ='43' AND `AnswerEva_QuesEvaId` = $QuesEvaId;";
        $result3 = $pdo_eva->query($query3);

        while ($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {
            $AnswerEva_IdRolEvaluator = $row3['AnswerEva_IdRolEvaluator'];
            $QualifyNum = $row3['AnswerEva_QualifyNum'];

            // Lógica según AnswerEva_IdRolEvaluator y QuesEvaId
            if ($AnswerEva_IdRolEvaluator == 1) {
                $contador2++;
                $promedioPorEvaluador[] = $QualifyNum;
            } elseif ($AnswerEva_IdRolEvaluator == 17 && $QuesEvaId == 12) {
                $contador2++;
                $promedioPorEvaluador[] = $QualifyNum;
            } elseif ($AnswerEva_IdRolEvaluator == 17 && $QuesEvaId == 13) {
                $contador2++;
                $promedioPorEvaluador[] = $QualifyNum;
            } elseif ($AnswerEva_IdRolEvaluator == 4 || $AnswerEva_IdRolEvaluator == 5) {
                $contador2++;
                $promedioPorEvaluador[] = $QualifyNum;
            }
        }

        // Calcular promedio
        $NotaFinal = ($contador2 > 0) ? array_sum($promedioPorEvaluador) / $contador2 : 0;

        // Almacenar resultados en la matriz correspondiente
        if ($AnswerEva_IdRolEvaluator == 1) {
            $NotaFinalEstudiantes[] = ['Estudiantes', $UserNameEvaluated, $NotaFinal];
        } elseif ($AnswerEva_IdRolEvaluator == 17 && $QuesEvaId == 12) {
            $NotaFinalDecano[] = ['Decano', $UserNameEvaluated, $NotaFinal];
        } elseif ($AnswerEva_IdRolEvaluator == 17 && $QuesEvaId == 13) {
            $NotaFinalDecanoCompromisoInstitucional[] = ['Compromiso Institucional', $UserNameEvaluated, $NotaFinal];
        } elseif ($AnswerEva_IdRolEvaluator == 4 || $AnswerEva_IdRolEvaluator == 5) {
            $NotaFinalAutoEvaluacion[] = ['Autoevaluación', $UserNameEvaluated, $NotaFinal];
        }
    }
}

// Configurar cabeceras para generar archivo CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename=NotasAutoEvaluacion.csv');

// Abrir el flujo de salida CSV directamente al navegador
$csvFile = fopen('php://output', 'w');

// Escribir las cabeceras CSV
fputcsv($csvFile, ['Usuario Evaluado', 'Nota Final Estudiantes', 'Nota Final Autoevaluacion', 'Nota Final Decano', 'Nota Final Compromiso Institucional']);

// Escribir los datos CSV
foreach ($NotaFinalAutoEvaluacion as $row) {
    fputcsv($csvFile, $row);
}

// Cerrar el flujo de salida CSV
fclose($csvFile);

exit;
?>
