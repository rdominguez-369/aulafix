<?php

/**
 * =====================================================
 * AULAFIX - LISTADO DE INCIDENCIAS
 * =====================================================
 *
 * Esta página muestra las incidencias almacenadas
 * en la base de datos MySQL.
 *
 * Los datos se obtienen mediante la función
 * reutilizable obtenerIncidencias(), que utiliza PDO.
 */

// =====================================================
// PASO 1: Definir el título de la página.
// =====================================================

$tituloPagina = 'Incidencias';

// =====================================================
// PASO 1.1: Recuperar el mensaje de confirmación.
// =====================================================

// Iniciamos o recuperamos la sesión del usuario.
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Recuperamos el mensaje almacenado después del registro.
$mensajeExito = $_SESSION['mensaje_exito'] ?? '';

// Eliminamos el mensaje de la sesión para que
// solamente aparezca una vez.
unset($_SESSION['mensaje_exito']);


// =====================================================
// PASO 2: Cargar las funciones de incidencias.
// =====================================================

// Este archivo contiene obtenerIncidencias(),
// que consulta la base de datos mediante PDO.

require_once __DIR__ . '/../includes/incidencias.php';


// =====================================================
// PASO 3: Obtener las incidencias reales de MySQL.
// =====================================================

// Antes utilizábamos un array con datos ficticios.
// Ahora recuperamos los registros almacenados en MySQL.

$incidencias = obtenerIncidencias();


// =====================================================
// PASO 4: Cargar la cabecera común.
// =====================================================

require_once __DIR__ . '/../includes/cabecera.php';

?>

<section>

    <h2>Listado de incidencias</h2>

    <!-- =================================================
     Mostrar el mensaje de confirmación del registro.
     ================================================= -->

    <?php if ($mensajeExito !== ''): ?>

        <p role="status">
            <?= e($mensajeExito) ?>
        </p>

    <?php endif; ?>

    <p>
        Consulta las incidencias registradas
        en los equipos del aula.
    </p>

    <!-- ============================================= -->
    <!-- PASO 5: Comprobar si existen incidencias     -->
    <!-- ============================================= -->

    <?php if (empty($incidencias)): ?>

        <p>
            Todavía no existen incidencias registradas.
        </p>

    <?php else: ?>

        <!-- ========================================= -->
        <!-- PASO 6: Mostrar las incidencias en tabla -->
        <!-- ========================================= -->

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

                <?php foreach ($incidencias as $incidencia): ?>

                    <tr>
                        <td>
                            <?= e($incidencia['id']) ?>
                        </td>

                        <td>
                            <?= e($incidencia['titulo']) ?>
                        </td>

                        <td>
                            <?= e($incidencia['categoria']) ?>
                        </td>

                        <td>
                            <?= e($incidencia['estado']) ?>
                        </td>

                        <td>
                            <?= e($incidencia['prioridad']) ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

</section>

<?php

// =====================================================
// PASO 7: Cargar el pie de página común.
// =====================================================

require_once __DIR__ . '/../includes/pie.php';

?>
