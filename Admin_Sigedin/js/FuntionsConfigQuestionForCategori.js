$('#tableQuestionForCategori').DataTable();
var tableQuestionForCategori;
document.addEventListener('DOMContentLoaded', function(){
    tableQuestionForCategori = $('#tableQuestionForCategori').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug.ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url":"./models/cuestions/TableConfigQuestionForCategori.php",
            "dataSrc": ""
        },
        "columns": [
            {"data": "GroupCatQues_Id"},
            {"data": "NameQuestion"},
            {"data": "acciones"}
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });
    var formQuestionForCategori = document.querySelector('#formQuestionForCategori');
    formQuestionForCategori.onsubmit = function(e){
        e.preventDefault(); // Previene la acción de envío por defecto del navegador al enviar el formulario
        var idConfigQuestionnaireCat = window.idConfigQuestionnaireCatAux;
        var idCategoriOfQuestions = document.querySelector('#idCategoriOfQuestions').value;

        if (idCategoriOfQuestions == ''){
            if (nombreQuestionForCategorit == '') {
                swal('Atención', 'Todos los campos son necesarios', 'error');
                return false;
            }
        }

        // Crear una nueva instancia de XMLHttpRequest
        var request = new XMLHttpRequest();

        // URL del script PHP
        var url = './models/cuestions/AjaxConfigQuestionForCategori.php';

        // Crear un objeto FormData y agregar los datos que deseas enviar
        var formData = new FormData(formQuestionForCategori);
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
                    $('#modalConfigQuestionForCategori').modal('hide');
                    formQuestionForCategori.reset();
                    if (data.msg == "Ya exite una configuración Tipo de Preguntas con el mismo nombre" || data.msg == "Todos los datos son necesarios" || data.msg == "Acción desconocida" || data.msg == "Error al ejecutar la consulta" || data.msg == "Petición inválida") {
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
function openModalQuestionForCategori(){
    formQuestionForCategori.reset();
    $('#modalConfigQuestionForCategori').modal('show');
}

function editQuestionForCategori(id) {
    var idQuestionForCategorit = id;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    var url = './models/cuestions/EditConfigQuestionForCategori.php?idQuestionForCategorit=' + idQuestionForCategorit;
    request.open('GET', url, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var data = JSON.parse(request.responseText);
            if (data.status) {
                // Realiza las acciones necesarias aquí, como llenar un formulario o mostrar datos.

                $('#modalConfigQuestionForCategori').modal('show');
            } else {
                swal('Atencion', data.msg, 'error');
            }
        }
    }
}



function deleteQuestionForCategori(id) {
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
            executeDeleteQuestionForCategori(id);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            showAlert('Cancelado', 'La configuración Tipo de Preguntas está a salvo', 'error');
        }
    });
}

function showAlert(title, message, type) {
    Swal.fire(title, message, type);
}

function executeDeleteQuestionForCategori(id) {
    const formData = new FormData();
    formData.append('id', id);
    
    const request = new XMLHttpRequest();
    request.open('POST', './models/cuestions/AjaxDeleteQuestionForCategori.php', true);
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
        tableQuestionForCategori.ajax.reload();
        showAlert('¡Eliminado!', 'La configuración Tipo de Preguntas ha sido eliminado.', 'success');
    } else {
        showAlert('Error', 'Ocurrió un error al intentar eliminar La configuración Tipo de Preguntas.', 'error');
    }
}
