<?php

/**
 * =====================================================
 * AULAFIX - PIE DE PÁGINA COMÚN
 * =====================================================
 *
 * Este archivo cierra el contenido principal
 * y añade el pie de página de AulaFix.
 */

// PASO 1: Obtener el año actual.
$anioActual = date('Y');

?>

    <!-- PASO 2: Cerrar el contenido principal -->
    </main>

    <!-- PASO 3: Mostrar el pie de página -->
    <footer>
        <p>
            &copy; <?= $anioActual ?> AulaFix.
            Proyecto integrador DAW.
        </p>
    </footer>

    <!-- PASO 4: Cargar el archivo JavaScript principal -->
    <script src="/js/main.js" defer></script>

</body>
</html>
