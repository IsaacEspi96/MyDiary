<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/includes/limpiaFormulario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseHistorial.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseUsuarioxPelicula.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/clasePelicula.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseApiPelicula.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseUsuarioxSerie.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseSerie.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseUsuarioxTemporada.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseTemporada.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseUsuarioxEpisodio.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseEpisodio.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseApiSerie.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseUsuarioxJuego.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseJuego.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseApiJuego.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseUsuarioxLibro.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseLibro.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseApiLibro.php';

//$_POST = limpiaFormulario($_POST);

switch ($_POST['orden']) {

    case 'agregarPelicula':
        $historial = new Historial();
        $historial->idUsuario = $_SESSION['idUsuario'];
        $historial->accionHistorial = $_POST['accion'];
        $historial->idUsuarioPelicula = empty($_POST['idUsuarioPelicula']) ? null : $_POST['idUsuarioPelicula'];

        $usuarioxPelicula = new UsuarioxPelicula();
        $usuarioxPelicula->idUsuarioPelicula = $_POST['idUsuarioPelicula'];
        $usuarioxPelicula->idUsuario = $_SESSION['idUsuario'];
        $resultado1 = $usuarioxPelicula->comprobar();

        if (isset($resultado1['error'])) {
            echo json_encode($resultado1);
            break;
        }

        $peli = new Pelicula();
        $peli->idPelicula = $resultado1[0]['idPelicula'];
        $resultado2 = $peli->comprobar();

        if (isset($resultado2['error'])) {
            echo json_encode($resultado2);
            break;
        }

        $historial->nombreHistorial = $resultado2[0]['nombrePelicula'];
        echo json_encode($historial->agregarPelicula());

        break;

    case 'listarPelicula':
        $historial = new Historial();
        $historial->idUsuario = $_SESSION['idUsuario'];

        echo json_encode($historial->listarPelicula());
        break;

    case 'agregarSerie':

        $historial = new Historial();
        $historial->idUsuario = $_SESSION['idUsuario'];
        $historial->accionHistorial = $_POST['accion'];
        $historial->idUsuarioSerie = empty($_POST['idUsuarioSerie']) ? null : $_POST['idUsuarioSerie'];

        $usuarioxSerie = new UsuarioxSerie();
        $usuarioxSerie->idUsuarioSerie = $_POST['idUsuarioSerie'];
        $usuarioxSerie->idUsuario = $_SESSION['idUsuario'];
        $resultado1 = $usuarioxSerie->comprobar();

        if (isset($resultado1['error'])) {
            echo json_encode($resultado1);
            break;
        }

        $serie = new Serie();
        $serie->idSerie = $resultado1[0]['idSerie'];
        $resultado2 = $serie->comprobar();

        if (isset($resultado2['error'])) {
            echo json_encode($resultado2);
            break;
        }

        $historial->nombreHistorial = $resultado2[0]['nombreSerie'];
        echo json_encode($historial->agregarSerie());

        break;

    case 'agregarTemporada':
        $historial = new Historial();
        $historial->idUsuario = $_SESSION['idUsuario'];
        $historial->accionHistorial = $_POST['accion'];
        $historial->idUsuarioTemporada = empty($_POST['idUsuarioTemporada']) ? null : $_POST['idUsuarioTemporada'];

        $usuarioxTemporada = new UsuarioxTemporada();
        $usuarioxTemporada->idUsuarioTemporada = $_POST['idUsuarioTemporada'];
        $usuarioxTemporada->idUsuario = $_SESSION['idUsuario'];
        $resultado1 = $usuarioxTemporada->comprobar();

        if (isset($resultado1['error'])) {
            echo json_encode($resultado1);
            break;
        }

        $temporada = new Temporada();
        $temporada->idTemporada = $resultado1[0]['idTemporada'];
        $resultado2 = $temporada->comprobar();

        if (isset($resultado2['error'])) {
            echo json_encode($resultado2);
            break;
        }

        $historial->nombreHistorial = $resultado2[0]['nombreTemporada'];
        echo json_encode($historial->agregarTemporada());

        break;

    case 'agregarEpisodio':
        $historial = new Historial();
        $historial->idUsuario = $_SESSION['idUsuario'];
        $historial->accionHistorial = $_POST['accion'];
        $historial->idUsuarioEpisodio = empty($_POST['idUsuarioEpisodio']) ? null : $_POST['idUsuarioEpisodio'];

        $usuarioxEpisodio = new UsuarioxEpisodio();
        $usuarioxEpisodio->idUsuarioEpisodio = $_POST['idUsuarioEpisodio'];
        $usuarioxEpisodio->idUsuario = $_SESSION['idUsuario'];
        $resultado1 = $usuarioxEpisodio->comprobar();

        if (isset($resultado1['error'])) {
            echo json_encode($resultado1);
            break;
        }

        $episodio = new Episodio();
        $episodio->idEpisodio = $resultado1[0]['idEpisodio'];
        $resultado2 = $episodio->comprobar();

        if (isset($resultado2['error'])) {
            echo json_encode($resultado2);
            break;
        }

        $historial->nombreHistorial = $resultado2[0]['nombreEpisodio'];
        echo json_encode($historial->agregarEpisodio());

        break;

    case 'listarSerie':
        $historial = new Historial();
        $historial->idUsuario = $_SESSION['idUsuario'];

        echo json_encode($historial->listarSerie());
        break;

    case 'agregarJuego':
        $historial = new Historial();
        $historial->idUsuario = $_SESSION['idUsuario'];
        $historial->accionHistorial = $_POST['accion'];
        $historial->idUsuarioJuego = empty($_POST['idUsuarioJuego']) ? null : $_POST['idUsuarioJuego'];

        $usuarioxJuego = new UsuarioxJuego();
        $usuarioxJuego->idUsuarioJuego = $_POST['idUsuarioJuego'];
        $usuarioxJuego->idUsuario = $_SESSION['idUsuario'];
        $resultado1 = $usuarioxJuego->comprobar();

        if (isset($resultado1['error'])) {
            echo json_encode($resultado1);
            break;
        }

        $juego = new Juego();
        $juego->idJuego = $resultado1[0]['idJuego'];
        $resultado2 = $juego->comprobar();

        if (isset($resultado2['error'])) {
            echo json_encode($resultado2);
            break;
        }

        $historial->nombreHistorial = $resultado2[0]['nombreJuego'];
        echo json_encode($historial->agregarJuego());

        break;

    case 'listarJuego':
        $historial = new Historial();
        $historial->idUsuario = $_SESSION['idUsuario'];

        echo json_encode($historial->listarJuego());
        break;

    case 'agregarLibro':
        $historial = new Historial();
        $historial->idUsuario = $_SESSION['idUsuario'];
        $historial->accionHistorial = $_POST['accion'];
        $historial->idUsuarioLibro = empty($_POST['idUsuarioLibro']) ? null : $_POST['idUsuarioLibro'];

        $usuarioxLibro = new UsuarioxLibro();
        $usuarioxLibro->idUsuarioLibro = $_POST['idUsuarioLibro'];
        $usuarioxLibro->idUsuario = $_SESSION['idUsuario'];
        $resultado1 = $usuarioxLibro->comprobar();

        if (isset($resultado1['error'])) {
            echo json_encode($resultado1);
            break;
        }

        $libro = new Libro();
        $libro->idLibro = $resultado1[0]['idLibro'];
        $resultado2 = $libro->comprobar();

        if (isset($resultado2['error'])) {
            echo json_encode($resultado2);
            break;
        }

        $historial->nombreHistorial = $resultado2[0]['nombreLibro'];
        echo json_encode($historial->agregarLibro());

        break;

    case 'listarLibro':
        $historial = new Historial();
        $historial->idUsuario = $_SESSION['idUsuario'];

        echo json_encode($historial->listarLibro());
        break;
} // Fin de switch
