const parametros = new URLSearchParams(window.location.search);
let tipoContenido = parametros.get('tipo');
if(!tipoContenido || !contenidoConfig[tipoContenido]){
    window.location.href = 'index.php';
}
var config = contenidoConfig[tipoContenido];
var configAnterior = null;

var tablaActual = '';
var contenidoSeleccionado = null;
var temporadaSeleccionada = null;
var episodioSeleccionado = null;
var temporizadorBusqueda;

$(document).ready(function(){

    tablaGeneral();
    mostrarHistorial();

    if(tipoContenido=='serie' || tipoContenido=='temporada' || tipoContenido=='episodio'){
        botonesSeries();
    }


    ///////////////////////////////////////     TABLAS      ///////////////////////////////////////

    // Funcionalidad boton todos los registros
    $('#botTodos').click(function(event){
        event.preventDefault();
        tablaGeneral();
    });

    /// Funcionalidad botones estrella
    $('.botEstrella').click(function(event) {
        event.preventDefault();
        let rating = this.id.replace('botEstrella', '');
        tablaEstrellas(rating);
    });

    // Funcionalidad boton favoritos
    $('#botFav').click(function(event){
        event.preventDefault();
        tablaFavoritas();
    });

    // Funcionalidad boton pendientes
    $('#botPendientes').click(function(){
        event.preventDefault();
        tablaPendientes();
    });

    // Funcionalidad buscar
    $('#buscarForm').submit(function(event){
        event.preventDefault();
        let busqueda = $('#cajaBusqueda').val();

        $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data: {
                "busqueda": busqueda,
                "orden": 'buscar'
            },
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                if(window.tabla){
                    window.tabla.destroy();
                }
                tablaActual = 'busqueda';
                window.tabla = crearTabla(respuesta, config.nombrePluralContenido+' Encontrad'+config.genero+'s por \''+busqueda+'\'');
            } // Fin else
        }) // Fin ajax
    });

    // Funcionalidad de corazones de tabla
    $('#tablas').on('click', '.fav', function(event){
        event.preventDefault();

        let corazon = $(this);
        let id = $(this).data('id');
        let fav = $(this).hasClass('bi-heart') ? 1 : 0;

        $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data: {
                [config.idUsuarioContenido]: id,
                [config.fav]: fav,
                "orden": 'favorita'
            },
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                corazon.hasClass('bi-heart-fill') ? agregarHistorial('desfav', id) : agregarHistorial('fav', id);

                corazon.toggleClass('bi-heart bi-heart-fill');
                if (tablaActual == 'favoritas'){
                    window.tabla.deleteRow(id);
                    actualizarNumero();
                }

            } // Fin else
        }); // Fin ajax
    });

    // Funcionalidad de notas de tabla
    $('#tablas').on('click', '.notas', function(event){
        event.preventDefault();

        let id = $(this).data('id');
        $('#idFormEditarNotas').val(id);
        $('#posterNotas').attr('src', 'images/noPoster.jpeg');
        $('#nombreNotas').text('Cargando...');

        obtenerDetalles(id).then(function(respuesta){
            if (respuesta[0][config.poster] == config.noPoster) {
                $('#posterNotas').attr('src', 'images/noPoster.jpeg');
            }else{
                $('#posterNotas').attr('src', respuesta[0][config.poster]);
            }
            $('#nombreNotas').text(respuesta[0][config.nombre]);
        });

        $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data: {
                [config.idUsuarioContenido]: id,
                "orden": 'comprobar'
            },
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                if(respuesta[0][config.notas] == null){
                    $('#textoNotas').text('Aún no has añadido ninguna nota.');
                    $('#notasFormEditarNotas').val(respuesta[0][config.notas]);
                }else{
                    $('#textoNotas').text(respuesta[0][config.notas]);
                    $('#notasFormEditarNotas').val(respuesta[0][config.notas]);
                }
            } // Fin else
        }) // Fin ajax


    });


    ///////////////////////////////////////     AGREGAR     ///////////////////////////////////////

    // Funcionalidad buscar en Api
    $('#nombreFormBuscarApi').on('input', function(){
        clearTimeout(temporizadorBusqueda);
        let nombre = $('#nombreFormBuscarApi').val();
        if(nombre.length < 2){
            return;
        }
        temporizadorBusqueda = setTimeout(function(){

            $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data: {
                [config.nombre]: nombre,
                "orden": 'buscarApi'
            },
            }).done(function(respuesta){
                if(respuesta.error){
                    mostrarError(respuesta.error);
                    console.log(respuesta.error_tecnico);
                }else{
                    let html = resultadosApi(respuesta);
                    $('#resultadosApi').html(html);
                } // Fin else
            }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log("Error AJAX:", textStatus);
            console.log("Error:", errorThrown);
            console.log("Respuesta del servidor:", jqXHR.responseText);
        }); // Fin ajax
        },600);
    });

    // Funcionalidad click en resultado Api
    $('#modalAgregar').on("click",".resultadoApi", function(event){
        event.preventDefault();
        let idApi = $(this).data("id");

        $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data:{
                "idApi": idApi,
                "orden":"detallesApi"
            }
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                contenidoSeleccionado = respuesta;

                if(config.nombreContenido == 'Serie' || config.nombreContenido == 'Temporada' || config.nombreContenido == 'Episodio'){
                    let info = mostrarDetalles(contenidoSeleccionado, config.detallesSerie, 'posterSerie');
                    $('#nuevosAgregar').html(info);

                    let selector = mostrarSelectorTemporadas(contenidoSeleccionado);
                    $('#selectorSerie').html(selector);

                    $('#nombreAgregar').text(contenidoSeleccionado['nombreSerie']);

                    $('#selectorSerie').removeClass('d-none');
                }else{
                    let info = mostrarDetalles(contenidoSeleccionado, config.detalles);
                    $('#nuevosAgregar').html(info);

                    let form = mostrarFormAgregar(config.formAgregar);
                    $('#detallesFormAgregar').html(form);

                    let hoy = new Date().toISOString().split('T')[0];
                    $('#fechaFormAgregar').val(hoy);

                    $('#nombreAgregar').text(contenidoSeleccionado[config.campos.nombre]);

                    $('#formAgregar').removeClass('d-none');
                    $('#pieAgregar').removeClass('d-none');
                }

                $('#contenidoBuscar').addClass('d-none');
                $('#contenidoAgregar').removeClass('d-none');
                $('#modal-dialog-Agregar').addClass('modal-xl');

            } // Fin else
        }); // Fin ajax
    });

    // Funcionalidad de estrellas en agregar
    $('#estrellasAgregar').on('click', '.estrella', function(event){
        event.preventDefault();

        let valor = $(this).data('valor');
        let mitad = this.getBoundingClientRect().left + this.offsetWidth / 2;
        let rating;

        if(event.clientX < mitad){
            rating = valor - 0.5;
        }else{
            rating = valor;
        }

        $('#ratingFormAgregar').val(rating);
        $('#infoEstrellasAgregar').removeClass('invisible');
        $('#infoEstrellasAgregar').text(rating+' de 5');
    });

    // Funcionalidad de corazon en agregar
    $('#corazonFormAgregar').click(function(event){
        event.preventDefault();
        $(this).toggleClass('bi-heart bi-heart-fill');
    });

    // Funcionalidad de aceptar en agregar
    $('#botAgregarAceptar').click(function(event){
        event.preventDefault();

        let rating = $('#ratingFormAgregar').val();
        let fav = $('#corazonFormAgregar').hasClass('bi-heart-fill') ? 1 : 0;
        let notas = $('#notasFormAgregar').val();

        let datos = {
            orden: "agregar",
            [config.rating]: rating,
            [config.fav]: fav,
            [config.notas]: notas
        };

        // Recogemos los detalles para meterlos en la base de datos
        for(const [campoPOST, campoContenido] of Object.entries(config.camposBD)){
            datos[campoPOST] = contenidoSeleccionado[campoContenido];
        }

        // Recogemos los datos especiales de cada apartado
        for(const campo of config.formAgregar){
            datos[campo.nombre] = $('#' + campo.id).val();
        }

        $.ajax({
            method:"POST",
            url: config.controlador,
            dataType: "json",
            data: datos
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                tablaGeneral();
                agregarHistorial('añadir', respuesta[config.idUsuarioContenido]);

                let modalAgregar = document.getElementById('modalAgregar');
                bootstrap.Modal.getInstance(modalAgregar).hide();
                $('#botSeries').click();

                if(config.nombreContenido == 'Libro'){
                    // Ajax para descargar la portada del apartado Libros
                    $.ajax({
                        method: "POST",
                        url: config.controlador,
                        dataType: "json",
                        data: {
                            orden: 'descargarPoster',
                            [config.idContenido]: respuesta[config.idContenido],
                            [config.poster]: contenidoSeleccionado[config.poster]
                        }
                    }).done(function(respuesta){
                        if(respuesta.error){
                            mostrarError(respuesta.error);
                            console.log(respuesta.error_tecnico);
                        }
                    }); // Fin ajax
                } // Fin if

            } // Fin else
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log("Error AJAX:", textStatus);
            console.log("Error:", errorThrown);
            console.log("Respuesta del servidor:", jqXHR.responseText);
        }); // Fin ajax
    });


    ///////////////////////////////////////     SERIES      ///////////////////////////////////////

    // Agregar

    // Funcionalidad click en serie completa
    $('#modalAgregar').on('click','.serieCompleta',function(event){
        event.preventDefault();

        configAnterior = config;
        config = contenidoConfig['serie'];

        let form = mostrarFormAgregar(config.formAgregarSerie);
        $('#detallesFormAgregar').html(form);

        let hoy = new Date().toISOString().split('T')[0];
        $('#fechaFormAgregar').val(hoy);

        $('#selectorSerie').addClass('d-none');
        $('#formAgregar').removeClass('d-none');
        $('#pieAgregar').removeClass('d-none');
    });

    // Funcionalidad click en temporada
    $('#modalAgregar').on('click','.temporadaOpcion',function(event){
        event.preventDefault();
        let idApiSerie = $(this).data('id');
        let numeroTemporada = $(this).data('temporada');
        let nombreSerie = contenidoSeleccionado['nombreSerie'];

        $.ajax({
            method: "POST",
            url: "controladores/controladorTemporada.php",
            dataType: "json",
            data:{
                "orden": "detallesApiTemporada",
                "idApiSerie": idApiSerie,
                "numeroTemporada": numeroTemporada,
                'nombreSerie': nombreSerie
            }
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                temporadaSeleccionada = respuesta;

                let info = mostrarDetalles(respuesta, config.detallesTemporada, 'posterTemporada');
                $('#nuevosAgregar').html(info);

                let selector = mostrarSelectorEpisodios(respuesta);
                $('#selectorSerie').html(selector);

                $('#nombreAgregar').text(temporadaSeleccionada['nombreTemporada']);
            }
        }).fail(function(
            jqXHR,
            textStatus,
            errorThrown
        ){

            console.error(
                'Error cargando temporada:',
                textStatus,
                errorThrown
            );

            console.error(
                jqXHR.responseText
            );

        });
    });

    // Funcionalidad click en temporada completa
    $('#modalAgregar').on('click','.temporadaCompleta',function(event){
        event.preventDefault();

        configAnterior = config;
        config = contenidoConfig['temporada'];

        let form = mostrarFormAgregar(config.formAgregarTemporada);
        $('#detallesFormAgregar').html(form);

        let hoy = new Date().toISOString().split('T')[0];
        $('#fechaFormAgregar').val(hoy);

        $('#selectorSerie').addClass('d-none');
        $('#formAgregar').removeClass('d-none');
        $('#pieAgregarTemporada').removeClass('d-none');
    });

    // Funcionalidad de aceptar en agregar temporada
    $('#botAgregarTemporadaAceptar').click(function(event){
        event.preventDefault();

        let rating = $('#ratingFormAgregar').val();
        let fav = $('#corazonFormAgregar').hasClass('bi-heart-fill') ? 1 : 0;
        let notas = $('#notasFormAgregar').val();
        let fecha = $('#fechaFormAgregar').val();

        $.ajax({
            method:"POST",
            url: 'controladores/controladorTemporada.php',
            dataType: "json",
            data: {
                'ratingTemporada': rating,
                'favTemporada': fav,
                'notasTemporada': notas,
                'fechaTemporada': fecha,
                'idApiTemporada': temporadaSeleccionada['idApi'],
                'nombreTemporada': temporadaSeleccionada['nombreTemporada'],
                'numeroTemporada': temporadaSeleccionada['numeroTemporada'],
                'directorTemporada': temporadaSeleccionada['directorTemporada'],
                'actorTemporada': temporadaSeleccionada['actorTemporada'],
                'guionistaTemporada': temporadaSeleccionada['guionistaTemporada'],
                'anoTemporada': temporadaSeleccionada['anoTemporada'],
                'episodiosTemporada': temporadaSeleccionada['episodiosTemporada'],
                'ratingAvgTemporada': temporadaSeleccionada['ratingAvgTemporada'],
                'posterTemporada': temporadaSeleccionada['posterTemporada'],
                'sinopsisTemporada': temporadaSeleccionada['sinopsisTemporada'],
                'idApiSerie': contenidoSeleccionado['idApi'],
                'nombreSerie': contenidoSeleccionado['nombreSerie'],
                'creadorSerie': contenidoSeleccionado['creadorSerie'],
                'directorSerie': contenidoSeleccionado['directorSerie'],
                'actorSerie': contenidoSeleccionado['actorSerie'],
                'companiaSerie': contenidoSeleccionado['companiaSerie'],
                'guionistaSerie': contenidoSeleccionado['guionistaSerie'],
                'generoSerie': contenidoSeleccionado['generoSerie'],
                'anoSerie': contenidoSeleccionado['anoSerie'],
                'temporadasSerie': contenidoSeleccionado['temporadasSerie'],
                'episodiosSerie': contenidoSeleccionado['episodiosSerie'],
                'ratingAvgSerie': contenidoSeleccionado['ratingAvgSerie'],
                'paisSerie': contenidoSeleccionado['paisSerie'],
                'idiomaSerie': contenidoSeleccionado['idiomaSerie'],
                'posterSerie': contenidoSeleccionado['posterSerie'],
                'sinopsisSerie': contenidoSeleccionado['sinopsisSerie'],
                "orden": 'agregar'
            }
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                agregarHistorial('añadir', respuesta['idUsuarioTemporada']);

                let modalAgregar = document.getElementById('modalAgregar');
                bootstrap.Modal.getInstance(modalAgregar).hide();
                $('#botTemporadas').click();
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log("Error AJAX:", textStatus);
            console.log("Error:", errorThrown);
            console.log("Respuesta del servidor:", jqXHR.responseText);
        }); // Fin ajax
    });

    // Funcionalidad click en episodio
    $('#modalAgregar').on('click','.episodioOpcion',function(event){
        event.preventDefault();

        configAnterior = config;
        config = contenidoConfig['episodio'];

        let idApiSerie = contenidoSeleccionado.idApi;
        let numeroEpisodio = $(this).data('episodio');
        let numeroTemporada = $(this).data('temporada');
        let nombreSerie = contenidoSeleccionado['nombreSerie'];

        $.ajax({
            method: "POST",
            url: "controladores/controladorEpisodio.php",
            dataType: "json",
            data:{
                "orden": "detallesApiEpisodio",
                "idApiSerie": idApiSerie,
                "numeroEpisodio": numeroEpisodio,
                "numeroTemporada": numeroTemporada,
                'nombreSerie': nombreSerie
            }
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                episodioSeleccionado = respuesta;

                let form = mostrarFormAgregar(config.formAgregarEpisodio);
                $('#detallesFormAgregar').html(form);
                
                let info = mostrarDetalles(respuesta, config.detallesEpisodio, 'posterEpisodio');
                $('#nuevosAgregar').html(info);

                $('#nombreAgregar').text(respuesta['nombreEpisodio']);

                let hoy = new Date().toISOString().split('T')[0];
                $('#fechaFormAgregar').val(hoy);

                $('#selectorSerie').addClass('d-none');
                $('#formAgregar').removeClass('d-none');
                $('#pieAgregarEpisodio').removeClass('d-none');
            }
        }).fail(function(
            jqXHR,
            textStatus,
            errorThrown
        ){

            console.error(
                'Error cargando temporada:',
                textStatus,
                errorThrown
            );

            console.error(
                jqXHR.responseText
            );

        });
    });

    // Funcionalidad de aceptar en agregar episodio
    $('#botAgregarEpisodioAceptar').click(function(event){
        event.preventDefault();

        let rating = $('#ratingFormAgregar').val();
        let fav = $('#corazonFormAgregar').hasClass('bi-heart-fill') ? 1 : 0;
        let notas = $('#notasFormAgregar').val();
        let fecha = $('#fechaFormAgregar').val();

        $.ajax({
            method:"POST",
            url: 'controladores/controladorEpisodio.php',
            dataType: "json",
            data: {
                'ratingEpisodio': rating,
                'favEpisodio': fav,
                'notasEpisodio': notas,
                'fechaEpisodio': fecha,
                'idApiEpisodio': episodioSeleccionado['idApi'],
                'nombreEpisodio': episodioSeleccionado['nombreEpisodio'],
                'numeroEpisodio': episodioSeleccionado['numeroEpisodio'],
                'directorEpisodio': episodioSeleccionado['directorEpisodio'],
                'actorEpisodio': episodioSeleccionado['actorEpisodio'],
                'guionistaEpisodio': episodioSeleccionado['guionistaEpisodio'],
                'anoEpisodio': episodioSeleccionado['anoEpisodio'],
                'duracionEpisodio': episodioSeleccionado['duracionEpisodio'],
                'ratingAvgEpisodio': episodioSeleccionado['ratingAvgEpisodio'],
                'posterEpisodio': episodioSeleccionado['posterEpisodio'],
                'sinopsisEpisodio': episodioSeleccionado['sinopsisEpisodio'],
                'idApiTemporada': temporadaSeleccionada['idApi'],
                'nombreTemporada': temporadaSeleccionada['nombreTemporada'],
                'numeroTemporada': temporadaSeleccionada['numeroTemporada'],
                'directorTemporada': temporadaSeleccionada['directorTemporada'],
                'actorTemporada': temporadaSeleccionada['actorTemporada'],
                'guionistaTemporada': temporadaSeleccionada['guionistaTemporada'],
                'anoTemporada': temporadaSeleccionada['anoTemporada'],
                'episodiosTemporada': temporadaSeleccionada['episodiosTemporada'],
                'ratingAvgTemporada': temporadaSeleccionada['ratingAvgTemporada'],
                'posterTemporada': temporadaSeleccionada['posterTemporada'],
                'sinopsisTemporada': temporadaSeleccionada['sinopsisTemporada'],
                'idApiSerie': contenidoSeleccionado['idApi'],
                'nombreSerie': contenidoSeleccionado['nombreSerie'],
                'creadorSerie': contenidoSeleccionado['creadorSerie'],
                'directorSerie': contenidoSeleccionado['directorSerie'],
                'actorSerie': contenidoSeleccionado['actorSerie'],
                'companiaSerie': contenidoSeleccionado['companiaSerie'],
                'guionistaSerie': contenidoSeleccionado['guionistaSerie'],
                'generoSerie': contenidoSeleccionado['generoSerie'],
                'anoSerie': contenidoSeleccionado['anoSerie'],
                'temporadasSerie': contenidoSeleccionado['temporadasSerie'],
                'episodiosSerie': contenidoSeleccionado['episodiosSerie'],
                'ratingAvgSerie': contenidoSeleccionado['ratingAvgSerie'],
                'paisSerie': contenidoSeleccionado['paisSerie'],
                'idiomaSerie': contenidoSeleccionado['idiomaSerie'],
                'posterSerie': contenidoSeleccionado['posterSerie'],
                'sinopsisSerie': contenidoSeleccionado['sinopsisSerie'],
                "orden": 'agregar'
            }
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                agregarHistorial('añadir', respuesta['idUsuarioEpisodio']);

                let modalAgregar = document.getElementById('modalAgregar');
                bootstrap.Modal.getInstance(modalAgregar).hide();
                $('#botEpisodios').click();
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log("Error AJAX:", textStatus);
            console.log("Error:", errorThrown);
            console.log("Respuesta del servidor:", jqXHR.responseText);
        }); // Fin ajax
    });

    // Funcionalidad volver serie
    $('#modalAgregar').on('click','.volverSeries',function(){
        event.preventDefault();

        let info = mostrarDetalles(contenidoSeleccionado, config.detallesSerie, 'posterSerie');
        $('#nuevosAgregar').html(info);

        let selector = mostrarSelectorTemporadas(contenidoSeleccionado);
        $('#selectorSerie').html(selector);

        $('#nombreAgregar').text(contenidoSeleccionado['nombreSerie']);
    });

    // Pendiente

    // Funcionalidad click en serie completa pendiente
    $('#modalPendiente').on('click','.serieCompleta',function(event){
        event.preventDefault();

        configAnterior = config;
        config = contenidoConfig['serie'];

        $('#selectorSeriePend').addClass('d-none');
        $('#pieAgregarPend').removeClass('d-none');
        $('#modal-dialog-Pend').removeClass('modal-xl');
        $('#modal-dialog-Pend').addClass('modal-lg');
        $('#capaNuevosAgregarPend').removeClass('col-md-6');
        
    });

    // Funcionalidad click en temporada pendiente
    $('#modalPendiente').on('click','.temporadaOpcion',function(event){
        event.preventDefault();
        let idApiSerie = $(this).data('id');
        let numeroTemporada = $(this).data('temporada');
        let nombreSerie = contenidoSeleccionado['nombreSerie'];

        $.ajax({
            method: "POST",
            url: "controladores/controladorTemporada.php",
            dataType: "json",
            data:{
                "orden": "detallesApiTemporada",
                "idApiSerie": idApiSerie,
                "numeroTemporada": numeroTemporada,
                'nombreSerie': nombreSerie
            }
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                temporadaSeleccionada = respuesta;

                let info = mostrarDetalles(respuesta, config.detallesTemporada, 'posterTemporada');
                $('#nuevosAgregarPend').html(info);

                let selector = mostrarSelectorEpisodios(respuesta);
                $('#selectorSeriePend').html(selector);

                $('#nombreAgregarPend').text(temporadaSeleccionada['nombreTemporada']);
            }
        }).fail(function(
            jqXHR,
            textStatus,
            errorThrown
        ){

            console.error(
                'Error cargando temporada:',
                textStatus,
                errorThrown
            );

            console.error(
                jqXHR.responseText
            );

        });
    });

    // Funcionalidad click en temporada completa pendiente
    $('#modalPendiente').on('click','.temporadaCompleta',function(event){
        event.preventDefault();

        configAnterior = config;
        config = contenidoConfig['temporada'];

        $('#selectorSeriePend').addClass('d-none');
        $('#pieAgregarTemporadaPend').removeClass('d-none');
        $('#modal-dialog-Pend').removeClass('modal-xl');
        $('#modal-dialog-Pend').addClass('modal-lg');
        $('#capaNuevosAgregarPend').removeClass('col-md-6');
    });

    // Funcionalidad de aceptar en agregar temporada pendiente
    $('#botAgregarTemporadaPendAceptar').click(function(event){
        event.preventDefault();

        $.ajax({
            method:"POST",
            url: 'controladores/controladorTemporada.php',
            dataType: "json",
            data: {
                'idApiTemporada': temporadaSeleccionada['idApi'],
                'nombreTemporada': temporadaSeleccionada['nombreTemporada'],
                'numeroTemporada': temporadaSeleccionada['numeroTemporada'],
                'directorTemporada': temporadaSeleccionada['directorTemporada'],
                'actorTemporada': temporadaSeleccionada['actorTemporada'],
                'guionistaTemporada': temporadaSeleccionada['guionistaTemporada'],
                'anoTemporada': temporadaSeleccionada['anoTemporada'],
                'episodiosTemporada': temporadaSeleccionada['episodiosTemporada'],
                'ratingAvgTemporada': temporadaSeleccionada['ratingAvgTemporada'],
                'posterTemporada': temporadaSeleccionada['posterTemporada'],
                'sinopsisTemporada': temporadaSeleccionada['sinopsisTemporada'],
                'idApiSerie': contenidoSeleccionado['idApi'],
                'nombreSerie': contenidoSeleccionado['nombreSerie'],
                'creadorSerie': contenidoSeleccionado['creadorSerie'],
                'directorSerie': contenidoSeleccionado['directorSerie'],
                'actorSerie': contenidoSeleccionado['actorSerie'],
                'companiaSerie': contenidoSeleccionado['companiaSerie'],
                'guionistaSerie': contenidoSeleccionado['guionistaSerie'],
                'generoSerie': contenidoSeleccionado['generoSerie'],
                'anoSerie': contenidoSeleccionado['anoSerie'],
                'temporadasSerie': contenidoSeleccionado['episodiosSerie'],
                'episodiosSerie': contenidoSeleccionado['episodiosSerie'],
                'ratingAvgSerie': contenidoSeleccionado['ratingAvgSerie'],
                'paisSerie': contenidoSeleccionado['paisSerie'],
                'idiomaSerie': contenidoSeleccionado['idiomaSerie'],
                'posterSerie': contenidoSeleccionado['posterSerie'],
                'sinopsisSerie': contenidoSeleccionado['sinopsisSerie'],
                "orden": 'agregarPend'
            }
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                agregarHistorial('añadirPend', respuesta['idUsuarioTemporada']);

                let modalAgregarPend = document.getElementById('modalPendiente');
                bootstrap.Modal.getInstance(modalAgregarPend).hide();
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log("Error AJAX:", textStatus);
            console.log("Error:", errorThrown);
            console.log("Respuesta del servidor:", jqXHR.responseText);
        }); // Fin ajax
    });

    // Funcionalidad click en episodio pendiente
    $('#modalPendiente').on('click','.episodioOpcion',function(event){
        event.preventDefault();

        configAnterior = config;
        config = contenidoConfig['episodio'];

        let idApiSerie = contenidoSeleccionado.idApi;
        let numeroEpisodio = $(this).data('episodio');
        let numeroTemporada = $(this).data('temporada');
        let nombreSerie = contenidoSeleccionado['nombreSerie'];

        $.ajax({
            method: "POST",
            url: "controladores/controladorEpisodio.php",
            dataType: "json",
            data:{
                "orden": "detallesApiEpisodio",
                "idApiSerie": idApiSerie,
                "numeroEpisodio": numeroEpisodio,
                "numeroTemporada": numeroTemporada,
                "nombreSerie": nombreSerie
            }
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                episodioSeleccionado = respuesta;
                
                let info = mostrarDetalles(respuesta, config.detallesEpisodio, 'posterEpisodio');
                $('#nuevosAgregarPend').html(info);

                $('#nombreAgregarPend').text(respuesta['nombreEpisodio']);

                $('#selectorSeriePend').addClass('d-none');
                $('#pieAgregarEpisodioPend').removeClass('d-none');
                $('#modal-dialog-Pend').removeClass('modal-xl');
                $('#modal-dialog-Pend').addClass('modal-lg');
                $('#capaNuevosAgregarPend').removeClass('col-md-6');
            }
        }).fail(function(
            jqXHR,
            textStatus,
            errorThrown
        ){

            console.error(
                'Error cargando temporada:',
                textStatus,
                errorThrown
            );

            console.error(
                jqXHR.responseText
            );

        });
    });

    // Funcionalidad de aceptar en agregar episodio pendiente
    $('#botAgregarEpisodioPendAceptar').click(function(event){
        event.preventDefault();

        $.ajax({
            method:"POST",
            url: 'controladores/controladorEpisodio.php',
            dataType: "json",
            data: {
                'idApiEpisodio': episodioSeleccionado['idApi'],
                'nombreEpisodio': episodioSeleccionado['nombreEpisodio'],
                'numeroEpisodio': episodioSeleccionado['numeroEpisodio'],
                'directorEpisodio': episodioSeleccionado['directorEpisodio'],
                'actorEpisodio': episodioSeleccionado['actorEpisodio'],
                'guionistaEpisodio': episodioSeleccionado['guionistaEpisodio'],
                'anoEpisodio': episodioSeleccionado['anoEpisodio'],
                'duracionEpisodio': episodioSeleccionado['duracionEpisodio'],
                'ratingAvgEpisodio': episodioSeleccionado['ratingAvgEpisodio'],
                'posterEpisodio': episodioSeleccionado['posterEpisodio'],
                'sinopsisEpisodio': episodioSeleccionado['sinopsisEpisodio'],
                'idApiTemporada': temporadaSeleccionada['idApi'],
                'nombreTemporada': temporadaSeleccionada['nombreTemporada'],
                'numeroTemporada': temporadaSeleccionada['numeroTemporada'],
                'directorTemporada': temporadaSeleccionada['directorTemporada'],
                'actorTemporada': temporadaSeleccionada['actorTemporada'],
                'guionistaTemporada': temporadaSeleccionada['guionistaTemporada'],
                'anoTemporada': temporadaSeleccionada['anoTemporada'],
                'episodiosTemporada': temporadaSeleccionada['episodiosTemporada'],
                'ratingAvgTemporada': temporadaSeleccionada['ratingAvgTemporada'],
                'posterTemporada': temporadaSeleccionada['posterTemporada'],
                'sinopsisTemporada': temporadaSeleccionada['sinopsisTemporada'],
                'idApiSerie': contenidoSeleccionado['idApi'],
                'nombreSerie': contenidoSeleccionado['nombreSerie'],
                'creadorSerie': contenidoSeleccionado['creadorSerie'],
                'directorSerie': contenidoSeleccionado['directorSerie'],
                'actorSerie': contenidoSeleccionado['actorSerie'],
                'companiaSerie': contenidoSeleccionado['companiaSerie'],
                'guionistaSerie': contenidoSeleccionado['guionistaSerie'],
                'generoSerie': contenidoSeleccionado['generoSerie'],
                'anoSerie': contenidoSeleccionado['anoSerie'],
                'temporadasSerie': contenidoSeleccionado['episodiosSerie'],
                'episodiosSerie': contenidoSeleccionado['episodiosSerie'],
                'ratingAvgSerie': contenidoSeleccionado['ratingAvgSerie'],
                'paisSerie': contenidoSeleccionado['paisSerie'],
                'idiomaSerie': contenidoSeleccionado['idiomaSerie'],
                'posterSerie': contenidoSeleccionado['posterSerie'],
                'sinopsisSerie': contenidoSeleccionado['sinopsisSerie'],
                "orden": 'agregarPend'
            }
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                agregarHistorial('añadirPend', respuesta['idUsuarioEpisodio']);

                let modalAgregarPend = document.getElementById('modalPendiente');
                bootstrap.Modal.getInstance(modalAgregarPend).hide();
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log("Error AJAX:", textStatus);
            console.log("Error:", errorThrown);
            console.log("Respuesta del servidor:", jqXHR.responseText);
        }); // Fin ajax
    });

    // Funcionalidad volver serie pendiente
    $('#modalPendiente').on('click','.volverSeries',function(){
        event.preventDefault();

        let info = mostrarDetalles(contenidoSeleccionado, config.detallesSerie, 'posterSerie');
        $('#nuevosAgregarPend').html(info);

        let selector = mostrarSelectorTemporadas(contenidoSeleccionado);
        $('#selectorSeriePend').html(selector);

        $('#nombreAgregarPend').text(contenidoSeleccionado['nombreSerie']);
    });


    ///////////////////////////////////////     EDITAR      ///////////////////////////////////////

    // Funcionalidad de editar valoración
    $('#tablas').on('click', '.editarValoracion', function(event){
        event.preventDefault();

        let id = $(this).data('id');

        $('#editarValForm').removeClass('d-none');
        $('#botVal').removeClass('d-none');
        $('#editarModalLabel').text('Editar Valoración');

        $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data: {
                [config.idUsuarioContenido]: id,
                "orden": 'comprobar'
            },
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                $('#idFormEditar').val(id);
                let rating = Number(respuesta[0][config.rating]);
                $('#ratingFormEditar').val(rating);
                let estrellas = transformarRating(rating);
                $('#estrellasEditar').html(estrellas);
            } // Fin else
        }); // Fin ajax
    });

    // Funcionalidad de estrellas en editar
    $('#modalEditar').on('click', '.estrella', function(event){
        event.preventDefault();
        
        let valor = $(this).data('valor');
        let id = $(this).data('id');
        let mitad = this.getBoundingClientRect().left + this.offsetWidth / 2;
        let rating;

        if(event.clientX < mitad){
            rating = valor - 0.5;
        }else{
            rating = valor;
        }

        $('#ratingFormEditar').val(rating);
        $('#infoEstrellasEditar').removeClass('invisible');
        $('#infoEstrellasEditar').text(rating+' de 5');

    });

    // Funcionalidad de aceptar en editar valoracion
    $('#botFormEditarValAceptar').click(function(event){
        event.preventDefault();

        let rating = $('#ratingFormEditar').val();
        let id = $('#idFormEditar').val();

        $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data: {
                [config.rating]: rating,
                [config.idUsuarioContenido]: id,
                "orden": 'editarVal'
            },
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                mostrarExito(respuesta.exito);
                agregarHistorial('editarVal', id);
                window.tabla.updateData([{
                    [config.idUsuarioContenido]: id,
                    [config.rating]: rating
                }]);

                $('#ratingFormEditar').val('');
                $('#idFormEditar').val('');
                $('#infoEstrellasEditar').addClass('invisible');

                let modalElemento = document.getElementById('modalEditar');
                bootstrap.Modal.getInstance(modalElemento).hide();
            } // Fin else
        }) // Fin ajax
    });

    // Funcionalidad de editar fecha
    $('#tablas').on('click', '.editarFecha', function(event){
        event.preventDefault();

        let id = $(this).data('id');

        $('#editarFechaForm').removeClass('d-none');
        $('#botFecha').removeClass('d-none');
        $('#editarModalLabel').text('Editar fecha de '+config.accionFecha);
        $('#nuevosEditarFecha').html('<div class=" colorJuego d-flex justify-content-center align-items-center py-4">Cargando...</div>');

        $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data: {
                [config.idUsuarioContenido]: id,
                "orden": 'comprobar'
            },
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{

                $('#nuevosEditarFecha').html(mostrarFormFecha());

                $('#idFormEditar').val(id);

                for(const campo of config.formFecha){
                    $('#' + campo.id).val(respuesta[0][campo.nombre] ?? '');
                }

            } // Fin else
        }); // Fin ajax
    });

    // Funcionalidad de aceptar en editar fecha
    $('#botFormEditarFechaAceptar').click(function(event){
        event.preventDefault();

        let id = $('#idFormEditar').val();

        let datos = {
            [config.idUsuarioContenido]: id,
        };

        for(const campo of config.formFecha){
            datos[campo.nombre] = $('#' + campo.id).val();
        }

        $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data: {
                ...datos,
                orden: "editarFecha"
            }
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                mostrarExito(respuesta.exito);
                agregarHistorial('editarFecha', id);

                window.tabla.updateData([datos]).then(function(){
                    if(window.tabla.getRow(id)){
                        window.tabla.getRow(id).reformat();
                    }
                });

                $('#fechaFormEditar').val('');
                $('#fechaInicioFormEditar').val('');
                $('#idFormEditar').val('');

                let modalElemento = $('#modalEditar');
                bootstrap.Modal.getInstance(modalElemento).hide();
            } // Fin else
        }) // Fin ajax
    });

    // Funcionalidad de editar estado Serie
    $('#tablas').on('click', '.editarEstado', function(event){
        event.preventDefault();

        let id = $(this).data('id');

        $('#editarEstadoForm').removeClass('d-none');
        $('#botEstado').removeClass('d-none');
        $('#editarModalLabel').text('Editar Estado');

        $('#idFormEditar').val(id);

        obtenerDetalles(id).then(function(respuesta){
            let html = mostrarFormEstado(respuesta[0]);
            $('#nuevosEditarEstado').html(html);

            return $.ajax({
                method: "POST",
                url: config.controlador,
                dataType: "json",
                data: {
                    [config.idUsuarioContenido]: id,
                    "orden": 'comprobar'
                },
            }); // Fin ajax
        }).then(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                $('#estadoFormEditar').val(respuesta[0][config.estado]);
            } // Fin else
        }); // Fin then

    });

    // Funcionalidad de aceptar en editar estado Serie
    $('#botFormEditarEstadoAceptar').click(function(event){
        event.preventDefault();

        let id = $('#idFormEditar').val();
        let estado = $('#estadoFormEditar').val();

        $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data: {
                [config.idUsuarioContenido]: id,
                [config.estado]: estado,
                orden: "editarEstado"
            }
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                mostrarExito(respuesta.exito);
                agregarHistorial('editarEstado', id);

                window.tabla.updateData([{
                    [config.idUsuarioContenido]: id,
                    [config.estado]: estado
                }]);

                $('#estadoFormEditar').val('');
                $('#idFormEditar').val('');

                let modalElemento = $('#modalEditar');
                bootstrap.Modal.getInstance(modalElemento).hide();
            } // Fin else
        }) // Fin ajax
    });

    // Funcionalidad de editar plataforma Juego
    $('#tablas').on('click', '.editarPlataforma', function(event){
        event.preventDefault();

        let id = $(this).data('id');

        $('#editarPlataformaForm').removeClass('d-none');
        $('#botPlat').removeClass('d-none');
        $('#editarModalLabel').text('Editar Plataforma');
        $('#nuevosEditarPlataforma').html('<div class=" colorJuego d-flex justify-content-center align-items-center py-4">Cargando...</div>');

        $('#idFormEditar').val(id);

        obtenerDetalles(id).then(function(respuesta){
            let html = mostrarFormPlataforma(respuesta[0]);
            $('#nuevosEditarPlataforma').html(html);

            return $.ajax({
                method: "POST",
                url: config.controlador,
                dataType: "json",
                data: {
                    [config.idUsuarioContenido]: id,
                    "orden": 'comprobar'
                },
            }); // Fin ajax
        }).then(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                $('#plataformaFormEditar').val(respuesta[0][config.plataforma]);
            } // Fin else
        }); // Fin then

    });

    // Funcionalidad de aceptar en editar plataforma Juego
    $('#botFormEditarPlatAceptar').click(function(event){
        event.preventDefault();

        let id = $('#idFormEditar').val();
        let plataforma = $('#plataformaFormEditar').val();

        $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data: {
                [config.idUsuarioContenido]: id,
                [config.plataforma]: plataforma,
                orden: "editarPlataforma"
            }
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                mostrarExito(respuesta.exito);
                agregarHistorial('editarPlataforma', id);

                window.tabla.updateData([{
                    [config.idUsuarioContenido]: id,
                    [config.plataforma]: plataforma
                }]);

                $('#plataformaFormEditar').val('');
                $('#idFormEditar').val('');

                let modalElemento = $('#modalEditar');
                bootstrap.Modal.getInstance(modalElemento).hide();
            } // Fin else
        }) // Fin ajax
    });

    // Funcionalidad de editar notas
    $('#botEditarNotas').click(function(event){
        event.preventDefault();

        let notas = $('#notasFormEditarNotas').val();

        $('#editorNotas').removeClass('d-none');
        $('#textoNotas').addClass('d-none');
        $('#botEditarNotas').addClass('d-none');
        $('#notasTextarea').trigger('focus');
        if(notas==''){
            $('#notasTextarea').val('')
        }else{
            $('#notasTextarea').val(notas);
        }

    });
    
    // Funcionalidad de aceptar en editar notas
    $('#botGuardarNotas').click(function(event){
        event.preventDefault();

        let notas = $('#notasTextarea').val();
        let id = $('#idFormEditarNotas').val();

        $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data: {
                [config.idUsuarioContenido]: id,
                [config.notas]: notas,
                "orden": 'editarNotas'
            },
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                mostrarExito(respuesta.exito);
                agregarHistorial('editarNotas', id);

                $('#editorNotas').addClass('d-none');
                $('#textoNotas').removeClass('d-none');
                $('#botEditarNotas').removeClass('d-none');
                $('#notasFormEditarNotas').val(notas);

                if(notas==''){
                    $('#textoNotas').text('Aún no has añadido ninguna nota.')
                }else{
                    $('#textoNotas').text(notas);
                }

                notas = notas === '' ? null : notas;

                let fila = window.tabla.getRow(id);

                fila.update({
                    [config.notas]: notas
                }).then(function(){
                    fila.reformat();
                });

            } // Fin else
        }) // Fin ajax
    });

    // Funcionalidad de cancelar en editar notas
    $('#botCancelarNotas').click(function(event){
        event.preventDefault();

        $('#editorNotas').addClass('d-none');
        $('#textoNotas').removeClass('d-none');
        $('#botEditarNotas').removeClass('d-none');
    });


    /////////////////////////////////////     PENDIENTES      /////////////////////////////////////

    // Funcionalidad de buscar pendiente
    $('#nombreFormPend').on('input', function(){

        clearTimeout(temporizadorBusqueda);
        let nombre = $('#nombreFormPend').val();
        if(nombre.length < 2){
            return;
        }

        temporizadorBusqueda = setTimeout(function(){

                $.ajax({
                method: "POST",
                url: config.controlador,
                dataType: "json",
                data: {
                    [config.nombre]: nombre,
                    "orden": 'buscarApi'
                },
            }).done(function(respuesta){
                if(respuesta.error){
                    mostrarError(respuesta.error);
                    console.log(respuesta.error_tecnico);
                }else{
                    let html = resultadosApi(respuesta);
                    $('#resultadosApiPend').html(html);
                } // Fin else
            }) // Fin ajax

        },500);

    });

    // Funcionalidad click en resultado Api pendiente
    $('#modalPendiente').on("click",".resultadoApi", function(event){
        event.preventDefault();
        let idApi = $(this).data("id");

        $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data:{
                "idApi": idApi,
                "orden":"detallesApi"
            }
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                contenidoSeleccionado = respuesta;

                if(config.nombreContenido == 'Serie' || config.nombreContenido == 'Temporada' || config.nombreContenido == 'Episodio'){
                    let info = mostrarDetalles(contenidoSeleccionado, config.detallesSerie, 'posterSerie');
                    $('#nuevosAgregarPend').html(info);

                    let selector = mostrarSelectorTemporadas(contenidoSeleccionado);
                    $('#selectorSeriePend').html(selector);

                    $('#nombreAgregarPend').text(contenidoSeleccionado['nombreSerie']);

                    $('#selectorSeriePend').removeClass('d-none');
                    $('#modal-dialog-Pend').addClass('modal-xl');
                    $('#capaNuevosAgregarPend').addClass('col-md-6');
                }else{

                    let info = mostrarDetalles(contenidoSeleccionado, config.detallesInfo);
                    $('#nuevosAgregarPend').html(info);

                    $('#nombreAgregarPend').text(contenidoSeleccionado[config.campos.nombre]);

                    $('#pieAgregarPend').removeClass('d-none');
                    $('#modal-dialog-Pend').addClass('modal-lg');
                }

                $('#contenidoBuscarPend').addClass('d-none');
                $('#contenidoAgregarPend').removeClass('d-none');

            } // Fin else
        }); // Fin ajax
    });

    // Funcionalidad de aceptar en agregar pendiente
    $('#botAgregarPendAceptar').click(function(event){
        event.preventDefault();

        let datos = {
            orden: "agregarPend",
        };

        for(const [campoPOST, campoContenido] of Object.entries(config.camposBD)){
            datos[campoPOST] = contenidoSeleccionado[campoContenido];
        }

        $.ajax({
            method:"POST",
            url: config.controlador,
            dataType: "json",
            data: datos
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                agregarHistorial('añadirPend', respuesta[config.idUsuarioContenido]);
                tablaPendientes();

                let modalPendiente = document.getElementById('modalPendiente');
                bootstrap.Modal.getInstance(modalPendiente).hide();

                $.ajax({
                    method: "POST",
                    url: config.controlador,
                    dataType: "json",
                    data: {
                        orden: 'descargarPoster',
                        [config.idContenido]: respuesta[config.idContenido],
                        [config.poster]: contenidoSeleccionado[config.poster]
                    }
                }).done(function(respuesta){
                    if(respuesta.error){
                        mostrarError(respuesta.error);
                        console.log(respuesta.error_tecnico);
                    }
                });

            } // Fin else
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log("Error AJAX:", textStatus);
            console.log("Error:", errorThrown);
            console.log("Respuesta del servidor:", jqXHR.responseText);
        }); // Fin ajax
    });

    // Funcionalidad de click de agregar en pendiente en tabla
    $('#tablas').on('click', '.agregarPendTabla', function(event){
        event.preventDefault();

        let id = $(this).data('id');

        $('#nombreAgregar').text('Cargando...');

        obtenerDetalles(id).then(function(respuesta){

            let info = mostrarDetalles(respuesta[0], config.detalles);
            $('#nuevosAgregar').html(info);
            $('#nombreAgregar').text(respuesta[0][config.campos.nombre]);
            
            let form = mostrarFormAgregar(config.formAgregar);
            $('#detallesFormAgregar').html(form);

            let hoy = new Date().toISOString().split('T')[0];
            $('#fechaFormAgregar').val(hoy);
        });

        $('#idFormAgregarPendTabla').val(id);

        $('#contenidoBuscar').addClass('d-none');
        $('#contenidoAgregar').removeClass('d-none');
        $('#formAgregar').removeClass('d-none');
        $('#pieAgregarPendTabla').removeClass('d-none');
        $('#modal-dialog-Agregar').addClass('modal-xl');

    });

    // Funcionalidad de aceptar en agregar pendiente en tabla
    $('#botAgregarPendTablaAceptar').click(function(event){
        event.preventDefault();

        let id = $('#idFormAgregarPendTabla').val();
        let rating = $('#ratingFormAgregar').val();
        let fav = $('#corazonFormAgregar').hasClass('bi-heart-fill') ? 1 : 0;
        let notas = $('#notasFormAgregar').val();
        
        let datos = {
            [config.idUsuarioContenido]: id,
            [config.rating]: rating,
            [config.fav]: fav,
            [config.notas]: notas,
            "orden": 'agregarPendTabla'
        }

        for(const campo of config.formAgregar){
            datos[campo.nombre] = $('#' + campo.id).val();
        }
        
        $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data: datos
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                agregarHistorial('añadir', id);
                tablaGeneral();

                let modalAgregar = document.getElementById('modalAgregar');
                bootstrap.Modal.getInstance(modalAgregar).hide();

            } // Fin else
        }); // Fin ajax
    });


    //////////////////////////////////////     ELIMINAR      //////////////////////////////////////

    // Funcionalidad de eliminar
    $('#tablas').on('click', '.eliminar', function(event){
        event.preventDefault();

        let id = $(this).data('id');
        $('#idFormEliminar').val(id);

        // Ajax para comprobar el idPelicula de este idUsuarioContenido en usuariosxcontenidos
        $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data: {
                [config.idUsuarioContenido]: id,
                "orden": 'comprobar'
            },
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                // Ajax para comprobar los datos de este idContenido
                $.ajax({
                    method: "POST",
                    url: config.controlador,
                    data: {
                        [config.idContenido]: respuesta[0][config.idContenido],
                        "orden": 'comprobarContenido'
                    },
                }).done(function(respuesta){
                    respuesta=JSON.parse(respuesta);
                    if(respuesta.error){
                        mostrarError(respuesta.error);
                        console.log(respuesta.error_tecnico);
                    }else{
                        if(respuesta[0][config.ano]){
                            $('#eliminarModalLabel').html('¿Está seguro de que quiere eliminar <span class="fw-bold '+config.color+'">'+respuesta[0][config.nombre]+' ('+respuesta[0][config.ano]+')</span>?');
                        }else{
                            $('#eliminarModalLabel').html('¿Está seguro de que quiere eliminar <span class="fw-bold '+config.color+'">'+respuesta[0][config.nombre]+'</span>?');
                        }
                        
                    } // Fin else
                }); // Fin ajax
                
            } // Fin else
        }); // Fin ajax
    });

    // Funcionalidad de aceptar en eliminar
    $('#botFormEliminarAceptar').click(function(event){
        event.preventDefault();

        let id = $('#idFormEliminar').val();
        agregarHistorial('eliminar', id);
        
        $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data: {
                [config.idUsuarioContenido]: id,
                "orden": 'eliminar'
            },
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                mostrarExito(respuesta.exito);
                if(tablaActual=='pendientes'){
                    tablaPendientes();
                }else{
                    $('#idFormEliminar').val('');

                    window.tabla.deleteRow(id);
                    actualizarNumero();
                }

                let modalElemento = $('#modalEliminar');
                bootstrap.Modal.getInstance(modalElemento).hide();
            } // Fin else
        }) // Fin ajax
    });

    
    ///////////////////////////////////////     OTROS      ////////////////////////////////////////

    // Información
    $('#tablas').on('click', '.info', function(event){
        event.preventDefault();
        
        let id = $(this).data('id');

        $('#contenidoBuscarPend').addClass('d-none');
        $('#contenidoAgregarPend').removeClass('d-none');
        $('#modal-dialog-Pend').addClass('modal-lg');
        $('#pendienteModalLabel').text('Información');
        $('#nombreAgregarPend').text('Cargando...');
        $('#contenidoAgregarPend').css('max-height', '80vh');
        $('#nuevosAgregarPend').html('');

        obtenerDetalles(id).then(function(respuesta){
            let info = mostrarDetalles(respuesta[0], config.detallesInfo);
            $('#nuevosAgregarPend').html(info);
            $('#nombreAgregarPend').text(respuesta[0][config.campos.nombre]);
        });

    });

    // Botones del apartado Series
    $('#nuevosBotones').on('click', 'button', function(){

        $('#nuevosBotones button').removeClass('active');
        $(this).addClass('active');

        if($(this).attr('id') === 'botSeries'){
            config = contenidoConfig['serie'];
        }else if($(this).attr('id') === 'botTemporadas'){
            config = contenidoConfig['temporada'];
        }else if($(this).attr('id') === 'botEpisodios'){
            config = contenidoConfig['episodio'];
        }

        tablaGeneral();
    });

    // Movilidad de las estrellas de los formularios
    $('form').on('mousemove', '.estrella', function(){

        let estrella = $(this);
        let valor = estrella.data('valor');
        
        let mitad = this.getBoundingClientRect().left + this.offsetWidth / 2;

        let rating;

        if(event.clientX < mitad){
            rating = valor - 0.5;
        }else{
            rating = valor;
        }

        $('.estrella').each(function(){

            let posicion = $(this).data('valor');

            $(this).removeClass('bi-star bi-star-fill bi-star-half');

            if(posicion <= Math.floor(rating)){
                $(this).addClass('bi-star-fill');
            }
            else if(posicion == Math.ceil(rating) && rating % 1 != 0){
                $(this).addClass('bi-star-half');
            }
            else{
                $(this).addClass('bi-star');
            }

        }); // Fin de la función de cada estrella
    });

    // Cargar historial al abrir panel
    $('#panelHistorial').on('shown.bs.collapse', function(){
        mostrarHistorial();
    });

    // Funcionalidad de X en menu
    $(document).on('click', '#menu .close', function(event) {
        event.preventDefault();
        $('body').removeClass('is-menu-visible'); 
        $('#menu').removeClass('visible');
    });

    // Abrir modal buscar
    $('#modalAgregar').on('shown.bs.modal', function () {
        if (!$('#contenidoBuscar').hasClass('d-none')) {
            $('#nombreFormBuscarApi').trigger('focus');
        }
    });

    // Abrir modal buscar pendiente
    $('#modalPendiente').on('shown.bs.modal', function () {
        if (!$('#contenidoBuscarPend').hasClass('d-none')) {
            $('#nombreFormPend').trigger('focus');
        }
    });

    // Placeholder buscar
    $('#cajaBusqueda').attr('placeholder', 'Buscar '+config.nombreContenido+'...');

    // Texto en boton agregar
    $('#botAgregar').text('Agregar ' + config.nombreContenido);

    // Títulos modales
    $('#agregarModalLabel').text('Agregar '+config.nombreContenido);
    $('#pendienteModalLabel').text('Agregar '+config.nombreContenido+' Pendiente');
    $('#notasModalLabel').text('Notas de '+config.nombreContenido);
    $('#editarFechaModalLabel').text('Editar fecha de '+config.accionFecha);

    // Colores
    $('#botAgregar').addClass(config.color);
    $('.bi-star-fill').addClass(config.color);
    $('.bi-star-half').addClass(config.color);
    $('.bi-star').addClass(config.color);
    $('.xModal').addClass(config.color);
    $('#nombreAgregar').addClass(config.color);
    $('#nombreAgregarPend').addClass(config.color);
    $('#nombreNotas').addClass(config.color);
    $('#estrellasEditar').addClass(config.color);
    $('#botAgregarAceptar').addClass(config.colorBoton);
    $('#botAgregarTemporadaAceptar').addClass(config.colorBoton);
    $('#botAgregarEpisodioAceptar').addClass(config.colorBoton);
    $('#botAgregarTemporadaPendAceptar').addClass(config.colorBoton);
    $('#botAgregarEpisodioPendAceptar').addClass(config.colorBoton);
    $('#botAgregarPendAceptar').addClass(config.colorBoton);
    $('#botAgregarPendTablaAceptar').addClass(config.colorBoton);
    $('#botFormEditarValAceptar').addClass(config.colorBoton);
    $('#botFormEditarFechaAceptar').addClass(config.colorBoton);
    $('#botFormEditarPlatAceptar').addClass(config.colorBoton);
    $('#botFormEditarEstadoAceptar').addClass(config.colorBoton);
    $('#botGuardarNotas').addClass(config.colorBoton);
    $('#botEditarNotas').addClass(config.color);
    $('#tablas').addClass(config.tabla);

    // Cerrar modales
    $('.modal').on('hide.bs.modal', function(){
        document.activeElement.blur();
        
        $('#nombreFormBuscarApi').val('');
        $('#nombreFormPend').val('');
        $('#resultadosApi').html('');
        $('#resultadosApiPend').html('');
        $('#contenidoBuscar').removeClass('d-none');
        $('#contenidoAgregar').addClass('d-none');
        $('#formAgregar').addClass('d-none');
        $('#contenidoBuscarPend').removeClass('d-none');
        $('#contenidoAgregarPend').addClass('d-none');
        $('#modal-dialog-Pend').removeClass('modal-lg');
        $('#pieAgregar').addClass('d-none');
        $('#pieAgregarEpisodio').addClass('d-none');
        $('#pieAgregarTemporada').addClass('d-none');
        $('#pieAgregarPend').addClass('d-none');
        $('#pieAgregarPendTabla').addClass('d-none');
        $('#pieAgregarEpisodioPend').addClass('d-none');
        $('#pieAgregarTemporadaPend').addClass('d-none');
        $('#modal-dialog-Agregar').removeClass('modal-xl');
        $('#modal-dialog-Pend').removeClass('modal-xl');
        $('#infoEstrellasAgregar').addClass('invisible');
        $('#pendienteModalLabel').text('Agregar '+config.nombreContenido+' Pendiente');
        $('#contenidoAgregarPend').css('max-height', '');

        $('#editarFechaForm').addClass('d-none');
        $('#editarValForm').addClass('d-none');
        $('#editarPlataformaForm').addClass('d-none');
        $('#editarEstadoForm').addClass('d-none');
        $('#botVal').addClass('d-none');
        $('#botFecha').addClass('d-none');
        $('#botPlat').addClass('d-none');
        $('#botEstado').addClass('d-none');

        $('#editorNotas').addClass('d-none');
        $('#textoNotas').removeClass('d-none');
        $('#botEditarNotas').removeClass('d-none');

        if($('#corazonFormAgregar').hasClass('bi-heart-fill')){
            $('#corazonFormAgregar').removeClass('bi-heart-fill').addClass('bi-heart');
        }
        $('#ratingFormAgregar').val('');
        $('#notasFormAgregar').val('');

        if(configAnterior){
            config = configAnterior;
            configAnterior = null;
        }
    });

    // Reposicionar tabla
    window.addEventListener("resize", function(){
        if(window.tabla){
            window.tabla.redraw(true);
        }
    });

}) // Fin document.ready



