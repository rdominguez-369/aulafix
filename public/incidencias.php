<?php

/**
 * =====================================================
 * AULAFIX - LISTADO DE INCIDENCIAS
 * =====================================================
 *
 * Primera versión del listado utilizando
 * datos de ejemplo almacenados en un array.
 *
 * Posteriormente utilizaremos MySQL.
 */

// PASO 1: Definir el título de la página.
$tituloPagina = 'Incidencias';

// PASO 2: Crear un array con incidencias de ejemplo.
$incidencias = [
    [
        'id' => 1,
        'titulo' => 'Ordenador no enciende',
        'categoria' => 'Hardware',
        'estado' => 'Pendiente',
        'prioridad' => 'Alta'
    ],
    [
        'id' => 2,
        'titulo' => 'Problema de conexión a Internet',
        'categoria' => 'Redes',
        'estado' => 'En proceso',
        'prioridad' => 'Media'
    ],
    [
        'id' => 3,
        'titulo' => 'Proyector sin imagen',
        'categoria' => 'Hardware',
        'estado' => 'Resuelta',
        'prioridad' => 'Baja'
    ]
];

// PASO 3: Cargar la cabecera común.
require_once __DIR__ . '/../includes/cabecera.php';

?>

<section>
    <h2>Listado de incidencias</h2>

    <p>
        Consulta las incidencias registradas
        en los equipos del aula.
    </p>

    <!-- PASO 4: Mostrar las incidencias -->
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

// PASO 5: Cargar el pie de página común.
require_once __DIR__ . '/../includes/pie.php';

?>
