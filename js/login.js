// Login Page Flipbox control
$('.login-content [data-toggle="flip"]').click(function() {
    $('.login-box').toggleClass('flipped');
    return false;
    });

    // Login form submission
    $('.btn-login').on('click', function(e) {
    e.preventDefault();

    var username = $('#username').val();
    var password = $('#password').val();

    console.log("Hasta aqui vamos bien");

    $.ajax({
        url: './includes/loginUser.php',
        method: 'POST',
        data: {
        username: username,
        password: password
        },
        success: function(data) {
        data = JSON.parse(data); // Parsea los datos como JSON si no se envían con el encabezado "Content-Type: application/json"
        if (data.status == "0") {
            Swal.fire({
                icon: 'info',
                title: 'Oops...',
                text: 'Actualmente te encuentras Deshabilitado, por favor comunicarse con el Administrador'
                //footer: '<a href="">Why do I have this issue?</a>'
            })

        } else if (data.status == "1") {
            Swal.fire({
                icon: 'success',
                title: 'Bienvenido'
                //footer: '<a href="">Why do I have this issue?</a>'
              })
              setTimeout(task, 5);
              function task() {
                window.location = data.redireccion;
              }
            //$('#messageUser').html('Administrador');
        } else {
            if(username=="" || password==""){
                //$('#messageUser').html('Todos los campos son requeridos');
                Swal.fire({
                    icon: 'info',
                    title: 'Oops...',
                    text: 'Todos los campos son requeridos!'
                    //footer: '<a href="">Why do I have this issue?</a>'
                  })
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Usuario o contraseña incorrectos!'
                    //footer: '<a href="">Why do I have this issue?</a>'
                  })
                //$('#messageUser').html('Usuario o contraseña incorrectos');
            }
        }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Error en la solicitud!'
                //footer: '<a href="">Why do I have this issue?</a>'
              })
            //$('#messageUser').html('Error en la solicitud');
        }
    });
});