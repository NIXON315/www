$('#tableGroupCatQues').DataTable();
var tableGroupCatQues;
document.addEventListener('DOMContentLoaded', function(){
    tableGroupCatQues = $('#tableGroupCatQues').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug.ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url":"./models/cuestions/TableConfigGroupCatQues.php",
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
    var formGroupCatQues = document.querySelector('#formGroupCatQues');
    formGroupCatQues.onsubmit = function(e){
        e.preventDefault(); // Prevents the default submit action of the browser on submission of this form
        var idGroupCatQuest             = document.querySelector('#idGroupCatQuest').value;
        var nombreGroupCatQuest         = document.querySelector('#nombreGroupCatQuest').value;
        var statusGroupCatQuest         = document.querySelector('#statusGroupCatQuest').value;

        if (idGroupCatQuest==''){
            if(nombreGroupCatQuest =='' || statusGroupCatQuest ==''  ){
                swal('Atencion','Todos los campos son necesarios','error');
                return false;
            }
        }else {
            if(nombreGroupCatQuest =='' || statusGroupCatQuest =='' ){
                swal('Atencion','Todos los campos son necesarios','error');
                return false;
            }
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        var url = ('./models/cuestions/AjaxConfigGroupCatQues.php');
        var form = new FormData(formGroupCatQues);
        request.open('POST', url, true);
        request.send(form);
        request.onreadystatechange = function() {
            if(request.readyState === 4 && request.status ===200){
                var data = JSON.parse(request.responseText);
                if(request.status){
                    $('#modalGroupCatQues').modal('hide');
                    formGroupCatQues.reset();
                    if (data.msg == "Ya exite una configuración Tipo de Preguntas con el mismo nombre" || data.msg == "Todos los datos son necesarios" || data.msg == "Acción desconocida" || data.msg == "Error al ejecutar la consulta" || data.msg == "Petición inválida" ){
                        swal('Configuración Tipo de Preguntas',data.msg,'error');
                    }else{
                        swal('Configuración Tipo de Preguntas',data.msg,'success');
                    }
                    tableGroupCatQues.ajax.reload();
                }else{
                    swal('Configuración Tipo de Preguntas',data.msg,'error');
                }
            }
        }
    }
})
function openModalGroupCatQues(){
    formGroupCatQues.reset();
    $('#modalGroupCatQues').modal('show');
}

function editGroupCatQues(id) {
    var idGroupCatQuest = id;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    var url = './models/cuestions/EditConfigGroupCatQues.php?idGroupCatQuest=' + idGroupCatQuest;
    request.open('GET', url, true);
    request.send();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var data = JSON.parse(request.responseText);
            if (data.status) {
                // Realiza las acciones necesarias aquí, como llenar un formulario o mostrar datos.
                document.querySelector('#idGroupCatQuest').value = data.data.GroupCatQuest_Id;
                document.querySelector('#nombreGroupCatQuest').value = data.data.GroupCatQuest_Name;
                document.querySelector('#statusGroupCatQuest').value = data.data.GroupCatQuest_StatusId;
                $('#modalGroupCatQues').modal('show');
            } else {
                swal('Atencion', data.msg, 'error');
            }
        }
    }
}

function deleteGroupCatQues(id) {
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
            executeDeleteGroupCatQues(id);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            showAlert('Cancelado', 'La configuración Tipo de Preguntas está a salvo', 'error');
        }
    });
}

function showAlert(title, message, type) {
    Swal.fire(title, message, type);
}

function executeDeleteGroupCatQues(id) {
    const formData = new FormData();
    formData.append('id', id);
    
    const request = new XMLHttpRequest();
    request.open('POST', './models/cuestions/AjaxDeleteGroupCatQues.php', true);
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
        tableGroupCatQues.ajax.reload();
        showAlert('¡Eliminado!', 'La configuración Tipo de Preguntas ha sido eliminado.', 'success');
    } else {
        showAlert('Error', 'Ocurrió un error al intentar eliminar La configuración Tipo de Preguntas.', 'error');
    }
}
