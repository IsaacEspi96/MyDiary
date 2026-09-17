<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/includes/limpiaFormulario.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseJuego.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseUsuarioxJuego.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/MyDiary/clases/claseApiJuego.php';

//$_POST = limpiaFormulario($_POST);

switch($_POST['orden']){

    case "agregar":

        // La metemos en la tabla juegos, exista o no, devolverá su idJuego.
        $juego = new Juego();

        $juego->idApi = $_POST['idApi'];
        $juego->nombreJuego = empty($_POST['nombreJuego']) ? null : $_POST['nombreJuego'];
        $juego->desarrolladorJuego = empty($_POST['desarrolladorJuego']) ? null : $_POST['desarrolladorJuego'];
        $juego->editorJuego = empty($_POST['editorJuego']) ? null : $_POST['editorJuego'];
        $juego->anoJuego = empty($_POST['anoJuego']) ? null : $_POST['anoJuego'];
        $juego->franquiciaJuego = empty($_POST['franquiciaJuego']) ? null : $_POST['franquiciaJuego'];
        $juego->generoJuego = empty($_POST['generoJuego']) ? null : $_POST['generoJuego'];
        $juego->plataformasJuego = empty($_POST['plataformasJuego']) ? null : $_POST['plataformasJuego'];
        $juego->dlcJuego = empty($_POST['dlcJuego']) ? null : $_POST['dlcJuego'];
        $juego->expansionJuego = empty($_POST['expansionJuego']) ? null : $_POST['expansionJuego'];
        $juego->duracionJuego = empty($_POST['duracionJuego']) ? null : $_POST['duracionJuego'];
        $juego->ratingAvgJuego = empty($_POST['ratingAvgJuego']) ? null : $_POST['ratingAvgJuego'];
        $juego->posterJuego = empty($_POST['posterJuego']) ? null : $_POST['posterJuego'];
        $juego->sinopsisJuego = empty($_POST['sinopsisJuego']) ? null : $_POST['sinopsisJuego'];

        $idJuego = $juego->agregar();

        if (isset($idJuego['error'])) {
            echo json_encode($idJuego);
            break;
        }

        // Usamos ese idJuego para agregarla a la tabla usuariosxjuegos
        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];
        $usuarioxJuego->idJuego = $idJuego;

        // Comprobamos si ya está registrada, si no se agrega
        $resultado = $usuarioxJuego->existe();
        
        if(!$resultado){
            $usuarioxJuego->fechaJuego = empty($_POST['fechaJuego']) ? null : $_POST['fechaJuego'];
            $usuarioxJuego->fechaInicioJuego = empty($_POST['fechaInicioJuego']) ? null : $_POST['fechaInicioJuego'];
            $usuarioxJuego->plataformaJuego = empty($_POST['plataformaJuego']) ? null : $_POST['plataformaJuego'];
            $usuarioxJuego->ratingJuego = empty($_POST['ratingJuego']) ? null : $_POST['ratingJuego'];
            $usuarioxJuego->notasJuego = empty($_POST['notasJuego']) ? null : $_POST['notasJuego'];
            $usuarioxJuego->favJuego = $_POST['favJuego'];
            $resultado = $usuarioxJuego->agregar();

            echo json_encode([
                'idJuego' => $idJuego,
                'idUsuarioJuego' => $resultado
            ]);
        }else{
            echo json_encode($resultado);
        }

    break;

    case "buscarApi":
        $api = new ApiJuego();
        $resultado = $api->buscar($_POST['nombreJuego']);

        $juegos = [];
        foreach($resultado as $item){
            $juegos[] = $api->transformarDatos($item);
        }

        echo json_encode($juegos);
    break;

    case "detallesApi":

        $api = new ApiJuego();
        $resultado = $api->detalles($_POST["idApi"]);

        if(isset($resultado['error'])){
            echo json_encode($resultado);
            break;
        }

        $resultado = $api->transformarDatos($resultado);

        echo json_encode($resultado);

    break;

    case 'listarTodo':
        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxJuego->listarTodo();
        echo json_encode($lista);
    break;

    case 'listarEstrellas':
        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];
        $usuarioxJuego->ratingJuego = $_POST['i'];
        $lista = $usuarioxJuego->listarEstrellas();
        echo json_encode($lista);
    break;

    case 'listarFav':
        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxJuego->listarFav();
        echo json_encode($lista);
    break;

    case 'listarPendientes':
        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxJuego->listarPendientes();
        echo json_encode($lista);
    break;

    case 'agregarPend':

        // La metemos en la tabla juegos, exista o no, devolverá su idJuego.
        $juego = new Juego();

        $juego->idApi = $_POST['idApi'];
        $juego->nombreJuego = empty($_POST['nombreJuego']) ? null : $_POST['nombreJuego'];
        $juego->desarrolladorJuego = empty($_POST['desarrolladorJuego']) ? null : $_POST['desarrolladorJuego'];
        $juego->editorJuego = empty($_POST['editorJuego']) ? null : $_POST['editorJuego'];
        $juego->anoJuego = empty($_POST['anoJuego']) ? null : $_POST['anoJuego'];
        $juego->franquiciaJuego = empty($_POST['franquiciaJuego']) ? null : $_POST['franquiciaJuego'];
        $juego->generoJuego = empty($_POST['generoJuego']) ? null : $_POST['generoJuego'];
        $juego->plataformasJuego = empty($_POST['plataformasJuego']) ? null : $_POST['plataformasJuego'];
        $juego->dlcJuego = empty($_POST['dlcJuego']) ? null : $_POST['dlcJuego'];
        $juego->expansionJuego = empty($_POST['expansionJuego']) ? null : $_POST['expansionJuego'];
        $juego->duracionJuego = empty($_POST['duracionJuego']) ? null : $_POST['duracionJuego'];
        $juego->ratingAvgJuego = empty($_POST['ratingAvgJuego']) ? null : $_POST['ratingAvgJuego'];
        $juego->posterJuego = empty($_POST['posterJuego']) ? null : $_POST['posterJuego'];
        $juego->sinopsisJuego = empty($_POST['sinopsisJuego']) ? null : $_POST['sinopsisJuego'];

        $idJuego = $juego->agregar();

        if (isset($idJuego['error'])) {
            echo json_encode($idJuego);
            break;
        }

        // Usamos ese idJuego para agregarla como pendiente a la tabla usuariosxjuegos
        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];
        $usuarioxJuego->idJuego = $idJuego;

        // Comprobamos si ya está registrada, si no se agrega
        $resultado = $usuarioxJuego->existe();
        if(!$resultado){
            $resultado = $usuarioxJuego->agregarPend();

            echo json_encode([
                'idJuego' => $idJuego,
                'idUsuarioJuego' => $resultado
            ]);
        }else{
            echo json_encode($resultado);
        }
    break;

    case 'buscar':
        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxJuego->buscar();
        echo json_encode($lista);
    break;

    case 'favorita':
        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuarioJuego = $_POST['idUsuarioJuego'];
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];
        $usuarioxJuego->favJuego = $_POST['favJuego'];
        $resultado = $usuarioxJuego -> favorita();
        echo json_encode($resultado);
    break;

    case 'comprobar':
        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuarioJuego = $_POST['idUsuarioJuego'];
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];
        $resultado = $usuarioxJuego -> comprobar();
        echo json_encode($resultado);
    break;

    case 'comprobarContenido':
        $juego = new Juego();
        $juego->idJuego = $_POST['idJuego'];

        echo json_encode($juego -> comprobar());
    break;

    case 'editarVal':
        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuarioJuego = $_POST['idUsuarioJuego'];
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];
        $usuarioxJuego->ratingJuego = $_POST['ratingJuego'];
        echo json_encode($usuarioxJuego->editarVal());
    break;
        
    case 'editarFecha':
        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuarioJuego = $_POST['idUsuarioJuego'];
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];
        $usuarioxJuego->fechaJuego = empty($_POST['fechaJuego']) ? null : $_POST['fechaJuego'];
        $usuarioxJuego->fechaInicioJuego = empty($_POST['fechaInicioJuego']) ? null : $_POST['fechaInicioJuego'];

        echo json_encode($usuarioxJuego->editarFecha());
    break;

    case 'editarPlataforma':
        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuarioJuego = $_POST['idUsuarioJuego'];
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];
        $usuarioxJuego->plataformaJuego = $_POST['plataformaJuego'];
        echo json_encode($usuarioxJuego->editarPlataforma());
    break;
    
    case 'editarNotas':
        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuarioJuego = $_POST['idUsuarioJuego'];
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];
        $usuarioxJuego->notasJuego = empty($_POST['notasJuego']) ? null : $_POST['notasJuego'];

        echo json_encode($usuarioxJuego->editarNotas());
    break;

    case 'agregarPendTabla':
        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuarioJuego = $_POST['idUsuarioJuego'];
        $usuarioxJuego->fechaJuego = empty($_POST['fechaJuego']) ? null : $_POST['fechaJuego'];
        $usuarioxJuego->fechaInicioJuego = empty($_POST['fechaInicioJuego']) ? null : $_POST['fechaInicioJuego'];
        $usuarioxJuego->plataformaJuego = empty($_POST['plataformaJuego']) ? null : $_POST['plataformaJuego'];
        $usuarioxJuego->ratingJuego = empty($_POST['ratingJuego']) ? null : $_POST['ratingJuego'];
        $usuarioxJuego->notasJuego = empty($_POST['notasJuego']) ? null : $_POST['notasJuego'];
        $usuarioxJuego->favJuego = $_POST['favJuego'];
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];

        echo json_encode($usuarioxJuego->agregarPendTabla());
    break;

    case 'eliminar':
        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuarioJuego = $_POST['idUsuarioJuego'];
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];
        echo json_encode($usuarioxJuego->eliminar());
    break;

} // Fin de switch


?>