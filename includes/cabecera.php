<?php

/**
 * =====================================================
 * AULAFIX - CABECERA COMÚN
 * =====================================================
 *
 * Este archivo contiene la estructura HTML inicial
 * y el menú de navegación de la aplicación.
 */

// PASO 1: Cargar las funciones reutilizables.
require_once __DIR__ . '/funciones.php';

// PASO 2: Definir un título predeterminado.
// Si la página ya ha definido $tituloPagina,
// conservaremos ese valor.
$tituloPagina = $tituloPagina ?? 'AulaFix';

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title><?= e($tituloPagina) ?> | AulaFix</title>

    <!-- Hoja de estilos principal -->
    <link rel="stylesheet" href="/css/estilos.css">
</head>

<body>

    <!-- CABECERA PRINCIPAL -->
    <header>
        <h1>AulaFix</h1>

        <p>Gestión de incidencias del aula</p>

        <!-- MENÚ DE NAVEGACIÓN -->
        <nav aria-label="Navegación principal">
            <a href="/index.php">Inicio</a>
            <a href="/incidencias.php">Incidencias</a>
            <a href="/nueva-incidencia.php">Nueva incidencia</a>
        </nav>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main>
