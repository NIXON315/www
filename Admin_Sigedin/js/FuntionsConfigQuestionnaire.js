$('#tableConfigQuestionnaire').DataTable();
var tableConfigQuestionnaire;
document.addEventListener('DOMContentLoaded', function(){
    tableConfigQuestionnaire = $('#tableConfigQuestionnaire').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language":{
            "url":"//cdn.datatables.net/plug.ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url":"./models/cuestions/TableConfigQuestionnaire.php",
            "dataSrc":""
        },
        "columns":[
            {"data":"ConfigQuestionnaire_Id"},
            {"data":"ConfigQuestionnaire_Name"},
            {"data":"NameEvaluator"},
            {"data":"NameEvaluated"},
            {"data":"ConfigQuestionnaire_StatusId"},
            {"data":"acciones"}
        ],
        "responsive":true,
        "bDestroy":true,
        "iDisplayLength":10,
        "order":[[0,"asc"]]
    });
    var formConfigQuestionnaire = document.querySelector('#formConfigQuestionnaire');
    formConfigQuestionnaire.onsubmit = function(e){
        e.preventDefault(); // Prevents the default submit action of the browser on submission of this form
        var idConfigQuestionnaire             = document.querySelector('#idConfigQuestionnaire').value;
        var nombreConfigQuestionnaire         = document.querySelector('#nombreConfigQuestionnaire').value;
        var statusConfigQuestionnaire         = document.querySelector('#statusConfigQuestionnaire').value;
        var evaluadorConfigQuestionnaire      = document.querySelector('#evaluadorConfigQuestionnaire').value;
        var evaluadoConfigQuestionnaire       = document.querySelector('#evaluadoConfigQuestionnaire').value;


        if (idConfigQuestionnaire==''){
            if(nombreConfigQuestionnaire =='' || statusConfigQuestionnaire =='' || evaluadorConfigQuestionnaire =='' || evaluadoConfigQuestionnaire == ''   ){
                swal('Atencion','Todos los campos son necesarios','error');
                return false;
            }
        }else {
            if(nombreConfigQuestionnaire =='' || statusConfigQuestionnaire =='' || evaluadorConfigQuestionnaire =='' || evaluadoConfigQuestionnaire == ''  ){
                swal('Atencion','Todos los campos son necesarios','error');
                return false;
            }
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        var url = ('./models/cuestions/AjaxConfigQuestionnaire.php');
        var form = new FormData(formConfigQuestionnaire);
        request.open('POST', url, true);
        request.send(form);
        request.onreadystatechange = function() {
            if(request.readyState === 4 && request.status ===200){
                var data = JSON.parse(request.responseText);
                if(request.status){
                    $('#modalConfigQuestionnaire').modal('hide');
                    formConfigQuestionnaire.reset();
                    if (data.msg == "Ya exite una Configuración con el mismo nombre" || data.msg == "Acción desconocida" || data.msg == "Error al ejecutar la consulta" || data.msg == "Petición inválida" ){
                        swal('Cuestionario',data.msg,'error');
                    }else{
                        swal('Cuestionario',data.msg,'success');
                    }
                    tableConfigQuestionnaire.ajax.reload();
                }else{
                    swal('Cuestionario',data.msg,'error');
                }
            }
        }
    }
})
function openModalQuestionnaire(){
    formConfigQuestionnaire.reset();
    $('#modalConfigQuestionnaire').modal('show');
}
function editConfigQuestionnaire(id){

    var idConfigQuestionnaire = id;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    var url = './models/cuestions/EditConfigQuestionnaire.php?idConfigQuestionnaire='+idConfigQuestionnaire;
    request.open('GET', url, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            var data = JSON.parse(request.responseText);
            if(data.status){
                document.querySelector('#idConfigQuestionnaire').value = data.data.ConfigQuestionnaire_Id;
                document.querySelector('#nombreConfigQuestionnaire').value = data.data.ConfigQuestionnaire_Name;
                document.querySelector('#statusConfigQuestionnaire').value = data.data.ConfigQuestionnaire_StatusId;

                                // Set selected option for Evaluador dropdown
                                var evaluadorSelect = document.querySelector('#evaluadorConfigQuestionnaire');
                                for (var i = 0; i < evaluadorSelect.options.length; i++) {
                                    if (evaluadorSelect.options[i].value == data.data.ConfigQuestionnaire_IdRolEvaluator) {
                                        evaluadorSelect.options[i].selected = true;
                                        break;
                                    }
                                }
                
                                // Set selected option for Evaluado dropdown
                                var evaluadoSelect = document.querySelector('#evaluadoConfigQuestionnaire');
                                for (var i = 0; i < evaluadoSelect.options.length; i++) {
                                    if (evaluadoSelect.options[i].value == data.data.ConfigQuestionnaire_IdRolEvaluated) {
                                        evaluadoSelect.options[i].selected = true;
                                        break;
                                    }
                                }



                $('#modalConfigQuestionnaire').modal('show');
            } else{
                swal('Atencion',data.msg,'error');
            }
        }
    }
}

