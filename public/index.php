
<?php

/**
 * =====================================================
 * AULAFIX - COMPROBACIÓN INICIAL DEL SERVIDOR
 * =====================================================
 *
 * Objetivo:
 * Comprobar que PHP funciona correctamente
 * dentro del contenedor Docker.
 */

// PASO 1: Obtener la versión actual de PHP.
$versionPHP = PHP_VERSION;

// PASO 2: Comprobar si PDO está disponible.
$pdoDisponible = extension_loaded('pdo_mysql');

// PASO 3: Preparar el mensaje de comprobación.
$mensaje = '¡AulaFix está funcionando correctamente!';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>AulaFix - Prueba inicial</title>
</head>
<body>

    <h1><?= htmlspecialchars($mensaje) ?></h1>

    <h2>Información del servidor</h2>

    <p>
        Versión de PHP:
        <strong><?= htmlspecialchars($versionPHP) ?></strong>
    </p>

    <p>
        Extensión PDO MySQL:
        <strong>
            <?= $pdoDisponible ? 'Disponible' : 'No disponible' ?>
        </strong>
    </p>

    <p>
        Servidor PHP ejecutándose mediante Docker.
    </p>

</body>
</html>
