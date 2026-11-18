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

    <!-- Eliminar el borrador solo después de un registro exitoso -->
    <script>
        localStorage.removeItem("aulafix_borrador_incidencia");
    </script>

<?php endif; ?>

<p>
    Consulta las incidencias registradas
    en los equipos del aula.
</p>


<!-- ========================================= -->
<!-- FILTROS DINÁMICOS - DWEC                 -->
<!-- ========================================= -->

<div class="filtros-incidencias">

    <h3>Buscar y filtrar incidencias</h3>

    <label for="buscarIncidencia">Buscar por título:</label>
    <input
        type="search"
        id="buscarIncidencia"
        placeholder="Escribe el título..."
    >

    <label for="filtrarEstado">Estado:</label>
    <select id="filtrarEstado">
        <option value="">Todos los estados</option>
        <option value="abierta">Abierta</option>
        <option value="en_curso">En curso</option>
        <option value="resuelta">Resuelta</option>
    </select>

    <label for="filtrarPrioridad">Prioridad:</label>
    <select id="filtrarPrioridad">
        <option value="">Todas las prioridades</option>
        <option value="Alta">Alta</option>
        <option value="Media">Media</option>
        <option value="Baja">Baja</option>
    </select>

    <p id="resultadoFiltros" role="status" aria-live="polite"></p>

</div>


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

        <table id="tablaIncidencias">

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
