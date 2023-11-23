$('#tablemanagequestions').DataTable();
var tablemanagequestions;
document.addEventListener('DOMContentLoaded', function(){
    tablemanagequestions = $('#tablemanagequestions').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language":{
            "url":"//cdn.datatables.net/plug.ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url":"./models/cuestions/TableQuestions.php",
            "dataSrc":""
        },
        "columns":[
            {"data":"QuesEva_Id"},
            {"data":"QuesEva_Name"},
            {"data":"NomPeriodoSigedin"},
            {"data":"QuesEva_StatusIdText"},
            {"data":"acciones"}
        ],
        "responsive":true,
        "bDestroy":true,
        "iDisplayLength":10,
        "order":[[0,"asc"]]
    });
    var formQuestiones = document.querySelector('#formQuestiones');
    formQuestiones.onsubmit = function(e){
        e.preventDefault(); // Prevents the default submit action of the browser on submission of this form
        var idQuestions             = document.querySelector('#idQuestions').value;
        var nombreQuestions         = document.querySelector('#nombreQuestions').value;
        var periodoQuestions        = document.querySelector('#periodoQuestions').value;
        var statusQuestions         = document.querySelector('#statusQuestions').value;
        var PercentQuestions        = document.querySelector('#PercentQuestions').value;
        var ConfigQuestions         = document.querySelector('#ConfigQuestions').value;
        var fechaAperturaQuestions  = document.querySelector('#fechaAperturaQuestions').value;
        var horaAperturaQuestions   = document.querySelector('#horaAperturaQuestions').value;
        var fechaCierreQuestions    = document.querySelector('#fechaCierreQuestions').value;
        var horaCierreQuestions     = document.querySelector('#horaCierreQuestions').value;



        if (idQuestions==''){
            if(nombreQuestions =='' || statusQuestions =='' || periodoQuestions == '' || PercentQuestions =='' || ConfigQuestions == '' || fechaAperturaQuestions =='' || horaAperturaQuestions == '' || fechaCierreQuestions =='' || horaCierreQuestions == '' ){
                swal('Atencion','Todos los campos son necesarios','error');
                return false;
            }
        }else {
            if(nombreQuestions =='' || statusQuestions =='' || periodoQuestions == '' || PercentQuestions =='' || ConfigQuestions == '' || fechaAperturaQuestions =='' || horaAperturaQuestions == '' || fechaCierreQuestions =='' || horaCierreQuestions == ''){
                swal('Atencion','Todos los campos son necesarios','error');
                return false;
            }
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        var url = ('./models/cuestions/AjaxQuestions.php');
        var form = new FormData(formQuestiones);
        request.open('POST', url, true);
        request.send(form);
        request.onreadystatechange = function() {
            if(request.readyState === 4 && request.status ===200){
                var data = JSON.parse(request.responseText);
                if(request.status){
                    $('#modalQuestions').modal('hide');
                    formQuestiones.reset();
                    if (data.msg == "Ya exite un cuestionario con el mismo nombre" || data.msg == "Acción desconocida" || data.msg == "Error al ejecutar la consulta" || data.msg == "Petición inválida" ){
                        swal('Cuestionario',data.msg,'error');
                    }else{
                        swal('Cuestionario',data.msg,'success');
                    }
                    tablemanagequestions.ajax.reload();
                }else{
                    swal('Cuestionario',data.msg,'error');
                }
            }
        }
    }
})
function openModalEditQuestions(){
    formQuestiones.reset();
    $('#modalQuestions').modal('show');
}
function editQuestions(id){
    var idQuestions = id;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    var url = './models/cuestions/EditMaganeQuestions.php?idQuestions='+idQuestions;
    request.open('GET', url, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            var data = JSON.parse(request.responseText);
            if(data.status){
                document.querySelector('#idQuestions').value = data.data.QuesEva_Id;
                document.querySelector('#nombreQuestions').value = data.data.QuesEva_Name;
                document.querySelector('#periodoQuestions').value = data.data.QuesEva_IdPeriodo;
                document.querySelector('#statusQuestions').value = data.data.QuesEva_StatusId;

                document.querySelector('#ConfigQuestions').value = data.data.QuesEva_ConfigQuestionnaireId;
                document.querySelector('#PercentQuestions').value = data.data.QuesEva_Percent;

                document.querySelector('#fechaAperturaQuestions').value = data.data.QuesEva_DateOpen;
                document.querySelector('#horaAperturaQuestions').value = data.data.QuesEva_TimeOpen;
                document.querySelector('#fechaCierreQuestions').value = data.data.QuesEva_DateClose;
                document.querySelector('#horaCierreQuestions').value = data.data.QuesEva_TimeClose;

                $('#modalQuestions').modal('show');
            } else{
                swal('Atencion',data.msg,'error');
            }
        }
    }
}

