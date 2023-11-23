$('#tableAssignQuestions').DataTable();
var tableAssignQuestions;
document.addEventListener('DOMContentLoaded', function(){
    tableAssignQuestions = $('#tableAssignQuestions').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug.ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url":"./models/cuestions/TableConfigAssignQuestions.php",
            "dataSrc": ""
        },
        "columns": [
            {"data": "GroupCatQues_Id"},
            {"data": "NameConfigQuestionnaire"},
            {"data": "acciones"}
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });
    var formAssignQuestions = document.querySelector('#formAssignQuestions');
    formAssignQuestions.onsubmit = function(e){
        e.preventDefault(); // Previene la acción de envío por defecto del navegador al enviar el formulario
        var idConfigQuestionnaireCat = window.idConfigQuestionnaAux;
        var idConfigQuestionForCategoriCat = window.idConfigQuestionForCategoriAux;


        var idQuestions = document.querySelector('#idQuestions').value;
        if (idQuestions == ''){
                swal('Atención', 'Todos los campos son necesarios', 'error');
                return false;
        }


        // Crear una nueva instancia de XMLHttpRequest
        var request = new XMLHttpRequest();

        // URL del script PHP
        var url = './models/cuestions/AjaxConfigAssignQuestions.php';

        // Crear un objeto FormData y agregar los datos que deseas enviar
        var formData = new FormData(formAssignQuestions);
        formData.append('idConfigQuestionnaireCat', idConfigQuestionnaireCat); // Agregar idConfigQuestionnaireCat
        formData.append('idConfigQuestionForCategoriCat', idConfigQuestionForCategoriCat); // Agregar idConfigQuestionForCategoriCat

        // Configurar la solicitud
        request.open('POST', url, true);

        // Enviar los datos
        request.send(formData);

        // Manejar la respuesta
        request.onreadystatechange = function() {
            if (request.readyState === 4 && request.status === 200) {
                var data = JSON.parse(request.responseText);
                if (request.status) {
                    $('#modalAssignQuestions').modal('hide');
                    tableQuestionForCategori.ajax.reload();
                    if (data.msg == "Ya existe una configuración Tipo de Preguntas con el mismo nombre" || data.msg == "Todos los datos son necesarios" || data.msg == "Acción desconocida" || data.msg == "Error al ejecutar la consulta" || data.msg == "Petición inválida") {
                        swal('Configuración Tipo de Preguntas', data.msg, 'error');
                    } else {
                        swal('Configuración Tipo de Preguntas', data.msg, 'success');
                    }
                    tableQuestionForCategori.ajax.reload();
                } else {
                    swal('Configuración Tipo de Preguntas', data.msg, 'error');
                }
            }
        }
    }

})
function openModalAssignQuestions(){
    var idConfigQuestionna = document.querySelector('#idConfigQuestionna').value;
    var idConfigQuestionForCategori = document.querySelector('#idConfigQuestionForCategori').value;


    window.idConfigQuestionnaAux = idConfigQuestionna;
    window.idConfigQuestionForCategoriAux = idConfigQuestionForCategori;

    tableAssignQuestions.ajax.reload();
    $('#modalAssignQuestions').modal('show');
}

function editAssignQuestions(id) {
    var idAssignQuestionst = id;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    var url = './models/cuestions/EditConfigAssignQuestions.php?idAssignQuestionst=' + idAssignQuestionst;
    request.open('GET', url, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var data = JSON.parse(request.responseText);
            if (data.status) {
                // Realiza las acciones necesarias aquí, como llenar un formulario o mostrar datos.

                $('#modalAssignQuestions').modal('show');
            } else {
                swal('Atencion', data.msg, 'error');
            }
        }
    }
}


function configureQuestionsForCategori(IdCatOfQues,IdConfigQuestionnaires){
    
    var idConfigQuestionForCategori = IdCatOfQues;
    var idConfigQuestionnaire = IdConfigQuestionnaires;


    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");

    var url = './models/cuestions/EditConfigQuestionForCategori.php?idConfigQuestionForCategori=' + idConfigQuestionForCategori + '&idConfigQuestionnaire=' + idConfigQuestionnaire;

    request.open('GET', url, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            var data = JSON.parse(request.responseText);
            if(data.status && data.configQuestionForCategori && data.configQuestionnaire ){
                document.querySelector('#idConfigQuestionForCategori').value = data.configQuestionForCategori.CatOfQues_Id;
                document.querySelector('#nombreConfigQuestionForCategori').value = data.configQuestionForCategori.CatOfQues_Name;

                document.querySelector('#idConfigQuestionna').value = data.configQuestionnaire.ConfigQuestionnaire_Id;
                document.querySelector('#nombreConfigQuestionna').value = data.configQuestionnaire.ConfigQuestionnaire_Name;





                var table = $('#tableQuestionForCategori').DataTable();

                table.ajax.url('./models/cuestions/TableConfigQuestionForCategori.php?idQuestionForCategorit=' + idConfigQuestionForCategori + '&idConfigQuestionnaire=' + idConfigQuestionnaire).load();

                $('#modalConfigQuestionForCategori').modal('show');
            } else {
                swal('Atencion q', data.msg, 'error');
            }
        }
    }
}




function deleteAssignQuestions(id) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });
    
    swalWithBootstrapButtons.fire({
        title: '¿Está seguro?',
        text: '¡No podrás revertir esto!',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '¡Sí, bórralo!',
        cancelButtonText: '¡No, Cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            executeDeleteAssignQuestions(id);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            showAlert('Cancelado', 'La configuración Tipo de Preguntas está a salvo', 'error');
        }
    });
}

function showAlert(title, message, type) {
    Swal.fire(title, message, type);
}

function executeDeleteAssignQuestions(id) {
    const formData = new FormData();
    formData.append('id', id);
    
    const request = new XMLHttpRequest();
    request.open('POST', './models/cuestions/AjaxDeleteAssignQuestions.php', true);
    tableQuestionForCategori.ajax.reload();
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            tableQuestionForCategori.ajax.reload();
            handleDeleteResponse(request.responseText);
        }
    };
    request.send(formData);
}

function handleDeleteResponse(responseText) {
    const data = JSON.parse(responseText);
    if (data.status) {
        tableAssignQuestions.ajax.reload();
        showAlert('¡Eliminado!', 'La configuración Tipo de Preguntas ha sido eliminado.', 'success');
    } else {
        showAlert('Error', 'Ocurrió un error al intentar eliminar La configuración Tipo de Preguntas.', 'error');
    }
}
