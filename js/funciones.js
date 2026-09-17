// TABLAS

function crearTabla(lista, texto){

    let titulo = '<div id="cabeceraTabla" class="text-white text-center py-2">';
    titulo += '<h1 id="tituloTabla" class="m-0 mb-2 '+config.color+'">'+texto +'</h1>';
    if(lista.length == 1){
        titulo+= '<h3 id="numRegistros" class="m-0">'+lista.length+' Registro</h3></div>';
    }else{
        titulo+= '<h3 id="numRegistros" class="m-0">'+lista.length+' Registros</h3></div>';
    }
    $("#tituloTablas").html(titulo);


    window.tabla = new Tabulator("#tablas", {
            data:lista,
            index: config.idUsuarioContenido,
            locale: "es",
            langs:{
                "es":{
                    "pagination":{
                        "page_size":"Filas:",
                        "page_title":"Mostrar página",
                        "first":"<<",
                        "first_title":"Primera página",
                        "last":">>",
                        "last_title":"Última página",
                        "prev":"<",
                        "prev_title":"Página anterior",
                        "next":">",
                        "next_title":"Página siguiente",
                        "all":"Todo",
                        "counter":{
                            "showing":"Mostrando",
                            "of":"de",
                            "rows":"filas",
                            "pages":"páginas"
                        }
                    },
                    "headerFilters":{
                        "default":"filtrar..."
                    }
                }
            },
            placeholder: '<div class="py-4 text-center"> <i class="bi '+config.icono+' fs-2 d-block mb-2 text-dark"></i> <strong class="text-black">No hay registros</strong> </div>',
            pagination: true,
            paginationSize: config.filas,
            paginationSizeSelector: [config.filas, 25, 50, 100, 500],
            movableColumns: true,
            layout:"fitColumns",
            responsiveLayout:false,
            columnDefaults:{
                resizable:false,
                headerSort:false,
                headerHozAlign:"center",
                hozAlign:"center"
            },
            headerElement: '<div class="text-center py-3 bg-primary text-white"><h2 class="m-0">'+texto+'</h2></div>',
            columns:config.columns
        });

        return window.tabla;
} // Fin crearTabla()

function celdaNombre(cell){
    let datos = cell.getRow().getData();

    if(datos[config.pendiente]==1){
        let codigo = '<div class="position-relative"><div class="text-center"><span class="d-inline-block w-75">(Pendiente)<br>'+datos[config.nombre]+'</span></div>';

        codigo += '<div class="tresPuntos position-absolute top-50 end-0 me-2"><div class="botPuntos btn p-0 border-0" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical fs-6"></i></div>';
        codigo +='<ul class="dropdown-menu menuTabla text-center">';
        
        codigo +='<li class="dropdown-item agregarPendTabla '+config.color+'" data-id="'+datos[config.idUsuarioContenido]+'" data-bs-toggle="modal" data-bs-target="#modalAgregar"> Agregar </li>';
        codigo +='<li class="dropdown-item info" data-id="'+datos[config.idUsuarioContenido]+'" data-bs-toggle="modal" data-bs-target="#modalPendiente"> Información </li>';
        codigo +='<li class="dropdown-item eliminar" data-id="'+datos[config.idUsuarioContenido]+'" data-bs-toggle="modal" data-bs-target="#modalEliminar"> Eliminar </li>';

        return codigo;
    }else{

        let codigo = '<div class="position-relative"><div class="text-center"><span class="d-inline-block w-75">'+datos[config.nombre]+'</span></div>';

        codigo += '<div class="tresPuntos position-absolute top-50 end-0 me-2"><div class="botPuntos btn p-0 border-0" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical fs-6"></i></div>';
        codigo +='<ul class="dropdown-menu menuTabla text-center">';
        
        codigo +='<li class="dropdown-item info" data-id="'+datos[config.idUsuarioContenido]+'" data-bs-toggle="modal" data-bs-target="#modalPendiente"> Información </li>';
        codigo +='<li class="dropdown-item editarValoracion" data-id="'+datos[config.idUsuarioContenido]+'" data-bs-toggle="modal" data-bs-target="#modalEditar">Editar Valoración</li>';
        codigo +='<li class="dropdown-item editarFecha" data-id="'+datos[config.idUsuarioContenido]+'" data-bs-toggle="modal" data-bs-target="#modalEditar">Editar Fecha'+config.pluralFecha+'</li>';
        if(config.editarEstado){
            codigo +='<li class="dropdown-item editarEstado" data-id="'+datos[config.idUsuarioContenido]+'" data-bs-toggle="modal" data-bs-target="#modalEditar">Editar Estado</li>';
        }
        if(config.editarPlataforma){
            codigo +='<li class="dropdown-item editarPlataforma" data-id="'+datos[config.idUsuarioContenido]+'" data-bs-toggle="modal" data-bs-target="#modalEditar">Editar Plataforma</li>';
        }
        codigo +='<li class="dropdown-item eliminar" data-id="'+datos[config.idUsuarioContenido]+'" data-bs-toggle="modal" data-bs-target="#modalEliminar">Eliminar</li></ul></div></div>';

        return codigo;
    }
} // Fin celdaNombre()

