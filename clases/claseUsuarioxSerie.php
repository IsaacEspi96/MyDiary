<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/includes/conexionBD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/MyDiary/clases/claseApiSerie.php';

class UsuarioxSerie
{
    public $idUsuarioSerie;
    public $idUsuario;
    public $idSerie;
    public $ratingSerie;
    public $favSerie;
    public $pendienteSerie;
    public $fechaSerie;
    public $estadoSerie;
    public $notasSerie;

    function __construct($idUsuarioSerie = null, $idUsuario = null, $idSerie = null, $ratingSerie = null, $favSerie = null, $pendienteSerie = null, $fechaSerie = null, $estadoSerie = null, $notasSerie = null)
    {
        $this->idUsuarioSerie = $idUsuarioSerie;
        $this->idUsuario = $idUsuario;
        $this->idSerie = $idSerie;
        $this->ratingSerie = $ratingSerie;
        $this->favSerie = $favSerie;
        $this->pendienteSerie = $pendienteSerie;
        $this->fechaSerie = $fechaSerie;
        $this->estadoSerie = $estadoSerie;
        $this->notasSerie = $notasSerie;
    } // Fin __construct

    public function agregar()
    {

        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("INSERT INTO usuariosxseries (idUsuario, idSerie, ratingSerie, favSerie, pendienteSerie, fechaSerie, notasSerie, estadoSerie) VALUES (:idUsuario,:idSerie, :rating, :fav, :pend, :fecha, :notas, :estado)");

                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':idSerie', $this->idSerie);
                $consulta->bindParam(':rating', $this->ratingSerie);
                $consulta->bindParam(':fav', $this->favSerie);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':fecha', $this->fechaSerie);
                $consulta->bindParam(':notas', $this->notasSerie);
                $consulta->bindParam(':estado', $this->estadoSerie);

                $consulta->execute();
                return $conexion->lastInsertId();
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al agregar la serie.',
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
                $consulta = $conexion->prepare("SELECT idUsuarioSerie FROM usuariosxseries WHERE idSerie=:idSerie AND idUsuario=:idUsuario");

                $consulta->bindParam(':idSerie', $this->idSerie);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

                if ($resultado) {
                    $respuesta = [
                        'error' => 'Ya has registrado esta serie',
                        'error_tecnico' => $this->idSerie
                    ];
                    $conexion = null;
                    return $respuesta;
                } else {
                    return false;
                }
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al comprobar si existe la serie en la Base de Datos.',
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
                $consulta = $conexion->prepare("SELECT p.idSerie, p.idApi, p.nombreSerie, p.creadorSerie, p.directorSerie, p.actorSerie, p.guionistaSerie, p.companiaSerie, p.generoSerie, p.anoSerie, p.temporadasSerie, p.episodiosSerie, p.ratingAvgSerie, p.paisSerie, p.idiomaSerie, p.posterSerie, p.sinopsisSerie, up.idUsuarioSerie, up.idUsuario, up.idSerie, up.ratingSerie, up.favSerie, up.pendienteSerie, up.fechaSerie, up.estadoSerie, up.notasSerie FROM usuariosxseries up INNER JOIN series p ON up.idSerie = p.idSerie WHERE up.idUsuario = :idUsuario AND up.pendienteSerie = :pend ORDER BY up.fechaSerie DESC, up.idUsuarioSerie DESC");

                $pend = 0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de series.',
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
                $consulta = $conexion->prepare("SELECT p.idSerie, p.idApi, p.nombreSerie, p.creadorSerie, p.directorSerie, p.actorSerie, p.guionistaSerie, p.companiaSerie, p.generoSerie, p.anoSerie, p.temporadasSerie, p.episodiosSerie, p.ratingAvgSerie, p.paisSerie, p.idiomaSerie, p.posterSerie, p.sinopsisSerie, up.idUsuarioSerie, up.idUsuario, up.idSerie, up.ratingSerie, up.favSerie, up.pendienteSerie, up.fechaSerie, up.estadoSerie, up.notasSerie FROM usuariosxseries up INNER JOIN series p ON up.idSerie = p.idSerie WHERE up.ratingSerie = :rating AND up.idUsuario = :idUsuario AND up.pendienteSerie = :pend ORDER BY up.fechaSerie DESC, up.idUsuarioSerie DESC");

                $pend = 0;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':rating', $this->ratingSerie);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de series con valoracion ' . $this->ratingSerie,
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
                $consulta = $conexion->prepare("SELECT p.idSerie, p.idApi, p.nombreSerie, p.creadorSerie, p.directorSerie, p.actorSerie, p.guionistaSerie, p.companiaSerie, p.generoSerie, p.anoSerie, p.temporadasSerie, p.episodiosSerie, p.ratingAvgSerie, p.paisSerie, p.idiomaSerie, p.posterSerie, p.sinopsisSerie, up.idUsuarioSerie, up.idUsuario, up.idSerie, up.ratingSerie, up.favSerie, up.pendienteSerie, up.fechaSerie, up.estadoSerie, up.notasSerie FROM usuariosxseries up INNER JOIN series p ON up.idSerie = p.idSerie WHERE up.favSerie = :fav AND up.idUsuario = :idUsuario AND up.pendienteSerie = :pend ORDER BY up.fechaSerie DESC, up.idUsuarioSerie DESC");

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
                    'error' => 'Ocurrió un error al obtener el listado de series favoritas.',
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
                $consulta = $conexion->prepare("SELECT p.idSerie, p.idApi, p.nombreSerie, p.creadorSerie, p.directorSerie, p.actorSerie, p.guionistaSerie, p.companiaSerie, p.generoSerie, p.anoSerie, p.temporadasSerie, p.episodiosSerie, p.ratingAvgSerie, p.paisSerie, p.idiomaSerie, p.posterSerie, p.sinopsisSerie, up.idUsuarioSerie, up.idUsuario, up.idSerie, up.ratingSerie, up.favSerie, up.pendienteSerie, up.fechaSerie, up.estadoSerie, up.notasSerie FROM usuariosxseries up INNER JOIN series p ON up.idSerie = p.idSerie WHERE up.pendienteSerie = :pend AND up.idUsuario = :idUsuario");

                $pend = 1;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);

                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de series pendientes.',
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
                $consulta = $conexion->prepare("INSERT INTO usuariosxseries (idUsuario, idSerie, pendienteSerie) VALUES (:idUsuario, :idSerie, :pend)");

                $pend = 1;
                $consulta->bindParam(':pend', $pend);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':idSerie', $this->idSerie);

                $consulta->execute();
                return $conexion->lastInsertId();
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al agregar la serie como pendiente.',
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

                    $consulta = $conexion->prepare("SELECT p.idSerie, p.idApi, p.nombreSerie, p.creadorSerie, p.directorSerie, p.actorSerie, p.guionistaSerie, p.companiaSerie, p.generoSerie, p.anoSerie, p.temporadasSerie, p.episodiosSerie, p.ratingAvgSerie, p.paisSerie, p.idiomaSerie, p.posterSerie, p.sinopsisSerie, up.idUsuarioSerie, up.idUsuario, up.idSerie, up.ratingSerie, up.favSerie, up.pendienteSerie, up.fechaSerie, up.estadoSerie, up.notasSerie FROM usuariosxseries up INNER JOIN series p ON up.idSerie = p.idSerie WHERE p.anoSerie=:ano AND up.idUsuario=:idUsuario ORDER BY up.ratingSerie DESC, up.fechaSerie DESC, up.idUsuarioSerie DESC");

                    $consulta->bindParam(':ano', $busqueda);
                    $consulta->bindParam(':idUsuario', $this->idUsuario);
                } else {
                    $busquedaParcial = "%" . $_POST['busqueda'] . "%";

                    $consulta = $conexion->prepare("SELECT p.idSerie, p.idApi, p.nombreSerie, p.creadorSerie, p.directorSerie, p.actorSerie, p.guionistaSerie, p.companiaSerie, p.generoSerie, p.anoSerie, p.temporadasSerie, p.episodiosSerie, p.ratingAvgSerie, p.paisSerie, p.idiomaSerie, p.posterSerie, p.sinopsisSerie, up.idUsuarioSerie, up.idUsuario, up.idSerie, up.ratingSerie, up.favSerie, up.pendienteSerie, up.fechaSerie, up.estadoSerie, up.notasSerie FROM usuariosxseries up INNER JOIN series p ON up.idSerie = p.idSerie WHERE up.idUsuario=:idUsuario AND (p.nombreSerie LIKE :nombre OR p.creadorSerie LIKE :creador OR p.directorSerie LIKE :director) ORDER BY up.ratingSerie DESC, up.fechaSerie DESC, up.idUsuarioSerie DESC");

                    $consulta->bindParam(':nombre', $busquedaParcial);
                    $consulta->bindParam(':creador', $busquedaParcial);
                    $consulta->bindParam(':director', $busquedaParcial);
                    $consulta->bindParam(':idUsuario', $this->idUsuario);
                }

                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al obtener el listado de series buscadas.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxseries SET favSerie= :fav WHERE idUsuarioSerie = :idUsuarioSerie AND idUsuario=:idUsuario AND pendienteSerie=:pend");

                $consulta->bindParam(':idUsuarioSerie', $this->idUsuarioSerie);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fav', $this->favSerie);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                return [
                    'exito' => true,
                    'idUsuarioSerie' => $this->idUsuarioSerie,
                    'favSerie' => $this->favSerie
                ];
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al cambiar el estado favorita de la serie.',
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
                $consulta = $conexion->prepare("SELECT * FROM usuariosxseries WHERE idUsuarioSerie= :idUsuarioSerie AND idUsuario=:idUsuario");
                $consulta->bindParam(':idUsuarioSerie', $this->idUsuarioSerie);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->execute();

                return $consulta->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al recoger los datos de la serie seleccionada.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxseries SET ratingSerie=:rating WHERE idUsuarioSerie=:id AND idUsuario=:idUsuario AND pendienteSerie=:pend");

                $consulta->bindParam(':rating', $this->ratingSerie);
                $consulta->bindParam(':id', $this->idUsuarioSerie);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente la valoración de la serie.',
                    'exito_tecnico' => $this->ratingSerie
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al editar la valoración de la serie.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxseries SET fechaSerie=:fecha WHERE idUsuarioSerie= :id AND idUsuario=:idUsuario AND pendienteSerie=:pend");

                $consulta->bindParam(':id', $this->idUsuarioSerie);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fecha', $this->fechaSerie);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente la fecha de visualización de la serie.',
                    'exito_tecnico' => $this->fechaSerie
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al editar la fecha de visualización de la serie.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin editarFecha()

    function editarEstado()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("UPDATE usuariosxseries SET estadoSerie=:estado WHERE idUsuarioSerie=:id AND idUsuario=:idUsuario AND pendienteSerie=:pend");

                $consulta->bindParam(':estado', $this->estadoSerie);
                $consulta->bindParam(':id', $this->idUsuarioSerie);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente el estado de la serie.',
                    'exito_tecnico' => $this->estadoSerie
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al editar el estado de la serie.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin editarEstado()

    function editarNotas()
    {
        $conexion = conexionBD();

        if (is_array($conexion)) {
            return $conexion;
        } else {
            try {
                $consulta = $conexion->prepare("UPDATE usuariosxseries SET notasSerie=:notas WHERE idUsuarioSerie= :id AND idUsuario=:idUsuario AND pendienteSerie=:pend");

                $consulta->bindParam(':id', $this->idUsuarioSerie);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':notas', $this->notasSerie);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se editó correctamente las notas de la serie.',
                    'exito_tecnico' => $this->fechaSerie
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al editar las notas de la serie.',
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
                $consulta = $conexion->prepare("UPDATE usuariosxseries SET pendienteSerie=:pend, fechaSerie=:fecha, ratingSerie=:rating, favSerie=:fav, notasSerie=:notas, estadoSerie=:estado WHERE idUsuarioSerie= :id AND idUsuario=:idUsuario");

                $consulta->bindParam(':id', $this->idUsuarioSerie);
                $consulta->bindParam(':idUsuario', $this->idUsuario);
                $consulta->bindParam(':fecha', $this->fechaSerie);
                $consulta->bindParam(':rating', $this->ratingSerie);
                $consulta->bindParam(':fav', $this->favSerie);
                $consulta->bindParam(':notas', $this->notasSerie);
                $consulta->bindParam(':estado', $this->estadoSerie);
                $pend = 0;
                $consulta->bindParam(':pend', $pend);

                $consulta->execute();

                return $this->idUsuarioSerie;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al agregar la serie pendiente.',
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

                $consulta = $conexion->prepare("DELETE FROM usuariosxseries WHERE idUsuarioSerie=:id AND idUsuario=:idUsuario");
                $consulta->bindParam(':id', $this->idUsuarioSerie);
                $consulta->bindParam(':idUsuario', $this->idUsuario);

                $consulta->execute();

                $respuesta = [
                    'exito' => 'Se eliminó correctamente la serie.',
                    'exito_tecnico' => $this->idUsuarioSerie,
                ];
                return $respuesta;
            } catch (PDOException $error) {
                $respuesta = [
                    'error' => 'Ocurrió un error al eliminar la serie.',
                    'error_tecnico' => $error
                ];

                $conexion = null;
                return $respuesta;
            }
        } // Fin else
    } // Fin eliminar()

} // Fin clase UsuarioxSerie
