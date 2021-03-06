<?php

$proyecto = $_POST['proyecto'];
$accion = $_POST['accion'];

if($accion=='crear'){
    include_once '../funciones/conexion.php';
    session_start();
    try{
        $stmt = $conn->prepare("INSERT INTO proyectos (nombre, id_usuario) values (?, ?)");
        $stmt->bind_param("si", $proyecto, $_SESSION['id']);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            $respuesta = array(
                'respuesta' => 'correcto',
                'id_incertado' => $stmt->insert_id,
                'tipo' => $accion,
                "nombre_proyecto" => $proyecto
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