function celdaDosFechas(cell){

    let datos = cell.getRow().getData();

    const fechaInicio = datos[config.fechaInicio];
    const fechaFin = datos[config.fecha];

    let html = '';

    if(fechaInicio){
        html += cambiarFecha(fechaInicio);
    }

    if(fechaFin){

        if(fechaInicio){
            html += '<br>';
        }

        html += cambiarFecha(fechaFin);
    }

    return html;

} // Fin celdaDosFechas()

function celdaIconos(cell){
    const datos = cell.getRow().getData();
    let html = '';

    if(datos[config.pendiente]==1){
        return html;
    }else if(datos[config.pendiente]==0){

        if(datos[config.fav]==false){
            if(datos[config.notas]==null){
                html += '<i id="notas'+datos[config.idUsuarioContenido]+'" data-id="'+datos[config.idUsuarioContenido]+'" class="notas bi bi-journal fs-6" data-bs-toggle="modal" data-bs-target="#modalNotas"></i> ';
            }else{
                html += ' <i id="notas'+datos[config.idUsuarioContenido]+'" data-id="'+datos[config.idUsuarioContenido]+'" class="notas bi bi-journal-text fs-6" data-bs-toggle="modal" data-bs-target="#modalNotas"></i> ';
            }
            html += ' <i id="corazon'+datos[config.idUsuarioContenido]+'" data-id="'+datos[config.idUsuarioContenido]+'" class="fav bi bi-heart text-danger fs-6 ms-1"></i>';
            return html;
        }else{
            if(datos[config.notas]==null){
                html += ' <i id="notas'+datos[config.idUsuarioContenido]+'" data-id="'+datos[config.idUsuarioContenido]+'" class="notas bi bi-journal fs-6" data-bs-toggle="modal" data-bs-target="#modalNotas"></i> ';
            }else{
                html += ' <i id="notas'+datos[config.idUsuarioContenido]+'" data-id="'+datos[config.idUsuarioContenido]+'" class="notas bi bi-journal-text fs-6" data-bs-toggle="modal" data-bs-target="#modalNotas"></i> ';
            }
            html += ' <i id="corazon'+datos[config.idUsuarioContenido]+'" data-id="'+datos[config.idUsuarioContenido]+'" class="fav bi bi-heart-fill text-danger fs-6 ms-1"></i> ';
            return html;
        }
    }
} // Fin celdaIconos()

function tablaGeneral(){

    $.ajax({
        method: "POST",
        url: config.controlador,
        dataType: "json",
        data:{
            "orden": 'listarTodo',
        },
    }).done(function(respuesta){
        if(respuesta.error){
           mostrarError(respuesta.error);
           console.log(respuesta.error_tecnico);
        }else{
            if(window.tabla){
                window.tabla.destroy();
            }
            tablaActual='general';
            window.tabla = crearTabla(respuesta, config.nombrePluralContenido);
        } // Fin else
    }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log("Error AJAX:", textStatus);
            console.log("Error:", errorThrown);
            console.log("Respuesta del servidor:", jqXHR.responseText);
        }); // Fin ajax
} // Fin TablaGeneral()

