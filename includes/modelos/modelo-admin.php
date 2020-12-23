<?php

$usuario = $_POST['usuario'];
$password = $_POST['password'];
$accion = $_POST['accion'];

if($accion=='crear'){
    include_once '../funciones/conexion.php';
    $opciones = array(
        'cost' => 12
    );
    $hash_password = password_hash($password, PASSWORD_BCRYPT, $opciones);

    try{
        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, password) values (?, ?)");
        $stmt->bind_param("ss", $usuario, $hash_password);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            $respuesta = array(
                'respuesta' => 'correcto',
                'id_incertado' => $stmt->insert_id,
                'tipo' => $accion
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

if($accion=='login'){
    include '../funciones/conexion.php';
    $opciones = array(
        'cost' => 12
    );

    try{
        $stmt = $conn->prepare('SELECT id, usuario, password FROM usuarios WHERE usuario = ?');
        $stmt->bind_param('s', $usuario);
        $stmt->execute();

        $stmt->bind_result($id_usuario, $nombre_usuario, $pass_usuario);
        $stmt->fetch();
        if($nombre_usuario){
            if(password_verify($password, $pass_usuario)){
                session_start();
                $_SESSION['nombre'] = $usuario;
                $_SESSION['id'] = $id_usuario;
                $_SESSION['login'] = true;
                $respuesta = array(
                    'respuesta' => 'correcto',
                    'nombre' => $nombre_usuario,
                    'tipo' => $accion
                );
            }else{
                $respuesta = array(
                    'error' => "Usuario o contraseña incorrecto"
                );
            }
            
        }else{
            $respuesta = array(
                'error' => "Usuario o contraseña incorrecto"
            );
        }
        $stmt->close();
    }catch(Exception $e){
        $respuesta = array(
            'pass' => $e->getMessage()
        );
    }
    echo json_encode($respuesta);
}