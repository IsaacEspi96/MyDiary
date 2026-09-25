<?php
session_start();

if (!isset($_SESSION['idUsuario'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyDiary</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Tabulator -->
    <link href="https://unpkg.com/tabulator-tables@6.5.0/dist/css/tabulator_bootstrap5.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@6.5.0/dist/js/tabulator.min.js"></script>

    <!-- js Útiles-->
    <script src="js/jquery-4.0.0.min.js"></script>
    <script src="js/configContenido.js"></script>
    <script src="js/funciones.js"></script>
    <!-- js Principal -->
    <script src="js/contenido.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/main.css" />
    <!-- Favicon -->
    <link rel="icon" href="images/favicon.svg" type="image/svg+xml">
</head>

<body>

    <?php include 'cabecera.php'; ?>


    <!---------------------------- CONTENIDO ---------------------------------->

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 col-md-2 d-flex flex-column align-items-center gap-2">

                <div id="capaHistorial" class="position-relative w-100">
                    <button type="button" id="botHistorial" class="btn w-100 py-0" data-bs-toggle="collapse" data-bs-target="#panelHistorial"> Historial </button>

                    <div id="panelHistorial" class="collapse">
                        <div id="contenidoHistorial" class="mt-3 pe-2">
                        </div>
                    </div>
                </div>

                <search>
                    <form id="buscarForm" class="d-flex align-items-center mt-4">
                        <div class="input-group input-group-sm" style="width: 180px;">
                            <input type="search" class="form-control" id="cajaBusqueda" placeholder="" required>
                            <button type="submit" class="btn" id="botonBuscar">
                                <i class="bi bi-search small"></i>
                            </button>
                        </div>
                    </form>
                </search>

                <button type="button" class="mt-4" id="botAgregar" data-bs-toggle="modal" data-bs-target="#modalAgregar"></button>

                <button type="button" id="botFav">Favoritas</button>

                <button type="button" id="botPendientes" class="mt-4">Pendientes</button>

                <button type="button" id="botAgregarPend" data-bs-toggle="modal" data-bs-target="#modalPendiente">Agregar Pendiente</button>

            </div>

            <div class="col-12 col-md-8">
                <div id="nuevosBotones"></div>
                <div id="tituloTablas"></div>
                <div class="w-100" id="tablas"></div>
            </div>

            <div id="botones" class="col-12 col-md-2 d-flex flex-column align-items-center gap-4">
                <h1 class="text-center text-white">Búsqueda por valoración:</h1>
                <div class="d-flex justify-content-center gap-4">
                    <button type="button" class="botEstrella" id="botEstrella5"> <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i> </button>

                    <button type="button" class="botEstrella" id="botEstrella4.5"> <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i> </button>
                </div>

                <div class="d-flex justify-content-center gap-4">
                    <button type="button" class="botEstrella" id="botEstrella4"> <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i> </button>

                    <button type="button" class="botEstrella" id="botEstrella3.5"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i> </button>
                </div>
                <div class="d-flex justify-content-center gap-4">
                    <button type="button" class="botEstrella" id="botEstrella3"> <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i> </button>

                    <button type="button" class="botEstrella" id="botEstrella2.5"> <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i> </button>
                </div>
                <div class="d-flex justify-content-center gap-4">
                    <button type="button" class="botEstrella" id="botEstrella2"> <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i> </button>

                    <button type="button" class="botEstrella" id="botEstrella1.5"> <i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i> </button>
                </div>
                <div class="d-flex justify-content-center gap-4">
                    <button type="button" class="botEstrella" id="botEstrella1"> <i class="bi bi-star-fill"></i> </button>

                    <button type="button" class="botEstrella" id="botEstrella0.5"> <i class="bi bi-star-half"></i> </button>
                </div>
                <button type="button" id="botTodos">Todos los registros</button>
            </div>
        </div>
    </div>

    <!---------------------------- MODALES ---------------------------------->

    <!-- Modal Agregar -->
    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
        <div id="modal-dialog-Agregar" class="modal-dialog">
            <div class="modalContent modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="agregarModalLabel"></h1>
                    <button type="button" class="xModal btn shadow-none ms-auto" data-bs-dismiss="modal" aria-label="Close"> <i class="bi bi-x-lg"></i> </button>
                </div>
                <div class="modal-body">
                    <div id="contenidoBuscar">
                        <form id="buscarApiForm">
                            <div class=" my-3">
                                <input class="form-control" id="nombreFormBuscarApi" name="nombreFormBuscarApi" type="text" placeholder="Nombre..." required />
                            </div>
                        </form>
                        <div id="resultadosApi">
                        </div>
                    </div>

                    <div id="contenidoAgregar" class="d-none">

                        <div class="text-center mb-3">
                            <h1 id="nombreAgregar" class="fw-bold mb-0"></h1>
                        </div>

                        <div class="row g-4">

                            <div class="col-md-6 border-end">
                                <div id="nuevosAgregar"></div>
                            </div>

                            <div id="selectorSerie" class="col-md-6 d-flex flex-column d-none">
                            </div>

                            <form id="formAgregar" class=" col-md-6 d-flex flex-column d-none">

                                <div id="detallesFormAgregar"></div>

                                <div class="row text-center align-items-center mt-4">

                                    <div class="col-7">

                                        <label class="form-label d-block">
                                            Valoración
                                        </label>

                                        <div class="d-flex flex-column align-items-center">

                                            <div id="estrellasAgregar">
                                                <i class="estrella bi bi-star fs-1" data-valor="1"></i>
                                                <i class="estrella bi bi-star fs-1" data-valor="2"></i>
                                                <i class="estrella bi bi-star fs-1" data-valor="3"></i>
                                                <i class="estrella bi bi-star fs-1" data-valor="4"></i>
                                                <i class="estrella bi bi-star fs-1" data-valor="5"></i>

                                                <input type="hidden" id="ratingFormAgregar">
                                            </div>

                                            <span id="infoEstrellasAgregar" class="invisible mt-2"> 0 de 5 </span>

                                        </div>
                                    </div>

                                    <div class="col-5">
                                        <label class="form-label d-block"> Favorita </label>
                                        <i id="corazonFormAgregar" class="bi bi-heart fav text-danger fs-2" style="-webkit-text-stroke: 1px;"> </i>
                                    </div>

                                </div>

                                <hr class="my-4">

                                <div class="flex-grow-1 d-flex flex-column">

                                    <label for="notasFormAgregar" class="form-label fw-bold">
                                        Notas
                                    </label>

                                    <textarea id="notasFormAgregar" class="form-control flex-grow-1" placeholder="Escribe aquí tus notas sobre la película..."></textarea>

                                </div>
                                <input type="hidden" id="idFormAgregarPendTabla" name="idFormAgregarPendTabla">
                            </form>
                        </div>
                    </div>

                    <div id="pieAgregar" class="modal-footer d-none mt-4">
                        <button class="btn btn-secondary" data-bs-dismiss="modal"> Cancelar </button>
                        <button id="botAgregarAceptar" class="btn"> Agregar </button>
                    </div>

                    <div id="pieAgregarTemporada" class="modal-footer d-none mt-4">
                        <button class="btn btn-secondary" data-bs-dismiss="modal"> Cancelar </button>
                        <button id="botAgregarTemporadaAceptar" class="btn"> Agregar </button>
                    </div>

                    <div id="pieAgregarEpisodio" class="modal-footer d-none mt-4">
                        <button class="btn btn-secondary" data-bs-dismiss="modal"> Cancelar </button>
                        <button id="botAgregarEpisodioAceptar" class="btn"> Agregar </button>
                    </div>

                    <div id="pieAgregarPendTabla" class="modal-footer d-none mt-4">
                        <button class="btn btn-secondary" data-bs-dismiss="modal"> Cancelar </button>
                        <button id="botAgregarPendTablaAceptar" class="btn"> Agregar </button>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- Fin Modal Agregar -->

    <!-- Modal Agregar Pendiente-->
    <div class="modal fade" id="modalPendiente" tabindex="-1" aria-labelledby="pendienteModalLabel" aria-hidden="true">
        <div id="modal-dialog-Pend" class="modal-dialog">
            <div class="modalContent modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="pendienteModalLabel"></h1>
                    <button type="button" class="xModal btn shadow-none ms-auto" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
                </div>

                <div class="modal-body">
                    <div id="contenidoBuscarPend">
                        <form id="formPend">
                            <div class=" my-3">
                                <input class="form-control" id="nombreFormPend" name="nombreFormPend" type="text" placeholder="Nombre..." required />
                            </div>
                        </form>
                        <div id="resultadosApiPend"></div>
                    </div>

                    <div id="contenidoAgregarPend" class="d-none">

                        <div class="text-center mb-3">
                            <h1 id="nombreAgregarPend" class="fw-bold mb-0"></h1>
                        </div>

                        <div class="row g-3">

                            <div id="capaNuevosAgregarPend" class="border-end">
                                <div id="nuevosAgregarPend"></div>
                            </div>

                            <div id="selectorSeriePend" class="col-md-6 d-flex flex-column d-none">
                            </div>

                        </div>
                    </div>

                    <div id="pieAgregarPend" class="modal-footer d-none mt-4">
                        <button class="btn btn-secondary" data-bs-dismiss="modal"> Cancelar </button>
                        <button id="botAgregarPendAceptar" class="btn"> Agregar </button>
                    </div>

                    <div id="pieAgregarTemporadaPend" class="modal-footer d-none mt-4">
                        <button class="btn btn-secondary" data-bs-dismiss="modal"> Cancelar </button>
                        <button id="botAgregarTemporadaPendAceptar" class="btn"> Agregar </button>
                    </div>

                    <div id="pieAgregarEpisodioPend" class="modal-footer d-none mt-4">
                        <button class="btn btn-secondary" data-bs-dismiss="modal"> Cancelar </button>
                        <button id="botAgregarEpisodioPendAceptar" class="btn"> Agregar </button>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- Fin Modal Agregar Pendiente-->

    <!-- Modal Editar -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modalContent modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editarModalLabel"></h1>
                    <button type="button" class="xModal btn shadow-none ms-auto" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
                </div>
                <div class="modal-body">

                    <form id="editarValForm" class="d-none">
                        <div class="d-flex flex-column align-items-center my-3">
                            <div id="estrellasEditar" class="fs-1">
                            </div>
                            <span id="infoEstrellasEditar" class="invisible mt-2">0 de 5</span>
                        </div>
                    </form>

                    <form id="editarFechaForm" class="d-none">
                        <div id="nuevosEditarFecha">
                        </div>
                    </form>

                    <form id="editarEstadoForm" class="d-none">
                        <div id="nuevosEditarEstado">
                        </div>
                    </form>

                    <form id="editarPlataformaForm" class="d-none">
                        <div id="nuevosEditarPlataforma">
                        </div>
                    </form>

                    <input type="hidden" id="ratingFormEditar" name="ratingFormEditar">
                    <input type="hidden" id="idFormEditar" name="idFormEditar">
                </div>
                <div id="botVal" class="modal-footer d-none">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="botFormEditarValCerrar">Cancelar</button>
                    <button type="submit" class="btn" id="botFormEditarValAceptar">Guardar</button>
                </div>

                <div id="botFecha" class="modal-footer d-none">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="botFormEditarFechaCerrar">Cancelar</button>
                    <button type="submit" class="btn" id="botFormEditarFechaAceptar">Guardar</button>
                </div>
                <div id="botEstado" class="modal-footer d-none">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="botFormEditarEstadoCerrar">Cancelar</button>
                    <button type="submit" class="btn" id="botFormEditarEstadoAceptar">Guardar</button>
                </div>
                <div id="botPlat" class="modal-footer d-none">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="botFormEditarPlatCerrar">Cancelar</button>
                    <button type="submit" class="btn" id="botFormEditarPlatAceptar">Guardar</button>
                </div>
            </div>
        </div>
    </div> <!-- Fin Modal Editar Valoracion -->

    <!-- Modal Eliminar -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modalContent modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="eliminarModalLabel"></h1>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <form id="eliminarForm">
                        <button type="button" class="btn btn-secondary mx-2" data-bs-dismiss="modal" id="botFormEditarCerrar">No</button>
                        <button type="submit" class="btn btn-danger mx-2" id="botFormEliminarAceptar">Sí</button>

                        <input type="hidden" id="idFormEliminar" name="idFormEliminar">
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- Fin Modal Eliminar-->

    <!-- Modal Notas -->
    <div class="modal fade" id="modalNotas" tabindex="-1" aria-labelledby="notasModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modalContent modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="notasModalLabel">Notas</h1>
                    <button type="button" class="xModal btn shadow-none ms-auto" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
                </div>
                <div class="modal-body">

                    <!-- Título -->
                    <div class="text-center mb-3">
                        <h1 id="nombreNotas" class="fw-bold mb-0"></h1>
                    </div>

                    <div class="row g-3">

                        <!-- Póster -->
                        <div class="col-4">
                            <img id="posterNotas"
                                src=""
                                class="img-fluid rounded shadow"
                                alt="Póster de la película">
                        </div>

                        <div class="col-8">

                            <!-- Vista de las notas -->
                            <div id="textoNotas"
                                class="border rounded p-3 text-white"
                                style="min-height: 300px; white-space: pre-wrap;">
                            </div>

                            <div class="d-flex justify-content-end mt-2">
                                <button id="botEditarNotas"
                                    type="button"
                                    class="btn shadow-none p-0"
                                    title="Editar notas">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </div>

                            <input type="hidden" id="idFormEditarNotas" name="idFormEditarNotas">
                            <input type="hidden" id="notasFormEditarNotas" name="notasFormEditarNotas">

                            <!-- Editor -->
                            <div id="editorNotas" class="d-none">

                                <textarea id="notasTextarea" class="form-control" rows="10"></textarea>

                                <div class="d-flex justify-content-end gap-2 mt-2">

                                    <button id="botCancelarNotas" type="button" class="btn btn-sm btn-secondary">Cancelar
                                    </button>

                                    <button id="botGuardarNotas" type="button" class="btn btn-sm">Guardar
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- Fin Modal Notas -->

    <div id="mensajes"></div>

    <!-- Scripts -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>