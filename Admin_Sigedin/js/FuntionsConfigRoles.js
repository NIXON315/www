$('#tableRoles').DataTable();
var tableRoles;
document.addEventListener('DOMContentLoaded', function(){
    tableRoles = $('#tableRoles').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language":{
            "url":"//cdn.datatables.net/plug.ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url":"./models/cuestions/TableConfigRoles.php",
            "dataSrc":""
        },
        "columns":[
            {"data":"Role_Id"},
            {"data":"Role_Name"},
            {"data":"Role_StatusId"},
            {"data":"acciones"}
        ],
        "responsive":true,
        "bDestroy":true,
        "iDisplayLength":10,
        "order":[[0,"asc"]]
    });
    var formRoles = document.querySelector('#formRoles');
    formRoles.onsubmit = function(e){
        e.preventDefault(); // Prevents the default submit action of the browser on submission of this form
        var idRole             = document.querySelector('#idRole').value;
        var nombreRole         = document.querySelector('#nombreRole').value;
        var statusRole         = document.querySelector('#statusRole').value;

        if (idRole==''){
            if(nombreRole =='' || statusRole ==''  ){
                swal('Atencion','Todos los campos son necesarios','error');
                return false;
            }
        }else {
            if(nombreRole =='' || statusRole =='' ){
                swal('Atencion','Todos los campos son necesarios','error');
                return false;
            }
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        var url = ('./models/cuestions/AjaxConfigRoles.php');
        var form = new FormData(formRoles);
        request.open('POST', url, true);
        request.send(form);
        request.onreadystatechange = function() {
            if(request.readyState === 4 && request.status ===200){
                var data = JSON.parse(request.responseText);
                if(request.status){
                    $('#modalRoles').modal('hide');
                    formRoles.reset();
                    if (data.msg == "Ya exite una configuración Tipo de Preguntas con el mismo nombre" || data.msg == "Todos los datos son necesarios" || data.msg == "Acción desconocida" || data.msg == "Error al ejecutar la consulta" || data.msg == "Petición inválida" ){
                        swal('Configuración Tipo de Preguntas',data.msg,'error');
                    }else{
                        swal('Configuración Tipo de Preguntas',data.msg,'success');
                    }
                    tableRoles.ajax.reload();
                }else{
                    swal('Configuración Tipo de Preguntas',data.msg,'error');
                }
            }
        }
    }
})
function openModalRoles(){
    formRoles.reset();
    $('#modalRoles').modal('show');
}
function editRoles(id){
    var idRole = id;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    var url = './models/cuestions/EditConfigRoles.php?idRole='+idRole;
    request.open('GET', url, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            var data = JSON.parse(request.responseText);
            if(data.status){
                document.querySelector('#idRole').value     = data.data.Role_Id;
                document.querySelector('#nombreRole').value = data.data.Role_Name;
                document.querySelector('#statusRole').value = data.data.Role_StatusId;



                $('#modalRoles').modal('show');
            } else{
                swal('Atencion',data.msg,'error');
            }
        }
    }
}


function deleteRoles(id) {
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
            executeDeleteRoles(id);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            showAlert('Cancelado', 'La configuración Tipo de Preguntas está a salvo', 'error');
        }
    });
}

function showAlert(title, message, type) {
    Swal.fire(title, message, type);
}

function executeDeleteRoles(id) {
    const formData = new FormData();
    formData.append('id', id);
    
    const request = new XMLHttpRequest();
    request.open('POST', './models/cuestions/AjaxDeleteRoles.php', true);
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
        tableRoles.ajax.reload();
        showAlert('¡Eliminado!', 'La configuración Tipo de Preguntas ha sido eliminado.', 'success');
    } else {
        showAlert('Error', 'Ocurrió un error al intentar eliminar La configuración Tipo de Preguntas.', 'error');
    }
}
