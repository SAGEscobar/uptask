<?php
include 'includes/funciones/secion.php';

header("access-control-allow-origin: *");

include_once 'includes/templates/header.php';
?>
<body>

<?php 
    include_once 'includes/templates/bar.php';

    if(isset($_GET['id_proyecto'])){
        $id_proyecto = $_GET['id_proyecto'];
    }
?>

<div class="contenedor">
    
    <?php include_once 'includes/templates/sidebar.php'; ?>

    <main class="contenido-principal">
        
            <?php 
                $proyecto = getNombreProyecto($id_proyecto);
                if($proyecto):
                    foreach($proyecto as $nombre): ?>
                    <h1>
                        <span><?php echo $nombre['nombre']; ?></span>
                    </h1>
                <?php endforeach; ?>

                <form action="#" class="agregar-tarea">
                    <div class="campo">
                        <label for="tarea">Tarea:</label>
                        <input type="text" placeholder="Nombre Tarea" class="nombre-tarea" id="tarea"> 
                    </div>
                    <div class="campo enviar">
                        <input type="hidden" id="id_proyecto" value="<?php echo $id_proyecto; ?>">
                        <input type="submit" class="boton nueva-tarea" value="Agregar">
                    </div>
                </form>
            <?php else: ?>
                <h1><span>Seleccione Un Proyecto</span></h1>
            <?php endif; ?>
        
 

        <h2>Listado de tareas:</h2>

        <div class="listado-pendientes">
            <ul>
                <?php 
                    $tareas = getTareasProyecto($id_proyecto);
                    if($tareas->num_rows > 0):
                        foreach($tareas as $tarea):
                            ?>
                                <li id="tarea:<?php echo $tarea['id']; ?>" class="tarea">
                                    <p><?php echo $tarea['nombre']; ?></p>
                                    <div class="acciones">
                                        <i class="far fa-check-circle <?php echo (($tarea['estado'] === '1')? 'completo':''); ?>"></i>
                                        <i class="fas fa-trash"></i>
                                    </div>
                                </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li id="no-tareas"><p>No hay tareas en este proyecto</p></li>
                    <?php endif; ?>
            </ul>
        </div>
    </main>
</div><!--.contenedor-->
<?php include_once 'includes/templates/footer.php'; ?>