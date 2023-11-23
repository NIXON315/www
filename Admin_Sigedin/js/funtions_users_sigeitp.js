$('#tableuserssigeitp').DataTable();
var tableuserssigeitp;
document.addEventListener('DOMContentLoaded', function(){
    tableuserssigeitp = $('#tableuserssigeitp').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language":{
            "url":"//cdn.datatables.net/plug.ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url":"./models/users/table_users_sigeitp.php",
            "dataSrc":""
        },
        "columns":[
            {"data":"acciones"},
            {"data":"User_UserName"},
            {"data":"User_Name"},
            {"data":"Role_Name"},
            {"data":"User_StatusId_Table"}
        ],
        "responsive":true,
        "bDestroy":true,
        "iDisplayLength":10,
        "order":[[0,"asc"]]
    })
})
function enviarUsuario(nombre, usuario, clave, email, rol, nombre_rol, estado) {
    if (estado==1){
        var statusUser = "Activo";
    }
    
    Swal.fire({
        title: '¿Estas seguro de enviar los siguientes datos?',
        html: '<p>Nombre: ' + nombre + '</p>' +
            '<p>Usuario: ' + usuario + '</p>' +
            '<p>Clave: ' + clave + '</p>' +
            '<p>Email: ' + email + '</p>' +
            '<p>Nombre de rol: ' + nombre_rol + '</p>' +
            '<p>Estado: ' + statusUser + '</p>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Deseo Enviar!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url:'./models/users/register_user.php',
                method: 'POST',
                data: {
                    nombre: nombre,
                    rol: rol,
                    usuario: usuario,
                    clave: clave,
                    email: email,
                    nombre_rol: nombre_rol,
                    estado:estado
                },
                success: function(data) {
                    data = JSON.parse(data); // Parsea los datos como JSON si no se envían con el encabezado "Content-Type: application/json"
                    if (data.status == "success") {
                        Swal.fire(
                            'Datos Enviados!',
                            'Se ha registrado el usuario de forma Exitosa',
                            'success'
                          )
                    }else if(data.status == "error1"){
                        Swal.fire(
                            'Datos NO Enviados!',
                            'El usuario ya existe en la base de datos',
                            'info'
                          )
                    }else{
                        Swal.fire(
                            'Error!',
                            'Error al insertar los datos',
                            'error'
                          )
                    }
                }
            })
        }
      })
  }