function tablaEstrellas(i){

        $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data:{
                "orden": 'listarEstrellas',
                "i": i
            },
        }).done(function(respuesta){
            if(respuesta.error){
                mostrarError(respuesta.error);
                console.log(respuesta.error_tecnico);
            }else{
                if(window.tabla){
                    window.tabla.destroy();
                }
                tablaActual='estrellas';
                window.tabla = crearTabla(respuesta, config.nombrePluralContenido+' valorad'+config.genero+'s con '+i+' estrellas');
            } // Fin else
        }); // Fin ajax
} // Fin tablaPelicula()

function tablaFavoritas(){

    $.ajax({
        method: "POST",
        url: config.controlador,
        dataType: "json",
        data:{
            "orden": 'listarFav',
        },
    }).done(function(respuesta){
        if(respuesta.error){
            mostrarError(respuesta.error);
            console.log(respuesta.error_tecnico);
        }else{
            if(window.tabla){
                window.tabla.destroy();
            }
            tablaActual = 'favoritas';
            window.tabla = crearTabla(respuesta, config.nombrePluralContenido+' Favorit'+config.genero+'s');
        } // Fin else
    }); // Fin ajax
} // Fin tablaFavoritas()

function crearTablaPendientes(lista){
    $('#tituloTabla').text(config.nombrePluralContenido+' Pendientes');
    let numPend = lista.length;
    $('#numRegistros').text(numPend+' Registros');

    if(lista.length == 0){
        let vacio = '<div class="card"><div class="card-body text-center flex-column"> <i class="bi '+config.icono+' fs-2 d-block mb-2"></i> <strong class="text-black"> No hay registros</strong> </div></div>';
        return vacio;
    }

    let tarjetas = '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">';

    for(let contenido of lista){

        tarjetas += `
        <div class="col d-flex">

            <div class="card position-relative w-100">
                <div class="card-body text-center">

                    <span class="d-inline-block w-75">
                        ${contenido[config.nombre]}
                    </span>

                    <div class="dropdown tresPuntos position-absolute top-50 end-0 me-2">
                        <div class="btn p-0 border-0" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical fs-6"></i>
                        </div>

                            <ul class="dropdown-menu menuTabla text-center">

                                <li class="dropdown-item agregarPendTabla ${config.color}"
                                    data-id="${contenido[config.idUsuarioContenido]}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalAgregar">
                                    Agregar
                                </li>

                                <li class="dropdown-item info"
                                    data-id="${contenido[config.idUsuarioContenido]}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalPendiente">
                                    Información
                                </li>

                                <li class="dropdown-item eliminar"
                                    data-id="${contenido[config.idUsuarioContenido]}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEliminar">
                                    Eliminar
                                </li>

                            </ul>

                    </div>

                </div>
            </div>

        </div>`;
    }

    tarjetas += '</div>';

    return tarjetas;
} // Fin crearTablaPendientes()

function tablaPendientes(){

    $.ajax({
        method: "POST",
        url: config.controlador,
        dataType: "json",
        data:{
            "orden": 'listarPendientes',
        },
    }).done(function(respuesta){
        if(respuesta.error){
            mostrarError(respuesta.error);
            console.log(respuesta.error_tecnico);
        }else{
            if(window.tabla){
                window.tabla.destroy();
            }
            tablaActual='pendientes';
            tarjetas = crearTablaPendientes(respuesta);
            $('#tablas').html(tarjetas);
        } // Fin else
    }); // Fin ajax
} // Fin tablaPendientes()


// API

