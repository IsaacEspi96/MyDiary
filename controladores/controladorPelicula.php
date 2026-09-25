<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/includes/limpiaFormulario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/clasePelicula.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseUsuarioxPelicula.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseApiPelicula.php';

//$_POST = limpiaFormulario($_POST);

switch ($_POST['orden']) {

    case "agregar":

        // La metemos en la tabla películas, exista o no, devolverá su idPelicula.
        $pelicula = new Pelicula();

        $pelicula->idApi = $_POST['idApi'];
        $pelicula->nombrePelicula = empty($_POST['nombrePelicula']) ? null : $_POST['nombrePelicula'];
        $pelicula->directorPelicula = empty($_POST['directorPelicula']) ? null : $_POST['directorPelicula'];
        $pelicula->actorPelicula = empty($_POST['actorPelicula']) ? null : $_POST['actorPelicula'];
        $pelicula->guionistaPelicula = empty($_POST['guionistaPelicula']) ? null : $_POST['guionistaPelicula'];
        $pelicula->generoPelicula = empty($_POST['generoPelicula']) ? null : $_POST['generoPelicula'];
        $pelicula->anoPelicula = empty($_POST['anoPelicula']) ? null : $_POST['anoPelicula'];
        $pelicula->companiaPelicula = empty($_POST['companiaPelicula']) ? null : $_POST['companiaPelicula'];
        $pelicula->duracionPelicula = empty($_POST['duracionPelicula']) ? null : $_POST['duracionPelicula'];
        $pelicula->ratingAvgPelicula = empty($_POST['ratingAvgPelicula']) ? null : $_POST['ratingAvgPelicula'];
        $pelicula->paisPelicula = empty($_POST['paisPelicula']) ? null : $_POST['paisPelicula'];
        $pelicula->idiomaPelicula = empty($_POST['idiomaPelicula']) ? null : $_POST['idiomaPelicula'];
        $pelicula->posterPelicula = empty($_POST['posterPelicula']) ? null : $_POST['posterPelicula'];
        $pelicula->sinopsisPelicula = empty($_POST['sinopsisPelicula']) ? null : $_POST['sinopsisPelicula'];

        $idPelicula = $pelicula->agregar();

        if (isset($idPelicula['error'])) {
            echo json_encode($idPelicula);
            break;
        }

        // Usamos ese idPelicula para agregarla a la tabla usuariosxpeliculas
        $usuarioxPelicula = new UsuarioxPelicula();
        $usuarioxPelicula->idUsuario = $_SESSION['idUsuario'];
        $usuarioxPelicula->idPelicula = $idPelicula;

        // Comprobamos si ya está registrada, si no se agrega
        $resultado = $usuarioxPelicula->existe();
        if (!$resultado) {
            $usuarioxPelicula->fechaPelicula = empty($_POST['fechaPelicula']) ? null : $_POST['fechaPelicula'];
            $usuarioxPelicula->ratingPelicula = empty($_POST['ratingPelicula']) ? null : $_POST['ratingPelicula'];
            $usuarioxPelicula->notasPelicula = empty($_POST['notasPelicula']) ? null : $_POST['notasPelicula'];
            $usuarioxPelicula->favPelicula = $_POST['favPelicula'];
            $resultado = $usuarioxPelicula->agregar();

            echo json_encode([
                'idPelicula' => $idPelicula,
                'idUsuarioPelicula' => $resultado
            ]);
        } else {
            echo json_encode($resultado);
        }
        break;

    case "buscarApi":
        $api = new ApiPelicula();
        $resultado = $api->buscar($_POST['nombrePelicula']);

        $peliculas = [];
        foreach ($resultado["results"] as $item) {
            $peliculas[] = $api->transformarDatos($item);
        }

        echo json_encode($peliculas);
        break;

    case "detallesApi":

        $api = new ApiPelicula();
        $resultado = $api->detalles($_POST["idApi"]);
        $resultado = $api->transformarDatos($resultado);

        echo json_encode($resultado);

        break;

    case 'listarTodo':
        $usuarioxPelicula = new UsuarioxPelicula();
        $usuarioxPelicula->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxPelicula->listarTodo();
        echo json_encode($lista);
        break;

    case 'listarEstrellas':
        $usuarioxPelicula = new UsuarioxPelicula();
        $usuarioxPelicula->idUsuario = $_SESSION['idUsuario'];
        $usuarioxPelicula->ratingPelicula = $_POST['i'];
        $lista = $usuarioxPelicula->listarEstrellas();
        echo json_encode($lista);
        break;

    case 'listarFav':
        $usuarioxPelicula = new UsuarioxPelicula();
        $usuarioxPelicula->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxPelicula->listarFav();
        echo json_encode($lista);
        break;

    case 'listarPendientes':
        $usuarioxPelicula = new UsuarioxPelicula();
        $usuarioxPelicula->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxPelicula->listarPendientes();
        echo json_encode($lista);
        break;

    case 'agregarPend':

        // La metemos en la tabla películas, exista o no, devolverá su idPelicula.
        $pelicula = new Pelicula();

        $pelicula->idApi = $_POST['idApi'];
        $pelicula->nombrePelicula = empty($_POST['nombrePelicula']) ? null : $_POST['nombrePelicula'];
        $pelicula->directorPelicula = empty($_POST['directorPelicula']) ? null : $_POST['directorPelicula'];
        $pelicula->actorPelicula = empty($_POST['actorPelicula']) ? null : $_POST['actorPelicula'];
        $pelicula->guionistaPelicula = empty($_POST['guionistaPelicula']) ? null : $_POST['guionistaPelicula'];
        $pelicula->generoPelicula = empty($_POST['generoPelicula']) ? null : $_POST['generoPelicula'];
        $pelicula->anoPelicula = empty($_POST['anoPelicula']) ? null : $_POST['anoPelicula'];
        $pelicula->companiaPelicula = empty($_POST['companiaPelicula']) ? null : $_POST['companiaPelicula'];
        $pelicula->duracionPelicula = empty($_POST['duracionPelicula']) ? null : $_POST['duracionPelicula'];
        $pelicula->ratingAvgPelicula = empty($_POST['ratingAvgPelicula']) ? null : $_POST['ratingAvgPelicula'];
        $pelicula->paisPelicula = empty($_POST['paisPelicula']) ? null : $_POST['paisPelicula'];
        $pelicula->idiomaPelicula = empty($_POST['idiomaPelicula']) ? null : $_POST['idiomaPelicula'];
        $pelicula->posterPelicula = empty($_POST['posterPelicula']) ? null : $_POST['posterPelicula'];
        $pelicula->sinopsisPelicula = empty($_POST['sinopsisPelicula']) ? null : $_POST['sinopsisPelicula'];

        $idPelicula = $pelicula->agregar();

        if (isset($idPelicula['error'])) {
            echo json_encode($idPelicula);
            break;
        }

        // Usamos ese idPelicula para agregarla como pendiente a la tabla usuariosxpeliculas
        $usuarioxPelicula = new UsuarioxPelicula();
        $usuarioxPelicula->idUsuario = $_SESSION['idUsuario'];
        $usuarioxPelicula->idPelicula = $idPelicula;

        // Comprobamos si ya está registrada, si no se agrega
        $resultado = $usuarioxPelicula->existe();
        if (!$resultado) {
            $resultado = $usuarioxPelicula->agregarPend();

            echo json_encode([
                'idPelicula' => $idPelicula,
                'idUsuarioPelicula' => $resultado
            ]);
        } else {
            echo json_encode($resultado);
        }
        break;

    case 'buscar':
        $usuarioxPelicula = new UsuarioxPelicula();
        $usuarioxPelicula->idUsuario = $_SESSION['idUsuario'];
        $lista = $usuarioxPelicula->buscar();
        echo json_encode($lista);
        break;

    case 'favorita':
        $usuarioxPelicula = new UsuarioxPelicula();
        $usuarioxPelicula->idUsuarioPelicula = $_POST['idUsuarioPelicula'];
        $usuarioxPelicula->idUsuario = $_SESSION['idUsuario'];
        $usuarioxPelicula->favPelicula = $_POST['favPelicula'];
        $resultado = $usuarioxPelicula->favorita();
        echo json_encode($resultado);
        break;

    case 'comprobar':
        $usuarioxPelicula = new UsuarioxPelicula();
        $usuarioxPelicula->idUsuarioPelicula = $_POST['idUsuarioPelicula'];
        $usuarioxPelicula->idUsuario = $_SESSION['idUsuario'];
        $resultado = $usuarioxPelicula->comprobar();
        echo json_encode($resultado);
        break;

    case 'comprobarContenido':
        $pelicula = new Pelicula();
        $pelicula->idPelicula = $_POST['idPelicula'];

        echo json_encode($pelicula->comprobar());
        break;

    case 'editarVal':
        $usuarioxPelicula = new UsuarioxPelicula();
        $usuarioxPelicula->idUsuarioPelicula = $_POST['idUsuarioPelicula'];
        $usuarioxPelicula->idUsuario = $_SESSION['idUsuario'];
        $usuarioxPelicula->ratingPelicula = $_POST['ratingPelicula'];
        echo json_encode($usuarioxPelicula->editarVal());
        break;

    case 'editarFecha':
        $usuarioxPelicula = new UsuarioxPelicula();
        $usuarioxPelicula->idUsuarioPelicula = $_POST['idUsuarioPelicula'];
        $usuarioxPelicula->idUsuario = $_SESSION['idUsuario'];
        $usuarioxPelicula->fechaPelicula = empty($_POST['fechaPelicula']) ? null : $_POST['fechaPelicula'];

        echo json_encode($usuarioxPelicula->editarFecha());
        break;

    case 'editarNotas':
        $usuarioxPelicula = new UsuarioxPelicula();
        $usuarioxPelicula->idUsuarioPelicula = $_POST['idUsuarioPelicula'];
        $usuarioxPelicula->idUsuario = $_SESSION['idUsuario'];
        $usuarioxPelicula->notasPelicula = empty($_POST['notasPelicula']) ? null : $_POST['notasPelicula'];

        echo json_encode($usuarioxPelicula->editarNotas());
        break;

    case 'agregarPendTabla':
        $usuarioxPelicula = new UsuarioxPelicula();
        $usuarioxPelicula->idUsuarioPelicula = $_POST['idUsuarioPelicula'];
        $usuarioxPelicula->fechaPelicula = empty($_POST['fechaPelicula']) ? null : $_POST['fechaPelicula'];
        $usuarioxPelicula->ratingPelicula = empty($_POST['ratingPelicula']) ? null : $_POST['ratingPelicula'];
        $usuarioxPelicula->notasPelicula = empty($_POST['notasPelicula']) ? null : $_POST['notasPelicula'];
        $usuarioxPelicula->favPelicula = $_POST['favPelicula'];
        $usuarioxPelicula->idUsuario = $_SESSION['idUsuario'];

        echo json_encode($usuarioxPelicula->agregarPendTabla());
        break;

    case 'eliminar':
        $usuarioxPelicula = new UsuarioxPelicula();
        $usuarioxPelicula->idUsuarioPelicula = $_POST['idUsuarioPelicula'];
        $usuarioxPelicula->idUsuario = $_SESSION['idUsuario'];
        echo json_encode($usuarioxPelicula->eliminar());
        break;

    case 'actualizarDetalles':

        $pelicula = new Pelicula();

        $peliculas = $pelicula->listarIdApi();

        if (isset($peliculas['error'])) {
            echo json_encode($peliculas);
            break;
        }

        $api = new ApiPelicula();

        $actualizadas = 0;
        $errores = 0;

        foreach ($peliculas as $fila) {

            /*
            * Obtenemos los detalles de TMDB
            */
            $resultado = $api->detalles($fila['idApi']);

            if (isset($resultado['status_code'])) {

                $errores++;
                continue;
            }


            /*
            * Transformamos los datos
            */
            $datos = $api->transformarDatos($resultado);


            /*
            * Preparamos la película
            */
            $pelicula->idPelicula = $fila['idPelicula'];

            $pelicula->actorPelicula =
                $datos['actorPelicula'] ?? '';

            $pelicula->guionistaPelicula =
                $datos['guionistaPelicula'] ?? '';

            $pelicula->generoPelicula =
                $datos['generoPelicula'] ?? '';

            $pelicula->duracionPelicula =
                $datos['duracionPelicula'] ?? null;

            $pelicula->companiaPelicula =
                $datos['companiaPelicula'] ?? '';

            $pelicula->paisPelicula =
                $datos['paisPelicula'] ?? '';

            $pelicula->idiomaPelicula =
                $datos['idiomaPelicula'] ?? '';


            /*
            * Actualizamos la BD
            */
            $resultadoUpdate =
                $pelicula->actualizarDetalles();

            if ($resultadoUpdate === true) {

                $actualizadas++;
            } else {

                $errores++;
            }
        }


        echo json_encode([
            'actualizadas' => $actualizadas,
            'errores' => $errores,
            'total' => count($peliculas)
        ]);

        break;
} // Fin de switch
