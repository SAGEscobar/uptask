
eventListeners();

function eventListeners(){
    document.querySelector('#formulario').addEventListener('submit', validarRegistro);
}

function validarRegistro(e){
    e.preventDefault();

    let usuario = document.querySelector("#usuario").value,
        password = document.querySelector("#password").value,
        tipo = document.querySelector("#tipo").value;

    if(usuario === "" || password === ""){
        swal({
            type: 'error',
            title: 'Error',
            text: 'Ambos campos son obligatorios'
        })
    }else{
        let datos = new FormData();
        datos.append('usuario', usuario);
        datos.append('password', password);
        datos.append('accion', tipo);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'includes/modelos/modelo-admin.php', true);
        xhr.onload = function(){
            if(this.status==200){
                let respuesta = JSON.parse(this.responseText);
                console.log(respuesta);
                if(respuesta.respuesta === "correcto"){
                    
                    if(respuesta.tipo === 'crear'){
                        swal({
                            title: 'Usuario Creado',
                            text: 'El usuario ha sido creado correctamente',
                            type: 'success'
                        }).then((result) => {
                            window.location.href = 'index.php';
                          })
                        document.querySelector('#formulario').reset();

                    }else if(respuesta.tipo === 'login'){
                        window.location.href = 'index.php';
                    }else{
                        swal({
                            title: 'Error',
                            text: 'Ha ocurrido un error',
                            type: 'error'
                        })
                    }
                }else{
                        swal({
                            title: 'Error',
                            text: 'Ha ocurrido un error',
                            type: 'error'
                        })
                    }
            }
        }
        xhr.send(datos)
    }
}