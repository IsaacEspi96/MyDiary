<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/includes/limpiaFormulario.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseSerie.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseUsuarioxSerie.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseApiSerie.php';

//$_POST = limpiaFormulario($_POST);

switch($_POST['orden']){

    case "agregar":

        // La metemos en la tabla series, exista o no, devolverá su idSerie.
        $serie = new Serie();

        $serie->idApi = $_POST['idApi'];
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

        // Usamos ese idSerie para agregarla a la tabla usuariosxseries
        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];
        $usuarioxSerie->idSerie = $idSerie;

        // Comprobamos si ya está registrada, si no se agrega
        $resultado = $usuarioxSerie->existe();
        
        if(!$resultado){
            $usuarioxSerie->fechaSerie = empty($_POST['fechaSerie']) ? null : $_POST['fechaSerie'];
            $usuarioxSerie->estadoSerie = empty($_POST['estadoSerie']) ? null : $_POST['estadoSerie'];
            $usuarioxSerie->ratingSerie = empty($_POST['ratingSerie']) ? null : $_POST['ratingSerie'];
            $usuarioxSerie->notasSerie = empty($_POST['notasSerie']) ? null : $_POST['notasSerie'];
            $usuarioxSerie->favSerie = $_POST['favSerie'];
            $resultado = $usuarioxSerie->agregar();

            echo json_encode([
                'idSerie' => $idSerie,
                'idUsuarioSerie' => $resultado
            ]);
        }else{
            echo json_encode($resultado);
        }

    break;

    case "buscarApi":
        $api = new ApiSerie();
        $resultado = $api->buscar($_POST['nombreSerie']);

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
        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxSerie->listarTodo();
        echo json_encode($lista);
    break;

    case 'listarEstrellas':
        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];
        $usuarioxSerie->ratingSerie = $_POST['i'];
        $lista = $usuarioxSerie->listarEstrellas();
        echo json_encode($lista);
    break;

    case 'listarFav':
        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxSerie->listarFav();
        echo json_encode($lista);
    break;

    case 'listarPendientes':
        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxSerie->listarPendientes();
        echo json_encode($lista);
    break;

    case 'agregarPend':

        // La metemos en la tabla series, exista o no, devolverá su idSerie.
        $serie = new Serie();

        $serie->idApi = $_POST['idApi'];
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

        // Usamos ese idSerie para agregarla como pendiente a la tabla usuariosxseries
        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];
        $usuarioxSerie->idSerie = $idSerie;

        // Comprobamos si ya está registrada, si no se agrega
        $resultado = $usuarioxSerie->existe();
        if(!$resultado){
            $resultado = $usuarioxSerie->agregarPend();

            echo json_encode([
                'idSerie' => $idSerie,
                'idUsuarioSerie' => $resultado
            ]);
        }else{
            echo json_encode($resultado);
        }
    break;

    case 'buscar':
        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxSerie->buscar();
        echo json_encode($lista);
    break;

    case 'favorita':
        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuarioSerie = $_POST['idUsuarioSerie'];
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];
        $usuarioxSerie->favSerie = $_POST['favSerie'];
        $resultado = $usuarioxSerie -> favorita();
        echo json_encode($resultado);
    break;

    case 'comprobar':
        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuarioSerie = $_POST['idUsuarioSerie'];
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];
        $resultado = $usuarioxSerie -> comprobar();
        echo json_encode($resultado);
    break;

    case 'comprobarContenido':
        $serie = new Serie();
        $serie->idSerie = $_POST['idSerie'];

        echo json_encode($serie -> comprobar());
    break;

    case 'editarVal':
        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuarioSerie = $_POST['idUsuarioSerie'];
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];
        $usuarioxSerie->ratingSerie = $_POST['ratingSerie'];
        echo json_encode($usuarioxSerie->editarVal());
    break;
        
    case 'editarFecha':
        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuarioSerie = $_POST['idUsuarioSerie'];
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];
        $usuarioxSerie->fechaSerie = empty($_POST['fechaSerie']) ? null : $_POST['fechaSerie'];

        echo json_encode($usuarioxSerie->editarFecha());
    break;

    case 'editarEstado':
        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuarioSerie = $_POST['idUsuarioSerie'];
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];
        $usuarioxSerie->estadoSerie = $_POST['estadoSerie'];
        echo json_encode($usuarioxSerie->editarEstado());
    break;
    
    case 'editarNotas':
        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuarioSerie = $_POST['idUsuarioSerie'];
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];
        $usuarioxSerie->notasSerie = empty($_POST['notasSerie']) ? null : $_POST['notasSerie'];

        echo json_encode($usuarioxSerie->editarNotas());
    break;

    case 'agregarPendTabla':
        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuarioSerie = $_POST['idUsuarioSerie'];
        $usuarioxSerie->fechaSerie = empty($_POST['fechaSerie']) ? null : $_POST['fechaSerie'];
        $usuarioxSerie->estadoSerie = empty($_POST['estadoSerie']) ? null : $_POST['estadoSerie'];
        $usuarioxSerie->ratingSerie = empty($_POST['ratingSerie']) ? null : $_POST['ratingSerie'];
        $usuarioxSerie->notasSerie = empty($_POST['notasSerie']) ? null : $_POST['notasSerie'];
        $usuarioxSerie->favSerie = $_POST['favSerie'];
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];

        echo json_encode($usuarioxSerie->agregarPendTabla());
    break;

    case 'eliminar':
        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuarioSerie = $_POST['idUsuarioSerie'];
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];
        echo json_encode($usuarioxSerie->eliminar());
    break;

    case 'temporada':
        $api = new ApiSerie();
        $resultado = $api->temporada($_POST['idApiSerie'],$_POST['numeroTemporada']);

        if(isset($resultado['error'])){
            echo json_encode($resultado);
            break;
        }

        $resultado = $api->transformarDatosTemporada($resultado);
        echo json_encode($resultado);

    break;

} // Fin de switch


?>