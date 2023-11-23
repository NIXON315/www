$('#tableCatOfQuest').DataTable();
var tableCatOfQuest;
document.addEventListener('DOMContentLoaded', function(){
    tableCatOfQuest = $('#tableCatOfQuest').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language":{
            "url":"//cdn.datatables.net/plug.ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url":"./models/cuestions/TableConfigCategoriOfQuestions.php",
            "dataSrc":""
        },
        "columns":[
            {"data":"CatOfQues_Id"},
            {"data":"CatOfQues_Name"},
            {"data":"CatOfQues_StatusIdText"},
            {"data":"acciones"}
        ],
        "responsive":true,
        "bDestroy":true,
        "iDisplayLength":10,
        "order":[[0,"asc"]]
    });
    var formCatOfQuest = document.querySelector('#formCatOfQuest');
    formCatOfQuest.onsubmit = function(e){
        e.preventDefault(); // Prevents the default submit action of the browser on submission of this form
        var idCatOfQuest             = document.querySelector('#idCatOfQuest').value;
        var nombreCatOfQuest         = document.querySelector('#nombreCatOfQuest').value;
        var statusCatOfQuest         = document.querySelector('#statusCatOfQuest').value;

        if (idCatOfQuest==''){
            if(nombreCatOfQuest =='' || statusCatOfQuest ==''  ){
                swal('Atencion','Todos los campos son necesarios','error');
                return false;
            }
        }else {
            if(nombreCatOfQuest =='' || statusCatOfQuest =='' ){
                swal('Atencion','Todos los campos son necesarios','error');
                return false;
            }
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        var url = ('./models/cuestions/AjaxConfigCategoriOfQuestions.php');
        var form = new FormData(formCatOfQuest);
        request.open('POST', url, true);
        request.send(form);
        request.onreadystatechange = function() {
            if(request.readyState === 4 && request.status ===200){
                var data = JSON.parse(request.responseText);
                if(request.status){
                    $('#modalCatOfQuest').modal('hide');
                    formCatOfQuest.reset();
                    if (data.msg == "Ya exite una configuración Tipo de Preguntas con el mismo nombre" || data.msg == "Todos los datos son necesarios" || data.msg == "Acción desconocida" || data.msg == "Error al ejecutar la consulta" || data.msg == "Petición inválida" ){
                        swal('Configuración Tipo de Preguntas',data.msg,'error');
                    }else{
                        swal('Configuración Tipo de Preguntas',data.msg,'success');
                    }
                    tableCatOfQuest.ajax.reload();
                }else{
                    swal('Configuración Tipo de Preguntas',data.msg,'error');
                }
            }
        }
    }
})
function openModalCatOfQuest(){
    formCatOfQuest.reset();
    $('#modalCatOfQuest').modal('show');
}
function editCatOfQuest(id){
    var idCatOfQuest = id;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    var url = './models/cuestions/EditConfigCategoriOfQuestions.php?idCatOfQuest='+idCatOfQuest;
    request.open('GET', url, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            var data = JSON.parse(request.responseText);
            if(data.status){
                document.querySelector('#idCatOfQuest').value     = data.data.CatOfQues_Id;
                document.querySelector('#nombreCatOfQuest').value = data.data.CatOfQues_Name;
                document.querySelector('#statusCatOfQuest').value = data.data.CatOfQues_StatusId;



                $('#modalCatOfQuest').modal('show');
            } else{
                swal('Atencion',data.msg,'error');
            }
        }
    }
}


function deleteCatOfQuest(id) {
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
            executeDeleteCatOfQuest(id);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            showAlert('Cancelado', 'La configuración Tipo de Preguntas está a salvo', 'error');
        }
    });
}

function showAlert(title, message, type) {
    Swal.fire(title, message, type);
}

function executeDeleteCatOfQuest(id) {
    const formData = new FormData();
    formData.append('id', id);
    
    const request = new XMLHttpRequest();
    request.open('POST', './models/cuestions/AjaxDeleteConfigCategoriOfQuestions.php', true);
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
        tableCatOfQuest.ajax.reload();
        showAlert('¡Eliminado!', 'La configuración Tipo de Preguntas ha sido eliminado.', 'success');
    } else {
        showAlert('Error', 'Ocurrió un error al intentar eliminar La configuración Tipo de Preguntas.', 'error');
    }
}
