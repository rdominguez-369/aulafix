-- =====================================================
-- AULAFIX - MIGRACIÓN 01
-- =====================================================
--
-- Objetivo:
-- Ampliar la base de datos inicial para incorporar
-- usuarios, equipos e historial de incidencias.
--
-- También adaptaremos la tabla incidencias para
-- relacionarla con las nuevas tablas.
--
-- IMPORTANTE:
-- Esta migración debe conservar los registros
-- existentes en la tabla incidencias.
--
-- =====================================================

USE aulafix_db;

-- =====================================================
-- PASO 1: CREAR LA TABLA USUARIOS
-- =====================================================
--
-- Almacena los usuarios registrados en AulaFix.
-- Cada usuario tendrá un identificador único,
-- un correo electrónico y un rol.
-- =====================================================

CREATE TABLE IF NOT EXISTS usuarios (

    -- Identificador único del usuario.
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- Nombre del alumno o profesor.
    nombre VARCHAR(100) NOT NULL,

    -- Correo electrónico único.
    email VARCHAR(150) NOT NULL UNIQUE,

    -- Contraseña protegida mediante un hash.
    password_hash VARCHAR(255) NOT NULL,

    -- Rol del usuario dentro de la aplicación.
    rol ENUM('alumno', 'profesor') NOT NULL DEFAULT 'alumno',

    -- Fecha y hora de creación del usuario.
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);


-- =====================================================
-- PASO 2: CREAR LA TABLA EQUIPOS
-- =====================================================
--
-- Almacena los equipos informáticos del centro.
-- Cada equipo tendrá un identificador único,
-- un nombre, un tipo y una ubicación.
-- =====================================================

CREATE TABLE IF NOT EXISTS equipos (

    -- Identificador único del equipo.
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- Nombre que identifica al equipo.
    nombre VARCHAR(100) NOT NULL,

    -- Tipo de dispositivo.
    tipo VARCHAR(50) NOT NULL,

    -- Aula o espacio donde se encuentra.
    ubicacion VARCHAR(100) NOT NULL,


    -- Fecha y hora de registro del equipo.
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    -- Impedir equipos duplicados en la misma ubicación.
    CONSTRAINT uq_equipos_nombre_ubicacion
        UNIQUE (nombre, ubicacion)


);


-- =====================================================
-- PASO 3: AMPLIAR LA TABLA INCIDENCIAS
-- =====================================================
--
-- Añadimos dos columnas para relacionar cada
-- incidencia con un usuario y un equipo.
--
-- Inicialmente permitimos NULL para conservar
-- las cuatro incidencias existentes.
--
-- Las claves foráneas se crearán posteriormente.
-- =====================================================

ALTER TABLE incidencias

    -- Usuario que ha registrado la incidencia.
    ADD COLUMN usuario_id INT NULL,

    -- Equipo al que corresponde la incidencia.
    ADD COLUMN equipo_id INT NULL;


-- =====================================================
-- PASO 4: CREAR LA TABLA HISTORIAL
-- =====================================================
--
-- Registra los cambios de estado de las incidencias.
--
-- Cada registro permitirá identificar:
-- - Qué incidencia se ha modificado.
-- - Qué usuario realizó el cambio.
-- - Cuál era el estado anterior.
-- - Cuál es el nuevo estado.
-- - Cuándo se realizó la modificación.
--
-- Las claves foráneas se añadirán posteriormente.
-- =====================================================

CREATE TABLE IF NOT EXISTS historial (

    -- Identificador único del registro.
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- Incidencia que ha cambiado de estado.
    incidencia_id INT NOT NULL,

    -- Usuario que realizó la modificación.
    usuario_id INT NOT NULL,

    -- Estado anterior de la incidencia.
    estado_anterior VARCHAR(20) NOT NULL,

    -- Nuevo estado de la incidencia.
    estado_nuevo VARCHAR(20) NOT NULL,

    -- Fecha y hora del cambio.
    fecha_cambio TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);


-- =====================================================
-- PASO 5: INSERTAR EQUIPOS DE PRUEBA
-- =====================================================

-- Insertar equipos solamente si no existen.

INSERT INTO equipos (nombre, tipo, ubicacion)
SELECT 'Ordenador 01', 'Ordenador', 'Aula 1'
WHERE NOT EXISTS (
    SELECT 1 FROM equipos
    WHERE nombre = 'Ordenador 01'
      AND ubicacion = 'Aula 1'
);

INSERT INTO equipos (nombre, tipo, ubicacion)
SELECT 'Proyector 01', 'Proyector', 'Aula 3'
WHERE NOT EXISTS (
    SELECT 1 FROM equipos
    WHERE nombre = 'Proyector 01'
      AND ubicacion = 'Aula 3'
);

