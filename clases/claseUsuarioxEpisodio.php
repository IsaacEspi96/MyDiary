<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/includes/conexionBD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseApiSerie.php';

class UsuarioxEpisodio
{
    public $idUsuarioEpisodio;
    public $idUsuario;
    public $idEpisodio;
    public $ratingEpisodio;
    public $favEpisodio;
    public $pendienteEpisodio;
    public $fechaEpisodio;
    public $notasEpisodio;

    function __construct($idUsuarioEpisodio = null, $idUsuario = null, $idEpisodio = null, $ratingEpisodio = null, $favEpisodio = null, $pendienteEpisodio = null, $fechaEpisodio = null, $notasEpisodio = null)
    {
        $this->idUsuarioEpisodio = $idUsuarioEpisodio;
        $this->idUsuario = $idUsuario;
        $this->idEpisodio = $idEpisodio;
        $this->ratingEpisodio = $ratingEpisodio;
        $this->favEpisodio = $favEpisodio;
        $this->pendienteEpisodio = $pendienteEpisodio;
        $this->fechaEpisodio = $fechaEpisodio;
        $this->notasEpisodio = $notasEpisodio;
    } // Fin __construct

    public function agregar()
    {

        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("INSERT INTO usuariosxepisodios (idUsuario, idEpisodio, ratingEpisodio, favEpisodio, pendienteEpisodio, fechaEpisodio, notasEpisodio) VALUES (:idUsuario,:idEpisodio, :rating, :fav, :pend, :fecha, :notas)");

                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':idEpisodio', $this->idEpisodio);
                $consulta->bindParam(':rating', $this->ratingEpisodio);
                $consulta->bindParam(':fav', $this->favEpisodio);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':fecha', $this->fechaEpisodio);
                $consulta->bindParam(':notas', $this->notasEpisodio);

                $consulta->execute();
                return $conexion->lastInsertId();
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al agregar el episodio.',
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
                $consulta = $conexion->prepare("SELECT idUsuarioEpisodio FROM usuariosxepisodios WHERE idEpisodio=:idEpisodio AND idUsuario=:idUsuario");

                $consulta->bindParam(':idEpisodio', $this->idEpisodio);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

                if ($resultado) {
                    $respuesta = [
                        'error' => 'Ya has registrado este episodio',
                        'error_tecnico' => $this->idEpisodio
                    ];
                    $conexion = null;
                    return $respuesta;
                } else {
                    return false;
                }
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al comprobar si existe el episodio en la Base de Datos.',
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
                $consulta = $conexion->prepare("SELECT p.idEpisodio, p.idApi, p.idTemporada, p.nombreEpisodio, p.numeroEpisodio, p.directorEpisodio, p.actorEpisodio, p.guionistaEpisodio, p.anoEpisodio, p.duracionEpisodio, p.ratingAvgEpisodio, p.posterEpisodio, p.sinopsisEpisodio, up.idUsuarioEpisodio, up.idUsuario, up.idEpisodio, up.ratingEpisodio, up.favEpisodio, up.pendienteEpisodio, up.fechaEpisodio, up.notasEpisodio FROM usuariosxepisodios up INNER JOIN seriesepisodios p ON up.idEpisodio = p.idEpisodio WHERE up.idUsuario = :idUsuario AND up.pendienteEpisodio = :pend ORDER BY up.fechaEpisodio DESC, up.idUsuarioEpisodio DESC");

                $pend = 0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de episodios.',
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
                $consulta = $conexion->prepare("SELECT p.idEpisodio, p.idApi, p.idTemporada, p.nombreEpisodio, p.numeroEpisodio, p.directorEpisodio, p.actorEpisodio, p.guionistaEpisodio, p.anoEpisodio, p.duracionEpisodio, p.ratingAvgEpisodio, p.posterEpisodio, p.sinopsisEpisodio, up.idUsuarioEpisodio, up.idUsuario, up.idEpisodio, up.ratingEpisodio, up.favEpisodio, up.pendienteEpisodio, up.fechaEpisodio, up.notasEpisodio FROM usuariosxepisodios up INNER JOIN seriesepisodios p ON up.idEpisodio = p.idEpisodio WHERE up.ratingEpisodio = :rating AND up.idUsuario = :idUsuario AND up.pendienteEpisodio = :pend ORDER BY up.fechaEpisodio DESC, up.idUsuarioEpisodio DESC");

                $pend = 0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':rating', $this->ratingEpisodio);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de episodios con valoracion ' . $this->ratingEpisodio,
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
                $consulta = $conexion->prepare("SELECT p.idEpisodio, p.idApi, p.idTemporada, p.nombreEpisodio, p.numeroEpisodio, p.directorEpisodio, p.actorEpisodio, p.guionistaEpisodio, p.anoEpisodio, p.duracionEpisodio, p.ratingAvgEpisodio, p.posterEpisodio, p.sinopsisEpisodio, up.idUsuarioEpisodio, up.idUsuario, up.idEpisodio, up.ratingEpisodio, up.favEpisodio, up.pendienteEpisodio, up.fechaEpisodio, up.notasEpisodio FROM usuariosxepisodios up INNER JOIN seriesepisodios p ON up.idEpisodio = p.idEpisodio WHERE up.favEpisodio = :fav AND up.idUsuario = :idUsuario AND up.pendienteEpisodio = :pend ORDER BY up.fechaEpisodio DESC, up.idUsuarioEpisodio DESC");

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
                    'error' => 'Ocurrió un error al obtener el listado de episodios favoritos.',
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
                $consulta = $conexion->prepare("SELECT p.idEpisodio, p.idApi, p.idTemporada, p.nombreEpisodio, p.numeroEpisodio, p.directorEpisodio, p.actorEpisodio, p.guionistaEpisodio, p.anoEpisodio, p.duracionEpisodio, p.ratingAvgEpisodio, p.posterEpisodio, p.sinopsisEpisodio, up.idUsuarioEpisodio, up.idUsuario, up.idEpisodio, up.ratingEpisodio, up.favEpisodio, up.pendienteEpisodio, up.fechaEpisodio, up.notasEpisodio FROM usuariosxepisodios up INNER JOIN seriesepisodios p ON up.idEpisodio = p.idEpisodio WHERE up.pendienteEpisodio = :pend AND up.idUsuario = :idUsuario");

                $pend = 1;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);

                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de episodios pendientes.',
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
                $consulta = $conexion->prepare("INSERT INTO usuariosxepisodios (idUsuario, idEpisodio, pendienteEpisodio) VALUES (:idUsuario, :idEpisodio, :pend)");

                $pend = 1;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':idEpisodio', $this->idEpisodio);

                $consulta->execute();
                return $conexion->lastInsertId();
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al agregar el episodio como pendiente.',
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

                    $consulta = $conexion->prepare("SELECT p.idEpisodio, p.idApi, p.idTemporada, p.nombreEpisodio, p.numeroEpisodio, p.directorEpisodio, p.actorEpisodio, p.guionistaEpisodio, p.anoEpisodio, p.duracionEpisodio, p.ratingAvgEpisodio, p.posterEpisodio, p.sinopsisEpisodio, up.idUsuarioEpisodio, up.idUsuario, up.idEpisodio, up.ratingEpisodio, up.favEpisodio, up.pendienteEpisodio, up.fechaEpisodio, up.notasEpisodio FROM usuariosxepisodios up INNER JOIN seriesepisodios p ON up.idEpisodio = p.idEpisodio WHERE p.anoEpisodio=:ano AND up.idUsuario=:idUsuario ORDER BY up.ratingEpisodio DESC, up.fechaEpisodio DESC, up.idUsuarioEpisodio DESC");

                    $consulta->bindParam(':ano', $busqueda);
                    $consulta->bindParam(':idUsuario', $this->idUsuario);
                } else {
                    $busquedaParcial = "%" . $_POST['busqueda'] . "%";

                    $consulta = $conexion->prepare("SELECT p.idEpisodio, p.idApi, p.idTemporada, p.nombreEpisodio, p.numeroEpisodio, p.directorEpisodio, p.actorEpisodio, p.guionistaEpisodio, p.anoEpisodio, p.duracionEpisodio, p.ratingAvgEpisodio, p.posterEpisodio, p.sinopsisEpisodio, up.idUsuarioEpisodio, up.idUsuario, up.idEpisodio, up.ratingEpisodio, up.favEpisodio, up.pendienteEpisodio, up.fechaEpisodio, up.notasEpisodio FROM usuariosxepisodios up INNER JOIN seriesepisodios p ON up.idEpisodio = p.idEpisodio WHERE up.idUsuario=:idUsuario AND (p.nombreEpisodio LIKE :nombre OR p.directorEpisodio LIKE :director) ORDER BY up.ratingEpisodio DESC, up.fechaEpisodio DESC, up.idUsuarioEpisodio DESC");

                    $consulta->bindParam(':nombre', $busquedaParcial);
                    $consulta->bindParam(':director', $busquedaParcial);
                    $consulta->bindParam(':idUsuario', $this->idUsuario);
                }

                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de episodios buscados.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxepisodios SET favEpisodio= :fav WHERE idUsuarioEpisodio = :idUsuarioEpisodio AND idUsuario=:idUsuario AND pendienteEpisodio=:pend");

                $consulta->bindParam(':idUsuarioEpisodio', $this->idUsuarioEpisodio);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fav', $this->favEpisodio);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                return [
                    'exito' => true,
                    'idUsuarioEpisodio' => $this->idUsuarioEpisodio,
                    'favEpisodio' => $this->favEpisodio
                ];
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al cambiar el estado favorita del episodio.',
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
                $consulta = $conexion->prepare("SELECT * FROM usuariosxepisodios WHERE idUsuarioEpisodio= :idUsuarioEpisodio AND idUsuario=:idUsuario");
                $consulta->bindParam(':idUsuarioEpisodio', $this->idUsuarioEpisodio);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al recoger los datos del episodio seleccionado.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxepisodios SET ratingEpisodio=:rating WHERE idUsuarioEpisodio=:id AND idUsuario=:idUsuario AND pendienteEpisodio=:pend");

                $consulta->bindParam(':rating', $this->ratingEpisodio);
                $consulta->bindParam(':id', $this->idUsuarioEpisodio);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente la valoración del episodio.',
                    'exito_tecnico' => $this->ratingEpisodio
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al editar la valoración del episodio.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxepisodios SET fechaEpisodio=:fecha WHERE idUsuarioEpisodio= :id AND idUsuario=:idUsuario AND pendienteEpisodio=:pend");

                $consulta->bindParam(':id', $this->idUsuarioEpisodio);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fecha', $this->fechaEpisodio);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente la fecha de visualización del episodio.',
                    'exito_tecnico' => $this->fechaEpisodio
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al editar la fecha de visualización del episodio.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxepisodios SET notasEpisodio=:notas WHERE idUsuarioEpisodio= :id AND idUsuario=:idUsuario AND pendienteEpisodio=:pend");

                $consulta->bindParam(':id', $this->idUsuarioEpisodio);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':notas', $this->notasEpisodio);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente las notas del episodio.',
                    'exito_tecnico' => $this->fechaEpisodio
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al editar las notas del episodio.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxepisodios SET pendienteEpisodio=:pend, fechaEpisodio=:fecha, ratingEpisodio=:rating, favEpisodio=:fav, notasEpisodio=:notas WHERE idUsuarioEpisodio= :id AND idUsuario=:idUsuario");

                $consulta->bindParam(':id', $this->idUsuarioEpisodio);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fecha', $this->fechaEpisodio);
                $consulta->bindParam(':rating', $this->ratingEpisodio);
                $consulta->bindParam(':fav', $this->favEpisodio);
                $consulta->bindParam(':notas', $this->notasEpisodio);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                return $this->idUsuarioEpisodio;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al agregar el episodio pendiente.',
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

                $consulta = $conexion->prepare("DELETE FROM usuariosxepisodios WHERE idUsuarioEpisodio=:id AND idUsuario=:idUsuario");
                $consulta->bindParam(':id', $this->idUsuarioEpisodio);
                $consulta->bindParam(':idUsuario', $this->idUsuario);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se eliminó correctamente el episodio.',
                    'exito_tecnico' => $this->idUsuarioEpisodio,
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al eliminar el episodio.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin eliminar()

} // Fin clase UsuarioxEpisodio
