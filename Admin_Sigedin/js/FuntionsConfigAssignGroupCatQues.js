$('#tableAssignGroupCatQues').DataTable();
var tableAssignGroupCatQues;
document.addEventListener('DOMContentLoaded', function(){
    tableAssignGroupCatQues = $('#tableAssignGroupCatQues').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug.ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url":"./models/cuestions/TableConfigAssignGroupCatQues.php",
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
    var formAssignGroupCatQues = document.querySelector('#formAssignGroupCatQues');
    formAssignGroupCatQues.onsubmit = function(e){
        e.preventDefault(); // Previene la acción de envío por defecto del navegador al enviar el formulario
        var idConfigQuestionnaireCat = window.idConfigQuestionnaireCatAux;
        var idCategoriOfQuestions = document.querySelector('#idCategoriOfQuestions').value;

        if (idCategoriOfQuestions == ''){
            if (nombreAssignGroupCatQuest == '') {
                swal('Atención', 'Todos los campos son necesarios', 'error');
                return false;
            }
        }

        // Crear una nueva instancia de XMLHttpRequest
        var request = new XMLHttpRequest();

        // URL del script PHP
        var url = './models/cuestions/AjaxConfigAssignGroupCatQues.php';

        // Crear un objeto FormData y agregar los datos que deseas enviar
        var formData = new FormData(formAssignGroupCatQues);
        formData.append('idConfigQuestionnaireCat', idConfigQuestionnaireCat); // Agregar idConfigQuestionnaireCat

        // Configurar la solicitud
        request.open('POST', url, true);

        // Enviar los datos
        request.send(formData);

        // Manejar la respuesta
        request.onreadystatechange = function() {
            if (request.readyState === 4 && request.status === 200) {
                var data = JSON.parse(request.responseText);
                if (request.status) {
                    $('#modalAssignGroupCatQues').modal('hide');
                    formAssignGroupCatQues.reset();
                    if (data.msg == "Ya exite una configuración Tipo de Preguntas con el mismo nombre" || data.msg == "Todos los datos son necesarios" || data.msg == "Acción desconocida" || data.msg == "Error al ejecutar la consulta" || data.msg == "Petición inválida") {
                        swal('Configuración Tipo de Preguntas', data.msg, 'error');
                    } else {
                        swal('Configuración Tipo de Preguntas', data.msg, 'success');
                    }
                    tableAssignGroupCatQues.ajax.reload();
                } else {
                    swal('Configuración Tipo de Preguntas', data.msg, 'error');
                }
            }
        }
    }

})
function openModalAssignGroupCatQues(){
    formAssignGroupCatQues.reset();
    $('#modalAssignGroupCatQues').modal('show');
}

function editAssignGroupCatQues(id) {
    var idAssignGroupCatQuest = id;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    var url = './models/cuestions/EditConfigAssignGroupCatQues.php?idAssignGroupCatQuest=' + idAssignGroupCatQuest;
    request.open('GET', url, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var data = JSON.parse(request.responseText);
            if (data.status) {
                // Realiza las acciones necesarias aquí, como llenar un formulario o mostrar datos.

                $('#modalAssignGroupCatQues').modal('show');
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




function deleteAssignGroupCatQues(id) {
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
            executeDeleteAssignGroupCatQues(id);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            showAlert('Cancelado', 'La configuración Tipo de Preguntas está a salvo', 'error');
        }
    });
}

function showAlert(title, message, type) {
    Swal.fire(title, message, type);
}

function executeDeleteAssignGroupCatQues(id) {
    const formData = new FormData();
    formData.append('id', id);
    
    const request = new XMLHttpRequest();
    request.open('POST', './models/cuestions/AjaxDeleteAssignGroupCatQues.php', true);
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            handleDeleteResponse(request.responseText);
        }
    };
    request.send(formData);
}

function handleDeleteResponse(responseText) {
    const data = JSON.parse(responseText);
    if (data.status) {
        tableAssignGroupCatQues.ajax.reload();
        showAlert('¡Eliminado!', 'La configuración Tipo de Preguntas ha sido eliminado.', 'success');
    } else {
        showAlert('Error', 'Ocurrió un error al intentar eliminar La configuración Tipo de Preguntas.', 'error');
    }
}