INSERT INTO equipos (nombre, tipo, ubicacion)
SELECT 'Ordenador 05', 'Ordenador', 'Aula 2'
WHERE NOT EXISTS (
    SELECT 1 FROM equipos
    WHERE nombre = 'Ordenador 05'
      AND ubicacion = 'Aula 2'
);

INSERT INTO equipos (nombre, tipo, ubicacion)
SELECT 'Punto de acceso WiFi', 'Red', 'Aula 2'
WHERE NOT EXISTS (
    SELECT 1 FROM equipos
    WHERE nombre = 'Punto de acceso WiFi'
      AND ubicacion = 'Aula 2'
);


-- =====================================================
-- PASO 6: CREAR USUARIO TÉCNICO DE MIGRACIÓN
-- =====================================================

-- Insertar el usuario técnico solamente si no existe.

INSERT INTO usuarios (nombre, email, password_hash, rol)
SELECT
    'Usuario de migración',
    'migracion@aulafix.invalid',
    CONCAT('!cuenta-bloqueada-', HEX(RANDOM_BYTES(32))),
    'alumno'
WHERE NOT EXISTS (
    SELECT 1
    FROM usuarios
    WHERE email = 'migracion@aulafix.invalid'
);



-- =====================================================
-- PASO 7: RELACIONAR LAS INCIDENCIAS EXISTENTES
-- =====================================================
--
-- Asociamos las cuatro incidencias anteriores
-- con el usuario técnico de migración.
-- =====================================================

UPDATE incidencias
SET usuario_id = (
    SELECT id
    FROM usuarios
    WHERE email = 'migracion@aulafix.invalid'
)
WHERE id IN (1, 2, 3, 4);


-- =====================================================
-- ASOCIAR CADA INCIDENCIA CON SU EQUIPO
-- =====================================================
-- Identificamos los equipos mediante su nombre
-- y ubicación para evitar asociaciones ambiguas.
-- =====================================================

-- Incidencia 1: ordenador que no enciende.
UPDATE incidencias
SET equipo_id = (
    SELECT id
    FROM equipos
    WHERE nombre = 'Ordenador 01'
      AND ubicacion = 'Aula 1'
    ORDER BY id
    LIMIT 1
)
WHERE id = 1;


-- Incidencia 2: proyector sin imagen.
UPDATE incidencias
SET equipo_id = (
    SELECT id
    FROM equipos
    WHERE nombre = 'Proyector 01'
      AND ubicacion = 'Aula 3'
    ORDER BY id
    LIMIT 1
)
WHERE id = 2;


-- Incidencia 3: teclado averiado.
UPDATE incidencias
SET equipo_id = (
    SELECT id
    FROM equipos
    WHERE nombre = 'Ordenador 05'
      AND ubicacion = 'Aula 2'
    ORDER BY id
    LIMIT 1
)
WHERE id = 3;


-- Incidencia 4: problema de conexión WiFi.
UPDATE incidencias
SET equipo_id = (
    SELECT id
    FROM equipos
    WHERE nombre = 'Punto de acceso WiFi'
      AND ubicacion = 'Aula 2'
    ORDER BY id
    LIMIT 1
)
WHERE id = 4;


-- =====================================================
-- PASO 8: NORMALIZAR LOS ESTADOS DE LAS INCIDENCIAS
-- =====================================================
--
-- Adaptamos el estado antiguo "Pendiente" al
-- nuevo estado "abierta".
--
-- Los estados utilizados a partir de ahora serán:
-- - abierta
-- - en_curso
-- - resuelta
-- =====================================================

UPDATE incidencias
SET estado = 'abierta'
WHERE estado = 'Pendiente';


-- Actualizar el estado predeterminado para
-- las nuevas incidencias.

ALTER TABLE incidencias
    MODIFY COLUMN estado VARCHAR(20)
    NOT NULL DEFAULT 'abierta';


-- =====================================================
-- PASO 9: ESTABLECER LAS CLAVES FORÁNEAS
-- =====================================================
--
-- Relacionamos las incidencias con sus usuarios
-- y equipos, y el historial con las incidencias
-- y los usuarios que realizaron los cambios.
-- =====================================================

-- Relaciones de la tabla incidencias.
ALTER TABLE incidencias

    ADD CONSTRAINT fk_incidencias_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id),

    ADD CONSTRAINT fk_incidencias_equipo
        FOREIGN KEY (equipo_id)
        REFERENCES equipos(id);


-- Relaciones de la tabla historial.
ALTER TABLE historial

    ADD CONSTRAINT fk_historial_incidencia
        FOREIGN KEY (incidencia_id)
        REFERENCES incidencias(id),

    ADD CONSTRAINT fk_historial_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id);
