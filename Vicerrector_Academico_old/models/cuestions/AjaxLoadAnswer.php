<?php
session_start();

require_once '../../../includes/conexion.php';

// Verificar si se recibieron datos POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados desde JavaScript
    $data = json_decode(file_get_contents("php://input"));

    // Verificar si los datos se recibieron correctamente
    if ($data && isset($data->idQuestionsEva) && isset($data->idQuesEvaConfigQuestionnaire) && isset($data->idQuesEvaidPeriodo) && isset($data->idQuesEvaidRolEvaluator) && isset($data->idQuesEvaidRolEvaluated)) {
        // Acceder a los datos
        $idQuestionsEva = $data->idQuestionsEva;
        $idQuesEvaConfigQuestionnaire = $data->idQuesEvaConfigQuestionnaire;
        $idQuesEvaidPeriodo = $data->idQuesEvaidPeriodo;
        $idQuesEvaidRolEvaluator = $data->idQuesEvaidRolEvaluator;
        $idQuesEvaidRolEvaluated = $data->idQuesEvaidRolEvaluated;
        $fechaActual = date("y-m-d");

        // Consultar la base de datos



        switch ($idQuesEvaidRolEvaluator) {
            case 1:
                $sqlViewsEva = 'SELECT * FROM VISTA_EVADOCENTE ORDER BY ID_ESTUDIANTE';
                $queryViewsEva = $pdo_sigeies->prepare($sqlViewsEva);
                $queryViewsEva->execute();
                $consultaViewsEva = $queryViewsEva->fetchAll(PDO::FETCH_ASSOC);
        
                for($i = 0; $i < count($consultaViewsEva);$i++){
                    $sql = 'SELECT
                    `EvaSys_GroupCatQues`.`GroupCatQues_Id`,
                    `EvaSys_ConfigQuestionnaire`.`ConfigQuestionnaire_Id`,
                    `EvaSys_ConfigQuestionnaire`.`ConfigQuestionnaire_Name`,
                    `EvaSys_CategoriOfQuestions`.`CatOfQues_Id`,
                    `EvaSys_CategoriOfQuestions`.`CatOfQues_Name`,
                    `EvaSys_Questions`.`Questions_Id`,
                    `EvaSys_Questions`.`Questions_Name`,
                    `EvaSys_Questions`.`Questions_Statement`,
                    `EvaSys_ConfigQuestionnaire`.`ConfigQuestionnaire_IdRolEvaluator`,
                    `EvaSys_ConfigQuestionnaire`.`ConfigQuestionnaire_IdRolEvaluated`,
                    `EvaSys_GuysQues`.`GuysQues_Id`
                    FROM
                    `sistema-escolar`.`EvaSys_GroupCatQues`
                    INNER JOIN `sistema-escolar`.`EvaSys_ConfigQuestionnaire`
                        ON (
                        `EvaSys_GroupCatQues`.`ConfigQuestionnaire_Id` = `EvaSys_ConfigQuestionnaire`.`ConfigQuestionnaire_Id`
                        )
                    INNER JOIN `sistema-escolar`.`EvaSys_CategoriOfQuestions`
                        ON (
                        `EvaSys_GroupCatQues`.`CatOfQues_Id` = `EvaSys_CategoriOfQuestions`.`CatOfQues_Id`
                        )
                    INNER JOIN `sistema-escolar`.`EvaSys_Questions`
                        ON (
                        `EvaSys_GroupCatQues`.`Questions_Ids` = `EvaSys_Questions`.`Questions_Id`
                        )
                    INNER JOIN `sistema-escolar`.`EvaSys_GuysQues`
                        ON (
                        `EvaSys_Questions`.`Questions_GuysId` = `EvaSys_GuysQues`.`GuysQues_Id`
                        ) WHERE  `EvaSys_ConfigQuestionnaire`.`ConfigQuestionnaire_Id` = ?';

                    $query = $pdo_eva->prepare($sql);
                    $query->execute([$idQuesEvaConfigQuestionnaire]);
                    $consulta = $query->fetchAll(PDO::FETCH_ASSOC);
                    for($j = 0; $j < count($consulta);$j++){
                        if ($consulta[$j]['ConfigQuestionnaire_IdRolEvaluator'] == "1"){
                            $evaluator = $consultaViewsEva[$i]['ID_ESTUDIANTE'];
                        }

                        if ($consulta[$j]['ConfigQuestionnaire_IdRolEvaluated'] == "2"){
                            $evaluated = $consultaViewsEva[$i]['ID_DOCENTE'];
                        }
                        $sqlInsert    = 'INSERT INTO EvaSys_AnswerEva (
                            AnswerEva_IdRolEvaluator, 
                            AnswerEva_UserNameEvaluator, 
                            AnswerEva_IdRolEvaluated, 
                            AnswerEva_UserNameEvaluated, 
                            AnswerEva_IdPeriod, 
                            AnswerEva_QuesEvaId, 
                            AnswerEva_CatOfQues_Id, 
                            AnswerEva_QuestionId, 
                            AnswerEva_GuysQuesId, 
                            AnswerEva_QualifyNum, 
                            AnswerEva_QualifyText, 
                            AnswerEva_IdCourse, 
                            AnswerEva_CourseName, 
                            AnswerEva_Campus, 
                            AnswerEva_Faculty, 
                            AnswerEva_StatusId ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
                        $queryInsert  = $pdo_eva->prepare($sqlInsert);
                        $request = $queryInsert->execute(array(
                            $consulta[$j]['ConfigQuestionnaire_IdRolEvaluator'],
                            $evaluator,
                            $consulta[$j]['ConfigQuestionnaire_IdRolEvaluated'],
                            $evaluated,
                            $idQuesEvaidPeriodo,
                            $idQuestionsEva,
                            $consulta[$j]['CatOfQues_Id'],
                            $consulta[$j]['Questions_Id'],
                            $consulta[$j]['GuysQues_Id'],
                            null,
                            null,
                            $consultaViewsEva[$i]['COD_ASIGNATURA'],
                            $consultaViewsEva[$i]['ASIGNATURA'],
                            $consultaViewsEva[$i]['NOMBRE_SEDE'],
                            $consultaViewsEva[$i]['NOM_FACULTAD'],
                            "1"
                        ));
                        $accion = 1;
                    }
                }
                break;
        
            case 2:

                break;
        
            case 3:

                break;
            
            case 4:

                break;
            
            case 5:

                break;
            
            case 6:

                break;
        
            case 7:

                break;
        
            case 3:

                break;
            
            case 3:

                break;
            
            case 3:

                break;
            
            case 3:

                break;

            default:
                echo "La opción no coincide con ninguna de las anteriores";
                break;
        }


       

    } else {
        // Enviar una respuesta de error si los datos no son válidos
        header('HTTP/1.1 400 Bad Request');
        echo json_encode(array('mensaje' => 'Datos no válidos'));
    }
} else {
    // Enviar una respuesta de error si no se recibió una solicitud POST
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(array('mensaje' => 'Método no permitido'));
}
?>
