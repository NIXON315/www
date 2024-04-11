<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once '../includes/conexion.php';

// Inicializar matrices
$NotasFinales = array();

// Query 1
$query1 = "SELECT `AnswerEva_UserNameEvaluated`, `AnswerEva_IdPeriod` FROM `sistema-escolar`.`EvaSys_AnswerEva` WHERE `AnswerEva_IdPeriod` ='44' GROUP BY `AnswerEva_UserNameEvaluated`;";
$result1 = $pdo_eva->query($query1);

while ($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {
    $UserNameEvaluated = $row1['AnswerEva_UserNameEvaluated'];

    // Inicializar variables para acumular notas
    $contadorEstudiantes = 0;
    $respuestasEstudiantes = array();

    $contadorDecano = 0;
    $respuestasDecano = array();

    $contadorCompromiso = 0;
    $respuestasCompromiso = array();

    $contadorAutoevaluacion = 0;
    $respuestasAutoevaluacion = array();

    // Inicializar variables para Sede y Facultad
    $Campus = '';
    $Faculty = '';

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
        ON (`EvaSys_AnswerEva`.`AnswerEva_UserNameEvaluated` = `EvaSys_Users`.`User_UserName`) WHERE `AnswerEva_UserNameEvaluated` = '$UserNameEvaluated' and `AnswerEva_IdPeriod` ='44' GROUP BY `AnswerEva_UserNameEvaluator`, `AnswerEva_IdCourse`, `AnswerEva_QuesEvaId`";
    $result2 = $pdo_eva->query($query2);

    while ($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
        $UserNameEvaluator = $row2['AnswerEva_UserNameEvaluator'];
        $QuesEvaId = $row2['AnswerEva_QuesEvaId'];

        // Actualizar Sede y Facultad
        $Campus = $row2['AnswerEva_Campus'];
        $Faculty = $row2['AnswerEva_Faculty'];

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
            , `AnswerEva_QualifyText`
            , `AnswerEva_QuesEvaId`
        FROM
            `sistema-escolar`.`EvaSys_AnswerEva` WHERE  `AnswerEva_UserNameEvaluated` = '$UserNameEvaluated' AND `AnswerEva_UserNameEvaluator` = '$UserNameEvaluator' AND `AnswerEva_GuysQuesId` ='3' AND `AnswerEva_IdPeriod` ='44' AND `AnswerEva_QuesEvaId` = $QuesEvaId  AND `AnswerEva_QualifyText` IS NOT NULL AND `AnswerEva_QualifyText` NOT IN ('', 'NULL', 'NaN');";
        $result3 = $pdo_eva->query($query3);

        while ($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {
            $AnswerEva_IdRolEvaluator = $row3['AnswerEva_IdRolEvaluator'];
            $QualifyText = $row3['AnswerEva_QualifyText'];

            // Acumular respuestas por tipo de evaluador
            switch ($AnswerEva_IdRolEvaluator) {
                case 1:
                    $contadorEstudiantes++;
                    $respuestasEstudiantes[] = $QualifyText;
                    break;
                case 17:
                    $contadorDecano++;
                    $respuestasDecano[] = $QualifyText;
                    if ($QuesEvaId == 13) {
                        $contadorCompromiso++;
                        $respuestasCompromiso[] = $QualifyText;
                    }
                    break;
                case 4:
                case 5:
                    $contadorAutoevaluacion++;
                    $respuestasAutoevaluacion[] = $QualifyText;
                    break;
            }
        }
    }

    $NotasFinales[] = [
        'Sede' => $Campus,
        'Facultad' => $Faculty,
        'Usuario Evaluado' => $UserNameEvaluated,
        'Respuestas Estudiantes' => implode(", ", array_unique($respuestasEstudiantes)),
        'Respuestas Autoevaluacion' => implode(", ", array_unique($respuestasAutoevaluacion)),
        'Respuestas Decano' => implode(", ", array_unique($respuestasDecano)),
        'Respuestas Compromiso Institucional' => implode(", ", array_unique($respuestasCompromiso)),
    ];
}

// Configurar cabeceras para generar archivo CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename=RespuestasAutoEvaluacion.csv');

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