function resultadosApi(respuesta){
    let poster='';
    let nombre='';
    let ano='';

    if(config.nombreContenido == 'Serie' || config.nombreContenido == 'Temporada' || config.nombreContenido == 'Episodio'){
        poster = 'posterSerie';
        nombre = 'nombreSerie';
        ano = 'anoSerie';
    }else{
        poster = config.poster;
        nombre = config.nombre;
        ano = config.ano;
    }

    let html = "";
    if(respuesta.length > 0){
        let principal = respuesta[0];
        html += `<div class="resultadoApi principal" data-id="${principal['idApi']}">`;
                    if(principal[poster] == config.noPoster){
                        html+=`<img src="images/noPoster.jpeg">`;
                    }else{
                        html+=`<img src="${principal[poster]}">`;
                    }
            html+= `<div>
                        <strong>${principal[nombre]}</strong>
                        <br>
                        ${principal[ano]}
                    </div>
                </div>`;

        html += `<div class="row mt-3 g-3">`;
        for(let i = 1; i < respuesta.length; i++){
            let contenido = respuesta[i];
            html += `<div class="col-4">
                        <div class="resultadoApi secundario text-center" data-id="${contenido['idApi']}">`;
                            if(contenido[poster] == config.noPoster){
                                html+=`<img src="images/noPoster.jpeg">`;
                            }else{
                                html+=`<img src="${contenido[poster]}">`;
                            }
                    html+= `<div>
                                <strong>${contenido[nombre]}</strong>
                                <br>
                                ${contenido[ano]}
                            </div>
                        </div>
                    </div>`;
        }
        html += `</div>`;
    }

    return html;
} // Fin resultadosApi()

// Obtener los detalles del contenido desde idUsuarioContenido
function obtenerDetalles(id){

    return $.ajax({
        method: "POST",
        url: config.controlador,
        dataType: "json",
        data:{
            [config.idUsuarioContenido]: id,
            "orden": 'comprobar',
        }
    }).then(function(respuesta){
        if(respuesta.error){
            throw respuesta.error;
        }

        let idContenido = respuesta[0][config.idContenido]

        return $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data:{
                [config.idContenido]: idContenido,
                "orden": 'comprobarContenido'
            }
        });
    }).then(function(respuesta){
        if(respuesta.error){
            throw respuesta.error;
        }
        contenidoSeleccionado = respuesta[0];

        return respuesta;

        }).catch(function(error){
        mostrarError(error);
    });

} // Fin obtenerDetalles()

// Obtener los detalles de la Api desde idUsuarioContenido
function obtenerDetalles2(id){

    // Ajax para obtener idPelicula desde idUsuarioContenido
    return $.ajax({
        method: "POST",
        url: config.controlador,
        dataType: "json",
        data:{
            [config.idUsuarioContenido]: id,
            "orden": 'comprobar',
        }
    }).then(function(respuesta){
        if(respuesta.error){
            throw respuesta.error;
        }

        let idContenido = respuesta[0][config.idContenido]

        // Ajax para obtener idApi desde idPelicula
        return $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data:{
                [config.idContenido]: idContenido,
                "orden": 'comprobarContenido'
            }
        });
    }).then(function(respuesta){
        if(respuesta.error){
            throw respuesta.error;
        }

        let idApi = respuesta[0].idApi;

        // Ajax para recoger los detalles desde idApi
        return $.ajax({
            method: "POST",
            url: config.controlador,
            dataType: "json",
            data: {
                "idApi": idApi,
                "orden": 'detallesApi'
            }
        });
    }).then(function(respuesta){
        if(respuesta.error){
            throw respuesta.error;
        }
            contenidoSeleccionado=respuesta;
            return respuesta;
    }).catch(function(error){
        mostrarError(error);
    });

} // Fin obtenerDetalles2()


// MODALES

