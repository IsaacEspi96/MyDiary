<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/includes/conexionBD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseApiPelicula.php';

class UsuarioxPelicula
{
    public $idUsuarioPelicula;
    public $idUsuario;
    public $idPelicula;
    public $ratingPelicula;
    public $favPelicula;
    public $pendientePelicula;
    public $fechaPelicula;
    public $notasPelicula;

    function __construct($idUsuarioPelicula = null, $idUsuario = null, $idPelicula = null, $ratingPelicula = null, $favPelicula = null, $pendientePelicula = null, $fechaPelicula = null, $notasPelicula = null)
    {
        $this->idUsuarioPelicula = $idUsuarioPelicula;
        $this->idUsuario = $idUsuario;
        $this->idPelicula = $idPelicula;
        $this->ratingPelicula = $ratingPelicula;
        $this->favPelicula = $favPelicula;
        $this->pendientePelicula = $pendientePelicula;
        $this->fechaPelicula = $fechaPelicula;
        $this->notasPelicula = $notasPelicula;
    } // Fin __construct

    public function agregar()
    {

        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("INSERT INTO usuariosxpeliculas (idUsuario, idPelicula, ratingPelicula, favPelicula, pendientePelicula, fechaPelicula, notasPelicula) VALUES (:idUsuario,:idPelicula, :rating, :fav, :pend, :fecha, :notas)");

                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':idPelicula', $this->idPelicula);
                $consulta->bindParam(':rating', $this->ratingPelicula);
                $consulta->bindParam(':fav', $this->favPelicula);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':fecha', $this->fechaPelicula);
                $consulta->bindParam(':notas', $this->notasPelicula);

                $consulta->execute();
                return $conexion->lastInsertId();
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al agregar la película.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin agregar()

    public function existe()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("SELECT idUsuarioPelicula FROM usuariosxpeliculas WHERE idPelicula=:idPelicula AND idUsuario=:idUsuario");

                $consulta->bindParam(':idPelicula', $this->idPelicula);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

                if ($resultado) {
                    $respuesta = [
                        'error' => 'Ya has registrado esta película',
                        'error_tecnico' => $this->idPelicula
                    ];
                    $conexion = null;
                    return $respuesta;
                } else {
                    return false;
                }
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al comprobar si existe la película en la Base de Datos.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin existe()

    public function listarTodo()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("SELECT p.idPelicula, p.idApi, p.nombrePelicula, p.directorPelicula, p.actorPelicula, p.guionistaPelicula, p.generoPelicula, p.anoPelicula, p.companiaPelicula, p.duracionPelicula, p.posterPelicula, p.ratingAvgPelicula, p.paisPelicula, p.idiomaPelicula, p.sinopsisPelicula, up.idUsuarioPelicula, up.idUsuario, up.idPelicula, up.ratingPelicula, up.favPelicula, up.pendientePelicula, up.fechaPelicula, up.notasPelicula FROM usuariosxpeliculas up INNER JOIN peliculas p ON up.idPelicula = p.idPelicula WHERE up.idUsuario = :idUsuario AND up.pendientePelicula = :pend ORDER BY up.fechaPelicula DESC, up.idUsuarioPelicula DESC");

                $pend = 0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de peliculas.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin listarTodo()

    public function listarEstrellas()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("SELECT p.idPelicula, p.idApi, p.nombrePelicula, p.directorPelicula, p.actorPelicula, p.guionistaPelicula, p.generoPelicula, p.anoPelicula, p.companiaPelicula, p.duracionPelicula, p.posterPelicula, p.ratingAvgPelicula, p.paisPelicula, p.idiomaPelicula, p.sinopsisPelicula, up.idUsuarioPelicula, up.idUsuario, up.idPelicula, up.ratingPelicula, up.favPelicula, up.pendientePelicula, up.fechaPelicula, up.notasPelicula FROM usuariosxpeliculas up INNER JOIN peliculas p ON up.idPelicula = p.idPelicula WHERE up.ratingPelicula = :rating AND up.idUsuario = :idUsuario AND up.pendientePelicula = :pend ORDER BY up.fechaPelicula DESC, up.idUsuarioPelicula DESC");

                $pend = 0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':rating', $this->ratingPelicula);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de peliculas con valoracion ' . $this->ratingPelicula,
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin listarEstrellas()

    public function listarFav()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("SELECT p.idPelicula, p.idApi, p.nombrePelicula, p.directorPelicula, p.actorPelicula, p.guionistaPelicula, p.generoPelicula, p.anoPelicula, p.companiaPelicula, p.duracionPelicula, p.posterPelicula, p.ratingAvgPelicula, p.paisPelicula, p.idiomaPelicula, p.sinopsisPelicula, up.idUsuarioPelicula, up.idUsuario, up.idPelicula, up.ratingPelicula, up.favPelicula, up.pendientePelicula, up.fechaPelicula, up.notasPelicula FROM usuariosxpeliculas up INNER JOIN peliculas p ON up.idPelicula = p.idPelicula WHERE up.favPelicula = :fav AND up.pendientePelicula= :pend AND up.idUsuario= :idUsuario ORDER BY up.fechaPelicula DESC, up.idUsuarioPelicula DESC");
                $fav = 1;
                $consulta->bindParam(':fav', $fav);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de peliculas favoritas.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin listarFav()

    public function listarPendientes()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("SELECT p.idPelicula, p.idApi, p.nombrePelicula, p.directorPelicula, p.actorPelicula, p.guionistaPelicula, p.generoPelicula, p.anoPelicula, p.companiaPelicula, p.duracionPelicula, p.posterPelicula, p.ratingAvgPelicula, p.paisPelicula, p.idiomaPelicula, p.sinopsisPelicula, up.idUsuarioPelicula, up.idUsuario, up.idPelicula, up.ratingPelicula, up.favPelicula, up.pendientePelicula, up.fechaPelicula, up.notasPelicula FROM usuariosxpeliculas up INNER JOIN peliculas p ON up.idPelicula = p.idPelicula WHERE up.pendientePelicula = :pend AND up.idUsuario=:idUsuario");
                $pend = 1;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);

                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de peliculas pendientes.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin listarPendientes()

    public function agregarPend()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("INSERT INTO usuariosxpeliculas (idUsuario, idPelicula, pendientePelicula) VALUES (:idUsuario, :idPelicula, :pend)");

                $pend = 1;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':idPelicula', $this->idPelicula);

                $consulta->execute();
                return $conexion->lastInsertId();
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al agregar la película como pendiente.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin agregarPend()

    public function buscar()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $busqueda = $_POST['busqueda'];

                if (is_numeric($busqueda)) {

                    $consulta = $conexion->prepare("SELECT p.idPelicula, p.idApi, p.nombrePelicula, p.directorPelicula, p.actorPelicula, p.guionistaPelicula, p.generoPelicula, p.anoPelicula, p.companiaPelicula, p.duracionPelicula, p.posterPelicula, p.ratingAvgPelicula, p.paisPelicula, p.idiomaPelicula, p.sinopsisPelicula, up.idUsuarioPelicula, up.idUsuario, up.idPelicula, up.ratingPelicula, up.favPelicula, up.pendientePelicula, up.fechaPelicula, up.notasPelicula FROM usuariosxpeliculas up INNER JOIN peliculas p ON up.idPelicula = p.idPelicula WHERE p.anoPelicula=:ano AND up.idUsuario=:idUsuario ORDER BY up.ratingPelicula DESC, up.fechaPelicula DESC, up.idUsuarioPelicula DESC");

                    $consulta->bindParam(':ano', $busqueda);
                    $consulta->bindParam(':idUsuario', $this->idUsuario);
                } else {
                    $busquedaParcial = "%" . $_POST['busqueda'] . "%";

                    $consulta = $conexion->prepare("SELECT p.idPelicula, p.idApi, p.nombrePelicula, p.directorPelicula, p.actorPelicula, p.guionistaPelicula, p.generoPelicula, p.anoPelicula, p.companiaPelicula, p.duracionPelicula, p.posterPelicula, p.ratingAvgPelicula, p.paisPelicula, p.idiomaPelicula, p.sinopsisPelicula, up.idUsuarioPelicula, up.idUsuario, up.idPelicula, up.ratingPelicula, up.favPelicula, up.pendientePelicula, up.fechaPelicula, up.notasPelicula FROM usuariosxpeliculas up INNER JOIN peliculas p ON up.idPelicula = p.idPelicula WHERE up.idUsuario=:idUsuario AND (p.nombrePelicula LIKE :nombre OR p.directorPelicula LIKE :director) ORDER BY up.ratingPelicula DESC, up.fechaPelicula DESC, up.idUsuarioPelicula DESC");

                    $consulta->bindParam(':nombre', $busquedaParcial);
                    $consulta->bindParam(':director', $busquedaParcial);
                    $consulta->bindParam(':idUsuario', $this->idUsuario);
                }

                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de peliculas buscadas.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin buscar()

    public function favorita()
    {

        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("UPDATE usuariosxpeliculas SET favPelicula= :favPelicula WHERE idUsuarioPelicula = :idUsuarioPelicula AND idUsuario=:idUsuario AND pendientePelicula=:pend");

                $consulta->bindParam(':idUsuarioPelicula', $this->idUsuarioPelicula);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':favPelicula', $this->favPelicula);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                return [
                    'exito' => true,
                    'idUsuarioPelicula' => $this->idUsuarioPelicula,
                    'favPelicula' => $this->favPelicula
                ];
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al cambiar el estado favorita de la película.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin favorita()

    public function comprobar()
    {

        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("SELECT * FROM usuariosxpeliculas WHERE idUsuarioPelicula= :idUsuarioPelicula AND idUsuario=:idUsuario");
                $consulta->bindParam(':idUsuarioPelicula', $this->idUsuarioPelicula);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al recoger los datos de la película seleccionada.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin comprobar()

    function editarVal()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("UPDATE usuariosxpeliculas SET ratingPelicula=:rating WHERE idUsuarioPelicula=:id AND idUsuario=:idUsuario AND pendientePelicula=:pend");

                $consulta->bindParam(':rating', $this->ratingPelicula);
                $consulta->bindParam(':id', $this->idUsuarioPelicula);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente la valoración de la película.',
                    'exito_tecnico' => $this->ratingPelicula
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al editar la valoración de la película.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin editarVal()

    function editarFecha()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("UPDATE usuariosxpeliculas SET fechaPelicula=:fecha WHERE idUsuarioPelicula= :id AND idUsuario=:idUsuario AND pendientePelicula=:pend");

                $consulta->bindParam(':id', $this->idUsuarioPelicula);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fecha', $this->fechaPelicula);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente la fecha de visualización de la película.',
                    'exito_tecnico' => $this->fechaPelicula
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al editar la fecha de visualización de la película.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin editarFecha()

    function editarNotas()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("UPDATE usuariosxpeliculas SET notasPelicula=:notas WHERE idUsuarioPelicula= :id AND idUsuario=:idUsuario AND pendientePelicula=:pend");

                $consulta->bindParam(':id', $this->idUsuarioPelicula);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':notas', $this->notasPelicula);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente las notas de la película.',
                    'exito_tecnico' => $this->fechaPelicula
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al editar las notas de la película.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin editarNotas()

    function agregarPendTabla()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("UPDATE usuariosxpeliculas SET pendientePelicula=:pend, fechaPelicula=:fecha, ratingPelicula=:rating, favPelicula=:fav, notasPelicula=:notas WHERE idUsuarioPelicula= :id AND idUsuario=:idUsuario");

                $consulta->bindParam(':id', $this->idUsuarioPelicula);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fecha', $this->fechaPelicula);
                $consulta->bindParam(':rating', $this->ratingPelicula);
                $consulta->bindParam(':fav', $this->favPelicula);
                $consulta->bindParam(':notas', $this->notasPelicula);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                return $this->idUsuarioPelicula;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al agregar la película pendiente.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin agregarPendTabla

    function eliminar()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {

                $consulta = $conexion->prepare("DELETE FROM usuariosxpeliculas WHERE idUsuarioPelicula=:id AND idUsuario=:idUsuario");
                $consulta->bindParam(':id', $this->idUsuarioPelicula);
                $consulta->bindParam(':idUsuario', $this->idUsuario);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se eliminó correctamente la película.',
                    'exito_tecnico' => $this->idUsuarioPelicula,
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al eliminar la película.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin eliminar()

} // Fin clase UsuarioxPelicula
