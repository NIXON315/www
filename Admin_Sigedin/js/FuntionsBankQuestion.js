$('#tableBankQuest').DataTable();
var tableBankQuest;
document.addEventListener('DOMContentLoaded', function(){
    tableBankQuest = $('#tableBankQuest').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug.ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "./models/cuestions/TableBankQuestion.php",
            "dataSrc": ""
        },
        "columns": [
            {"data": "Questions_Id"},
            {
                "data": "Questions_Statement",
                "render": function (data, type, row) {
                    return '<td class="truncate">' + data + '</td>';
                }
            },
            {"data": "NameGuysQues"},
            {"data": "Questions_Status"},
            {"data": "acciones"}
        ],
        "responsive": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "asc"]]
    });
    var formBankQuest = document.querySelector('#formBankQuest');
    formBankQuest.onsubmit = function(e){
        e.preventDefault(); // Prevents the default submit action of the browser on submission of this form
        var idBankQuest        = document.querySelector('#idBankQuest').value;
        var nombreBankQuest    = document.querySelector('#nombreBankQuest').value;
        var statusBankQuest    = document.querySelector('#statusBankQuest').value;
        var StatementBankQuest = document.querySelector('#StatementBankQuest').value;
        var GuysBankQuest      = document.querySelector('#GuysBankQuest').value;
        var ValMinBankQuest    = document.querySelector('#ValMinBankQuest').value;
        var ValMaxBankQuest    = document.querySelector('#ValMaxBankQuest').value;
        

        if (idBankQuest==''){
            if(nombreBankQuest=='' || statusBankQuest =='' || StatementBankQuest =='' || GuysBankQuest =='' ){
                swal('Atencion','Todos los campos son necesarios','error');
                return false;
            }
        }else {
            if(nombreBankQuest=='' || statusBankQuest =='' || StatementBankQuest =='' || GuysBankQuest =='' ){
                swal('Atencion','Todos los campos son necesarios','error');
                return false;
            }
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        var url = ('./models/cuestions/AjaxBankQuestion.php');
        var form = new FormData(formBankQuest);
        request.open('POST', url, true);
        request.send(form);
        request.onreadystatechange = function() {
            if(request.readyState === 4 && request.status ===200){
                var data = JSON.parse(request.responseText);
                if(request.status){
                    $('#modalBankQuest').modal('hide');
                    formBankQuest.reset();
                    if (data.msg == "Ya exite una pregunta con el mismo nombre" || data.msg == "Todos los datos son necesarios" || data.msg == "Acción desconocida" || data.msg == "Error al ejecutar la consulta" || data.msg == "Petición inválida" ){
                        swal('Cuestionario',data.msg,'error');
                    }else{
                        swal('Cuestionario',data.msg,'success');
                    }
                    tableBankQuest.ajax.reload();
                }else{
                    swal('Cuestionario',data.msg,'error');
                }
            }
        }
    }
})
function openModalBankQuestion(){
    formBankQuest.reset();
    $('#modalBankQuest').modal('show');
}
function editBankQuest(id){
    var idBankQuest = id;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    var url = './models/cuestions/EditBankQuestion.php?idBankQuest='+idBankQuest;
    request.open('GET', url, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            var data = JSON.parse(request.responseText);
            if(data.status){
                document.querySelector('#idBankQuest').value        = data.data.Questions_Id;
                document.querySelector('#nombreBankQuest').value    = data.data.Questions_Name;
                document.querySelector('#statusBankQuest').value    = data.data.Questions_StatusId;
                document.querySelector('#StatementBankQuest').value = data.data.Questions_Statement;
                document.querySelector('#ValMinBankQuest').value    = data.data.Questions_ValueMinimum;
                document.querySelector('#ValMaxBankQuest').value    = data.data.Questions_ValueMaximum;



                                // Set selected option for Evaluador dropdown
                var GuysIdSelect = document.querySelector('#GuysBankQuest');
                for (var i = 0; i < GuysIdSelect.options.length; i++) {
                    if (GuysIdSelect.options[i].value == data.data.Questions_GuysId) {
                        GuysIdSelect.options[i].selected = true;
                        break;
                    }
                }
                
                                // Set selected option for Evaluado dropdown
                               /* var evaluadoSelect = document.querySelector('#evaluadoBankQuest');
                                for (var i = 0; i < evaluadoSelect.options.length; i++) {
                                    if (evaluadoSelect.options[i].value == data.data.BankQuest_IdRolEvaluated) {
                                        evaluadoSelect.options[i].selected = true;
                                        break;
                                    }
                                }*/
                var numericFields = document.getElementById('numericFields');
                if (data.data.Questions_GuysId == 1) {
                    numericFields.style.display = 'block';
                } else {
                    numericFields.style.display = 'none';
                }



                $('#modalBankQuest').modal('show');
            } else{
                swal('Atencion',data.msg,'error');
            }
        }
    }
}

function deleteBankQuest(id) {
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
            executeDeleteBankQuestion(id);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            showAlert('Cancelado', 'Tu cuestionario está a salvo', 'error');
        }
    });
}

function showAlert(title, message, type) {
    Swal.fire(title, message, type);
}

function executeDeleteBankQuestion(id) {
    const formData = new FormData();
    formData.append('id', id);
    
    const request = new XMLHttpRequest();
    request.open('POST', './models/cuestions/AjaxDeleteBankQuest.php', true);
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

        showAlert('¡Eliminado!', 'El cuestionario ha sido eliminado.', 'success')
            .then(() => {
                location.reload();
            });
            tableBankQuest.ajax.reload();
    } else {
        showAlert('Error', 'Ocurrió un error al intentar eliminar el cuestionario.', 'error');
    }
}
