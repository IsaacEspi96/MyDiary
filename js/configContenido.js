const contenidoConfig = {
  pelicula: {
    nombreContenido: "Película",
    nombrePluralContenido: "Películas",
    genero: "a",

    controlador: "controladores/controladorPelicula.php",

    idUsuarioContenido: "idUsuarioPelicula",
    idContenido: "idPelicula",
    nombre: "nombrePelicula",
    ano: "anoPelicula",
    poster: "posterPelicula",
    rating: "ratingPelicula",
    fav: "favPelicula",
    pendiente: "pendientePelicula",
    fecha: "fechaPelicula",
    notas: "notasPelicula",

    noPoster: "https:\/\/image.tmdb.org\/t\/p\/w500",

    accionFecha: "visualización",
    pluralFecha: "",

    tabla: "tablaPelicula",
    color: "colorPelicula",
    colorBoton: "colorPeliculaBoton",

    icono: "bi-film",

    camposBD: {
      idApi: "idApi",
      nombrePelicula: "nombrePelicula",
      directorPelicula: "directorPelicula",
      actorPelicula: "actorPelicula",
      guionistaPelicula: "guionistaPelicula",
      generoPelicula: "generoPelicula",
      anoPelicula: "anoPelicula",
      companiaPelicula: "companiaPelicula",
      duracionPelicula: "duracionPelicula",
      ratingAvgPelicula: "ratingAvgPelicula",
      paisPelicula: "paisPelicula",
      idiomaPelicula: "idiomaPelicula",
      posterPelicula: "posterPelicula",
      sinopsisPelicula: "sinopsisPelicula",
    },

    campos: {
      idApi: "idApi",
      nombre: "nombrePelicula",
      director: "directorPelicula",
      actor: "actorPelicula",
      guionista: "guionistaPelicula",
      genero: "generoPelicula",
      ano: "anoPelicula",
      compania: "companiaPelicula",
      duracion: "duracionPelicula",
      ratingAvg: "ratingAvgPelicula",
      pais: "paisPelicula",
      idioma: "idiomaPelicula",
      poster: "posterPelicula",
      sinopsis: "sinopsisPelicula",
    },

    formAgregar: [
      {
        type: "date",
        nombre: "fechaPelicula",
        label: "Fecha de visualización",
        id: "fechaFormAgregar",
        ancho: 12,
      },
    ],

    formFecha: [
      {
        type: "date",
        nombre: "fechaPelicula",
        label: "",
        id: "fechaFormEditar",
        ancho: 12,
      },
    ],

    detalles: [
      {
        campo: "directorPelicula",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorPelicula",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaPelicula",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "generoPelicula",
        titulo: "Géneros",
        icono: "bi-tags",
        zona: "poster",
      },
      {
        campo: "companiaPelicula",
        titulo: "Productoras",
        icono: "bi-building",
        zona: "poster",
      },
      {
        campo: "anoPelicula",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "duracionPelicula",
        titulo: "Duración",
        unidad: " min",
        zona: "datos",
      },
      {
        campo: "ratingAvgPelicula",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "paisPelicula",
        titulo: "País",
        icono: "bi-globe",
        zona: "abajo",
      },
      {
        campo: "idiomaPelicula",
        titulo: "Idiomas",
        icono: "bi-translate",
        zona: "abajo",
      },
      {
        campo: "sinopsisPelicula",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    detallesInfo: [
      {
        campo: "directorPelicula",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorPelicula",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaPelicula",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "generoPelicula",
        titulo: "Géneros",
        icono: "bi-tags",
        zona: "poster",
      },
      {
        campo: "companiaPelicula",
        titulo: "Productoras",
        icono: "bi-building",
        zona: "poster",
      },
      {
        campo: "anoPelicula",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "duracionPelicula",
        titulo: "Duración",
        unidad: " min",
        zona: "datos",
      },
      {
        campo: "ratingAvgPelicula",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "paisPelicula",
        titulo: "País",
        icono: "bi-globe",
        zona: "poster",
      },
      {
        campo: "idiomaPelicula",
        titulo: "Idiomas",
        icono: "bi-translate",
        zona: "poster",
      },
      {
        campo: "sinopsisPelicula",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    historial: {
      agregar: "agregarPelicula",
      listar: "listarPelicula",
    },

    filas: 10,

    columns: [
      { field: "idUsuarioPelicula", visible: false, download: false },
      { field: "idPelicula", visible: false, download: false },
      { field: "idApi", visible: false, download: false },
      { field: "pendientePelicula", visible: false, download: false },
      { field: "posterPelicula", visible: false, download: false },
      { field: "ratingAvgPelicula", visible: false, download: false },
      { field: "notasPelicula", visible: false, download: false },
      { field: "favPelicula", visible: false, download: false },
      {
        field: "nombrePelicula",
        title: "Película",
        widthGrow: 5,
        variableHeight: true,
        cssClass: "expandirCelda nombreTabla",
        headerTooltip: "Nombre de la película",
        formatter: (cell) => celdaNombre(cell),
      },
      {
        field: "directorPelicula",
        title: "Director",
        widthGrow: 3,
        cssClass: "expandirCelda",
        headerTooltip: "Director de la película",
      },
      {
        field: "anoPelicula",
        title: "Año",
        width: 70,
        headerTooltip: "Año de salida de la película",
      },
      {
        field: "fechaPelicula",
        title: "Visualización",
        width: 120,
        headerTooltip: "Fecha de visualización",
        formatter: (cell) => cambiarFecha(cell.getValue()),
      },
      {
        field: "ratingPelicula",
        title: "Valoración",
        width: 110,
        headerTooltip: "Valoración personal de la película",
        formatter: (cell) => transformarRatingTabla(cell.getValue()),
      },
      {
        field: "iconos",
        title: "",
        width: 60,
        download: false,
        formatter: (cell) => celdaIconos(cell),
      },
    ],
  }, // Fin pelicula

  serie: {
    nombreContenido: "Serie",
    nombrePluralContenido: "Series",
    genero: "a",

    controlador: "controladores/controladorSerie.php",

    idUsuarioContenido: "idUsuarioSerie",
    idContenido: "idSerie",
    nombre: "nombreSerie",
    ano: "anoSerie",
    poster: "posterSerie",
    rating: "ratingSerie",
    fav: "favSerie",
    pendiente: "pendienteSerie",
    fecha: "fechaSerie",
    estado: "estadoSerie",
    notas: "notasSerie",

    noPoster: "https:\/\/image.tmdb.org\/t\/p\/w500",

    accionFecha: "visualización",
    pluralFecha: "",

    tabla: "tablaSerie",
    color: "colorSerie",
    colorBoton: "colorSerieBoton",

    icono: "bi-tv",

    camposBD: {
      idApi: "idApi",
      nombreSerie: "nombreSerie",
      creadorSerie: "creadorSerie",
      directorSerie: "directorSerie",
      actorSerie: "actorSerie",
      guionistaSerie: "guionistaSerie",
      companiaSerie: "companiaSerie",
      generoSerie: "generoSerie",
      anoSerie: "anoSerie",
      temporadasSerie: "temporadasSerie",
      episodiosSerie: "episodiosSerie",
      ratingAvgSerie: "ratingAvgSerie",
      paisSerie: "paisSerie",
      idiomaSerie: "idiomaSerie",
      posterSerie: "posterSerie",
      sinopsisSerie: "sinopsisSerie",
    },

    campos: {
      idApi: "idApi",
      nombre: "nombreSerie",
      creador: "creadorSerie",
      director: "directorSerie",
      actor: "actorSerie",
      guionista: "guionistaSerie",
      compania: "companiaSerie",
      genero: "generoSerie",
      ano: "anoSerie",
      temporadas: "temporadasSerie",
      episodios: "episodiosSerie",
      ratingAvg: "ratingAvgSerie",
      pais: "paisSerie",
      idioma: "idiomaSerie",
      poster: "posterSerie",
      sinopsis: "sinopsisSerie",
    },

    formAgregar: [
      {
        type: "select",
        nombre: "estadoSerie",
        label: "Estado",
        id: "estadoFormAgregar",
        ancho: 6,
      },
      {
        type: "date",
        nombre: "fechaSerie",
        label: "Fecha de visualización",
        id: "fechaFormAgregar",
        ancho: 6,
      },
    ],

    formAgregarSerie: [
      {
        type: "select",
        nombre: "estadoSerie",
        label: "Estado",
        id: "estadoFormAgregar",
        ancho: 6,
      },
      {
        type: "date",
        nombre: "fechaSerie",
        label: "Fecha de visualización",
        id: "fechaFormAgregar",
        ancho: 6,
      },
    ],

    formAgregarTemporada: [
      {
        type: "date",
        nombre: "fechaTemporada",
        label: "Fecha de visualización",
        id: "fechaFormAgregar",
        ancho: 12,
      },
    ],

    formAgregarEpisodio: [
      {
        type: "date",
        nombre: "fechaEpisodio",
        label: "Fecha de visualización",
        id: "fechaFormAgregar",
        ancho: 12,
      },
    ],

    formFecha: [
      {
        type: "date",
        nombre: "fechaSerie",
        label: "",
        id: "fechaFormEditar",
        ancho: 12,
      },
    ],

    editarEstado: true,

    detalles: [
      {
        campo: "creadorSerie",
        titulo: "Creador",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "directorSerie",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorSerie",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaSerie",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "generoSerie",
        titulo: "Géneros",
        icono: "bi-tags",
        zona: "poster",
      },
      {
        campo: "companiaSerie",
        titulo: "Productoras",
        icono: "bi-building",
        zona: "poster",
      },
      {
        campo: "anoSerie",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "temporadasSerie",
        titulo: "Temporadas",
        zona: "datos",
      },
      {
        campo: "episodiosSerie",
        titulo: "Episodios",
        zona: "datos",
      },
      {
        campo: "ratingAvgSerie",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "paisSerie",
        titulo: "País",
        icono: "bi-globe",
        zona: "abajo",
      },
      {
        campo: "idiomaSerie",
        titulo: "Idiomas",
        icono: "bi-translate",
        zona: "abajo",
      },
      {
        campo: "sinopsisSerie",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    detallesInfo: [
      {
        campo: "creadorSerie",
        titulo: "Creador",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "directorSerie",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorSerie",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaSerie",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "generoSerie",
        titulo: "Géneros",
        icono: "bi-tags",
        zona: "poster",
      },
      {
        campo: "companiaSerie",
        titulo: "Productoras",
        icono: "bi-building",
        zona: "poster",
      },
      {
        campo: "anoSerie",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "temporadasSerie",
        titulo: "Temporadas",
        zona: "datos",
      },
      {
        campo: "episodiosSerie",
        titulo: "Episodios",
        zona: "datos",
      },
      {
        campo: "ratingAvgSerie",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "paisSerie",
        titulo: "País",
        icono: "bi-globe",
        zona: "poster",
      },
      {
        campo: "idiomaSerie",
        titulo: "Idiomas",
        icono: "bi-translate",
        zona: "poster",
      },
      {
        campo: "sinopsisSerie",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    detallesSerie: [
      {
        campo: "creadorSerie",
        titulo: "Creador",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "directorSerie",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorSerie",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaSerie",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "generoSerie",
        titulo: "Géneros",
        icono: "bi-tags",
        zona: "poster",
      },
      {
        campo: "companiaSerie",
        titulo: "Productoras",
        icono: "bi-building",
        zona: "poster",
      },
      {
        campo: "anoSerie",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "temporadasSerie",
        titulo: "Temporadas",
        zona: "datos",
      },
      {
        campo: "episodiosSerie",
        titulo: "Episodios",
        zona: "datos",
      },
      {
        campo: "ratingAvgSerie",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "paisSerie",
        titulo: "País",
        icono: "bi-globe",
        zona: "abajo",
      },
      {
        campo: "idiomaSerie",
        titulo: "Idiomas",
        icono: "bi-translate",
        zona: "abajo",
      },
      {
        campo: "sinopsisSerie",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    detallesTemporada: [
      {
        campo: "directorTemporada",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorTemporada",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaTemporada",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "anoTemporada",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "numeroTemporada",
        titulo: "Temporada",
        zona: "datos",
      },
      {
        campo: "episodiosTemporada",
        titulo: "Episodios",
        zona: "datos",
      },
      {
        campo: "ratingAvgTemporada",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "sinopsisTemporada",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    detallesEpisodio: [
      {
        campo: "directorEpisodio",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorEpisodio",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaEpisodio",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "anoEpisodio",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "numeroEpisodio",
        titulo: "Episodio",
        zona: "datos",
      },
      {
        campo: "duracionEpisodio",
        titulo: "Duracion",
        zona: "datos",
      },
      {
        campo: "ratingAvgEpisodio",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "sinopsisEpisodio",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    historial: {
      agregar: "agregarSerie",
      listar: "listarSerie",
    },

    filas: 10,

    columns: [
      { field: "idUsuarioSerie", visible: false, download: false },
      { field: "idSerie", visible: false, download: false },
      { field: "idApi", visible: false, download: false },
      { field: "pendienteSerie", visible: false, download: false },
      { field: "posterSerie", visible: false, download: false },
      { field: "ratingAvgSerie", visible: false, download: false },
      { field: "notasSerie", visible: false, download: false },
      { field: "favSerie", visible: false, download: false },
      {
        field: "nombreSerie",
        title: "Serie",
        widthGrow: 5,
        variableHeight: true,
        cssClass: "expandirCelda nombreTabla",
        headerTooltip: "Nombre de la serie",
        formatter: (cell) => celdaNombre(cell),
      },
      {
        field: "creadorSerie",
        title: "Creador",
        widthGrow: 3,
        cssClass: "expandirCelda",
        headerTooltip: "Creador de la serie",
      },
      {
        field: "anoSerie",
        title: "Año",
        width: 70,
        headerTooltip: "Año de salida de la serie",
      },
      {
        field: "fechaSerie",
        title: "Visualización",
        width: 120,
        headerTooltip: "Fecha de visualización",
        formatter: (cell) => cambiarFecha(cell.getValue()),
      },
      {
        field: "estadoSerie",
        title: "Estado",
        width: 100,
        headerTooltip: "Estado personal de la serie",
      },
      {
        field: "ratingSerie",
        title: "Valoración",
        width: 110,
        headerTooltip: "Valoración personal de la serie",
        formatter: (cell) => transformarRatingTabla(cell.getValue()),
      },
      {
        field: "iconos",
        title: "",
        width: 60,
        download: false,
        formatter: (cell) => celdaIconos(cell),
      },
    ],
  }, // Fin serie

  temporada: {
    nombreContenido: "Temporada",
    nombrePluralContenido: "Temporadas",
    genero: "a",

    controlador: "controladores/controladorTemporada.php",

    idUsuarioContenido: "idUsuarioTemporada",
    idContenido: "idTemporada",
    nombre: "nombreTemporada",
    ano: "anoTemporada",
    poster: "posterTemporada",
    rating: "ratingTemporada",
    fav: "favTemporada",
    pendiente: "pendienteTemporada",
    fecha: "fechaTemporada",
    notas: "notasTemporada",

    noPoster: "https:\/\/image.tmdb.org\/t\/p\/w500",

    accionFecha: "visualización",
    pluralFecha: "",

    tabla: "tablaTemporada",
    color: "colorSerie",
    colorBoton: "colorSerieBoton",

    icono: "bi-collection-play",

    camposBD: {
      idApi: "idApi",
      idSerie: "idSerie",
      nombreTemporada: "nombreTemporada",
      numeroTemporada: "numeroTemporada",
      directorTemporada: "directorTemporada",
      actorSerie: "actorSerie",
      guionistaTemporada: "guionistaTemporada",
      anoTemporada: "anoTemporada",
      episodiosTemporada: "episodiosTemporada",
      ratingAvgTemporada: "ratingAvgTemporada",
      posterTemporada: "posterTemporada",
      sinopsisTemporada: "sinopsisTemporada",
    },

    campos: {
      idApi: "idApi",
      idSerie: "idSerie",
      nombre: "nombreTemporada",
      numero: "numeroTemporada",
      director: "directorTemporada",
      actor: "actorSerie",
      guionista: "guionistaTemporada",
      ano: "anoTemporada",
      episodios: "episodiosTemporada",
      ratingAvg: "ratingAvgTemporada",
      poster: "posterTemporada",
      sinopsis: "sinopsisTemporada",
    },

    formAgregar: [
      {
        type: "date",
        nombre: "fechaTemporada",
        label: "Fecha de visualización",
        id: "fechaFormAgregar",
        ancho: 12,
      },
    ],

    formAgregarSerie: [
      {
        type: "select",
        nombre: "estadoSerie",
        label: "Estado",
        id: "estadoFormAgregar",
        ancho: 6,
      },
      {
        type: "date",
        nombre: "fechaSerie",
        label: "Fecha de visualización",
        id: "fechaFormAgregar",
        ancho: 6,
      },
    ],

    formAgregarTemporada: [
      {
        type: "date",
        nombre: "fechaTemporada",
        label: "Fecha de visualización",
        id: "fechaFormAgregar",
        ancho: 12,
      },
    ],

    formAgregarEpisodio: [
      {
        type: "date",
        nombre: "fechaEpisodio",
        label: "Fecha de visualización",
        id: "fechaFormAgregar",
        ancho: 12,
      },
    ],

    formFecha: [
      {
        type: "date",
        nombre: "fechaTemporada",
        label: "",
        id: "fechaFormEditar",
        ancho: 12,
      },
    ],

    detalles: [
      {
        campo: "directorTemporada",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorTemporada",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaTemporada",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "anoTemporada",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "numeroTemporada",
        titulo: "Temporada",
        zona: "datos",
      },
      {
        campo: "episodiosTemporada",
        titulo: "Episodios",
        zona: "datos",
      },
      {
        campo: "ratingAvgTemporada",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "sinopsisTemporada",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    detallesInfo: [
      {
        campo: "directorTemporada",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorTemporada",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaTemporada",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "anoTemporada",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "numeroTemporada",
        titulo: "Temporada",
        zona: "datos",
      },
      {
        campo: "episodiosTemporada",
        titulo: "Episodios",
        zona: "datos",
      },
      {
        campo: "ratingAvgTemporada",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "sinopsisTemporada",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    detallesSerie: [
      {
        campo: "creadorSerie",
        titulo: "Creador",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "directorSerie",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorSerie",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaSerie",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "generoSerie",
        titulo: "Géneros",
        icono: "bi-tags",
        zona: "poster",
      },
      {
        campo: "companiaSerie",
        titulo: "Productoras",
        icono: "bi-building",
        zona: "poster",
      },
      {
        campo: "anoSerie",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "temporadasSerie",
        titulo: "Temporadas",
        zona: "datos",
      },
      {
        campo: "episodiosSerie",
        titulo: "Episodios",
        zona: "datos",
      },
      {
        campo: "ratingAvgSerie",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "paisSerie",
        titulo: "País",
        icono: "bi-globe",
        zona: "abajo",
      },
      {
        campo: "idiomaSerie",
        titulo: "Idiomas",
        icono: "bi-translate",
        zona: "abajo",
      },
      {
        campo: "sinopsisSerie",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    detallesTemporada: [
      {
        campo: "directorTemporada",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorTemporada",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaTemporada",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "anoTemporada",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "numeroTemporada",
        titulo: "Temporada",
        zona: "datos",
      },
      {
        campo: "episodiosTemporada",
        titulo: "Episodios",
        zona: "datos",
      },
      {
        campo: "ratingAvgTemporada",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "sinopsisTemporada",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    detallesEpisodio: [
      {
        campo: "directorEpisodio",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorEpisodio",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaEpisodio",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "anoEpisodio",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "numeroEpisodio",
        titulo: "Episodio",
        zona: "datos",
      },
      {
        campo: "duracionEpisodio",
        titulo: "Duracion",
        zona: "datos",
      },
      {
        campo: "ratingAvgEpisodio",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "sinopsisEpisodio",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    historial: {
      agregar: "agregarTemporada",
      listar: "listarSerie",
    },

    filas: 10,

    columns: [
      { field: "idUsuarioTemporada", visible: false, download: false },
      { field: "idTemporada", visible: false, download: false },
      { field: "idSerie", visible: false, download: false },
      { field: "idApi", visible: false, download: false },
      { field: "pendienteTemporada", visible: false, download: false },
      { field: "posterTemporada", visible: false, download: false },
      { field: "ratingAvgTemporada", visible: false, download: false },
      { field: "notasTemporada", visible: false, download: false },
      { field: "favTemporada", visible: false, download: false },
      {
        field: "nombreTemporada",
        title: "Temporada",
        widthGrow: 5,
        variableHeight: true,
        cssClass: "expandirCelda nombreTabla",
        headerTooltip: "Nombre de la temporada",
        formatter: (cell) => celdaNombre(cell),
      },
      {
        field: "directorTemporada",
        title: "Director",
        widthGrow: 3,
        cssClass: "expandirCelda",
        headerTooltip: "Director de la temporada",
      },
      {
        field: "anoTemporada",
        title: "Año",
        width: 70,
        headerTooltip: "Año de salida de la temporada",
      },
      {
        field: "fechaTemporada",
        title: "Visualización",
        width: 120,
        headerTooltip: "Fecha de visualización",
        formatter: (cell) => cambiarFecha(cell.getValue()),
      },
      {
        field: "ratingTemporada",
        title: "Valoración",
        width: 110,
        headerTooltip: "Valoración personal de la temporada",
        formatter: (cell) => transformarRatingTabla(cell.getValue()),
      },
      {
        field: "iconos",
        title: "",
        width: 60,
        download: false,
        formatter: (cell) => celdaIconos(cell),
      },
    ],
  }, // Fin temporada

  episodio: {
    nombreContenido: "Episodio",
    nombrePluralContenido: "Episodios",
    genero: "o",

    controlador: "controladores/controladorEpisodio.php",

    idUsuarioContenido: "idUsuarioEpisodio",
    idContenido: "idEpisodio",
    nombre: "nombreEpisodio",
    ano: "anoEpisodio",
    poster: "posterEpisodio",
    rating: "ratingEpisodio",
    fav: "favEpisodio",
    pendiente: "pendienteEpisodio",
    fecha: "fechaEpisodio",
    notas: "notasEpisodio",

    noPoster: "https:\/\/image.tmdb.org\/t\/p\/w500",

    accionFecha: "visualización",
    pluralFecha: "",

    tabla: "tablaEpisodio",
    color: "colorSerie",
    colorBoton: "colorSerieBoton",

    icono: "bi-play-btn",

    camposBD: {
      idApi: "idApi",
      idTemporada: "idTemporada",
      nombreEpisodio: "nombreEpisodio",
      numeroEpisodio: "numeroEpisodio",
      directorEpisodio: "directorEpisodio",
      actorEpisodio: "actorEpisodio",
      guionistaEpisodio: "guionistaEpisodio",
      anoEpisodio: "anoEpisodio",
      duracionEpisodio: "duracionEpisodio",
      ratingAvgEpisodio: "ratingAvgEpisodio",
      posterEpisodio: "posterEpisodio",
      sinopsisEpisodio: "sinopsisEpisodio",
    },

    campos: {
      idApi: "idApi",
      idTemporada: "idTemporada",
      nombre: "nombreEpisodio",
      numero: "numeroEpisodio",
      director: "directorEpisodio",
      actor: "actorEpisodio",
      guionista: "guionistaEpisodio",
      ano: "anoEpisodio",
      duracion: "duracionEpisodio",
      ratingAvg: "ratingAvgEpisodio",
      poster: "posterEpisodio",
      sinopsis: "sinopsisEpisodio",
    },

    formAgregar: [
      {
        type: "date",
        nombre: "fechaEpisodio",
        label: "Fecha de visualización",
        id: "fechaFormAgregar",
        ancho: 12,
      },
    ],

    formAgregarSerie: [
      {
        type: "select",
        nombre: "estadoSerie",
        label: "Estado",
        id: "estadoFormAgregar",
        ancho: 6,
      },
      {
        type: "date",
        nombre: "fechaSerie",
        label: "Fecha de visualización",
        id: "fechaFormAgregar",
        ancho: 6,
      },
    ],

    formAgregarTemporada: [
      {
        type: "date",
        nombre: "fechaTemporada",
        label: "Fecha de visualización",
        id: "fechaFormAgregar",
        ancho: 12,
      },
    ],

    formAgregarEpisodio: [
      {
        type: "date",
        nombre: "fechaEpisodio",
        label: "Fecha de visualización",
        id: "fechaFormAgregar",
        ancho: 12,
      },
    ],

    formFecha: [
      {
        type: "date",
        nombre: "fechaEpisodio",
        label: "",
        id: "fechaFormEditar",
        ancho: 12,
      },
    ],

    detalles: [
      {
        campo: "directorEpisodio",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorEpisodio",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaEpisodio",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "anoEpisodio",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "numeroEpisodio",
        titulo: "Episodio",
        zona: "datos",
      },
      {
        campo: "duracionEpisodio",
        titulo: "Duracion",
        zona: "datos",
      },
      {
        campo: "ratingAvgEpisodio",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "sinopsisEpisodio",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    detallesInfo: [
      {
        campo: "directorEpisodio",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorEpisodio",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaEpisodio",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "anoEpisodio",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "numeroEpisodio",
        titulo: "Episodio",
        zona: "datos",
      },
      {
        campo: "duracionEpisodio",
        titulo: "Duracion",
        zona: "datos",
      },
      {
        campo: "ratingAvgEpisodio",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "sinopsisEpisodio",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    detallesSerie: [
      {
        campo: "creadorSerie",
        titulo: "Creador",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "directorSerie",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorSerie",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaSerie",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "generoSerie",
        titulo: "Géneros",
        icono: "bi-tags",
        zona: "poster",
      },
      {
        campo: "companiaSerie",
        titulo: "Productoras",
        icono: "bi-building",
        zona: "poster",
      },
      {
        campo: "anoSerie",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "temporadasSerie",
        titulo: "Temporadas",
        zona: "datos",
      },
      {
        campo: "episodiosSerie",
        titulo: "Episodios",
        zona: "datos",
      },
      {
        campo: "ratingAvgSerie",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "paisSerie",
        titulo: "País",
        icono: "bi-globe",
        zona: "abajo",
      },
      {
        campo: "idiomaSerie",
        titulo: "Idiomas",
        icono: "bi-translate",
        zona: "abajo",
      },
      {
        campo: "sinopsisSerie",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    detallesTemporada: [
      {
        campo: "directorTemporada",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorTemporada",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaTemporada",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "anoTemporada",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "numeroTemporada",
        titulo: "Temporada",
        zona: "datos",
      },
      {
        campo: "episodiosTemporada",
        titulo: "Episodios",
        zona: "datos",
      },
      {
        campo: "ratingAvgTemporada",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "sinopsisTemporada",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    detallesEpisodio: [
      {
        campo: "directorEpisodio",
        titulo: "Director",
        icono: "bi-camera-reels",
        zona: "poster",
      },
      {
        campo: "actorEpisodio",
        titulo: "Reparto",
        icono: "bi-people",
        zona: "poster",
      },
      {
        campo: "guionistaEpisodio",
        titulo: "Guion",
        icono: "bi-pencil",
        zona: "poster",
      },
      {
        campo: "anoEpisodio",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "numeroEpisodio",
        titulo: "Episodio",
        zona: "datos",
      },
      {
        campo: "duracionEpisodio",
        titulo: "Duracion",
        zona: "datos",
      },
      {
        campo: "ratingAvgEpisodio",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "sinopsisEpisodio",
        titulo: "Sinopsis",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    historial: {
      agregar: "agregarEpisodio",
      listar: "listarSerie",
    },

    filas: 10,

    columns: [
      { field: "idUsuarioEpisodio", visible: false, download: false },
      { field: "idEpisodio", visible: false, download: false },
      { field: "idTemporada", visible: false, download: false },
      { field: "idApi", visible: false, download: false },
      { field: "pendienteEpisodio", visible: false, download: false },
      { field: "posterEpisodio", visible: false, download: false },
      { field: "ratingAvgEpisodio", visible: false, download: false },
      { field: "notasEpisodio", visible: false, download: false },
      { field: "favEpisodio", visible: false, download: false },
      {
        field: "nombreEpisodio",
        title: "Episodio",
        widthGrow: 5,
        variableHeight: true,
        cssClass: "expandirCelda nombreTabla",
        headerTooltip: "Nombre del episodio",
        formatter: (cell) => celdaNombre(cell),
      },
      {
        field: "directorEpisodio",
        title: "Director",
        widthGrow: 3,
        cssClass: "expandirCelda",
        headerTooltip: "Director del episodio",
      },
      {
        field: "anoEpisodio",
        title: "Año",
        width: 70,
        headerTooltip: "Año de salida del episodio",
      },
      {
        field: "fechaEpisodio",
        title: "Visualización",
        width: 120,
        headerTooltip: "Fecha de visualización",
        formatter: (cell) => cambiarFecha(cell.getValue()),
      },
      {
        field: "ratingEpisodio",
        title: "Valoración",
        width: 110,
        headerTooltip: "Valoración personal del episodio",
        formatter: (cell) => transformarRatingTabla(cell.getValue()),
      },
      {
        field: "iconos",
        title: "",
        width: 60,
        download: false,
        formatter: (cell) => celdaIconos(cell),
      },
    ],
  }, // Fin episodio

  juego: {
    nombreContenido: "Videojuego",
    nombrePluralContenido: "Videojuegos",
    genero: "o",

    controlador: "controladores/controladorJuego.php",

    idUsuarioContenido: "idUsuarioJuego",
    idContenido: "idJuego",
    nombre: "nombreJuego",
    ano: "anoJuego",
    poster: "posterJuego",
    rating: "ratingJuego",
    fav: "favJuego",
    pendiente: "pendienteJuego",
    fecha: "fechaJuego",
    fechaInicio: "fechaInicioJuego",
    notas: "notasJuego",
    plataforma: "plataformaJuego",

    noPoster: "",

    accionFecha: "juego",
    pluralFecha: "s",

    tabla: "tablaJuego",
    color: "colorJuego",
    colorBoton: "colorJuegoBoton",

    icono: "bi-controller",

    camposBD: {
      idApi: "idApi",
      nombreJuego: "nombreJuego",
      desarrolladorJuego: "desarrolladorJuego",
      editorJuego: "editorJuego",
      anoJuego: "anoJuego",
      franquiciaJuego: "franquiciaJuego",
      generoJuego: "generoJuego",
      plataformasJuego: "plataformasJuego",
      dlcJuego: "dlcJuego",
      expansionJuego: "expansionJuego",
      duracionJuego: "duracionJuego",
      ratingAvgJuego: "ratingAvgJuego",
      posterJuego: "posterJuego",
      sinopsisJuego: "sinopsisJuego",
    },

    campos: {
      idApi: "idApi",
      nombre: "nombreJuego",
      desarrollador: "desarrolladorJuego",
      editor: "editorJuego",
      ano: "anoJuego",
      franquicia: "franquiciaJuego",
      genero: "generoJuego",
      plataformas: "plataformasJuego",
      dlc: "dlcJuego",
      expansion: "expansionJuego",
      duracion: "duracionJuego",
      ratingAvg: "ratingAvgJuego",
      poster: "posterJuego",
      sinopsis: "sinopsisJuego",
    },

    formAgregar: [
      {
        type: "select",
        nombre: "plataformaJuego",
        label: "Plataforma",
        id: "plataformaFormAgregar",
        ancho: 12,
      },
      {
        type: "date",
        nombre: "fechaInicioJuego",
        label: "Fecha de comienzo",
        id: "fechaInicioFormAgregar",
        ancho: 6,
      },
      {
        type: "date",
        nombre: "fechaJuego",
        label: "Fecha de finalización",
        id: "fechaFormAgregar",
        ancho: 6,
      },
    ],

    formFecha: [
      {
        type: "date",
        nombre: "fechaInicioJuego",
        label: "Fecha de inicio",
        id: "fechaInicioFormEditar",
        ancho: 6,
      },
      {
        type: "date",
        nombre: "fechaJuego",
        label: "Fecha de finalización",
        id: "fechaFormEditar",
        ancho: 6,
      },
    ],

    editarPlataforma: true,

    detalles: [
      {
        campo: "desarrolladorJuego",
        titulo: "Desarrollador",
        icono: "bi-code-square",
        zona: "poster",
      },
      {
        campo: "editorJuego",
        titulo: "Editor",
        icono: "bi-building",
        zona: "poster",
      },
      {
        campo: "franquiciaJuego",
        titulo: "Franquicia",
        icono: "bi-collection",
        zona: "poster",
      },
      {
        campo: "generoJuego",
        titulo: "Géneros",
        icono: "bi-tags",
        zona: "poster",
      },
      {
        campo: "plataformasJuego",
        titulo: "Plataformas",
        icono: "bi-controller",
        zona: "poster",
      },
      {
        campo: "dlcJuego",
        titulo: "DLCs",
        icono: "bi-box-seam",
        zona: "abajo",
      },
      {
        campo: "expansionJuego",
        titulo: "Expansiones",
        icono: "bi-puzzle",
        zona: "abajo",
      },
      {
        campo: "anoJuego",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "duracionJuego",
        titulo: "Duración estimada",
        zona: "datos",
      },
      {
        campo: "ratingAvgJuego",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "sinopsisJuego",
        titulo: "Descripción",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    detallesInfo: [
      {
        campo: "desarrolladorJuego",
        titulo: "Desarrollador",
        icono: "bi-code-square",
        zona: "poster",
      },
      {
        campo: "editorJuego",
        titulo: "Editor",
        icono: "bi-building",
        zona: "poster",
      },
      {
        campo: "franquiciaJuego",
        titulo: "Franquicia",
        icono: "bi-collection",
        zona: "poster",
      },
      {
        campo: "generoJuego",
        titulo: "Géneros",
        icono: "bi-tags",
        zona: "poster",
      },
      {
        campo: "plataformasJuego",
        titulo: "Plataformas",
        icono: "bi-controller",
        zona: "poster",
      },
      {
        campo: "expansionJuego",
        titulo: "Expansiones",
        icono: "bi-puzzle",
        zona: "poster",
      },
      {
        campo: "dlcJuego",
        titulo: "DLCs",
        icono: "bi-box-seam",
        zona: "poster",
      },
      {
        campo: "anoJuego",
        titulo: "Año",
        zona: "datos",
      },
      {
        campo: "duracionJuego",
        titulo: "Duración estimada",
        zona: "datos",
      },
      {
        campo: "ratingAvgJuego",
        titulo: "Valoración",
        zona: "datos",
      },
      {
        campo: "sinopsisJuego",
        titulo: "Descripción",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    historial: {
      agregar: "agregarJuego",
      listar: "listarJuego",
    },

    filas: 9,

    columns: [
      { field: "idUsuarioJuego", visible: false, download: false },
      { field: "idJuego", visible: false, download: false },
      { field: "idApi", visible: false, download: false },
      { field: "pendienteJuego", visible: false, download: false },
      { field: "posterJuego", visible: false, download: false },
      { field: "notasJuego", visible: false, download: false },
      { field: "favJuego", visible: false, download: false },
      {
        field: "nombreJuego",
        title: "Videojuego",
        widthGrow: 5,
        variableHeight: true,
        cssClass: "expandirCelda nombreTabla",
        headerTooltip: "Nombre del videojuego",
        formatter: (cell) => celdaNombre(cell),
      },
      {
        field: "desarrolladorJuego",
        title: "Desarrollador",
        widthGrow: 3,
        variableHeight: true,
        vertAlign: "middle",
        cssClass: "expandirCelda",
        headerTooltip: "Desarrollador del videojuego",
      },
      {
        field: "anoJuego",
        title: "Año",
        width: 60,
        vertAlign: "middle",
        headerTooltip: "Año de salida del videojuego",
      },
      {
        field: "fechaInicioJuego",
        title: "Inicio",
        width: 100,
        vertAlign: "middle",
        headerTooltip: "Fecha de inicio",
        formatter: (cell) => cambiarFecha(cell.getValue()),
      },
      {
        field: "fechaJuego",
        title: "Finalización",
        width: 110,
        vertAlign: "middle",
        headerTooltip: "Fecha de finalización",
        formatter: (cell) => cambiarFecha(cell.getValue()),
      },
      {
        field: "plataformaJuego",
        title: "Plataforma",
        width: 110,
        variableHeight: true,
        vertAlign: "middle",
        cssClass: "expandirCelda",
        headerTooltip: "Plataforma del videojuego",
      },
      {
        field: "ratingJuego",
        title: "Valoración",
        width: 100,
        vertAlign: "middle",
        headerTooltip: "Valoración personal del videojuego",
        formatter: (cell) => transformarRatingTabla(cell.getValue()),
      },
      {
        field: "iconos",
        title: "",
        width: 50,
        vertAlign: "middle",
        download: false,
        formatter: (cell) => celdaIconos(cell),
      },
    ],
  }, // Fin juego

  libro: {
    nombreContenido: "Libro",
    nombrePluralContenido: "Libros",
    genero: "o",

    controlador: "controladores/controladorLibro.php",

    idUsuarioContenido: "idUsuarioLibro",
    idContenido: "idLibro",
    nombre: "nombreLibro",
    ano: "anoLibro",
    poster: "posterLibro",
    rating: "ratingLibro",
    fav: "favLibro",
    pendiente: "pendienteLibro",
    fecha: "fechaLibro",
    fechaInicio: "fechaInicioLibro",
    notas: "notasLibro",

    noPoster: "",

    accionFecha: "lectura",
    pluralFecha: "s",

    tabla: "tablaLibro",
    color: "colorLibro",
    colorBoton: "colorLibroBoton",

    icono: "bi-book",

    camposBD: {
      idApi: "idApi",
      nombreLibro: "nombreLibro",
      autorLibro: "autorLibro",
      anoLibro: "anoLibro",
      generoLibro: "generoLibro",
      temaLibro: "temaLibro",
      paginasLibro: "paginasLibro",
      edicionesLibro: "edicionesLibro",
      idiomaLibro: "idiomaLibro",
      ratingAvgLibro: "ratingAvgLibro",
      posterLibro: "posterLibro",
      sinopsisLibro: "sinopsisLibro",
    },

    campos: {
      idApi: "idApi",
      nombre: "nombreLibro",
      autor: "autorLibro",
      ano: "anoLibro",
      genero: "generoLibro",
      tema: "temaLibro",
      paginas: "paginasLibro",
      ediciones: "edicionesLibro",
      idioma: "idiomaLibro",
      ratingAvg: "ratingAvgLibro",
      poster: "posterLibro",
      sinopsis: "sinopsisLibro",
    },

    formAgregar: [
      {
        type: "date",
        nombre: "fechaInicioLibro",
        label: "Fecha de comienzo",
        id: "fechaInicioFormAgregar",
        ancho: 6,
      },
      {
        type: "date",
        nombre: "fechaLibro",
        label: "Fecha de finalización",
        id: "fechaFormAgregar",
        ancho: 6,
      },
    ],

    formFecha: [
      {
        type: "date",
        nombre: "fechaInicioLibro",
        label: "Fecha de inicio",
        id: "fechaInicioFormEditar",
        ancho: 6,
      },
      {
        type: "date",
        nombre: "fechaLibro",
        label: "Fecha de finalización",
        id: "fechaFormEditar",
        ancho: 6,
      },
    ],

    detalles: [
      {
        campo: "autorLibro",
        titulo: "Autor",
        icono: "bi-person",
        zona: "poster",
      },

      {
        campo: "generoLibro",
        titulo: "Géneros",
        icono: "bi-bookmark-star",
        zona: "poster",
      },

      {
        campo: "temaLibro",
        titulo: "Temas",
        icono: "bi-tags",
        zona: "poster",
      },

      {
        campo: "anoLibro",
        titulo: "Año",
        zona: "datos",
      },

      {
        campo: "paginasLibro",
        titulo: "Páginas",
        zona: "datos",
      },

      {
        campo: "ratingAvgLibro",
        titulo: "Valoración",
        zona: "datos",
      },

      {
        campo: "idiomaLibro",
        titulo: "Idiomas",
        icono: "bi-translate",
        zona: "abajo",
      },

      {
        campo: "edicionesLibro",
        titulo: "Ediciones",
        icono: "bi-layers",
        zona: "abajo",
      },

      {
        campo: "sinopsisLibro",
        titulo: "Descripción",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    detallesInfo: [
      {
        campo: "autorLibro",
        titulo: "Autor",
        icono: "bi-person",
        zona: "poster",
      },

      {
        campo: "generoLibro",
        titulo: "Géneros",
        icono: "bi-bookmark-star",
        zona: "poster",
      },

      {
        campo: "temaLibro",
        titulo: "Temas",
        icono: "bi-tags",
        zona: "poster",
      },

      {
        campo: "anoLibro",
        titulo: "Año",
        zona: "datos",
      },

      {
        campo: "paginasLibro",
        titulo: "Páginas",
        zona: "datos",
      },

      {
        campo: "ratingAvgLibro",
        titulo: "Valoración",
        zona: "datos",
      },

      {
        campo: "idiomaLibro",
        titulo: "Idiomas",
        icono: "bi-translate",
        zona: "poster",
      },

      {
        campo: "edicionesLibro",
        titulo: "Ediciones",
        icono: "bi-layers",
        zona: "poster",
      },

      {
        campo: "sinopsisLibro",
        titulo: "Descripción",
        icono: "bi-text-paragraph",
        zona: "sinopsis",
      },
    ],

    historial: {
      agregar: "agregarLibro",
      listar: "listarLibro",
    },

    filas: 10,

    columns: [
      { field: "idUsuarioLibro", visible: false, download: false },
      { field: "idLibro", visible: false, download: false },
      { field: "idApi", visible: false, download: false },
      { field: "pendienteLibro", visible: false, download: false },
      { field: "posterLibro", visible: false, download: false },
      { field: "notasLibro", visible: false, download: false },
      { field: "favLibro", visible: false, download: false },
      {
        field: "nombreLibro",
        title: "Libro",
        widthGrow: 5,
        variableHeight: true,
        cssClass: "expandirCelda nombreTabla",
        headerTooltip: "Nombre del libro",
        formatter: (cell) => celdaNombre(cell),
      },
      {
        field: "autorLibro",
        title: "Autor",
        widthGrow: 3,
        variableHeight: true,
        vertAlign: "middle",
        cssClass: "expandirCelda",
        headerTooltip: "Desarrollador del libro",
      },
      {
        field: "anoLibro",
        title: "Año",
        width: 60,
        vertAlign: "middle",
        headerTooltip: "Año de salida del libro",
      },
      {
        field: "fechaInicioLibro",
        title: "Inicio",
        width: 100,
        vertAlign: "middle",
        headerTooltip: "Fecha de inicio",
        formatter: (cell) => cambiarFecha(cell.getValue()),
      },
      {
        field: "fechaLibro",
        title: "Finalización",
        width: 110,
        vertAlign: "middle",
        headerTooltip: "Fecha de finalización",
        formatter: (cell) => cambiarFecha(cell.getValue()),
      },
      {
        field: "ratingLibro",
        title: "Valoración",
        width: 100,
        vertAlign: "middle",
        headerTooltip: "Valoración personal del libro",
        formatter: (cell) => transformarRatingTabla(cell.getValue()),
      },
      {
        field: "iconos",
        title: "",
        width: 50,
        vertAlign: "middle",
        download: false,
        formatter: (cell) => celdaIconos(cell),
      },
    ],
  }, // Fin libro
};
