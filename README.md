# 🛠️ AulaFix — Sistema de Gestión de Incidencias del Aula

## 📌 Descripción del proyecto

**AulaFix** es una aplicación web desarrollada como proyecto integrador de los módulos de **Desarrollo Web en Entorno Cliente (DWEC)** y **Desarrollo Web en Entorno Servidor (DWES)** del ciclo formativo de Grado Superior en Desarrollo de Aplicaciones Web (DAW).

Su objetivo es facilitar el registro y la consulta de incidencias técnicas relacionadas con los equipos informáticos de un centro educativo.

La aplicación permite registrar problemas, asociarlos a equipos existentes y consultar las incidencias almacenadas en una base de datos MySQL.

También incorpora funcionalidades interactivas mediante JavaScript para mejorar la experiencia del usuario.

## 🎯 Objetivos

- Desarrollar una aplicación web dinámica utilizando PHP y JavaScript.
- Implementar una base de datos relacional mediante MySQL.
- Realizar operaciones de consulta e inserción utilizando PDO.
- Aplicar validaciones tanto en el cliente como en el servidor.
- Utilizar JavaScript para manipular el DOM y gestionar eventos.
- Implementar filtros dinámicos sin recargar la página.
- Utilizar `localStorage` para almacenar temporalmente información.
- Organizar el proyecto mediante archivos y funciones reutilizables.
- Utilizar Docker para configurar un entorno de ejecución reproducible.
- Gestionar el código fuente mediante Git y GitHub.

## 💻 Tecnologías utilizadas

| Tecnología | Utilización |
|---|---|
| HTML5 | Estructura de las páginas y formularios |
| CSS3 | Estilos de la interfaz |
| JavaScript | Interactividad, filtros y validaciones |
| PHP | Lógica del servidor y procesamiento de formularios |
| MySQL 8 | Almacenamiento de datos |
| PDO | Conexión y consultas a la base de datos |
| Apache | Servidor web |
| Docker y Docker Compose | Entorno de ejecución |
| Git y GitHub | Control de versiones |

## ⚙️ Funcionalidades implementadas

### 1. Gestión de incidencias — DWES

La aplicación permite:

- Consultar las incidencias registradas en MySQL.
- Registrar nuevas incidencias mediante formularios HTML.
- Validar los datos recibidos en el servidor.
- Clasificar las incidencias por categoría y prioridad.
- Asociar cada incidencia con un equipo existente.
- Asignar automáticamente el estado inicial `abierta`.
- Mostrar mensajes de confirmación después de registrar una incidencia.

Las operaciones con MySQL se realizan mediante PDO, utilizando consultas preparadas para insertar información.

### 2. Buscador dinámico — DWEC

Se ha implementado un buscador que permite localizar incidencias por su título.

La búsqueda se realiza mediante JavaScript y actualiza los resultados sin recargar la página.

Conceptos aplicados:

- Manipulación del DOM.
- Eventos `input`.
- Arrays.
- Método `filter()`.
- Método `includes()`.
- Funciones y condicionales.

### 3. Filtros por estado y prioridad — DWEC

El listado incorpora filtros que permiten seleccionar incidencias según:

**Estado:**
- Abierta.
- En curso.
- Resuelta.

**Prioridad:**
- Alta.
- Media.
- Baja.

Los filtros pueden combinarse con el buscador de títulos.

También se muestra un contador con el número de incidencias visibles respecto del total.

### 4. Validación interactiva de formularios — DWEC

El formulario de registro incorpora:

- Comprobación de campos obligatorios.
- Validación del título.
- Contador dinámico de caracteres, con un máximo de 100.
- Comprobación de categoría, equipo y prioridad.
- Mensajes de advertencia cuando los datos no son válidos.

Estas validaciones complementan las comprobaciones realizadas por PHP en el servidor.

### 5. Guardado automático de borradores — DWEC

Mediante `localStorage`, la aplicación permite guardar temporalmente los datos introducidos en el formulario.

Características:

- Guardado automático mientras el usuario escribe.
- Recuperación de datos después de recargar la página.
- Conservación del borrador al navegar entre páginas.
- Eliminación programada del borrador después de un registro exitoso.

Esta funcionalidad utiliza objetos JavaScript, `JSON.stringify()` y `JSON.parse()`.

## 🗂️ Estructura del proyecto

```text
aulafix/
│
├── backups/
│   └── aulafix_antes_migracion.sql
│
├── database/
│   ├── migracion_01_test.sql
│   ├── migracion_01.sql
│   └── schema.sql
│
├── includes/
│   ├── cabecera.php
│   ├── db.php
│   ├── equipos.php
│   ├── funciones.php
│   ├── incidencias.php
│   └── pie.php
│
├── public/
│   ├── css/
│   │   └── estilos.css
│   ├── js/
│   │   └── main.js
│   ├── incidencias.php
│   ├── index.php
│   ├── nueva-incidencia-test.php
│   └── nueva-incidencia.php
│
├── .env
├── .env.example
├── .gitignore
├── config.php
├── docker-compose.yml
├── Dockerfile
└── README.md
```

### Descripción de los directorios

**`backups/`**

Contiene copias de seguridad de la base de datos realizadas antes de operaciones importantes, como las migraciones.

**`database/`**

Almacena los scripts SQL utilizados para crear y modificar la estructura de la base de datos.

**`includes/`**