function mostrarDetalles(contenido, detalles, campoPoster=null){

    let htmlPoster = '';
    let htmlDatos = '';
    let htmlAbajo = '';
    let htmlSinopsis = '';

    /*
     * ZONA POSTER
    */

    let poster = contenido[campoPoster ?? config.campos.poster];

    if(!poster || poster === config.noPoster){

        poster = 'images/noPoster.jpeg';
    }

    htmlPoster += `
        <div class="row g-3">

            <div class="col-5">

                <img id="posterAgregar"
                     src="${poster}"
                     class="img-fluid rounded shadow"
                     alt="Póster">

            </div>

            <div class="col-7 text-center">
    `;


    for(const detalle of detalles){

        if(detalle.zona !== 'poster'){
            continue;
        }

        const valor = contenido[detalle.campo];

        if(valor == null || valor === ''){
            continue;
        }

        htmlPoster += `
            <div class="mb-3">

                <div class="${config.color} small fw-bold">

                    ${detalle.icono
                        ? `<i class="bi ${detalle.icono} me-1"></i>`
                        : ''
                    }

                    ${detalle.titulo}

                </div>

                <div>
                    ${valor}${detalle.unidad ?? ''}
                </div>

            </div>
        `;
    }


    htmlPoster += `
            </div>

        </div>
    `;


    /*
     * ZONA DATOS
    */

    const datosZona = detalles.filter(
        detalle => detalle.zona === 'datos'
    );


    if(datosZona.length > 0){

        htmlDatos += `
            <div class="row text-center g-2 mt-3">
        `;


        datosZona.forEach(function(detalle){

            let valor = contenido[detalle.campo];

            if(valor == null || valor === ''){
                return;
            }

            htmlDatos += `
                <div class="col-${12 / datosZona.length}">

                    <div class="border rounded p-2">

                        <div class="${config.color} small fw-bold">
                            ${detalle.titulo}
                        </div>

                        <div>
                            ${valor}${detalle.unidad ?? ''}
                        </div>

                    </div>

                </div>
            `;
        });


        htmlDatos += `
            </div>
        `;
    }


    /*
     * ZONA ABAJO
    */

    const abajoZona = detalles.filter(
        detalle => detalle.zona === 'abajo'
    );


    if(abajoZona.length > 0){

        htmlAbajo += `
            <hr class="my-3">

            <div class="row text-center align-items-center">
        `;


        abajoZona.forEach(function(detalle){

            const valor = contenido[detalle.campo];

            if(valor == null || valor === ''){
                return;
            }

            let claseColumna = 'col-6 mb-3';

            if(detalle.campo === 'companiaPelicula'){
                claseColumna = 'col-12 mb-3';
            }

            htmlAbajo += `
                <div class="${claseColumna}">

                    <div class="${config.color} small fw-bold">

                        ${detalle.icono
                            ? `<i class="bi ${detalle.icono} me-1"></i>`
                            : ''
                        }

                        ${detalle.titulo}

                    </div>

                    <div>
                        ${valor}${detalle.unidad ?? ''}
                    </div>

                </div>
            `;
        });


        htmlAbajo += `
            </div>
        `;
    }


    /*
     * ZONA SINOPSIS
    */

    const sinopsis = detalles.find(
        detalle => detalle.zona === 'sinopsis'
    );


    if(sinopsis){

        const valor = contenido[sinopsis.campo];

        if(valor != null && valor !== ''){

            htmlSinopsis = `
                <hr class="my-3">

                <div>

                    <div class="${config.color} small fw-bold">

                        ${sinopsis.icono
                            ? `<i class="bi ${sinopsis.icono} me-1"></i>`
                            : ''
                        }

                        ${sinopsis.titulo}

                    </div>

                    <div>
                        ${valor}
                    </div>

                </div>
            `;
        }
    }

    /*
     * Juntamos todas las zonas
    */

    return htmlPoster + htmlDatos + htmlAbajo + htmlSinopsis

} // Fin mostrarDetalles()

