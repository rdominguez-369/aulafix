<?php

/**
 * =====================================================
 * AULAFIX - LISTADO DE INCIDENCIAS
 * =====================================================
 *
 * Esta página obtiene las incidencias mediante
 * una función reutilizable.
 *
 * Los datos se encuentran separados del HTML.
 */

// PASO 1: Definir el título de la página.
$tituloPagina = 'Incidencias';

// PASO 2: Cargar las funciones de incidencias.
require_once __DIR__ . '/../includes/incidencias.php';

// PASO 3: Obtener los datos mediante la función.
$incidencias = obtenerIncidencias();

// PASO 4: Cargar la cabecera común.
require_once __DIR__ . '/../includes/cabecera.php';

?>

<!-- PASO 5: Mostrar el contenido principal -->
<section>

    <h2>Listado de incidencias</h2>

    <p>
        Consulta las incidencias registradas
        en los equipos del aula.
    </p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Categoría</th>
                <th>Estado</th>
                <th>Prioridad</th>
            </tr>
        </thead>

        <tbody>

            <!-- PASO 6: Recorrer las incidencias -->
            <?php foreach ($incidencias as $incidencia): ?>

                <tr>
                    <td><?= e($incidencia['id']) ?></td>
                    <td><?= e($incidencia['titulo']) ?></td>
                    <td><?= e($incidencia['categoria']) ?></td>
                    <td><?= e($incidencia['estado']) ?></td>
                    <td><?= e($incidencia['prioridad']) ?></td>
                </tr>

            <?php endforeach; ?>

        </tbody>
    </table>

</section>

<?php

// PASO 7: Cargar el pie de página común.
require_once __DIR__ . '/../includes/pie.php';

?>
