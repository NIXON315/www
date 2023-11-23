$('#tableGuysQues').DataTable();
var tableGuysQues;
document.addEventListener('DOMContentLoaded', function(){
    tableGuysQues = $('#tableGuysQues').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language":{
            "url":"//cdn.datatables.net/plug.ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url":"./models/cuestions/TableConfigGuysQues.php",
            "dataSrc":""
        },
        "columns":[
            {"data":"GuysQues_Id"},
            {"data":"GuysQues_Name"},
            {"data":"GuysQues_StatusId"},
            {"data":"acciones"}
        ],
        "responsive":true,
        "bDestroy":true,
        "iDisplayLength":10,
        "order":[[0,"asc"]]
    });
    var formGuysQues = document.querySelector('#formGuysQues');
    formGuysQues.onsubmit = function(e){
        e.preventDefault(); // Prevents the default submit action of the browser on submission of this form
        var idGuysQues             = document.querySelector('#idGuysQues').value;
        var nombreGuysQues         = document.querySelector('#nombreGuysQues').value;
        var statusGuysQues         = document.querySelector('#statusGuysQues').value;

        if (idGuysQues==''){
            if(nombreGuysQues =='' || statusGuysQues ==''  ){
                swal('Atencion','Todos los campos son necesarios','error');
                return false;
            }
        }else {
            if(nombreGuysQues =='' || statusGuysQues =='' ){
                swal('Atencion','Todos los campos son necesarios','error');
                return false;
            }
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        var url = ('./models/cuestions/AjaxConfigGuysQues.php');
        var form = new FormData(formGuysQues);
        request.open('POST', url, true);
        request.send(form);
        request.onreadystatechange = function() {
            if(request.readyState === 4 && request.status ===200){
                var data = JSON.parse(request.responseText);
                if(request.status){
                    $('#modalGuysQues').modal('hide');
                    formGuysQues.reset();
                    if (data.msg == "Ya exite una configuración Tipo de Preguntas con el mismo nombre" || data.msg == "Todos los datos son necesarios" || data.msg == "Acción desconocida" || data.msg == "Error al ejecutar la consulta" || data.msg == "Petición inválida" ){
                        swal('Configuración Tipo de Preguntas',data.msg,'error');
                    }else{
                        swal('Configuración Tipo de Preguntas',data.msg,'success');
                    }
                    tableGuysQues.ajax.reload();
                }else{
                    swal('Configuración Tipo de Preguntas',data.msg,'error');
                }
            }
        }
    }
})
function openModalGuysQues(){
    formGuysQues.reset();
    $('#modalGuysQues').modal('show');
}
function editGuysQues(id){
    var idGuysQues = id;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    var url = './models/cuestions/EditConfigGuysQues.php?idGuysQues='+idGuysQues;
    request.open('GET', url, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            var data = JSON.parse(request.responseText);
            if(data.status){
                document.querySelector('#idGuysQues').value     = data.data.GuysQues_Id;
                document.querySelector('#nombreGuysQues').value = data.data.GuysQues_Name;
                document.querySelector('#statusGuysQues').value = data.data.GuysQues_StatusId;



                $('#modalGuysQues').modal('show');
            } else{
                swal('Atencion',data.msg,'error');
            }
        }
    }
}


function deleteGuysQues(id) {
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
            executeDeleteGuysQues(id);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            showAlert('Cancelado', 'La configuración Tipo de Preguntas está a salvo', 'error');
        }
    });
}

function showAlert(title, message, type) {
    Swal.fire(title, message, type);
}

function executeDeleteGuysQues(id) {
    const formData = new FormData();
    formData.append('id', id);
    
    const request = new XMLHttpRequest();
    request.open('POST', './models/cuestions/AjaxDeleteGuysQues.php', true);
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
        tableGuysQues.ajax.reload();
        showAlert('¡Eliminado!', 'La configuración Tipo de Preguntas ha sido eliminado.', 'success');
    } else {
        showAlert('Error', 'Ocurrió un error al intentar eliminar La configuración Tipo de Preguntas.', 'error');
    }
}
