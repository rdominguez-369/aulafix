<?php

/**
 * =====================================================
 * AULAFIX - REGISTRO DE NUEVA INCIDENCIA
 * =====================================================
 *
 * Este archivo permite mostrar y procesar el formulario
 * de registro de incidencias del aula.
 *
 * Funcionalidades:
 * - Recibir los datos enviados mediante POST.
 * - Validar los campos en el servidor.
 * - Utilizar funciones PHP reutilizables.
 * - Mostrar errores de validación.
 * - Conservar los valores introducidos.
 * - Mostrar un mensaje de confirmación.
 *
 * IMPORTANTE:
 * Todavía no almacena incidencias en MySQL.
 */

// =====================================================
// PASO 1: Definir el título de la página.
// =====================================================

$tituloPagina = 'Nueva incidencia';


// =====================================================
// PASO 2: Cargar las funciones reutilizables.
// =====================================================

require_once __DIR__ . '/../includes/funciones.php';


// =====================================================
// PASO 3: Obtener las opciones permitidas.
// =====================================================

// Obtener las categorías desde la función reutilizable.
$categoriasValidas = obtenerCategorias();

// Obtener las prioridades desde la función reutilizable.
$prioridadesValidas = obtenerPrioridades();


// =====================================================
// PASO 4: Inicializar las variables.
// =====================================================

// Array para almacenar los mensajes de error.
$errores = [];

// Mensaje que aparecerá si los datos son válidos.
$mensajeExito = '';

// Variables que almacenarán los datos del formulario.
$titulo = '';
$descripcion = '';
$categoria = '';
$prioridad = '';


// =====================================================
// PASO 5: Comprobar si se ha enviado el formulario.
// =====================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // =================================================
    // PASO 6: Obtener y limpiar los datos recibidos.
    // =================================================
    
    $titulo = limpiarCampo($_POST['titulo'] ?? '');
    $descripcion = limpiarCampo($_POST['descripcion'] ?? '');
    $categoria = limpiarCampo($_POST['categoria'] ?? '');
    $prioridad = limpiarCampo($_POST['prioridad'] ?? '');


    // =================================================
    // PASO 7: Validar el título.
    // =================================================

    if ($titulo === '') {

        $errores[] = 'El título es obligatorio.';

    } elseif (mb_strlen($titulo) > 100) {

        $errores[] = 'El título no puede superar 100 caracteres.';

    }


    // =================================================
    // PASO 8: Validar la descripción.
    // =================================================

    if ($descripcion === '') {

        $errores[] = 'La descripción es obligatoria.';

    }


    // =================================================
    // PASO 9: Validar la categoría.
    // =================================================

    // Comprobar que la categoría recibida pertenece
    // a las opciones devueltas por obtenerCategorias().

    if (!in_array($categoria, $categoriasValidas, true)) {

        $errores[] = 'La categoría seleccionada no es válida.';

    }


    // =================================================
    // PASO 10: Validar la prioridad.
    // =================================================

    // Comprobar que la prioridad recibida pertenece
    // a las opciones devueltas por obtenerPrioridades().

    if (!in_array($prioridad, $prioridadesValidas, true)) {

        $errores[] = 'La prioridad seleccionada no es válida.';

    }


    // =================================================
    // PASO 11: Comprobar si existen errores.
    // =================================================

    // Si el array $errores está vacío, significa
    // que todos los campos han superado la validación.

    if (empty($errores)) {

        $mensajeExito =
            'Incidencia validada correctamente. '
            . 'Todavía no se ha guardado en la base de datos.';

    }

}


// =====================================================
// PASO 12: Cargar la cabecera común.
// =====================================================

require_once __DIR__ . '/../includes/cabecera.php';

?>

<!-- =================================================
     AULAFIX - FORMULARIO DE NUEVA INCIDENCIA
     ================================================= -->

<section>

    <h2>Registrar nueva incidencia</h2>

    <p>
        Completa el formulario para comunicar
        un problema en el aula.
    </p>


    <!-- =============================================
         PASO 13: Mostrar errores de validación.
         ============================================= -->

    <?php if (!empty($errores)): ?>

        <div role="alert">

            <h3>Se encontraron errores:</h3>

            <ul>

                <?php foreach ($errores as $error): ?>

                    <li><?= e($error) ?></li>

                <?php endforeach; ?>

            </ul>

        </div>

    <?php endif; ?>


    <!-- =============================================
         PASO 14: Mostrar mensaje de confirmación.
         ============================================= -->

    <?php if ($mensajeExito !== ''): ?>

        <p role="status">
            <?= e($mensajeExito) ?>
        </p>

    <?php endif; ?>


    <!-- =============================================
         PASO 15: Mostrar el formulario HTML.
         ============================================= -->

    <form action="/nueva-incidencia.php" method="POST">

        <!-- CAMPO 1: Título de la incidencia -->

        <div>

            <label for="titulo">Título:</label>

            <input
                type="text"
                id="titulo"
                name="titulo"
                maxlength="100"
                value="<?= e($titulo) ?>"
                required
            >

        </div>


        <!-- CAMPO 2: Descripción de la incidencia -->

        <div>

            <label for="descripcion">Descripción:</label>

            <textarea
                id="descripcion"
                name="descripcion"
                rows="5"
                required
            ><?= e($descripcion) ?></textarea>

        </div>


        <!-- CAMPO 3: Categoría de la incidencia -->

        <div>

            <label for="categoria">Categoría:</label>

            <select
                id="categoria"
                name="categoria"
                required
            >

                <option value="">
                    Selecciona una categoría
                </option>

                <?php foreach ($categoriasValidas as $opcion): ?>

                    <option
                        value="<?= e($opcion) ?>"
                        <?= $categoria === $opcion ? 'selected' : '' ?>
                    >
                        <?= e($opcion) ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <!-- CAMPO 4: Prioridad de la incidencia -->

        <div>

            <label for="prioridad">Prioridad:</label>

            <select
                id="prioridad"
                name="prioridad"
                required
            >

                <option value="">
                    Selecciona una prioridad
                </option>

                <?php foreach ($prioridadesValidas as $opcion): ?>

                    <option
                        value="<?= e($opcion) ?>"
                        <?= $prioridad === $opcion ? 'selected' : '' ?>
                    >
                        <?= e($opcion) ?>
                    </option>

                <?php endforeach; ?>

            </select>

        </div>


        <!-- BOTÓN: Enviar el formulario -->

        <div>

            <button type="submit">
                Registrar incidencia
            </button>

        </div>

    </form>

</section>

<?php

// =====================================================
// PASO 16: Cargar el pie de página común.
// =====================================================

require_once __DIR__ . '/../includes/pie.php';

?>
