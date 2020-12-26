<?php

$nombre = $_POST['nombre'];
$accion = $_POST['accion'];
$proyecto_id = (int)$_POST['proyecto_id'];
$estado = (int) $_POST['estado'];
$id_tarea = (int) $_POST['id'];

if($accion=='crear'){
    include_once '../funciones/conexion.php';

    try{
        $stmt = $conn->prepare("INSERT INTO tareas (nombre, id_proyecto) values (?, ?)");
        $stmt->bind_param("si", $nombre, $proyecto_id);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            $respuesta = array(
                'respuesta' => 'correcto',
                'id_incertado' => $stmt->insert_id,
                'tipo' => $accion,
                "nombre_tarea" => $nombre
            );
        }else{
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $stmt->close();
        $conn->close();
    }catch(Exception $e){
        $respuesta = array(
            'pass' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}

if($accion === 'actualizar'){
    include_once '../funciones/conexion.php';

    try{
        $stmt = $conn->prepare("UPDATE tareas SET estado = ? where id = ?");
        $stmt->bind_param("ii", $estado, $id_tarea);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            $respuesta = array(
                'respuesta' => 'correcto',
            );
        }else{
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $stmt->close();
        $conn->close();
    }catch(Exception $e){
        $respuesta = array(
            'pass' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}

if($accion === 'eliminar'){
    include_once '../funciones/conexion.php';

    try{
        $stmt = $conn->prepare("DELETE FROM tareas where id = ?");
        $stmt->bind_param("i", $id_tarea);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            $respuesta = array(
                'respuesta' => 'correcto',
            );
        }else{
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $stmt->close();
        $conn->close();
    }catch(Exception $e){
        $respuesta = array(
            'pass' => $e->getMessage()
        );
    }

    echo json_encode($respuesta);
}