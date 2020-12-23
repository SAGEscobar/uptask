<script src="js/sweetalert2.all.min.js"></script>

<?php include "includes/funciones/funciones.php";
$pag = getPaginaActual();
if($pag == 'crear-cuenta' || $pag == 'login'): ?>
    <script src="js/formulario.js"></script>
<?php endif; ?>

</body>
</html>