Contiene archivos PHP reutilizables relacionados con la conexión a MySQL, la gestión de incidencias, la consulta de equipos y los componentes comunes de la interfaz.

**`public/`**

Contiene los archivos accesibles desde el navegador, incluyendo las páginas PHP y los recursos CSS y JavaScript.

**Archivos de configuración**

- `.env`: variables de entorno privadas.
- `.env.example`: referencia para configurar las variables necesarias.
- `.gitignore`: archivos excluidos del control de versiones.
- `config.php`: configuración de conexión a MySQL.
- `docker-compose.yml`: definición de los servicios Docker.
- `Dockerfile`: configuración de la imagen del servidor web.

**Nota:** los archivos de respaldo, las variables privadas y los archivos temporales de pruebas se mantienen excluidos del repositorio mediante `.gitignore`.

## 🗄️ Base de datos

AulaFix utiliza una base de datos MySQL denominada `aulafix_db`.

Su estructura actual está formada por cuatro tablas:

| Tabla | Función |
|---|---|
| `usuarios` | Almacena información de usuarios |
| `equipos` | Registra los dispositivos informáticos |
| `incidencias` | Almacena los problemas comunicados |
| `historial` | Estructura destinada a registrar cambios de estado |

La tabla `incidencias` dispone de relaciones con las tablas `usuarios` y `equipos` mediante claves foráneas.

Durante el desarrollo se realizó una migración que permitió ampliar la estructura inicial sin perder las incidencias existentes.

También se utilizó una base de datos independiente, `aulafix_test`, para comprobar las migraciones y operaciones SQL antes de aplicarlas a la base principal.

## 🚀 Ejecución del proyecto

### Requisitos previos

- Docker Desktop instalado.
- Docker Compose disponible.
- Git instalado.
- Navegador web actualizado.

### 1. Clonar el repositorio

```bash
git clone https://github.com/rdominguez-369/aulafix.git
```

```bash
cd aulafix
```

### 2. Configurar las variables de entorno

Crear el archivo `.env` a partir de `.env.example`.

```bash
cp .env.example .env
```

Revisar las variables de configuración y establecer las credenciales correspondientes al entorno local.

### 3. Iniciar los contenedores

```bash
docker compose up -d --build
```

### 4. Comprobar los servicios

```bash
docker compose ps
```

### 5. Acceder a la aplicación

Abrir en el navegador:

**http://localhost:8080**

La aplicación necesita que la base de datos tenga aplicado el esquema y la migración correspondiente. La preparación de una instalación nueva debe verificarse según la configuración de inicialización de MySQL utilizada en Docker Compose.

## 🔐 Seguridad implementada

Durante el desarrollo se han aplicado diferentes medidas de seguridad:

- Validación de datos recibidos mediante PHP.
- Consultas preparadas con PDO.
- Protección de formularios mediante tokens CSRF.
- Escape de contenido HTML al mostrar datos.
- Validación de identificadores de equipos.
- Separación de las credenciales mediante variables de entorno.
- Exclusión de archivos sensibles del repositorio Git.
- Comprobación de permisos de MySQL.

Las validaciones JavaScript mejoran la experiencia del usuario, pero no sustituyen las validaciones del servidor.

## 🧪 Pruebas realizadas

Se han comprobado satisfactoriamente:

- Conexión de PHP con MySQL.
- Consulta de incidencias almacenadas.
- Registro de nuevas incidencias.
- Asociación de incidencias con equipos existentes.
- Conservación de datos durante una migración.
- Búsqueda de incidencias por título.
- Filtrado por estado y prioridad.
- Actualización dinámica del contador de resultados.
- Validación de campos obligatorios.
- Contador de caracteres del título.
- Recuperación de borradores mediante `localStorage`.
- Conservación del borrador al navegar entre páginas.
- Comprobaciones de sintaxis PHP y JavaScript.

## 📋 Funcionalidades pendientes

AulaFix es una versión funcional parcial del proyecto integrador.

Quedan pendientes funcionalidades como:

- Registro y autenticación de usuarios.
- Inicio y cierre de sesión.
- Gestión de permisos según roles.
- Asociación automática de incidencias al usuario autenticado.
- Modificación del estado de las incidencias.
- Consulta y gestión del historial de cambios.
- Mejoras de diseño responsive y accesibilidad.
- Ampliación de las pruebas funcionales y de seguridad.

## 📚 Aprendizajes adquiridos

El desarrollo de AulaFix ha permitido integrar conocimientos de programación en entorno cliente y servidor.

En DWES se ha trabajado con PHP, formularios, sesiones, PDO, MySQL, migraciones y validación de datos.

En DWEC se han aplicado JavaScript, manipulación del DOM, eventos, arrays, funciones, filtros dinámicos, validaciones y almacenamiento local.

También se ha trabajado con Docker para configurar el entorno de ejecución y con Git y GitHub para gestionar los avances del proyecto.

## 👨‍💻 Autor

**Renzo Domínguez**

Ciclo Formativo de Grado Superior en Desarrollo de Aplicaciones Web (DAW).

Proyecto integrador de Desarrollo Web en Entorno Cliente y Desarrollo Web en Entorno Servidor.

**Curso académico:** 2026–2027.

---

**Estado del proyecto:** versión funcional parcial, desarrollada con fines académicos.

**Última actualización:** noviembre de 2026.
