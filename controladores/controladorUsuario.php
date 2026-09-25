<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/includes/limpiaFormulario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseUsuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseUsuarioxPelicula.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseUsuarioxSerie.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseUsuarioxJuego.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseUsuarioxLibro.php';

$_POST = limpiaFormulario($_POST);

switch ($_POST['orden']) {

    case 'validar':

        $usuario = new Usuario();

        $usuario->identificador = $_POST['identificador'];
        $usuario->contrasena = $_POST['contrasena'];
        $validacion = $usuario->validar();
        echo json_encode($validacion);

        break;

    case 'insertar':
        $usuario = new Usuario();
        $usuario->username = $_POST['username'];
        $usuario->email = $_POST['email'];
        $usuario->contrasena = $_POST['contrasena'];

        $resultado = $usuario->insertar();
        echo json_encode($resultado);
        break;

    case 'editarNombre':
        $usuario = new Usuario();
        $usuario->idUsuario = $_POST['idUsuario'];
        $usuario->nombreUsuario = $_POST['nombreUsuario'];

        $resultado = $usuario->editarNombre();
        echo json_encode($resultado);

        break;

    case 'editarAvatar':

        $usuario = new Usuario();
        $usuario->idUsuario = $_SESSION['idUsuario'];

        $resultado = $usuario->editarAvatar();
        echo json_encode($resultado);

        break;

    case 'cerrarSesion':
        $usuario = new Usuario();
        $respuesta = $usuario->cerrarSesion();

        echo json_encode($respuesta);
        break;

    case 'numeroTotal':
        $usuarioxPelicula = new UsuarioxPelicula();
        $usuarioxPelicula->idUsuario = $_SESSION['idUsuario'];

        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];

        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];

        $usuarioxLibro = new UsuarioxLibro();
        $usuarioxLibro->idUsuario = $_SESSION['idUsuario'];

        echo json_encode([
            'peliculas' => $usuarioxPelicula->listarTodo(),
            'series' => $usuarioxSerie->listarTodo(),
            'juegos' => $usuarioxJuego->listarTodo(),
            'libros' => $usuarioxLibro->listarTodo()
        ]);
        break;

    case 'revisarCookies':

        if (isset($_COOKIE['autentificadoEnBlog'])) {
            $usuario = new Usuario();
            $usuario->cookie = $_COOKIE['autentificadoEnBlog'];
            $respuesta = $usuario->compruebaCookie();

            if (isset($respuesta['sinCoincidencias'])) {
                if ($_SESSION['validadoPorCookie']) {
                    $usuario->cerrarSesion();
                }
                echo json_encode($respuesta);
            } else {
                // Almacenamos datos del usuario para que javascript los utilice, pero no pasamos datos sensibles
                $datosUsuario = [
                    'nombreUsuario' => $usuario->nombreUsuario,
                    'avatar' => $usuario->avatar
                ];
                echo json_encode($datosUsuario);
            }
        } else {
            // Si hay un usuario autentificado por cookie pero ya no está la cookie
            if (isset($_SESSION['idUsuario'])) {
                if (isset($_SESSION['validadoPorCookie']) && $_SESSION['validadoPorCookie']) {
                    $usuario = new Usuario();
                    $usuario->cerrarSesion();
                }
            }
        }

        if (!isset($_COOKIE['autentificadoEnBlog'])) {
            $respuesta = [
                'estado' => 'No hay cookies de autentificación en el navegador'
            ];
            echo json_encode($respuesta);
        }

        break;
} // Fin de switch
