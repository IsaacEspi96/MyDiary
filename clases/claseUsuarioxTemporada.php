<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/includes/conexionBD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseApiSerie.php';

class UsuarioxTemporada
{
    public $idUsuarioTemporada;
    public $idUsuario;
    public $idTemporada;
    public $ratingTemporada;
    public $favTemporada;
    public $pendienteTemporada;
    public $fechaTemporada;
    public $notasTemporada;

    function __construct($idUsuarioTemporada = null, $idUsuario = null, $idTemporada = null, $ratingTemporada = null, $favTemporada = null, $pendienteTemporada = null, $fechaTemporada = null, $notasTemporada = null)
    {
        $this->idUsuarioTemporada = $idUsuarioTemporada;
        $this->idUsuario = $idUsuario;
        $this->idTemporada = $idTemporada;
        $this->ratingTemporada = $ratingTemporada;
        $this->favTemporada = $favTemporada;
        $this->pendienteTemporada = $pendienteTemporada;
        $this->fechaTemporada = $fechaTemporada;
        $this->notasTemporada = $notasTemporada;
    } // Fin __construct

    public function agregar()
    {

        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("INSERT INTO usuariosxtemporadas (idUsuario, idTemporada, ratingTemporada, favTemporada, pendienteTemporada, fechaTemporada, notasTemporada) VALUES ( :idUsuario, :idTemporada, :rating, :fav, :pend, :fecha, :notas)");

                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':idTemporada', $this->idTemporada);
                $consulta->bindParam(':rating', $this->ratingTemporada);
                $consulta->bindParam(':fav', $this->favTemporada);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':fecha', $this->fechaTemporada);
                $consulta->bindParam(':notas', $this->notasTemporada);

                $consulta->execute();

                return $conexion->lastInsertId();
            } catch (PDOException $error) {

                $respuesta = [
                    'error' => 'Ocurrió un error al agregar la temporada.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        }
    } // Fin agregar()

    public function existe()
    {

        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("SELECT idUsuarioTemporada FROM usuariosxtemporadas WHERE idTemporada = :idTemporada AND idUsuario = :idUsuario");

                $consulta->bindParam(':idTemporada', $this->idTemporada);
                $consulta->bindParam(':idUsuario', $this->idUsuario);

                $consulta->execute();

                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

                if ($resultado) {

                    $respuesta = [
                        'error' => 'Ya has registrado esta temporada.',
                        'error_tecnico' => $this->idTemporada
                    ];

                    $conexion = null;
                    return $respuesta;
                } else {
                    return false;
                }
            } catch (PDOException $error) {

                $respuesta = [
                    'error' => 'Ocurrió un error al comprobar si existe la temporada en la Base de Datos.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        }
    } // Fin existe()

    public function listarTodo()
    {

        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("SELECT p.idTemporada, p.idApi, p.idSerie, p.nombreTemporada, p.numeroTemporada, p.directorTemporada, p.guionistaTemporada, p.actorTemporada, p.episodiosTemporada, p.anoTemporada, p.ratingAvgTemporada, p.posterTemporada, p.sinopsisTemporada, up.idUsuarioTemporada, up.idUsuario, up.idTemporada, up.ratingTemporada, up.favTemporada, up.pendienteTemporada, up.fechaTemporada, up.notasTemporada FROM usuariosxtemporadas up INNER JOIN seriestemporadas p ON up.idTemporada = p.idTemporada WHERE up.idUsuario = :idUsuario AND up.pendienteTemporada = :pend ORDER BY up.fechaTemporada DESC, up.idUsuarioTemporada DESC");

                $pend = 0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);

                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de temporadas.',
                    'error_tecnico' => $error
                ];
                $conexion = null;

                return $respuesta;
            }
        }
    } // Fin listarTodo()

    public function listarEstrellas()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("SELECT p.idTemporada, p.idApi, p.idSerie, p.nombreTemporada, p.numeroTemporada, p.directorTemporada, p.guionistaTemporada, p.actorTemporada, p.episodiosTemporada, p.anoTemporada, p.ratingAvgTemporada, p.posterTemporada, p.sinopsisTemporada, up.idUsuarioTemporada, up.idUsuario, up.idTemporada, up.ratingTemporada, up.favTemporada, up.pendienteTemporada, up.fechaTemporada, up.notasTemporada FROM usuariosxtemporadas up INNER JOIN seriestemporadas p ON up.idTemporada = p.idTemporada WHERE up.ratingTemporada = :rating AND up.idUsuario = :idUsuario AND up.pendienteTemporada = :pend ORDER BY up.fechaTemporada DESC, up.idUsuarioTemporada DESC");

                $pend = 0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':rating', $this->ratingTemporada);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de temporadas con valoracion ' . $this->ratingTemporada,
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
                $consulta = $conexion->prepare("SELECT p.idTemporada, p.idApi, p.idSerie, p.nombreTemporada, p.numeroTemporada, p.directorTemporada, p.guionistaTemporada, p.actorTemporada, p.episodiosTemporada, p.anoTemporada, p.ratingAvgTemporada, p.posterTemporada, p.sinopsisTemporada, up.idUsuarioTemporada, up.idUsuario, up.idTemporada, up.ratingTemporada, up.favTemporada, up.pendienteTemporada, up.fechaTemporada, up.notasTemporada FROM usuariosxtemporadas up INNER JOIN seriestemporadas p ON up.idTemporada = p.idTemporada WHERE up.favTemporada = :fav AND up.idUsuario = :idUsuario AND up.pendienteTemporada = :pend ORDER BY up.fechaTemporada DESC, up.idUsuarioTemporada DESC");

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
                    'error' => 'Ocurrió un error al obtener el listado de temporadas favoritas.',
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
                $consulta = $conexion->prepare("SELECT p.idTemporada, p.idApi, p.idSerie, p.nombreTemporada, p.numeroTemporada, p.directorTemporada, p.guionistaTemporada, p.actorTemporada, p.episodiosTemporada, p.anoTemporada, p.ratingAvgTemporada, p.posterTemporada, p.sinopsisTemporada, up.idUsuarioTemporada, up.idUsuario, up.idTemporada, up.ratingTemporada, up.favTemporada, up.pendienteTemporada, up.fechaTemporada, up.notasTemporada FROM usuariosxtemporadas up INNER JOIN seriestemporadas p ON up.idTemporada = p.idTemporada WHERE up.pendienteTemporada = :pend AND up.idUsuario = :idUsuario");

                $pend = 1;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);

                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de temporadas pendientes.',
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
                $consulta = $conexion->prepare("INSERT INTO usuariosxtemporadas (idUsuario, idTemporada, pendienteTemporada) VALUES (:idUsuario, :idTemporada, :pend)");

                $pend = 1;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':idTemporada', $this->idTemporada);

                $consulta->execute();
                return $conexion->lastInsertId();
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al agregar la temporada como pendiente.',
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

                    $consulta = $conexion->prepare("SELECT p.idTemporada, p.idApi, p.idSerie, p.nombreTemporada, p.numeroTemporada, p.directorTemporada, p.guionistaTemporada, p.actorTemporada, p.episodiosTemporada, p.anoTemporada, p.ratingAvgTemporada, p.posterTemporada, p.sinopsisTemporada, up.idUsuarioTemporada, up.idUsuario, up.idTemporada, up.ratingTemporada, up.favTemporada, up.pendienteTemporada, up.fechaTemporada, up.notasTemporada FROM usuariosxtemporadas up INNER JOIN seriestemporadas p ON up.idTemporada = p.idTemporada WHERE p.anoTemporada=:ano AND up.idUsuario=:idUsuario ORDER BY up.ratingTemporada DESC, up.fechaTemporada DESC, up.idUsuarioTemporada DESC");

                    $consulta->bindParam(':ano', $busqueda);
                    $consulta->bindParam(':idUsuario', $this->idUsuario);
                } else {
                    $busquedaParcial = "%" . $_POST['busqueda'] . "%";

                    $consulta = $conexion->prepare("SELECT p.idTemporada, p.idApi, p.idSerie, p.nombreTemporada, p.numeroTemporada, p.directorTemporada, p.guionistaTemporada, p.actorTemporada, p.episodiosTemporada, p.anoTemporada, p.ratingAvgTemporada, p.posterTemporada, p.sinopsisTemporada, up.idUsuarioTemporada, up.idUsuario, up.idTemporada, up.ratingTemporada, up.favTemporada, up.pendienteTemporada, up.fechaTemporada, up.notasTemporada FROM usuariosxtemporadas up INNER JOIN seriestemporadas p ON up.idTemporada = p.idTemporada WHERE up.idUsuario=:idUsuario AND (p.nombreTemporada LIKE :nombre OR p.directorTemporada LIKE :director) ORDER BY up.ratingTemporada DESC, up.fechaTemporada DESC, up.idUsuarioTemporada DESC");

                    $consulta->bindParam(':nombre', $busquedaParcial);
                    $consulta->bindParam(':director', $busquedaParcial);
                    $consulta->bindParam(':idUsuario', $this->idUsuario);
                }

                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de temporadas buscadas.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxtemporadas SET favTemporada= :fav WHERE idUsuarioTemporada = :idUsuarioTemporada AND idUsuario=:idUsuario AND pendienteTemporada=:pend");

                $consulta->bindParam(':idUsuarioTemporada', $this->idUsuarioTemporada);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fav', $this->favTemporada);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                return [
                    'exito' => true,
                    'idUsuarioSerie' => $this->idUsuarioTemporada,
                    'favSerie' => $this->favTemporada
                ];
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al cambiar el estado favorita de la temporada.',
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
                $consulta = $conexion->prepare("SELECT * FROM usuariosxtemporadas WHERE idUsuarioTemporada= :idUsuarioTemporada AND idUsuario=:idUsuario");
                $consulta->bindParam(':idUsuarioTemporada', $this->idUsuarioTemporada);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al recoger los datos de la temporada seleccionada.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxtemporadas SET ratingTemporada=:rating WHERE idUsuarioTemporada=:id AND idUsuario=:idUsuario AND pendienteTemporada=:pend");

                $consulta->bindParam(':rating', $this->ratingTemporada);
                $consulta->bindParam(':id', $this->idUsuarioTemporada);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente la valoración de la temporada.',
                    'exito_tecnico' => $this->ratingTemporada
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al editar la valoración de la temporada.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxtemporadas SET fechaTemporada=:fecha WHERE idUsuarioTemporada= :id AND idUsuario=:idUsuario AND pendienteTemporada=:pend");

                $consulta->bindParam(':id', $this->idUsuarioTemporada);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fecha', $this->fechaTemporada);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente la fecha de visualización de la temporada.',
                    'exito_tecnico' => $this->fechaTemporada
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al editar la fecha de visualización de la temporada.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxtemporadas SET notasTemporada=:notas WHERE idUsuarioTemporada= :id AND idUsuario=:idUsuario AND pendienteTemporada=:pend");

                $consulta->bindParam(':id', $this->idUsuarioTemporada);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':notas', $this->notasTemporada);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente las notas de la temporada.',
                    'exito_tecnico' => $this->fechaTemporada
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al editar las notas de la temporada.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxtemporadas SET pendienteTemporada=:pend, fechaTemporada=:fecha, ratingTemporada=:rating, favTemporada=:fav, notasTemporada=:notas WHERE idUsuarioTemporada= :id AND idUsuario=:idUsuario");

                $consulta->bindParam(':id', $this->idUsuarioTemporada);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fecha', $this->fechaTemporada);
                $consulta->bindParam(':rating', $this->ratingTemporada);
                $consulta->bindParam(':fav', $this->favTemporada);
                $consulta->bindParam(':notas', $this->notasTemporada);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                return $this->idUsuarioTemporada;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al agregar la temporada pendiente.',
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

                $consulta = $conexion->prepare("DELETE FROM usuariosxtemporadas WHERE idUsuarioTemporada=:id AND idUsuario=:idUsuario");
                $consulta->bindParam(':id', $this->idUsuarioTemporada);
                $consulta->bindParam(':idUsuario', $this->idUsuario);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se eliminó correctamente la temporada.',
                    'exito_tecnico' => $this->idUsuarioTemporada,
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al eliminar la temporada.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin eliminar()

} // Fin clase UsuarioxTemporada
