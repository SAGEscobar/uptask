let listaProyectos = document.querySelector('ul#proyectos')

eventListeners();

function eventListeners(){
    document.querySelector('.crear-proyecto a').addEventListener('click', nuevoProyecto);
    document.querySelector('.nueva-tarea').addEventListener('click', nuevaTarea);
    document.querySelector('.listado-pendientes').addEventListener('click', accionesTareas);
}

function nuevoProyecto(e){
    e.preventDefault();

    //Creando input

    let newProyect = document.createElement('li');
    newProyect.innerHTML = '<input type="text" id="nuevo-proyecto">';
    listaProyectos.appendChild(newProyect);
    newProyect.focus();

    let inputNuevo = document.querySelector('input#nuevo-proyecto');

    inputNuevo.addEventListener('keypress', function(e){
        let tecla = e.which || e.keyCode;
        if(tecla == 13){
            guardarProyectoDB(inputNuevo.value)
            listaProyectos.removeChild(newProyect);
        }
    })
}

function guardarProyectoDB(nombreProyecto) {
   let xhr = new XMLHttpRequest(); 

   let datos = new FormData();
   datos.append('proyecto', nombreProyecto);
   datos.append('accion', 'crear')

   xhr.open('POST', 'includes/modelos/modelo-proyecto.php', true);
   xhr.onload = function(){
        if(this.status===200){
            let respuesta = JSON.parse(this.responseText);
            if(respuesta.respuesta==='correcto'){
                let newProyect = document.createElement('li')
                newProyect.innerHTML = `
                    <a href="index.php?id_proyecto=${respuesta.id_incertado}" id="proyecto:a<z${respuesta.id_incertado}">
                        ${nombreProyecto}
                    </a>
                `;
                listaProyectos.appendChild(newProyect);
                window.location.href = 'index.php?id_proyecto=' + respuesta.id_incertado;
            }else{
                swal({
                    type: 'error',
                    title: 'Error',
                    text: 'Ha ocurrido un error'
                });
            }
        }
   }
   xhr.send(datos);
}

function nuevaTarea(e){
    e.preventDefault();

    let tarea = document.querySelector('input.nombre-tarea').value,
        proyecto_id = document.querySelector('input#id_proyecto').value;

    if(tarea === ""){
        swal({
            type: 'error',
            title: 'Error',
            text: 'Debe ingresar el nombre de la tarea'
        });
    }else{
        let datos = new FormData()
        datos.append('proyecto_id', proyecto_id);
        datos.append('nombre', tarea);
        datos.append('accion', 'crear')

        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'includes/modelos/modelo-tareas.php', true);
        xhr.onload = function(){
            if(this.status === 200){
                let respuesta = JSON.parse(this.responseText)
                if(respuesta.respuesta === 'correcto'){
                    let newTask = document.createElement('li');
                    newTask.innerHTML = `
                        <p>${respuesta.nombre_tarea}</p>
                        <div class="acciones">
                            <i class="far fa-check-circle"></i>
                            <i class="fas fa-trash"></i>
                        </div>
                    `;
                    newTask.id = 'tarea:'+respuesta.id_incertado;
                    newTask.classList.add('tarea');
                    listadoPendientes = document.querySelector('.listado-pendientes ul');
                    if(document.querySelector('li#no-tareas')){
                        document.querySelector('li#no-tareas').remove();
                    }
                    listadoPendientes.appendChild(newTask);
                    document.querySelector('form.agregar-tarea').reset();
                }
            }
        }
        xhr.send(datos);
    }
}

function accionesTareas(e){
    e.preventDefault();

    if(e.target.classList.contains('fa-check-circle')){
        if(e.target.classList.contains('completo')){
            e.target.classList.remove('completo');
            cambiarEstadoTarea(e.target, 0);
        }else{
            e.target.classList.add('completo');
            cambiarEstadoTarea(e.target, 1);
        }
    }else if(e.target.classList.contains('fa-trash')){
        eliminarTarea(e.target);
    }
}


function cambiarEstadoTarea(tarea, estado){
    let id = tarea.parentElement.parentElement.id.split(':')[1];
    let xhr = new XMLHttpRequest();

    let datos = new FormData();
    datos.append('id', id);
    datos.append('accion', 'actualizar');
    datos.append('estado', estado);

    xhr.open('POST', 'includes/modelos/modelo-tareas.php', true);
    xhr.onload = function (){
        if(this.status == 200){
            respuesta = JSON.parse(this.responseText);
            if(respuesta.respuesta === 'correcto'){
                console.log(respuesta);
            }
        }
    }

    xhr.send(datos);
}

function eliminarTarea(tarea){
    let id = tarea.parentElement.parentElement.id.split(':')[1];
    let xhr = new XMLHttpRequest();

    let datos = new FormData();
    datos.append('id', id);
    datos.append('accion', 'eliminar');

    xhr.open('POST', 'includes/modelos/modelo-tareas.php', true);
    xhr.onload = function (){
        if(this.status == 200){
            respuesta = JSON.parse(this.responseText);
            if(respuesta.respuesta === 'correcto'){
                lista = tarea.parentElement.parentElement.parentElement;
                lista.removeChild(tarea.parentElement.parentElement);
                if(lista.childElementCount < 1){
                    lista.innerHTML = '<li><p id="no-tareas">No hay tareas en este proyecto</p></li>';
                }
            }
        }
    }
    xhr.send(datos);
}