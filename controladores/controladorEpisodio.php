<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/includes/limpiaFormulario.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseSerie.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseTemporada.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseEpisodio.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseUsuarioxEpisodio.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseApiSerie.php';

//$_POST = limpiaFormulario($_POST);

switch($_POST['orden']){

    case "agregar":

        // Primero metemos la serie completa en series, y exista o no devolverá su idSerie.
        $serie = new Serie();
        $serie->idApi = $_POST['idApiSerie'];
        $serie->nombreSerie = empty($_POST['nombreSerie']) ? null : $_POST['nombreSerie'];
        $serie->creadorSerie = empty($_POST['creadorSerie']) ? null : $_POST['creadorSerie'];
        $serie->directorSerie = empty($_POST['directorSerie']) ? null : $_POST['directorSerie'];
        $serie->actorSerie = empty($_POST['actorSerie']) ? null : $_POST['actorSerie'];
        $serie->guionistaSerie = empty($_POST['guionistaSerie']) ? null : $_POST['guionistaSerie'];
        $serie->companiaSerie = empty($_POST['companiaSerie']) ? null : $_POST['companiaSerie'];
        $serie->generoSerie = empty($_POST['generoSerie']) ? null : $_POST['generoSerie'];
        $serie->anoSerie = empty($_POST['anoSerie']) ? null : $_POST['anoSerie'];
        $serie->temporadasSerie = empty($_POST['temporadasSerie']) ? null : $_POST['temporadasSerie'];
        $serie->episodiosSerie = empty($_POST['episodiosSerie']) ? null : $_POST['episodiosSerie'];
        $serie->ratingAvgSerie = empty($_POST['ratingAvgSerie']) ? null : $_POST['ratingAvgSerie'];
        $serie->paisSerie = empty($_POST['paisSerie']) ? null : $_POST['paisSerie'];
        $serie->idiomaSerie = empty($_POST['idiomaSerie']) ? null : $_POST['idiomaSerie'];
        $serie->posterSerie = empty($_POST['posterSerie']) ? null : $_POST['posterSerie'];
        $serie->sinopsisSerie = empty($_POST['sinopsisSerie']) ? null : $_POST['sinopsisSerie'];

        $idSerie = $serie->agregar();

        if (isset($idSerie['error'])) {
            echo json_encode($idSerie);
            break;
        }

        // Segundo metemos la temporada en seriestemporadas usando el $idSerie, y exista o no devolverá su idTemporada.
        $temporada = new Temporada();

        $temporada->idApi = $_POST['idApiTemporada'];
        $temporada->idSerie = $idSerie;
        $temporada->nombreTemporada = empty($_POST['nombreTemporada']) ? null : $_POST['nombreTemporada'];
        $temporada->numeroTemporada = empty($_POST['numeroTemporada']) ? null : $_POST['numeroTemporada'];
        $temporada->directorTemporada = empty($_POST['directorTemporada']) ? null : $_POST['directorTemporada'];
        $temporada->actorTemporada = empty($_POST['actorTemporada']) ? null : $_POST['actorTemporada'];
        $temporada->guionistaTemporada = empty($_POST['guionistaTemporada']) ? null : $_POST['guionistaTemporada'];
        $temporada->episodiosTemporada = empty($_POST['episodiosTemporada']) ? null : $_POST['episodiosTemporada'];
        $temporada->anoTemporada = empty($_POST['anoTemporada']) ? null : $_POST['anoTemporada'];
        $temporada->ratingAvgTemporada = empty($_POST['ratingAvgTemporada']) ? null : $_POST['ratingAvgTemporada'];
        $temporada->posterTemporada = empty($_POST['posterTemporada']) ? null : $_POST['posterTemporada'];
        $temporada->sinopsisTemporada = empty($_POST['sinopsisTemporada']) ? null : $_POST['sinopsisTemporada'];

        $idTemporada = $temporada->agregar();

        if (isset($idTemporada['error'])) {
            echo json_encode($idTemporada);
            break;
        }

        // Tercero metemos el episodio en seriesepisodios usando el $idTemporada, y exista o no devolverá su idEpisodio.
        $episodio = new Episodio();

        $episodio->idApi = $_POST['idApiEpisodio'];
        $episodio->idTemporada = $idTemporada;
        $episodio->nombreEpisodio = empty($_POST['nombreEpisodio']) ? null : $_POST['nombreEpisodio'];
        $episodio->numeroEpisodio = empty($_POST['numeroEpisodio']) ? null : $_POST['numeroEpisodio'];
        $episodio->directorEpisodio = empty($_POST['directorEpisodio']) ? null : $_POST['directorEpisodio'];
        $episodio->actorEpisodio = empty($_POST['actorEpisodio']) ? null : $_POST['actorEpisodio'];
        $episodio->guionistaEpisodio = empty($_POST['guionistaEpisodio']) ? null : $_POST['guionistaEpisodio'];
        $episodio->anoEpisodio = empty($_POST['anoEpisodio']) ? null : $_POST['anoEpisodio'];
        $episodio->duracionEpisodio = empty($_POST['duracionEpisodio']) ? null : $_POST['duracionEpisodio'];
        $episodio->ratingAvgEpisodio = empty($_POST['ratingAvgEpisodio']) ? null : $_POST['ratingAvgEpisodio'];
        $episodio->posterEpisodio = empty($_POST['posterEpisodio']) ? null : $_POST['posterEpisodio'];
        $episodio->sinopsisEpisodio = empty($_POST['sinopsisEpisodio']) ? null : $_POST['sinopsisEpisodio'];

        $idEpisodio = $episodio->agregar();

        if (isset($idEpisodio['error'])) {
            echo json_encode($idEpisodio);
            break;
        }

        // Usamos ese idEpisodio para agregarla a usuariosxepisodios
        $usuarioxEpisodio = new UsuarioxEpisodio();
        $usuarioxEpisodio->idUsuario = $_SESSION['idUsuario'];
        $usuarioxEpisodio->idEpisodio = $idEpisodio;

        // Comprobamos si ya está registrada, si no se agrega
        $resultado = $usuarioxEpisodio->existe();
        
        if(!$resultado){
            $usuarioxEpisodio->fechaEpisodio = empty($_POST['fechaEpisodio']) ? null : $_POST['fechaEpisodio'];
            $usuarioxEpisodio->ratingEpisodio = empty($_POST['ratingEpisodio']) ? null : $_POST['ratingEpisodio'];
            $usuarioxEpisodio->notasEpisodio = empty($_POST['notasEpisodio']) ? null : $_POST['notasEpisodio'];
            $usuarioxEpisodio->favEpisodio = $_POST['favEpisodio'];
            $resultado = $usuarioxEpisodio->agregar();

            echo json_encode([
                'idEpisodio' => $idEpisodio,
                'idUsuarioEpisodio' => $resultado
            ]);
        }else{
            echo json_encode($resultado);
        }

    break;

    case "buscarApi":
        $api = new ApiSerie();
        $resultado = $api->buscar($_POST['nombreEpisodio']);

        $series = [];
        foreach($resultado as $item){
            $series[] = $api->transformarDatos($item);
        }

        echo json_encode($series);
    break;

    case "detallesApi":

        $api = new ApiSerie();
        $resultado = $api->detalles($_POST["idApi"]);

        if(isset($resultado['error'])){
            echo json_encode($resultado);
            break;
        }

        $resultado = $api->transformarDatos($resultado);

        echo json_encode($resultado);

    break;

    case 'detallesApiTemporada':
        $api = new ApiSerie();
        $resultado = $api->temporada($_POST['idApiSerie'],$_POST['numeroTemporada']);

        if(isset($resultado['error'])){
            echo json_encode($resultado);
            break;
        }

        $resultado = $api->transformarDatosTemporada($resultado, $_POST['nombreSerie']);
        echo json_encode($resultado);

    break;

    case 'detallesApiEpisodio':
        $api = new ApiSerie();
        $resultado = $api->episodio($_POST['idApiSerie'], $_POST['numeroTemporada'], $_POST['numeroEpisodio']);

        if(isset($resultado['error'])){
            echo json_encode($resultado);
            break;
        }

        $resultado = $api->transformarDatosEpisodio($resultado, $_POST['numeroTemporada'], $_POST['nombreSerie']);
        echo json_encode($resultado);

    break;

    case 'listarTodo':
        $usuarioxEpisodio = new UsuarioxEpisodio();
        $usuarioxEpisodio->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxEpisodio->listarTodo();
        echo json_encode($lista);
    break;

    case 'listarEstrellas':
        $usuarioxEpisodio = new UsuarioxEpisodio();
        $usuarioxEpisodio->idUsuario = $_SESSION['idUsuario'];
        $usuarioxEpisodio->ratingEpisodio = $_POST['i'];
        $lista = $usuarioxEpisodio->listarEstrellas();
        echo json_encode($lista);
    break;

    case 'listarFav':
        $usuarioxEpisodio = new UsuarioxEpisodio();
        $usuarioxEpisodio->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxEpisodio->listarFav();
        echo json_encode($lista);
    break;

    case 'listarPendientes':
        $usuarioxEpisodio = new UsuarioxEpisodio();
        $usuarioxEpisodio->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxEpisodio->listarPendientes();
        echo json_encode($lista);
    break;

    case 'agregarPend':

        // Primero metemos la serie completa en series, y exista o no devolverá su idSerie.
        $serie = new Serie();
        $serie->idApi = $_POST['idApiSerie'];
        $serie->nombreSerie = empty($_POST['nombreSerie']) ? null : $_POST['nombreSerie'];
        $serie->creadorSerie = empty($_POST['creadorSerie']) ? null : $_POST['creadorSerie'];
        $serie->directorSerie = empty($_POST['directorSerie']) ? null : $_POST['directorSerie'];
        $serie->actorSerie = empty($_POST['actorSerie']) ? null : $_POST['actorSerie'];
        $serie->guionistaSerie = empty($_POST['guionistaSerie']) ? null : $_POST['guionistaSerie'];
        $serie->companiaSerie = empty($_POST['companiaSerie']) ? null : $_POST['companiaSerie'];
        $serie->generoSerie = empty($_POST['generoSerie']) ? null : $_POST['generoSerie'];
        $serie->anoSerie = empty($_POST['anoSerie']) ? null : $_POST['anoSerie'];
        $serie->temporadasSerie = empty($_POST['temporadasSerie']) ? null : $_POST['temporadasSerie'];
        $serie->episodiosSerie = empty($_POST['episodiosSerie']) ? null : $_POST['episodiosSerie'];
        $serie->ratingAvgSerie = empty($_POST['ratingAvgSerie']) ? null : $_POST['ratingAvgSerie'];
        $serie->paisSerie = empty($_POST['paisSerie']) ? null : $_POST['paisSerie'];
        $serie->idiomaSerie = empty($_POST['idiomaSerie']) ? null : $_POST['idiomaSerie'];
        $serie->posterSerie = empty($_POST['posterSerie']) ? null : $_POST['posterSerie'];
        $serie->sinopsisSerie = empty($_POST['sinopsisSerie']) ? null : $_POST['sinopsisSerie'];

        $idSerie = $serie->agregar();

        if (isset($idSerie['error'])) {
            echo json_encode($idSerie);
            break;
        }

        // Segundo metemos la temporada en seriestemporadas usando el $idSerie, y exista o no devolverá su idTemporada.
        $temporada = new Temporada();

        $temporada->idApi = $_POST['idApiTemporada'];
        $temporada->idSerie = $idSerie;
        $temporada->nombreTemporada = empty($_POST['nombreTemporada']) ? null : $_POST['nombreTemporada'];
        $temporada->numeroTemporada = empty($_POST['numeroTemporada']) ? null : $_POST['numeroTemporada'];
        $temporada->directorTemporada = empty($_POST['directorTemporada']) ? null : $_POST['directorTemporada'];
        $temporada->actorTemporada = empty($_POST['actorTemporada']) ? null : $_POST['actorTemporada'];
        $temporada->guionistaTemporada = empty($_POST['guionistaTemporada']) ? null : $_POST['guionistaTemporada'];
        $temporada->episodiosTemporada = empty($_POST['episodiosTemporada']) ? null : $_POST['episodiosTemporada'];
        $temporada->anoTemporada = empty($_POST['anoTemporada']) ? null : $_POST['anoTemporada'];
        $temporada->ratingAvgTemporada = empty($_POST['ratingAvgTemporada']) ? null : $_POST['ratingAvgTemporada'];
        $temporada->posterTemporada = empty($_POST['posterTemporada']) ? null : $_POST['posterTemporada'];
        $temporada->sinopsisTemporada = empty($_POST['sinopsisTemporada']) ? null : $_POST['sinopsisTemporada'];

        $idTemporada = $temporada->agregar();

        if (isset($idTemporada['error'])) {
            echo json_encode($idTemporada);
            break;
        }

        // Tercero metemos el episodio en seriesepisodios usando el $idTemporada, y exista o no devolverá su idEpisodio.
        $episodio = new Episodio();

        $episodio->idApi = $_POST['idApiEpisodio'];
        $episodio->idTemporada = $idTemporada;
        $episodio->nombreEpisodio = empty($_POST['nombreEpisodio']) ? null : $_POST['nombreEpisodio'];
        $episodio->numeroEpisodio = empty($_POST['numeroEpisodio']) ? null : $_POST['numeroEpisodio'];
        $episodio->directorEpisodio = empty($_POST['directorEpisodio']) ? null : $_POST['directorEpisodio'];
        $episodio->actorEpisodio = empty($_POST['actorEpisodio']) ? null : $_POST['actorEpisodio'];
        $episodio->guionistaEpisodio = empty($_POST['guionistaEpisodio']) ? null : $_POST['guionistaEpisodio'];
        $episodio->anoEpisodio = empty($_POST['anoEpisodio']) ? null : $_POST['anoEpisodio'];
        $episodio->duracionEpisodio = empty($_POST['duracionEpisodio']) ? null : $_POST['duracionEpisodio'];
        $episodio->ratingAvgEpisodio = empty($_POST['ratingAvgEpisodio']) ? null : $_POST['ratingAvgEpisodio'];
        $episodio->posterEpisodio = empty($_POST['posterEpisodio']) ? null : $_POST['posterEpisodio'];
        $episodio->sinopsisEpisodio = empty($_POST['sinopsisEpisodio']) ? null : $_POST['sinopsisEpisodio'];

        $idEpisodio = $episodio->agregar();

        if (isset($idEpisodio['error'])) {
            echo json_encode($idEpisodio);
            break;
        }

        // Usamos ese idEpisodio para agregarla a usuariosxepisodios
        $usuarioxEpisodio = new UsuarioxEpisodio();
        $usuarioxEpisodio->idUsuario = $_SESSION['idUsuario'];
        $usuarioxEpisodio->idEpisodio = $idEpisodio;

        // Comprobamos si ya está registrada, si no se agrega
        $resultado = $usuarioxEpisodio->existe();
        
        if(!$resultado){
            $resultado = $usuarioxEpisodio->agregarPend();

            echo json_encode([
                'idEpisodio' => $idEpisodio,
                'idUsuarioEpisodio' => $resultado
            ]);
        }else{
            echo json_encode($resultado);
        }

    break;

    case 'buscar':
        $usuarioxEpisodio = new UsuarioxEpisodio();
        $usuarioxEpisodio->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxEpisodio->buscar();
        echo json_encode($lista);
    break;

    case 'favorita':
        $usuarioxEpisodio = new UsuarioxEpisodio();
        $usuarioxEpisodio->idUsuarioEpisodio = $_POST['idUsuarioEpisodio'];
        $usuarioxEpisodio->idUsuario = $_SESSION['idUsuario'];
        $usuarioxEpisodio->favEpisodio = $_POST['favEpisodio'];
        $resultado = $usuarioxEpisodio -> favorita();
        echo json_encode($resultado);
    break;

    case 'comprobar':
        $usuarioxEpisodio = new UsuarioxEpisodio();
        $usuarioxEpisodio->idUsuarioEpisodio = $_POST['idUsuarioEpisodio'];
        $usuarioxEpisodio->idUsuario = $_SESSION['idUsuario'];
        $resultado = $usuarioxEpisodio -> comprobar();
        echo json_encode($resultado);
    break;

    case 'comprobarContenido':
        $Episodio = new Episodio();
        $Episodio->idEpisodio = $_POST['idEpisodio'];

        echo json_encode($Episodio -> comprobar());
    break;

    case 'editarVal':
        $usuarioxEpisodio = new UsuarioxEpisodio();
        $usuarioxEpisodio->idUsuarioEpisodio = $_POST['idUsuarioEpisodio'];
        $usuarioxEpisodio->idUsuario = $_SESSION['idUsuario'];
        $usuarioxEpisodio->ratingEpisodio = $_POST['ratingEpisodio'];
        echo json_encode($usuarioxEpisodio->editarVal());
    break;
        
    case 'editarFecha':
        $usuarioxEpisodio = new UsuarioxEpisodio();
        $usuarioxEpisodio->idUsuarioEpisodio = $_POST['idUsuarioEpisodio'];
        $usuarioxEpisodio->idUsuario = $_SESSION['idUsuario'];
        $usuarioxEpisodio->fechaEpisodio = empty($_POST['fechaEpisodio']) ? null : $_POST['fechaEpisodio'];

        echo json_encode($usuarioxEpisodio->editarFecha());
    break;
    
    case 'editarNotas':
        $usuarioxEpisodio = new UsuarioxEpisodio();
        $usuarioxEpisodio->idUsuarioEpisodio = $_POST['idUsuarioEpisodio'];
        $usuarioxEpisodio->idUsuario = $_SESSION['idUsuario'];
        $usuarioxEpisodio->notasEpisodio = empty($_POST['notasEpisodio']) ? null : $_POST['notasEpisodio'];

        echo json_encode($usuarioxEpisodio->editarNotas());
    break;

    case 'agregarPendTabla':
        $usuarioxEpisodio = new UsuarioxEpisodio();
        $usuarioxEpisodio->idUsuarioEpisodio = $_POST['idUsuarioEpisodio'];
        $usuarioxEpisodio->fechaEpisodio = empty($_POST['fechaEpisodio']) ? null : $_POST['fechaEpisodio'];
        $usuarioxEpisodio->ratingEpisodio = empty($_POST['ratingEpisodio']) ? null : $_POST['ratingEpisodio'];
        $usuarioxEpisodio->notasEpisodio = empty($_POST['notasEpisodio']) ? null : $_POST['notasEpisodio'];
        $usuarioxEpisodio->favEpisodio = $_POST['favEpisodio'];
        $usuarioxEpisodio->idUsuario = $_SESSION['idUsuario'];

        echo json_encode($usuarioxEpisodio->agregarPendTabla());
    break;

    case 'eliminar':
        $usuarioxEpisodio = new UsuarioxEpisodio();
        $usuarioxEpisodio->idUsuarioEpisodio = $_POST['idUsuarioEpisodio'];
        $usuarioxEpisodio->idUsuario = $_SESSION['idUsuario'];
        echo json_encode($usuarioxEpisodio->eliminar());
    break;

} // Fin de switch


?>