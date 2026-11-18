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
 * Las incidencias se almacenan en MySQL mediante PDO.
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
// PASO 2.1: Cargar las funciones de incidencias.
// =====================================================

// Permite utilizar guardarIncidencia(), que inserta
// los registros en MySQL mediante PDO.

require_once __DIR__ . '/../includes/incidencias.php';


 
// =====================================================
// PASO 2.2: Cargar las funciones de equipos.
// =====================================================

// Permite utilizar obtenerEquipos() para consultar
// los dispositivos registrados en MySQL.

require_once __DIR__ . '/../includes/equipos.php';

// =====================================================
// PASO 3: Generar o recuperar el token CSRF.
// =====================================================

// Esta llamada inicia la sesión, si es necesario,
// y obtiene el token que utilizaremos en el formulario.

$tokenCSRF = obtenerTokenCSRF();


// =====================================================
// PASO 3: Obtener las opciones permitidas.
// =====================================================

// Obtener las categorías desde la función reutilizable.
$categoriasValidas = obtenerCategorias();

// Obtener las prioridades desde la función reutilizable.
$prioridadesValidas = obtenerPrioridades();

// =====================================================
// PASO 3.1: Preparar la lista de equipos.
// =====================================================

// Obtener los equipos registrados en la base de datos.
$equipos = obtenerEquipos();


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

$equipoId = null;

// =====================================================
// PASO 5: Comprobar si se ha enviado el formulario.
// =====================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // =====================================================
    // PASO 5: Comprobar el token CSRF recibido.
    // =====================================================

    $tokenRecibido = $_POST['csrf_token'] ?? '';

    if (
        !is_string($tokenRecibido)
        || !validarTokenCSRF($tokenRecibido)
    ) {
        $errores[] = 'La solicitud no es válida. Recarga el formulario.';
    }

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

    // =====================================================
    // Validar el equipo afectado.
    // =====================================================

    $equipoRecibido = $_POST['equipo_id'] ?? null;

    $equipoId = filter_var(
        $equipoRecibido,
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]
    );

    if ($equipoId === false || $equipoId === null) {

        $errores[] = 'Debes seleccionar un equipo válido.';

    } elseif (!existeEquipo($equipoId)) {

        $errores[] = 'El equipo seleccionado no existe.';

    }

    // =====================================================
    // PASO 11: Guardar la incidencia si no existen errores.
    // =====================================================

    if (empty($errores)) {

        try {

            // PASO 11.1: Insertar la incidencia en MySQL.
            // La función devuelve el ID del nuevo registro.

            $idIncidencia = guardarIncidencia(
                $titulo,
                $descripcion,
                $categoria,
                $prioridad,
                $equipoId
            );

            // PASO 11.2: Guardar un mensaje temporal
            // en la sesión para mostrarlo después.

            $_SESSION['mensaje_exito'] =
                'Incidencia registrada correctamente. '
                . 'Identificador: ' . $idIncidencia;

            // PASO 11.3: Redirigir al listado de incidencias.
            // Evita repetir el POST al actualizar la página.

            header('Location: /incidencias.php', true, 303);
            exit;

        } catch (PDOException $e) {

            // PASO 11.4: Mostrar un mensaje genérico
            // si ocurre un error en la base de datos.
            // No exponemos información interna de MySQL.

            error_log($e->getMessage());

            $errores[] =
                'No se pudo registrar la incidencia. '
                . 'Inténtalo nuevamente.';

        }

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

    <form
    id="formNuevaIncidencia"
    action="/nueva-incidencia.php"
    method="POST"
    >

    <!-- PASO 13.1: Enviar el token de seguridad CSRF -->

    <input
        type="hidden"
        name="csrf_token"
        value="<?= e($tokenCSRF) ?>"
    >
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

            <small id="contadorTitulo" aria-live="polite">
                0 / 100 caracteres
            </small>

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


        <!-- =====================================================
            CAMPO 4: Equipo afectado
            ===================================================== -->

        <?php if (!empty($equipos)): ?>

            <div>

                <label for="equipo_id">Equipo afectado:</label>

                <select
                    id="equipo_id"
                    name="equipo_id"
                    required
                >

                    <option value="">
                        Selecciona un equipo
                    </option>

                    <?php foreach ($equipos as $equipo): ?>

                        <option
                            value="<?= (int) $equipo['id'] ?>"
                            <?= $equipoId === (int) $equipo['id'] ? 'selected' : '' ?>
                        >
                            <?= e($equipo['nombre']) ?>
                            -
                            <?= e($equipo['ubicacion']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

        <?php endif; ?>


        <!-- CAMPO 5: Prioridad de la incidencia -->

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
