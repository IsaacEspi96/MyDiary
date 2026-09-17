<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/includes/limpiaFormulario.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseSerie.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseTemporada.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseUsuarioxTemporada.php';
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

        // Segundo metemos la temporada en la tabla seriestemporadas usando el $idSerie, y exista o no devolverá su idTemporada.
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

        // Usamos ese idTemporada para agregarla a la tabla usuariosxtemporadas
        $usuarioxTemporada = new UsuarioxTemporada();
        $usuarioxTemporada->idUsuario = $_SESSION['idUsuario'];
        $usuarioxTemporada->idTemporada = $idTemporada;

        // Comprobamos si ya está registrada, si no se agrega
        $resultado = $usuarioxTemporada->existe();
        
        if(!$resultado){
            $usuarioxTemporada->fechaTemporada = empty($_POST['fechaTemporada']) ? null : $_POST['fechaTemporada'];
            $usuarioxTemporada->ratingTemporada = empty($_POST['ratingTemporada']) ? null : $_POST['ratingTemporada'];
            $usuarioxTemporada->notasTemporada = empty($_POST['notasTemporada']) ? null : $_POST['notasTemporada'];
            $usuarioxTemporada->favTemporada = $_POST['favTemporada'];
            $resultado = $usuarioxTemporada->agregar();

            echo json_encode([
                'idTemporada' => $idTemporada,
                'idUsuarioTemporada' => $resultado
            ]);
        }else{
            echo json_encode($resultado);
        }

    break;

    case "buscarApi":
        $api = new ApiSerie();
        $resultado = $api->buscar($_POST['nombreTemporada']);

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
        $usuarioxTemporada = new UsuarioxTemporada();
        $usuarioxTemporada->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxTemporada->listarTodo();
        echo json_encode($lista);
    break;

    case 'listarEstrellas':
        $usuarioxTemporada = new UsuarioxTemporada();
        $usuarioxTemporada->idUsuario = $_SESSION['idUsuario'];
        $usuarioxTemporada->ratingTemporada = $_POST['i'];
        $lista = $usuarioxTemporada->listarEstrellas();
        echo json_encode($lista);
    break;

    case 'listarFav':
        $usuarioxTemporada = new UsuarioxTemporada();
        $usuarioxTemporada->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxTemporada->listarFav();
        echo json_encode($lista);
    break;

    case 'listarPendientes':
        $usuarioxTemporada = new UsuarioxTemporada();
        $usuarioxTemporada->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxTemporada->listarPendientes();
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
        

        // Segundo metemos la temporada en la tabla seriestemporadas usando el $idSerie, y exista o no devolverá su idTemporada.
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
        

        // Usamos ese idTemporada para agregarla a la tabla usuariosxtemporadas
        $usuarioxTemporada = new UsuarioxTemporada();
        $usuarioxTemporada->idUsuario = $_SESSION['idUsuario'];
        $usuarioxTemporada->idTemporada = $idTemporada;

        // Comprobamos si ya está registrada, si no se agrega
        $resultado = $usuarioxTemporada->existe();
        
        if(!$resultado){
            $resultado = $usuarioxTemporada->agregarPend();

            echo json_encode([
                'idTemporada' => $idTemporada,
                'idUsuarioTemporada' => $resultado
            ]);
        }else{
            echo json_encode($resultado);
        }

    break;

    case 'buscar':
        $usuarioxTemporada = new UsuarioxTemporada();
        $usuarioxTemporada->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxTemporada->buscar();
        echo json_encode($lista);
    break;

    case 'favorita':
        $usuarioxTemporada = new UsuarioxTemporada();
        $usuarioxTemporada->idUsuarioTemporada = $_POST['idUsuarioTemporada'];
        $usuarioxTemporada->idUsuario = $_SESSION['idUsuario'];
        $usuarioxTemporada->favTemporada = $_POST['favTemporada'];
        $resultado = $usuarioxTemporada -> favorita();
        echo json_encode($resultado);
    break;

    case 'comprobar':
        $usuarioxTemporada = new UsuarioxTemporada();
        $usuarioxTemporada->idUsuarioTemporada = $_POST['idUsuarioTemporada'];
        $usuarioxTemporada->idUsuario = $_SESSION['idUsuario'];
        $resultado = $usuarioxTemporada -> comprobar();
        echo json_encode($resultado);
    break;

    case 'comprobarContenido':
        $temporada = new Temporada();
        $temporada->idTemporada = $_POST['idTemporada'];

        echo json_encode($temporada -> comprobar());
    break;

    case 'editarVal':
        $usuarioxTemporada = new UsuarioxTemporada();
        $usuarioxTemporada->idUsuarioTemporada = $_POST['idUsuarioTemporada'];
        $usuarioxTemporada->idUsuario = $_SESSION['idUsuario'];
        $usuarioxTemporada->ratingTemporada = $_POST['ratingTemporada'];
        echo json_encode($usuarioxTemporada->editarVal());
    break;
        
    case 'editarFecha':
        $usuarioxTemporada = new UsuarioxTemporada();
        $usuarioxTemporada->idUsuarioTemporada = $_POST['idUsuarioTemporada'];
        $usuarioxTemporada->idUsuario = $_SESSION['idUsuario'];
        $usuarioxTemporada->fechaTemporada = empty($_POST['fechaTemporada']) ? null : $_POST['fechaTemporada'];

        echo json_encode($usuarioxTemporada->editarFecha());
    break;
    
    case 'editarNotas':
        $usuarioxTemporada = new UsuarioxTemporada();
        $usuarioxTemporada->idUsuarioTemporada = $_POST['idUsuarioTemporada'];
        $usuarioxTemporada->idUsuario = $_SESSION['idUsuario'];
        $usuarioxTemporada->notasTemporada = empty($_POST['notasTemporada']) ? null : $_POST['notasTemporada'];

        echo json_encode($usuarioxTemporada->editarNotas());
    break;

    case 'agregarPendTabla':
        $usuarioxTemporada = new UsuarioxTemporada();
        $usuarioxTemporada->idUsuarioTemporada = $_POST['idUsuarioTemporada'];
        $usuarioxTemporada->fechaTemporada = empty($_POST['fechaTemporada']) ? null : $_POST['fechaTemporada'];
        $usuarioxTemporada->ratingTemporada = empty($_POST['ratingTemporada']) ? null : $_POST['ratingTemporada'];
        $usuarioxTemporada->notasTemporada = empty($_POST['notasTemporada']) ? null : $_POST['notasTemporada'];
        $usuarioxTemporada->favTemporada = $_POST['favTemporada'];
        $usuarioxTemporada->idUsuario = $_SESSION['idUsuario'];

        echo json_encode($usuarioxTemporada->agregarPendTabla());
    break;

    case 'eliminar':
        $usuarioxTemporada = new UsuarioxTemporada();
        $usuarioxTemporada->idUsuarioTemporada = $_POST['idUsuarioTemporada'];
        $usuarioxTemporada->idUsuario = $_SESSION['idUsuario'];
        echo json_encode($usuarioxTemporada->eliminar());
    break;

} // Fin de switch


?>