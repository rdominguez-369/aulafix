
-- =====================================================
-- AULAFIX - ESQUEMA DE BASE DE DATOS
-- =====================================================
--
-- Este archivo define la estructura de la tabla
-- utilizada para almacenar las incidencias del aula.
--
-- Base de datos: aulafix_db
-- Motor: MySQL 8
-- =====================================================


-- PASO 1: Seleccionar la base de datos.
USE aulafix_db;


-- PASO 2: Crear la tabla de incidencias.
CREATE TABLE IF NOT EXISTS incidencias (

    -- Identificador único de cada incidencia.
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- Título del problema.
    titulo VARCHAR(100) NOT NULL,

    -- Descripción detallada.
    descripcion TEXT NOT NULL,

    -- Categoría de la incidencia.
    categoria VARCHAR(30) NOT NULL,

    -- Nivel de prioridad.
    prioridad VARCHAR(10) NOT NULL,

    -- Estado inicial de la incidencia.
    estado VARCHAR(20) NOT NULL DEFAULT 'Pendiente',

    -- Fecha y hora de creación.
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);