function configureConfigQuestionnaireCat(id){
    var idConfigQuestionnaireCat = id;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    var url = './models/cuestions/EditConfigQuestionnaireCat.php?idConfigQuestionnaireCat='+idConfigQuestionnaireCat;
    request.open('GET', url, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            var data = JSON.parse(request.responseText);
            if(data.status){
                document.querySelector('#idConfigQuestionnaireCat').value = data.data.ConfigQuestionnaire_Id;

                document.querySelector('#nombreConfigQuestionnaireCat').value = data.data.ConfigQuestionnaire_Name;
                document.querySelector('#statusConfigQuestionnaireCat').value = data.data.ConfigQuestionnaire_StatusId;

                                // Set selected option for Evaluador dropdown
                                var evaluadorSelect = document.querySelector('#evaluadorConfigQuestionnaireCat');
                                for (var i = 0; i < evaluadorSelect.options.length; i++) {
                                    if (evaluadorSelect.options[i].value == data.data.ConfigQuestionnaire_IdRolEvaluator) {
                                        evaluadorSelect.options[i].selected = true;
                                        break;
                                    }
                                }
                
                                // Set selected option for Evaluado dropdown
                                var evaluadoSelect = document.querySelector('#evaluadoConfigQuestionnaireCat');
                                for (var i = 0; i < evaluadoSelect.options.length; i++) {
                                    if (evaluadoSelect.options[i].value == data.data.ConfigQuestionnaire_IdRolEvaluated) {
                                        evaluadoSelect.options[i].selected = true;
                                        break;
                                    }
                                }

                var table = $('#tableAssignGroupCatQues').DataTable();
                window.idConfigQuestionnaireCatAux = data.data.ConfigQuestionnaire_Id;

                table.ajax.url('./models/cuestions/TableConfigAssignGroupCatQues.php?idAssignGroupCatQuest=' + idConfigQuestionnaireCat).load();

                $('#modalConfigQuestionnaireCat').modal('show');
            } else {
                swal('Atencion', data.msg, 'error');
            }
        }
    }
}

function deleteConfigQuestionnaire(id) {
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
            executeDeleteDeleteConfigQuestionnaire(id);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            showAlert('Cancelado', 'Tu Configuración está a salvo', 'error');
        }
    });
}

function showAlert(title, message, type) {
    Swal.fire(title, message, type);
}

function executeDeleteDeleteConfigQuestionnaire(id) {
    const formData = new FormData();
    formData.append('id', id);
    
    const request = new XMLHttpRequest();
    request.open('POST', './models/cuestions/AjaxDeleteConfigQuestionnaire.php', true);
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
        tableConfigQuestionnaire.ajax.reload();

        showAlert('¡Eliminado!', 'La Configuración ha sido eliminado.', 'success')
            .then(() => {

            });
    } else {
        showAlert('Error', 'Ocurrió un error al intentar eliminar la Configuración.', 'error');
    }
}