function mostrarSelectorTemporadas(respuesta){

    let html = '';

    html += `
        <div class="mb-4 text-center d-flex justify-content-center">

            <div class="serieCompleta w-75" data-tipo="serie" data-id="${respuesta.idApi}">

                <div class="serieOpcionContenido">
                    <i class="bi bi-collection-play-fill"></i>
                    <div>
                        <strong>Serie Completa</strong>
                        <div>
                            ${respuesta.temporadasSerie}
                            temporadas ·
                            ${respuesta.episodiosSerie}
                            episodios
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

    html += `<h5 class="mb-3 text-center">Temporadas</h5>
                <div class="row g-3">`;


    for(const temporada of respuesta.temporadas){

        const numero = temporada.season_number;

        const posterTemporada = temporada.poster_path ? 'https://image.tmdb.org/t/p/w300'+ temporada.poster_path : 'images/noPoster.jpeg';


        html += `
            <div class="col-6 col-md-4 col-lg-3">

                <div class="temporadaOpcion" data-id="${respuesta.idApi}" data-temporada="${numero}">

                    <img src="${posterTemporada}" class="img-fluid rounded">

                    <div class="text-center mt-2">
                        <strong>
                            ${numero === 0 ? 'Especiales' : 'Temporada ' + numero}
                        </strong>

                        <div>
                            ${temporada.episode_count} episodios
                        </div>

                    </div>
                </div>
            </div>`;
    }

    html += `</div>`;

    return html;

} // Fin mostrarSelectorTemporadas()

function mostrarSelectorEpisodios(temporada){

    let html = '';

    html += `
        <div class="d-flex align-items-center mb-4">

            <button type="button" class="btn btn-link text-decoration-none volverSeries">
                <i class="bi bi-arrow-left"></i>
                Volver
            </button>

        </div>`;

    html += `
        <div class="my-4 text-center d-flex justify-content-center">

            <div class="temporadaCompleta w-75" data-tipo="serie" data-id="${temporada.idApi}">

                <div class="temporadaOpcionContenido">
                    <i class="bi bi-collection-play-fill"></i>
                    <div>
                        <strong>Temporada Completa</strong>
                        <div>
                            ${temporada.episodiosTemporada}
                            episodios
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

    html += `<h5 class="mb-3 text-center">Episodios</h5>
                <div class="row g-3">`;


    // Episodios
    html += `
        <div class="row g-3">
    `;

    for(const episodio of temporada.episodios){

        html += `
            <div class="col-12">

                <div class="episodioOpcion mx-4"
                     data-id="${episodio.idApi}"
                     data-episodio="${episodio.numeroEpisodio}"
                     data-temporada="${temporada.numeroTemporada}">

                    <div class="row g-3 align-items-center">

                        <div class="col-4 col-md-3">

                            <img src="${episodio.posterEpisodio}"
                                 class="img-fluid rounded"
                                 alt="${episodio.nombreEpisodio}">

                        </div>

                        <div class="col-8 col-md-9">

                            <strong>
                                ${episodio.numeroEpisodio}.
                                ${episodio.nombreEpisodio}
                            </strong>

                            <div>
                                ⭐ ${episodio.ratingAvgEpisodio ?? ''}
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        `;
    }


    html += `</div>`;


    return html;

} // Fin mostrarSelectorEpisodios()

function mostrarFormAgregar(form){

    let html = '';
    html += '<div class="row g-3">';

    for(const campo of form){

        let claseInput = 'form-control';
        let claseContenedor = '';

        if(campo.ancho == 12){
            claseInput += ' w-50';
            claseContenedor = 'd-flex justify-content-center';
        }

        if(campo.type === 'date'){

            html += `
                <div class="col-${campo.ancho}">

                    <div class="text-center">

                        <label class="form-label"> ${campo.label} </label>

                        <div class="${claseContenedor}">

                            <input id="${campo.id}" type="date" class="${claseInput}">

                        </div>
                    </div>
                </div>`;

        }else if(campo.type === 'select'){

            let opciones = [];
            if(campo.label == 'Plataforma'){
                opciones = contenidoSeleccionado["plataformasJuego"] ? contenidoSeleccionado["plataformasJuego"].split(",").map(opcion => opcion.trim()) : [];
            }else if(campo.label == 'Estado'){
                opciones = ['Terminada', 'Viendo', 'Esperando', 'Abandonada'];
            }

            html += `
                <div class="col-${campo.ancho}">

                    <div class="text-center">

                        <label for="${campo.id}" class="form-label"> ${campo.label} </label>

                        <div class="${claseContenedor}">
                            <select id="${campo.id}" class="form-select ${claseInput}">

                            <option value=""> Seleccione ${campo.label}... </option>`;

            opciones.forEach(function(opcion){

                html += `<option value="${opcion}"> ${opcion} </option>`;

            });

            html += `</select>
                    </div>
                </div>
            </div>`;
        }
    }

    html += '</div>';

    return html;
} // Fin mostrarForm()

function mostrarFormFecha(){

    let html = '<div class="row g-3">';

    for(const campo of config.formFecha){

        if(campo.type === "date"){

            let claseInput = "form-control";
            let claseContenedor = "";

            if(campo.ancho == 12){
                claseInput += " w-50";
                claseContenedor = "d-flex justify-content-center";
            }

            html += `
                <div class="col-${campo.ancho}">
                    <div class="text-center">

                        <label for="${campo.id}" class="form-label"> ${campo.label} </label>

                        <div class="${claseContenedor}">
                            <input id="${campo.id}" type="date" class="${claseInput}">
                        </div>

                    </div>
                </div>`;
        }
    }

    html += '</div>';

    return html;

} // Fin mostrarFormFecha()

