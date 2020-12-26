<script src="js/sweetalert2.all.min.js"></script>

<?php
$pag = getPaginaActual();
if($pag == 'crear-cuenta' || $pag == 'login'): ?>
    <script src="js/formulario.js"></script>
<?php endif; ?>
<?php if($pag == 'index'):?>
    <script src='js/script.js'></script>
<?php endif; ?>

</body>
</html>