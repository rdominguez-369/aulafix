
"use strict";

/**
 * AULAFIX - FILTROS DINÁMICOS DE INCIDENCIAS
 *
 * Permite buscar y filtrar las incidencias
 * sin recargar la página.
 */

document.addEventListener("DOMContentLoaded", () => {

    // Obtener los elementos del DOM.
    const buscador = document.getElementById("buscarIncidencia");
    const filtroEstado = document.getElementById("filtrarEstado");
    const filtroPrioridad = document.getElementById("filtrarPrioridad");
    const tabla = document.getElementById("tablaIncidencias");
    const resultado = document.getElementById("resultadoFiltros");

    // Evitar errores en páginas que no tengan la tabla.
    if (!buscador || !filtroEstado || !filtroPrioridad || !tabla || !resultado) {
        return;
    }

    // Obtener todas las filas del cuerpo de la tabla.
    const filas = Array.from(tabla.querySelectorAll("tbody tr"));

    /**
     * Filtra las incidencias según los criterios
     * seleccionados por el usuario.
     */
    function filtrarIncidencias() {

        const texto = buscador.value.trim().toLowerCase();
        const estado = filtroEstado.value.toLowerCase();
        const prioridad = filtroPrioridad.value.toLowerCase();

        // Filtrar las filas utilizando el método filter().
        const filasVisibles = filas.filter((fila) => {

            const celdas = fila.querySelectorAll("td");

            const tituloFila = celdas[1].textContent.trim().toLowerCase();
            const estadoFila = celdas[3].textContent.trim().toLowerCase();
            const prioridadFila = celdas[4].textContent.trim().toLowerCase();

            const coincideTitulo = tituloFila.includes(texto);
            const coincideEstado = estado === "" || estadoFila === estado;
            const coincidePrioridad = prioridad === "" || prioridadFila === prioridad;

            return coincideTitulo && coincideEstado && coincidePrioridad;
        });

        // Mostrar únicamente las filas coincidentes.
        filas.forEach((fila) => {
            fila.hidden = !filasVisibles.includes(fila);
        });

        // Mostrar la cantidad de resultados.
        resultado.textContent =
            `Mostrando ${filasVisibles.length} de ${filas.length} incidencias.`;
    }

    // Eventos que ejecutan el filtrado.
    buscador.addEventListener("input", filtrarIncidencias);
    filtroEstado.addEventListener("change", filtrarIncidencias);
    filtroPrioridad.addEventListener("change", filtrarIncidencias);

    // Mostrar el contador inicial.
    filtrarIncidencias();
});


/**
 * ============================================
 * AULAFIX - VALIDACIÓN DEL FORMULARIO
 * ============================================
 */

document.addEventListener("DOMContentLoaded", () => {

    const formulario = document.getElementById("formNuevaIncidencia");

    // Solo ejecutar en la página del formulario.
    if (!formulario) {
        return;
    }

    const titulo = document.getElementById("titulo");
    const descripcion = document.getElementById("descripcion");
    const categoria = document.getElementById("categoria");
    const equipo = document.getElementById("equipo_id");
    const prioridad = document.getElementById("prioridad");
    const contador = document.getElementById("contadorTitulo");

    if (!titulo || !descripcion || !categoria ||
        !equipo || !prioridad || !contador) {
        return;
    }

    // Contador de caracteres del título.
    function actualizarContador() {
        const cantidad = titulo.value.length;
        contador.textContent = `${cantidad} / 100 caracteres`;
    }

    titulo.addEventListener("input", actualizarContador);
    actualizarContador();


    // ============================================
    // AULAFIX - BORRADOR CON LOCALSTORAGE
    // ============================================

    const CLAVE_BORRADOR = "aulafix_borrador_incidencia";

    const campos = [
        titulo,
        descripcion,
        categoria,
        equipo,
        prioridad
    ];

    // Recuperar el borrador guardado.
    function recuperarBorrador() {

        const borradorGuardado = localStorage.getItem(CLAVE_BORRADOR);

        if (!borradorGuardado) {
            return;
        }

        try {
            const borrador = JSON.parse(borradorGuardado);

            campos.forEach((campo) => {
                if (
                    Object.prototype.hasOwnProperty.call(
                        borrador,
                        campo.name
                    )
                ) {
                    campo.value = borrador[campo.name];
                }
            });

            actualizarContador();

        } catch (error) {
            console.error("Error al recuperar el borrador:", error);
            localStorage.removeItem(CLAVE_BORRADOR);
        }
    }

    // Guardar automáticamente el borrador.
    function guardarBorrador() {

        const borrador = {};

        campos.forEach((campo) => {
            borrador[campo.name] = campo.value;
        });

        localStorage.setItem(
            CLAVE_BORRADOR,
            JSON.stringify(borrador)
        );
    }

    // Detectar modificaciones.
    campos.forEach((campo) => {
        campo.addEventListener("input", guardarBorrador);
        campo.addEventListener("change", guardarBorrador);
    });

    // Recuperar los datos al cargar la página.
    recuperarBorrador();


    // Validación antes del envío.
    formulario.addEventListener("submit", (evento) => {

        const errores = [];

        if (titulo.value.trim().length === 0) {
            errores.push("El título es obligatorio.");
        } else if (titulo.value.trim().length > 100) {
            errores.push("El título no puede superar 100 caracteres.");
        }

        if (descripcion.value.trim().length === 0) {
            errores.push("La descripción es obligatoria.");
        }

        if (categoria.value === "") {
            errores.push("Selecciona una categoría.");
        }

        if (equipo.value === "") {
            errores.push("Selecciona un equipo.");
        }

        if (prioridad.value === "") {
            errores.push("Selecciona una prioridad.");
        }

        if (errores.length > 0) {
            evento.preventDefault();
            alert(errores.join("\n"));
        }
    });
});
