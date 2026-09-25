<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/includes/limpiaFormulario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseLibro.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseUsuarioxLibro.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseApiLibro.php';

//$_POST = limpiaFormulario($_POST);

switch ($_POST['orden']) {

    case "agregar":

        // La metemos en la tabla libros, exista o no, devolverá su idLibro.
        $libro = new Libro();

        $libro->idApi = $_POST['idApi'];
        $libro->nombreLibro = empty($_POST['nombreLibro']) ? null : $_POST['nombreLibro'];
        $libro->autorLibro = empty($_POST['autorLibro']) ? null : $_POST['autorLibro'];
        $libro->anoLibro = empty($_POST['anoLibro']) ? null : $_POST['anoLibro'];
        $libro->generoLibro = empty($_POST['generoLibro']) ? null : $_POST['generoLibro'];
        $libro->temaLibro = empty($_POST['temaLibro']) ? null : $_POST['temaLibro'];
        $libro->paginasLibro = empty($_POST['paginasLibro']) ? null : $_POST['paginasLibro'];
        $libro->edicionesLibro = empty($_POST['edicionesLibro']) ? null : $_POST['edicionesLibro'];
        $libro->idiomaLibro = empty($_POST['idiomaLibro']) ? null : $_POST['idiomaLibro'];
        $libro->ratingAvgLibro = empty($_POST['ratingAvgLibro']) ? null : $_POST['ratingAvgLibro'];
        $libro->posterLibro = empty($_POST['posterLibro']) ? null : $_POST['posterLibro'];
        $libro->sinopsisLibro = empty($_POST['sinopsisLibro']) ? null : $_POST['sinopsisLibro'];

        // Exista o no, agregar() devolverá su idLibro
        $idLibro = $libro->agregar();

        if (isset($idLibro['error'])) {
            echo json_encode($idLibro);
            break;
        }

        // Usamos ese idLibro para agregarlo a la tabla usuariosxlibros
        $usuarioxLibro = new UsuarioxLibro();
        $usuarioxLibro->idUsuario = $_SESSION['idUsuario'];
        $usuarioxLibro->idLibro = $idLibro;

        // Comprobamos si ya está registrado, si no se agrega
        $resultado = $usuarioxLibro->existe();

        if (!$resultado) {
            $usuarioxLibro->fechaLibro = empty($_POST['fechaLibro']) ? null : $_POST['fechaLibro'];
            $usuarioxLibro->fechaInicioLibro = empty($_POST['fechaInicioLibro']) ? null : $_POST['fechaInicioLibro'];
            $usuarioxLibro->ratingLibro = empty($_POST['ratingLibro']) ? null : $_POST['ratingLibro'];
            $usuarioxLibro->notasLibro = empty($_POST['notasLibro']) ? null : $_POST['notasLibro'];
            $usuarioxLibro->favLibro = $_POST['favLibro'];
            $resultado = $usuarioxLibro->agregar();

            echo json_encode([
                'idLibro' => $idLibro,
                'idUsuarioLibro' => $resultado
            ]);
        } else {
            echo json_encode($resultado);
        }

        break;

    case 'descargarPoster':

        $libro = new Libro();
        $api = new ApiLibro();

        $libro->idLibro = $_POST['idLibro'];

        $url = $_POST['posterLibro'] ?? '';

        /*
        * Descargamos la portada desde Open Library.
        */
        $posterLocal = $api->descargarPortada($url);

        if (empty($posterLocal)) {
            echo json_encode([
                'error' => 'No se pudo descargar la portada del libro.'
            ]);
            break;
        }

        $libro->posterLibro = $posterLocal;
        $resultado = $libro->actualizarPoster();
        echo json_encode($resultado);

        break;

    case "buscarApi":

        $api = new ApiLibro();

        $resultado = $api->buscar($_POST['nombreLibro']);

        $libros = [];
        foreach ($resultado as $item) {
            $libros[] = $api->transformarDatos($item);
        }

        echo json_encode($libros);

        break;

    case "detallesApi":

        $api = new ApiLibro();

        $resultado = $api->detalles($_POST["idApi"]);

        if (isset($resultado['error'])) {
            echo json_encode($resultado);
            break;
        }

        $resultado = $api->transformarDatos($resultado);

        echo json_encode($resultado);

        break;

    case 'listarTodo':

        $usuarioxLibro = new UsuarioxLibro();
        $usuarioxLibro->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxLibro->listarTodo();

        echo json_encode($lista);

        break;

    case 'listarEstrellas':

        $usuarioxLibro = new UsuarioxLibro();
        $usuarioxLibro->idUsuario = $_SESSION['idUsuario'];
        $usuarioxLibro->ratingLibro = $_POST['i'];
        $lista = $usuarioxLibro->listarEstrellas();

        echo json_encode($lista);

        break;

    case 'listarFav':

        $usuarioxLibro = new UsuarioxLibro();
        $usuarioxLibro->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxLibro->listarFav();

        echo json_encode($lista);

        break;

    case 'listarPendientes':

        $usuarioxLibro = new UsuarioxLibro();
        $usuarioxLibro->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxLibro->listarPendientes();

        echo json_encode($lista);

        break;

    case 'agregarPend':

        // La metemos en la tabla libros, exista o no, devolverá su idLibro.
        $libro = new Libro();

        $libro->idApi = $_POST['idApi'];
        $libro->nombreLibro = empty($_POST['nombreLibro']) ? null : $_POST['nombreLibro'];
        $libro->autorLibro = empty($_POST['autorLibro']) ? null : $_POST['autorLibro'];
        $libro->anoLibro = empty($_POST['anoLibro']) ? null : $_POST['anoLibro'];
        $libro->generoLibro = empty($_POST['generoLibro']) ? null : $_POST['generoLibro'];
        $libro->temaLibro = empty($_POST['temaLibro']) ? null : $_POST['temaLibro'];
        $libro->paginasLibro = empty($_POST['paginasLibro']) ? null : $_POST['paginasLibro'];
        $libro->edicionesLibro = empty($_POST['edicionesLibro']) ? null : $_POST['edicionesLibro'];
        $libro->idiomaLibro = empty($_POST['idiomaLibro']) ? null : $_POST['idiomaLibro'];
        $libro->ratingAvgLibro = empty($_POST['ratingAvgLibro']) ? null : $_POST['ratingAvgLibro'];
        $libro->posterLibro = empty($_POST['posterLibro']) ? null : $_POST['posterLibro'];
        $libro->sinopsisLibro = empty($_POST['sinopsisLibro']) ? null : $_POST['sinopsisLibro'];

        $idLibro = $libro->agregar();

        if (isset($idLibro['error'])) {
            echo json_encode($idLibro);
            break;
        }

        // Usamos ese idLibro para agregarlo como pendiente a la tabla usuariosxlibros
        $usuarioxLibro = new UsuarioxLibro();

        $usuarioxLibro->idUsuario = $_SESSION['idUsuario'];
        $usuarioxLibro->idLibro = $idLibro;

        // Comprobamos si ya está registrado, si no se agrega
        $resultado = $usuarioxLibro->existe();

        if (!$resultado) {
            $resultado = $usuarioxLibro->agregarPend();

            echo json_encode([
                'idLibro' => $idLibro,
                'idUsuarioLibro' => $resultado
            ]);
        } else {
            echo json_encode($resultado);
        }

        break;

    case 'buscar':

        $usuarioxLibro = new UsuarioxLibro();
        $usuarioxLibro->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxLibro->buscar();

        echo json_encode($lista);

        break;

    case 'favorita':

        $usuarioxLibro = new UsuarioxLibro();
        $usuarioxLibro->idUsuarioLibro = $_POST['idUsuarioLibro'];
        $usuarioxLibro->idUsuario = $_SESSION['idUsuario'];
        $usuarioxLibro->favLibro = $_POST['favLibro'];
        $resultado = $usuarioxLibro->favorita();

        echo json_encode($resultado);

        break;

    case 'comprobar':

        $usuarioxLibro = new UsuarioxLibro();
        $usuarioxLibro->idUsuarioLibro = $_POST['idUsuarioLibro'];
        $usuarioxLibro->idUsuario = $_SESSION['idUsuario'];
        $resultado = $usuarioxLibro->comprobar();

        echo json_encode($resultado);

        break;

    case 'comprobarContenido':

        $libro = new Libro();
        $libro->idLibro = $_POST['idLibro'];

        echo json_encode($libro->comprobar());

        break;

    case 'editarVal':

        $usuarioxLibro = new UsuarioxLibro();
        $usuarioxLibro->idUsuarioLibro = $_POST['idUsuarioLibro'];
        $usuarioxLibro->idUsuario = $_SESSION['idUsuario'];
        $usuarioxLibro->ratingLibro = $_POST['ratingLibro'];

        echo json_encode($usuarioxLibro->editarVal());

        break;

    case 'editarFecha':

        $usuarioxLibro = new UsuarioxLibro();
        $usuarioxLibro->idUsuarioLibro = $_POST['idUsuarioLibro'];
        $usuarioxLibro->idUsuario = $_SESSION['idUsuario'];
        $usuarioxLibro->fechaLibro = empty($_POST['fechaLibro']) ? null : $_POST['fechaLibro'];
        $usuarioxLibro->fechaInicioLibro = empty($_POST['fechaInicioLibro']) ? null : $_POST['fechaInicioLibro'];

        echo json_encode($usuarioxLibro->editarFecha());

        break;

    case 'editarNotas':

        $usuarioxLibro = new UsuarioxLibro();
        $usuarioxLibro->idUsuarioLibro = $_POST['idUsuarioLibro'];
        $usuarioxLibro->idUsuario = $_SESSION['idUsuario'];
        $usuarioxLibro->notasLibro = empty($_POST['notasLibro']) ? null : $_POST['notasLibro'];

        echo json_encode($usuarioxLibro->editarNotas());

        break;

    case 'agregarPendTabla':

        $usuarioxLibro = new UsuarioxLibro();
        $usuarioxLibro->idUsuarioLibro = $_POST['idUsuarioLibro'];
        $usuarioxLibro->fechaLibro = empty($_POST['fechaLibro']) ? null : $_POST['fechaLibro'];
        $usuarioxLibro->fechaInicioLibro = empty($_POST['fechaInicioLibro']) ? null : $_POST['fechaInicioLibro'];
        $usuarioxLibro->ratingLibro = empty($_POST['ratingLibro']) ? null : $_POST['ratingLibro'];
        $usuarioxLibro->notasLibro = empty($_POST['notasLibro']) ? null : $_POST['notasLibro'];
        $usuarioxLibro->favLibro = $_POST['favLibro'];
        $usuarioxLibro->idUsuario = $_SESSION['idUsuario'];

        echo json_encode($usuarioxLibro->agregarPendTabla());

        break;

    case 'eliminar':

        $usuarioxLibro = new UsuarioxLibro();
        $usuarioxLibro->idUsuarioLibro = $_POST['idUsuarioLibro'];
        $usuarioxLibro->idUsuario = $_SESSION['idUsuario'];

        echo json_encode($usuarioxLibro->eliminar());

        break;
} // Fin de switch
