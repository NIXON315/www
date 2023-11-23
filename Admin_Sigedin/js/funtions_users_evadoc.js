$('#tableusersevadoc').DataTable();
var tableusersevadoc;
document.addEventListener('DOMContentLoaded', function(){
    tableusersevadoc = $('#tableusersevadoc').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language":{
            "url":"//cdn.datatables.net/plug.ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url":"./models/users/table_users_evadoc.php",
            "dataSrc":""
        },
        "columns":[
            {"data":"acciones"},
            {"data":"User_UserName"},
            {"data":"User_Name"},
            {"data":"Role_Name"},
            {"data":"User_StatusId"}
        ],
        "responsive":true,
        "bDestroy":true,
        "iDisplayLength":10,
        "order":[[0,"asc"]]
    });
    var formUser = document.querySelector('#formUser');
    formUser.onsubmit = function(e){
        e.preventDefault(); // Prevents the default submit action of the browser on submission of this form
        var idUser  = document.querySelector('#idUser').value;
        var nombre  = document.querySelector('#nombre').value;
        var usuario = document.querySelector('#usuario').value;
        var clave   = document.querySelector('#clave').value;
        var rol     = document.querySelector('#listRol').value;
        var estado  = document.querySelector('#listStatus').value;
        if (idUser==''){
            if(nombre =='' || usuario =='' || clave == ''){
                swal('Atencion','Todos los campos son necesarios','error');
                return false;
            }
        }else {
            if(nombre =='' || usuario ==''){
                swal('Atencion','Todos los campos son necesarios','error');
                return false;
            }
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        var url = ('./models/users/ajax-user.php');
        var form = new FormData(formUser);
        request.open('POST', url, true);
        request.send(form);
        request.onreadystatechange = function() {
            if(request.readyState === 4 && request.status ===200){
                var data = JSON.parse(request.responseText);
                if(request.status){
                    $('#modalUser').modal('hide');
                    formUser.reset();
                    swal('Usuario',data.msg,'success');
                    tableusersevadoc.ajax.reload();
                }else{
                    swal('Usuario',data.msg,'error');
                }
            }
        }
    }
})
function openModal(){
    formUser.reset();
    $('#modalUser').modal('show');
}
function editUser(id){
    var idUser = id;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    var url = './models/users/edit_user.php?idUser='+idUser;
    request.open('GET', url, true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200){
            var data = JSON.parse(request.responseText);
            if(data.status){
                document.querySelector('#idUser').value =      data.data.User_Id;
                document.querySelector('#nombre').value =      data.data.User_Name;
                document.querySelector('#usuario').value =     data.data.User_UserName;
                //document.querySelector('#listRol').value =     data.data.User_IdRole;
                //document.querySelector('#listStatus').value =  data.data.User_StatusId;

                var RoleSelect = document.querySelector('#listRol');
                for (var i = 0; i < RoleSelect.options.length; i++) {
                    if (RoleSelect.options[i].value == data.data.User_IdRole) {
                        RoleSelect.options[i].selected = true;
                        break;
                    }
                }
                var StatusIdSelect = document.querySelector('#listStatus');
                for (var i = 0; i < StatusIdSelect.options.length; i++) {
                    if (StatusIdSelect.options[i].value == data.data.User_StatusId) {
                        StatusIdSelect.options[i].selected = true;
                        break;
                    }
                }

                $('#modalUser').modal('show');
            } else{
                swal('Atencion',data.msg,'error');
            }
        }
    }
}

