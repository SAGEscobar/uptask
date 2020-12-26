<?php
    function getPaginaActual(){
        $archivo = basename($_SERVER['PHP_SELF']);
        $pagina = str_replace(".php", "", $archivo);
        return $pagina;
    }

    function getProyectos(){
        include 'conexion.php';

        try{
            return $conn->query('SELECT id, nombre FROM proyectos');
        }catch(Exeption $e){
            echo "Error: " - $e->getMessage();
            return false;
        }
    }

    function getNombreProyecto($id = null){
        include 'conexion.php';
        
        try{
            return $conn->query("SELECT nombre FROM proyectos WHERE id = {$id}");
        }catch(Exeption $e){
            echo "Error: " - $e->getMessage();
            return false;
        }
    }

    function getTareasProyecto($id = null){
        include 'conexion.php';
        
        try{
            return $conn->query("SELECT id, nombre, estado FROM tareas WHERE id_proyecto = {$id}");
        }catch(Exeption $e){
            echo "Error: " - $e->getMessage();
            return false;
        }
    }