function mostrarFormEstado(){

    const opciones = ['Terminada', 'Viendo', 'Esperando', 'Abandonada'];

    let html = `<div class="text-center d-flex justify-content-center">
                    <select id="estadoFormEditar" class="form-select w-50">
                        <option value="">
                            Seleccione estado...
                        </option>`;

    opciones.forEach(function(opcion){
        html += `<option value="${opcion}">${opcion}</option>`;
    });

    html += `</select></div>`;

    return html;
} // Fin mostrarFormEstado

function mostrarFormPlataforma(contenido){

    const opciones = contenido["plataformasJuego"] ? contenido["plataformasJuego"].split(",").map(opcion => opcion.trim()) : [];

    let html = `<div class="text-center d-flex justify-content-center">
                    <select id="plataformaFormEditar" class="form-select w-50">
                        <option value="">
                            Seleccione plataforma...
                        </option>`;

    opciones.forEach(function(opcion){
        html += `<option value="${opcion}">${opcion}</option>`;
    });

    html += `</select></div>`;

    return html;
} // Fin mostrarFormPlataforma


// HISTORIAL

function mostrarHistorial(){
    $.ajax({
        method: "POST",
        url: "controladores/controladorHistorial.php",
        dataType: "json",
        data:{
            "orden": config.historial.listar,
        },
    }).done(function(respuesta){
        if(respuesta.error){
           mostrarError(respuesta.error);
           console.log(respuesta.error_tecnico);
        }else{

            let html="";

            if(respuesta.length==0){
                html=`<div class="text-center py-4 text-white">
                        <i class="bi bi-clock-history fs-2"></i>
                        <p>No hay actividad</p>
                    </div>`;
            }else{
                respuesta.forEach(function(h){

                    html+=`<div class="card tarjetaHistorial mb-2">
                            <div class="card-body py-3 d-flex flex-column text-white text-center">
                                <small class="d-block mb-2">
                                    ${cambiarFechaHora(h.fechaHistorial)}
                                </small>

                                <div class="fs-5">
                                    ${textoHistorial(h.accionHistorial)}
                                    <span class="${config.color}">${h.nombreHistorial}</span>
                                </div>
                            </div>
                        </div>`;
                });
            }

            $('#contenidoHistorial').html(html);

        } // Fin else
    }); // Fin ajax
} // Fin mostrarHistorial()