function executeQuestions(idQuesEva, idQuesEvaConfigQuest, idPeriodo, idRolEvaluator, idRolEvaluated) {
    var modal = document.getElementById("myModal");
    var progressBar = document.getElementById("progressBar");

    // Mostrar la ventana modal
    $(modal).modal('show');

    var idQuestionsEva = idQuesEva;
    var idQuesEvaConfigQuestionnaire = idQuesEvaConfigQuest;
    var idQuesEvaidPeriodo = idPeriodo;
    var idQuesEvaidRolEvaluator = idRolEvaluator;
    var idQuesEvaidRolEvaluated = idRolEvaluated;

    // Objeto que contiene los datos a enviar
    var dataToSend = {
        idQuestionsEva: idQuestionsEva,
        idQuesEvaConfigQuestionnaire: idQuesEvaConfigQuestionnaire,
        idQuesEvaidPeriodo: idQuesEvaidPeriodo,
        idQuesEvaidRolEvaluator: idQuesEvaidRolEvaluator,
        idQuesEvaidRolEvaluated: idQuesEvaidRolEvaluated
    };

    var xhr = new XMLHttpRequest();
    xhr.open('POST', './models/cuestions/AjaxLoadAnswer.php', true);

    // Manejar el progreso de la solicitud AJAX
    xhr.upload.onprogress = function (e) {
        if (e.lengthComputable) {
            var progress = (e.loaded / e.total) * 100;
            progressBar.style.width = progress + '%';
        }
    };

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Ocultar la ventana modal cuando la solicitud se complete
                $(modal).modal('hide');

                // Manejar la respuesta del servidor aquí
                var data = JSON.parse(xhr.responseText);
                console.log(data);
                // Puedes hacer lo que necesites con la respuesta del servidor
            } else {
                // Manejar errores de la solicitud AJAX aquí
                console.error('Error en la solicitud AJAX:', xhr.statusText);
            }
        }
    };

    // Configurar el encabezado de la solicitud
    xhr.setRequestHeader('Content-Type', 'application/json');

    // Enviar la solicitud
    xhr.send(JSON.stringify(dataToSend));
}





function deleteQuestions(id) {
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
            executeDeleteDeleteQuestions(id);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            showAlert('Cancelado', 'Tu cuestionario está a salvo', 'error');
        }
    });
}

function showAlert(title, message, type) {
    Swal.fire(title, message, type);
}

function executeDeleteDeleteQuestions(id) {
    const formData = new FormData();
    formData.append('id', id);
    
    const request = new XMLHttpRequest();
    request.open('POST', './models/cuestions/AjaxDeleteQuestions.php', true);
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
        tablemanagequestions.ajax.reload();

        showAlert('¡Eliminado!', 'El cuestionario ha sido eliminado.', 'success')
            .then(() => {

            });
    } else {
        showAlert('Error', 'Ocurrió un error al intentar eliminar el cuestionario.', 'error');
    }
}
