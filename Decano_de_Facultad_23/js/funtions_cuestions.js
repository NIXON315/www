var tableQuestionsAnswer;

document.addEventListener('DOMContentLoaded', function () {
    $('table[id^="tableQuestionsAnswer_"]').each(function () {
        var table = $(this);
        var questionId = table.data('questionid'); // Obtén questionId dentro del bucle
        console.log(questionId);

        fetch("./models/cuestions/TableQuestionsAnswer.php", {
            method: 'POST', // Puedes ajustar el método HTTP según tus necesidades
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ questionId: questionId })
        })
        .then(response => response.json())
        .then(data => {
            // Procesa los datos de respuesta aquí y configura la tabla DataTables si es necesario
            console.log(data);
            
            table.DataTable({
                "aProcessing": true,
                "aServerSide": true,
                "data": data, // Puedes asignar directamente los datos de respuesta a la tabla DataTables
                "columns": [
                    {"data": "NameUser"},
                    {"data": "Qualify"},
                    {"data": "accion"}
                ],
                "responsive": true,
                "bDestroy": true,
                "iDisplayLength": 10,
                "order": [[0, "asc"]],
                "createdRow": function (row, data, dataIndex) {
                            // Obtener el número de fila par/impar
                    var evenOdd = dataIndex % 2 === 0 ? 'even' : 'odd';
            
                    // Asignar una clase CSS a la fila
                    $(row).addClass(evenOdd);
            
                    // Asignar un color de fila basado en el índice
                    if (dataIndex % 4 === 0) {
                        $(row).addClass('table-info');
                    } else if (dataIndex % 4 === 1) {
                        $(row).addClass('table-success');
                    } else if (dataIndex % 4 === 2) {
                        $(row).addClass('table-danger');
                    } else if (dataIndex % 4 === 3) {
                        $(row).addClass('table-warning');
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error en la solicitud Fetch:', error);
        });
    });
});

function openModalCuestions() {
    $('#modalCuestions').modal('show');
}

function saveAnswer(answerId, questionId, guysQuesId) {
    const qualifyField = document.getElementById('qualify_' + answerId);
    console.log(guysQuesId);
    let qualifyValue;
    if (guysQuesId === 1) {
      console.log("R1");

      qualifyValue = parseFloat(qualifyField.value);
    }else{
      console.log("R2");

      qualifyValue = qualifyField.value;
    }
    console.log(qualifyValue);

    if (guysQuesId === 1) {
      if (isNaN(qualifyValue) || qualifyValue < 0 || qualifyValue > 5) {
        alert('La calificación debe estar entre 0 y 5.');
        return;
      }
    }
  
    // Desactiva el campo de entrada y el botón
    qualifyField.disabled = true;
    const saveButton = document.querySelector('button[onclick="saveAnswer(' + answerId + ',' + questionId + ',' + guysQuesId + ')"');
    const naButton = document.querySelector('button[onclick="saveAnswerNA(' + answerId + ',' + questionId + ',' + guysQuesId + ')"');
    saveButton.disabled = true;
    if(naButton !== null){
      naButton.disabled = true;
    }

    // Envía los datos al servidor mediante una solicitud AJAX (usando jQuery en este ejemplo).
    $.ajax({
      type: 'POST',
      url: './models/cuestions/AjaxSaveAnswer.php',
      data: {
        answerId: answerId,
        questionId: questionId,
        guysQuesId: guysQuesId,
        qualifyValue: qualifyValue,
      },
      success: function (response) {
        // Manejar la respuesta del servidor si es necesario
      },
      error: function (error) {
        // Manejar errores si es necesario
        console.error(error);
      },
    });
  }

  function saveAnswerNA(answerId, questionId, guysQuesId) {
    const qualifyField = document.getElementById('qualify_' + answerId);
  
    // Enviar "NA" al servidor
    const qualifyValue = "NA";
  
    // Desactivar el campo de entrada
    qualifyField.disabled = true;
  
    // Desactivar el botón de guardar y el botón "No Aplica"
    const saveButton = document.querySelector('button[onclick="saveAnswer(' + answerId + ',' + questionId + ',' + guysQuesId + ')"');
    const naButton = document.querySelector('button[onclick="saveAnswerNA(' + answerId + ',' + questionId + ',' + guysQuesId + ')"');
    saveButton.disabled = true;
    naButton.disabled = true;
  
    // Envía los datos al servidor mediante una solicitud AJAX (usando jQuery en este ejemplo).
    $.ajax({
      type: 'POST',
      url: './models/cuestions/AjaxSaveAnswerNA.php',
      data: {
        answerId: answerId,
        questionId: questionId,
        guysQuesId: guysQuesId,
        qualifyValue: qualifyValue,
      },
      success: function (response) {
        // Manejar la respuesta del servidor si es necesario
      },
      error: function (error) {
        // Manejar errores si es necesario
        console.error(error);
      },
    });
  }