function agregarHistorial(accion, id){
    $.ajax({
        method: "POST",
        url: "controladores/controladorHistorial.php",
        dataType: "json",
        data:{
            "accion": accion,
            [config.idUsuarioContenido]: id,
            "orden": config.historial.agregar,
        },
    }).done(function(respuesta){
        if(respuesta.error){
            mostrarError(respuesta.error);
            console.log(respuesta.error_tecnico);
        }else{
            mostrarHistorial();
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log("Error AJAX:", textStatus);
            console.log("Error:", errorThrown);
            console.log("Respuesta del servidor:", jqXHR.responseText);
        }); // Fin ajax
} // Fin agregarHistorial()

function textoHistorial(accion){

    switch(accion){
        case "añadir":
            return "Añadiste ";

        case "añadirPend":
            return "Añadiste como pendiente "

        case "eliminar":
            return "Eliminaste ";

        case "editarVal":
            return "Cambiaste la valoración de ";

        case "editarFecha":
            return "Cambiaste la fecha de visualizacion de ";

        case "editarNotas":
            return "Cambiaste las notas de ";

        case "editarEstado":
            return "Cambiaste el estado de ";

        case "editarPlataforma":
            return "Cambiaste la plataforma de ";

        case "fav":
            return "Añadiste a favorita ";

        case "desfav":
            return "Quitaste de favorita ";
    }
} // Fin textoHistorial()


// AJUSTES

function botonesSeries(){

    let html = '';

    html += `
        <div class="row g-2 text-center">

            <div class="col-4">
                <button type="button" class="btn botonSerie w-100 active" id="botSeries">
                <i class="bi bi-tv me-2"></i>
                    Series
                </button>
            </div>

            <div class="col-4">
                <button type="button" class="btn botonSerie w-100" id="botTemporadas">
                    <i class="bi bi-collection-play me-2"></i>
                    Temporadas
                </button>
            </div>

            <div class="col-4">
                <button type="button" class="btn botonSerie w-100" id="botEpisodios">
                    <i class="bi bi-play-btn me-2"></i>
                    Episodios
                </button>
            </div>

        </div>
    `;

    $('#nuevosBotones').html(html);

} // Fin botonesSeries()

function transformarRating(n){

let estrellas='';

if(Number.isInteger(n)){
    for(i=1; i < n+1; i++){
        estrellas+='<i data-valor="'+i+'" id="estrella'+i+'" class="estrella bi bi-star-fill"></i>';
        }
    for(i=1; i < 6 - n; i++){
        estrellas+='<i data-valor="'+(n+i)+'" id="estrella'+(n+i)+'"class="estrella bi bi-star mx-1"></i>';
    }

    }else{
        for(i=1; i < n; i++){
            estrellas+='<i data-valor="'+i+'" id="estrella'+i+'" class="estrella bi bi-star-fill mx-1"></i>';
        }

        estrellas+='<i data-valor="'+Math.ceil(n)+'" id="estrella'+Math.ceil(n)+'"class="estrella bi bi-star-half mx-1"></i>';

        for(i=1; i < 5 - n; i++){
        estrellas+='<i data-valor="'+(Math.ceil(n)+i)+'" id="estrella'+(Math.ceil(n)+i)+'"class="estrella bi bi-star mx-1"></i>';
        }   
    }

return estrellas;

} // Fin transformarRating()

function transformarRatingTabla(n){

    if(n == null || n == 0){
        return "";
    }

    let estrellas = '<div class=" text '+config.color+'">';

    if(Math.floor(n)==n){
        for(let i=0; i < n; i++){
            estrellas+='<i class="estrellaTabla bi bi-star-fill '+config.color+'"></i>';
        }
    }else{
        for(let i=0; i < n-1; i++){
            estrellas+='<i class="estrellaTabla bi bi-star-fill '+config.color+'"></i>';
        }
        estrellas+='<i class="estrellaTabla bi bi-star-half '+config.color+'"></i>';
    }

    if(Math.floor(n)==n){
        for(let i=0; i < 5 - n; i++){
            estrellas+='<i class="estrellaTabla bi bi-star '+config.color+'"></i>';
        }
    }else{
        for(let i=0; i < 5 - n-1; i++){
            estrellas+='<i class="estrellaTabla bi bi-star '+config.color+'"></i>';
        }
    }

    estrellas+= '</div>';

    return estrellas;
} // Fin transformarRatingTabla()

function cambiarFecha(n){
    if (!n) return "";

    const [ano, mes, dia] = n.split("-");
    return `${dia}-${mes}-${ano}`;
} // Fin cambiarFecha()

function cambiarFechaHora(n){

    if(!n) return "";

    const [fecha, hora] = n.split(" ");

    const [ano, mes, dia] = fecha.split("-");

    return `${dia}-${mes}-${ano} ${hora.substring(0,5)}`;

} // Fin cambiarFechaHora()

function actualizarNumero(){
    let total = window.tabla.getDataCount();
    $('#numRegistros').text(total+' Registros');
} // Fin actualizarNumero()

function mostrarExito(mensaje){

    $('#mensajes').append(`
        <div class="alert alert-success alert-dismissible fade show shadow text-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            ${mensaje}
        </div>
    `);

    let alerta = $('#mensajes .alert').last();

    setTimeout(function(){
        alerta.alert('close');
    },2000);

} // Fin mostrarExito()

function mostrarError(mensaje){

    $('#mensajes').append(`
        <div class="alert alert-danger alert-dismissible fade show shadow text-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            ${mensaje}
        </div>
    `);

    let alerta = $('#mensajes .alert').last();

    setTimeout(function(){
        alerta.alert('close');
    },4000);

} // Fin mostrarError()